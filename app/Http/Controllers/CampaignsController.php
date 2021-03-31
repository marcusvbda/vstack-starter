<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Models\{Campaign};

class CampaignsController extends Controller
{
	public function leadList($code)
	{
		$campaign = Campaign::findByCodeOrFail($code);
		dd($campaign);
	}
}