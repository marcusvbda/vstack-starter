<?php

namespace App\Http\Controllers;

use App\Http\Models\{Role, Permission};
use Illuminate\Http\Request;
use ResourcesHelpers;
use marcusvbda\vstack\Services\Messages;
use Cache;

class RolesController extends Controller
{
	public function create()
	{
		$resource = ResourcesHelpers::find("grupos-de-acesso");
		if (!$resource->canCreate()) abort(401);
		$permissions = $this->getGroupedPermissions();
		return view("admin.roles.create", compact("resource", "permissions"));
	}

	private function getGroupedPermissions()
	{
		$groups = Permission::orderBy("description")->groupBy("group")->pluck("group")->toArray();
		foreach ($groups as $group) $values[$group] = Permission::whereGroup($group)->get()->chunk(4);
		return $values;
	}

	public function store(Request $request)
	{
		$role = @$request["id"] ? Role::findOrFail($request["id"]) : new Role();
		$this->validate($request, $role->getRules());
		$data = [
			"Description" => $request["description"],
			"name" => $role->makeRoleName($request["description"])
		];
		$role->fill($data);
		$role->save();
		$role->syncPermissions(); //remove all old permissions
		foreach ($request["permissions"] as $permission => $value) {
			if ($value) $role->givePermissionTo($permission);
		}
		Messages::send("success", "Grupo de Acesso salvo com sucesso");
		Cache::flush('spatie.permission.cache');
		Cache::flush('spatie.role.cache');
		return ["success" => true];
	}

	public function edit($id)
	{
		$resource = ResourcesHelpers::find("grupos-de-acesso");
		if (!$resource->canUpdate()) abort(401);
		$role = $resource->model->findOrFail($id);
		$permissions = $this->getGroupedPermissions();
		return view("admin.roles.edit", compact("resource", "permissions", "role"));
	}
}