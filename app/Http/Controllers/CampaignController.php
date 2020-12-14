<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\{Campaign, CampaignFunnel};

class CampaignController extends Controller
{
	public function api($id, $action, Request $request)
	{
		$campaign = Campaign::findOrFail($id);
		return $this->{$action}($campaign, $request);
	}

	protected function update_sections($campaign, $request)
	{
		$data = $campaign->data;
		$data->sections = $request->toArray();
		$campaign->data = $data;
		return ["success" => $campaign->save()];
	}
}