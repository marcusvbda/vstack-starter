<?php

use App\Http\Controllers\FunnelController;

Route::group(["prefix" => "funil-de-conversao"], function () {
	Route::get('', [FunnelController::class, 'index']);
});