<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\{EmailTemplate};
use marcusvbda\vstack\Controllers\ResourceController;
use ResourcesHelpers;

class EmailsController extends Controller
{
	public function create(Request $request)
	{
		$resource = ResourcesHelpers::find("emails");
		if (!@$request->has("template")) {
			if (!@$resource->canCreate()) abort(403);
			$templates = EmailTemplate::get();
			return view("admin.emails.select_templates", compact("templates"));
		}
		$controller = new ResourceController;
		return $controller->create($resource->id, $request);
	}
}