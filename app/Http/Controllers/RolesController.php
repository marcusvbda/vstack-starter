<?php

namespace App\Http\Controllers;

use App\Http\Models\{Role, Permission};
use Illuminate\Http\Request;
use ResourcesHelpers;
use marcusvbda\vstack\Services\Messages;
use Cache;

class RolesController extends Controller
{
	private function getGroupedPermissions()
	{
		$groups = Permission::orderBy("description")->groupBy("group")->pluck("group")->toArray();
		foreach ($groups as $group) $values[$group] = Permission::whereGroup($group)->get()->chunk(4);
		return $values;
	}

	public function store(Request $request)
	{
		$resource = ResourcesHelpers::find($request["resource_id"]);
		if (!$resource->canCreate()) abort(401);


		$validation_custom_message =  $resource->getValidationRuleMessage();
		$this->validate($request, $resource->getValidationRule(), @$validation_custom_message ? $validation_custom_message : []);

		$role = @$request["id"] ? Role::findOrFail($request["id"]) : new Role();
		$role->description  = $request["description"];
		$role->save();
		$role->syncPermissions(); //remove all old permissions

		$permissions = $request->except(["id", "description", "resource_id"]);

		array_map(function ($key) use ($role, $permissions) {
			if ($permissions[$key]) return $role->givePermissionTo(str_replace("_", "-", $key));
		}, array_keys($permissions));

		Messages::send("success", "Grupo de Acesso salvo com sucesso");
		Cache::flush('spatie.permission.cache');
		Cache::flush('spatie.role.cache');
		return ["success" => true, "route" => route('resource.index', ["resource" => $resource->id])];
	}
}