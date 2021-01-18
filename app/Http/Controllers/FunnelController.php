<?php

namespace App\Http\Controllers;

use App\Http\Constants\Leads\Statuses;
use Illuminate\Http\Request;
use ResourcesHelpers;

class FunnelController extends Controller
{
	public function index(Request $request)
	{
		$resource = ResourcesHelpers::find("leads");
		$status = Statuses::options();
		return view("admin.leads.funnel", compact('resource', 'status'));
	}
}