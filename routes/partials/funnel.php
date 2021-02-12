<?php

use App\Http\Controllers\FunnelController;

Route::group(["prefix" => "funil-de-conversao"], function () {
	Route::get('', [FunnelController::class, 'index']);
	Route::post('filter', [FunnelController::class, 'filter']);
	Route::get('{code}/converter', [FunnelController::class, 'convert'])->middleware(['hashids:code']);
	Route::post('{code}/converter', [FunnelController::class, 'finishConvert'])->middleware(['hashids:code']);
});