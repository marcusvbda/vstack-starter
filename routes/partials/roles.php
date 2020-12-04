<?php

use App\Http\Controllers\RolesController;

Route::group(["prefix" => "grupos-de-acesso"], function () {
	Route::get('create', [RolesController::class, 'create']);
	Route::post('store', [RolesController::class, 'store']);
	Route::get('{code}/edit', [RolesController::class, 'edit'])->middleware(['hashids:code']);
});