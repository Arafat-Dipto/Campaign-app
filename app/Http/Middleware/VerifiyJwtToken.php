<?php

namespace App\Http\Middleware;

use Tymon\JWTAuth\JWTAuth;
use Illuminate\Http\Response;

class VerifiyJwtToken
{
	protected $jwtAuth;

	public function __construct(JWTAuth $jwtAuth)
	{
		$this->jwtAuth = $jwtAuth;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, \Closure $next)
	{
		$method = $request->method();

		// If you API check fails, then check if a valid token has been found
		if (!$token = $this->jwtAuth->getToken()) {
			$status = Response::HTTP_BAD_REQUEST;
			return response()->json([
				'message'    => 'Token Not provided',
				'statusCode' => statusCodes($status),
				'method'     => $method
			], $status);
		}
		try {
			// attempt to verify the credentials and create a token for the user
			$token = $this->jwtAuth->getToken();
			$apy   = $this->jwtAuth->getPayload($token)->toArray();
		} catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
			return response()->json([
				'message'    => 'token_expired',
				'statusCode' => statusCodes(401)
			], 401);
		} catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
			return response()->json([
				'message'    => 'token_invalid',
				'statusCode' => statusCodes(401)
			], 401);
		} catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
			return response()->json([
				'token_absent' => $e->getMessage()
			], 400);
		}
		// *NOW* we run the controller (or whatever this middleware wraps)

		$response = $next($request);

		return $response;
	}
}
