<?php

namespace App\Http\Resources;

use marcusvbda\vstack\Resource;
use Auth;

class GruposDeAcesso extends Resource
{
	public $model = \App\Http\Models\Role::class;

	public function globallySearchable()
	{
		return false;
	}

	public function label()
	{
		return "Grupos de Acesso";
	}

	public function singularLabel()
	{
		return "Grupo de Acesso";
	}

	public function icon()
	{
		return "el-icon-lock";
	}

	public function search()
	{
		return ["name", "description"];
	}

	public function table()
	{
		$user = Auth::user();
		$columns = [];
		$columns["code"] = ["label" => "Código", "sortable_index" => "id"];
		$columns["description"] = ["label" => "Nome"];
		$columns["name"] = ["label" => "Valor"];
		if ($user->hasRole(["super-admin"])) $columns["tenant->name"] = ["label" => "Tenant", "sortable_index" => "tenant_id"];
		$columns["f_access_level"] = ["label" => "Nível de Acesso", "sortable" => false];
		$columns["f_created_at_for_humans"] = ["label" => "", "sortable_index" => "created_at"];
		return $columns;
	}

	public function canCreate()
	{
		return Auth::user()->hasRoles(["super-admin", "admin"]);
	}

	public function canUpdate()
	{
		return Auth::user()->hasRoles(["super-admin", "admin"]);
	}

	public function canDelete()
	{
		return Auth::user()->hasRoles(["super-admin", "admin"]);
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
		return Auth::user()->hasRoles(["super-admin", "admin"]);
	}

	public function canView()
	{
		return false;
	}


	public function nothingStoredText()
	{
		return "<h4>Nada cadastrado ainda além de seu grupo...<h4>";
	}

	public function nothingStoredSubText()
	{
		return "<span>Clique no botão abaixo para adicionar o primeiro registro, se seu usuário possuir tal permissão ...</span>";
	}

	public function beforeListSlot()
	{
		return '
        <div class="alert alert-warning" role="alert">
            <strong>Atenção ! </strong>Este listagem de <b>Grupos de Acesso</b>, contém todos os grupos exceto o administrador, pois o usuário não pode alterar seu próprio grupo de acesso ).
        </div>';
	}
}