<?php

use App\Http\Controllers\LeadsController;

Route::group(['prefix' => "leads"], function () {
	Route::get('create', [LeadsController::class, 'create']);
});