<?php

namespace App\Http\Resources;

use marcusvbda\vstack\Resource;
use Auth;

class Campanhas extends Resource
{
	public $model = \App\Http\Models\Campaign::class;

	public function label()
	{
		return "Campanhas";
	}

	public function singularLabel()
	{
		return "Campanha";
	}

	public function icon()
	{
		return "el-icon-magic-stick";
	}

	public function search()
	{
		return ["name", "description"];
	}

	// public function table()
	// {
	// 	$user = Auth::user();
	// 	$columns = [];
	// 	$columns["code"] = ["label" => "Código", "sortable_index" => "id"];
	// 	$columns["description"] = ["label" => "Nome"];
	// 	$columns["name"] = ["label" => "Valor"];
	// 	if ($user->hasRole(["super-admin"])) $columns["tenant->name"] = ["label" => "Tenant", "sortable_index" => "tenant_id"];
	// 	$columns["f_access_level"] = ["label" => "Nível de Acesso", "sortable" => false];
	// 	$columns["f_created_at_for_humans"] = ["label" => "", "sortable_index" => "created_at"];
	// 	return $columns;
	// }

	public function canCreate()
	{
		return Auth::user()->hasRole(["super-admin", "admin"]);
	}

	public function canUpdate()
	{
		return Auth::user()->hasRole(["super-admin", "admin"]);
	}

	public function canDelete()
	{
		return Auth::user()->hasRole(["super-admin", "admin"]);
	}

	public function canImport()
	{
		return false;
	}

	public function canExport()
	{
		return false;
	}

	public function canViewList()
	{
		return Auth::user()->hasRole(["super-admin", "admin"]);
	}

	public function canView()
	{
		return false;
	}
}