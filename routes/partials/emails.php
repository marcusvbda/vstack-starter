<?php

use App\Http\Controllers\EmailsController;

Route::group(["prefix" => "emails"], function () {
	Route::get('create', [EmailsController::class, 'create']);
});