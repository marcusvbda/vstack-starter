<?php

use App\Http\Controllers\CampaignsController;

Route::group(["prefix" => "campanhas"], function () {
	Route::post('store', [CampaignsController::class, 'store']);
	Route::get('{code}/leads', [CampaignsController::class, 'leads']);
	Route::post('{code}/leads/list', [CampaignsController::class, 'list']);
});