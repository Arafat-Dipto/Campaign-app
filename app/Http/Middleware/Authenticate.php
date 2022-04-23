<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
	/**
	 * Get the path the user should be redirected to when they are not authenticated.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return string|null
	 */
	protected function redirectTo($request)
	{
		if (!$request->expectsJson()) {
			// if ($request->route()->xUser) {
			// 	// URL::defaults(['xUser' => $request->route()->xUser]);
			// }
			if (request()->is('dashboard') || request()->is('dashboard/*')) {
				return route('dashboard.login');
			} else {
				return route('login');
			}
		}
	}
}
