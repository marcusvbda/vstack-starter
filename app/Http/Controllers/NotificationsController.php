<?php

namespace App\Http\Controllers;

use Auth;

class NotificationsController extends Controller
{
	public function index()
	{
		$user = Auth::user();
		$qty = $user->userNotifications()->isNew()->count();
		$user->userNotifications()->isNew()->update(["new" => false]);
		return view('admin.notifications.index', compact("qty", "user"));
	}

	public function getQty()
	{
		$user = Auth::user();
		return ['qty' => $user->getQyNewNotifications()];
	}
}