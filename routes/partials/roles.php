<?php

use App\Http\Controllers\RolesController;

Route::group(["prefix" => "grupos-de-acesso"], function () {
	Route::post('store', [RolesController::class, 'store']);
});