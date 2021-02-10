<?php

namespace App\Http\Controllers;

use ResourcesHelpers;
use Illuminate\Http\Request;
use marcusvbda\vstack\Services\Messages;

class EmailController extends Controller
{
	public function create()
	{
		$resource = ResourcesHelpers::find("emails");
		if (!$resource->canCreate()) abort(403);
		return view("admin.emails.crud", compact("resource"));
	}

	public function edit($id)
	{
		$resource = ResourcesHelpers::find("emails");
		if (!$resource->canUpdate()) abort(403);
		$email = $resource->model->findOrFail($id);
		return view("admin.emails.crud", compact("resource", "email"));
	}

	public function store(Request $request)
	{
		$data = $request->all();
		$resource = ResourcesHelpers::find("emails");

		if (!@$data["id"]) {
			if (!$resource->canCreate()) abort(403);
		} else {
			if (!$resource->canUpdate()) abort(403);
		}

		$validation_custom_message =  $resource->getValidationRuleMessage();
		$this->validate($request, $resource->getValidationRule(), @$validation_custom_message ? $validation_custom_message : []);
		$target = @$data["id"] ? $resource->model->findOrFail($data["id"]) : new $resource->model();
		$target->fill($data);
		$target->save();

		Messages::send("success", "Registro salvo com sucesso !!");
		return ["success" => true, "route" => route('resource.index', ["resource" => $resource->id])];
	}
}