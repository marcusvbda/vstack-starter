<?php

namespace App\Http\Resources;

use marcusvbda\vstack\Resource;
use marcusvbda\vstack\Fields\{
	Card,
	Text,
	BelongsTo,
};

class RespostasContato extends Resource
{
	public $model = \App\Http\Models\LeadAnswer::class;

	public function globallySearchable()
	{
		return false;
	}

	public function label()
	{
		return "Resposta de Contato";
	}

	public function singularLabel()
	{
		return "Respostas de Contato";
	}

	public function icon()
	{
		return "el-icon-s-management";
	}

	public function search()
	{
		return ["description"];
	}

	public function table()
	{
		$columns = [];
		$columns["code"] = ["label" => "#", "sortable_index" => "id"];
		$columns["description"] = ["label" => "Descrição"];
		$columns["type"] = ["label" => "Tipo da Resposta"];
		$columns["behavior"] = ["label" => "Comportamento"];
		return $columns;
	}

	public function canCreate()
	{
		return hasPermissionTo("create-leadanswer");
	}

	public function canUpdate()
	{
		return hasPermissionTo("edit-leadanswer");
	}

	public function canDelete()
	{
		return hasPermissionTo("destroy-leadanswer");
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
		return hasPermissionTo("viewlist-leadanswer");
	}

	public function canView()
	{
		return false;
	}

	public function fields()
	{
		$fields = [
			new Text([
				"label" => "Descrição",
				"field" => "description",
				"required" => true,
				"rules" => "max:255"
			]),
			new BelongsTo([
				"label" => "Tipo da Resposta",
				"field" => "type",
				"required" => true,
				"options" => ["Resposta Neutra", "Resposta Negativa", "Resposta Positiva"]
			]),
			new BelongsTo([
				"label" => "Comportamento",
				"field" => "behavior",
				"required" => true,
				"options" => ["Solicitar Objeção", "Solicitar Agendamento"]
			])
		];
		$cards = [new Card("Informações Básicas", $fields)];
		return $cards;
	}
}