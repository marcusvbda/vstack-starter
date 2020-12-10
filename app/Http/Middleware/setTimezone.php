<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use DB;

class setTimezone
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$user = Auth::user();
		if ($tenant = @$user->tenant) {
			$timezone =  @$tenant->timezone ? $tenant->timezone : "UTC";
			DB::disconnect('mysql');
			config(['app.timezone' => $timezone]);
			date_default_timezone_set($timezone);
		}
		return $next($request);
	}
}