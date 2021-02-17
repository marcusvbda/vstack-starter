<?php

namespace App\Http\Resources;

use marcusvbda\vstack\Resource;
use marcusvbda\vstack\Fields\{
	Card,
	Text,
	Radio,
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
			new Radio([
				"label" => "Tipo da Resposta",
				"description" => "O tipo da resposta que o operador recebeu para o contato realizado",
				"field" => "type",
				"required" => true,
				// "default" => "Resposta Neutra",
				"options" => ["Resposta Neutra", "Resposta Negativa", "Resposta Positiva"]
			]),
			new Radio([
				"label" => "Comportamento",
				"description" => "Como o sistema deve se comportar caso essa resposta seja selecionada pelo operador",
				"field" => "behavior",
				"required" => true,
				// "default" => "Solicitar Agendamento",
				"options" => ["Solicitar Objeção", "Solicitar Agendamento"]
			])
		];
		$cards = [new Card("Informações Básicas", $fields)];
		return $cards;
	}
}