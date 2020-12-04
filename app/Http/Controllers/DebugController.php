<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Models\{UserNotification, Polo};

class DebugController extends Controller
{
	public function testUserNotification()
	{
		$user = User::find(1);
		UserNotification::create([
			"user_id" => $user->id,
			"data" => [
				"mensagem" => "bla bla bla",
				"icon" => "bla bla "
			]
		]);
		return ['success' => true];
	}

	public function testPoloNotification()
	{
		$polo = Polo::find(8);
		foreach ($polo->getAllPossibleUsers() as  $user) {
			UserNotification::create([
				"user_id" => $user->id,
				"data" => [
					"mensagem" => "bla bla bla",
					"icon" => "bla bla "
				]
			]);
		}
		return ['success' => true];
	}
}