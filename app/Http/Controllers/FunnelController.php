<?php

namespace App\Http\Controllers;

use App\Http\Constants\Leads\Statuses;
use Illuminate\Http\Request;
use ResourcesHelpers;
use marcusvbda\vstack\Controllers\ResourceController;

class FunnelController extends Controller
{
	public function index(Request $request)
	{
		$resource = static::getProcessedResource();
		$status = Statuses::options();
		return view("admin.leads.funnel", compact('resource', 'status'));
	}

	public function filter(Request $request)
	{
		$resource = static::getProcessedResource();
		$data = (new ResourceController)->getData($resource, $request);
		$total = $data->count();
		$leads = $data->where("status", @Statuses::getIndex($request["status"]))
			->select("*")
			->paginate($request["per_page"] ? $request["per_page"] : $resource->resultsPerPage()[0]);
		return ["total" => $total, "leads" => $leads];
	}

	public static function getProcessedResource()
	{
		$resource = ResourcesHelpers::find("leads");
		$_filters = [];
		$filters = $resource->filters();
		foreach ($filters as $row) if (get_class($row) != \App\Http\Filters\Leads\LeadsByStatus::class) $_filters[] = $row;
		$filters = $_filters;
		$resource->_filters = $_filters;
		return $resource;
	}
}