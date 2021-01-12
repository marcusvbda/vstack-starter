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
		if ($polo = @$user->polo) {
			$timezone =  @$polo->timezone ? $polo->timezone : config("app.timezone");
			config(['vstack.timezone' => $timezone]);
		}
		DB::statement("SET time_zone = '+00:00'");
		return $next($request);
	}
}