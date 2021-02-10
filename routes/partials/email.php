<?php

use App\Http\Controllers\EmailController;

Route::group(['prefix' => "emails"], function () {
	Route::get('create', [EmailController::class, 'create']);
	Route::post('store', [EmailController::class, 'store']);
	Route::get('{code}/edit', [EmailController::class, 'edit'])->middleware(['hashids:code'])->name("resource.edit");
});