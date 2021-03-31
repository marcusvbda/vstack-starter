<?php

use App\Http\Controllers\CampaignsController;

Route::group(["prefix" => "campanhas"], function () {
	Route::get('{code}/leads', [CampaignsController::class, 'leadList']);
});