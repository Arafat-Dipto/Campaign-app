<?php

namespace App\Exceptions;

use Throwable;
use Inertia\Inertia;
use Illuminate\Support\Facades\App;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
	/**
	 * A list of the exception types that are not reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		//
	];

	/**
	 * A list of the inputs that are never flashed for validation exceptions.
	 *
	 * @var array
	 */
	protected $dontFlash = [
		'password',
		'password_confirmation',
	];

	/**
	 * Register the exception handling callbacks for the application.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

	/**
	 * Convert a validation exception into a JSON response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Illuminate\Validation\ValidationException  $exception
	 * @return \Illuminate\Http\JsonResponse
	 */
	protected function invalidJson($request, ValidationException $exception)
	{
		return response()->json([
			'statusCode'    => statusCodes($exception->status),
			'message'       => $exception->getMessage(),
			'errors'        => $this->transformErrors($exception),
		], $exception->status);
	}

	// transform the error messages,
	private function transformErrors(ValidationException $exception)
	{
		$errors = [];

		foreach ($exception->errors() as $field => $message) {
			$errors[] = $message[0];
		}

		return implode(', ', $errors);
	}

	/*
	// transform the error messages,
	private function transformErrors(ValidationException $exception)
	{
		$errors = [];

		foreach ($exception->errors() as $field => $message) {
			$errors[] = [
				'field' => $field,
				'message' => $message[0],
			];
		}

		return $errors;
	}
	*/

	protected function unauthenticated($request, AuthenticationException $exception)
	{
		if ($request->expectsJson()) {
			return response()->json([
				'statusCode' => statusCodes(401),
				'message'    => $exception->getMessage(),
				'errors'     => $exception->getMessage(),
			], 401);
		}

		if (request()->is('dashboard') || request()->is('dashboard/*')) {
			return redirect()->guest(route('dashboard.login'));
		} else {
			return redirect()->guest(route('login'));
		}
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $exception
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Throwable $exception)
	{
		$response = parent::render($request, $exception);

		if (
			(App::environment('production'))
			&& $request->header('X-Inertia')
			&& in_array($response->status(), [500, 503, 404, 403])
		) {
			return Inertia::render('Error', ['status' => $response->status()])
				->toResponse($request)
				->setStatusCode($response->status());
		}

		return $response;
	}
}
