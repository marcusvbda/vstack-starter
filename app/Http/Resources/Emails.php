<?php

namespace App\Http\Resources;

use marcusvbda\vstack\Resource;
use marcusvbda\vstack\Fields\{
	Card,
	Text,
	HtmlEditor
};

class Emails extends Resource
{
	public $model = \App\Http\Models\Email::class;
	public $_filters = [];

	public function label()
	{
		return "Emails";
	}

	public function singularLabel()
	{
		return "Email";
	}

	public function icon()
	{
		return "el-icon-s-promotion";
	}

	public function search()
	{
		return ["name", "subject"];
	}

	public function table()
	{
		$columns = [];
		$columns["code"] = ["label" => "Código", "sortable_index" => "id", "size" => "100px"];
		$columns["name"] = ["label" => "Nome"];
		$columns["subject"] = ["label" => "Assunto"];
		return $columns;
	}

	public function canCreate()
	{
		return hasPermissionTo("create-emails");
	}

	public function canUpdate()
	{
		return hasPermissionTo("edit-emails");
	}

	public function canDelete()
	{
		return hasPermissionTo("destroy-emails");
	}

	public function canViewList()
	{
		return hasPermissionTo("viewlist-emails");
	}

	public function canView()
	{
		return false;
	}

	public function canViewReport()
	{
		return false;
	}

	public function canImport()
	{
		return false;
	}

	public function canExport()
	{
		return false;
	}

	public function export_columns()
	{
		return [
			"code" => ["label" => "Código"],
			"name" => ["label" => "Nome"],
			"subject" => ["label" => "Assunto"],
		];
	}

	public function fields()
	{
		return [
			new Card("Identificação", [
				new Text([
					"label" => "Nome",
					"field" => "name",
					"rules" => ["required", "max:255"]
				]),
				new Text([
					"label" => "Assunto",
					"field" => "subject",
					"rules" => ["required", "max:255"]
				]),
				new HtmlEditor([
					"label" => "Corpo do Email",
					"field" => "body",
					"mode" => "newsletter"
				]),
			]),
		];
	}
}