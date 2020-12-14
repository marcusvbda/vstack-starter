<?php

use App\Http\Controllers\CampaignController;

Route::group(['prefix' => "campanhas"], function () {
	Route::post('{code}/api/{action}', [CampaignController::class, 'api'])->middleware(['hashids:code']);
});