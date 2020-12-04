<?php

use App\Http\Controllers\PoloController;

Route::group(["prefix" => "polos"], function () {
	Route::post('', [PoloController::class, 'all']);
	Route::post('change-logged', [PoloController::class, 'changeLogged']);
});