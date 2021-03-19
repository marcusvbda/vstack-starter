<?php

namespace App\Http\Resources;

use marcusvbda\vstack\Resource;
use App\Http\Models\Campaign;

class Campanhas extends Resource
{
	public $model = Campaign::class;

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
		return "el-icon-connection";
	}

	public function search()
	{
		return ["name"];
	}

	public function table()
	{
		$columns = [];
		$columns["code"] = ["label" => "Código", "sortable_index" => "id", "size" => "100px"];
		$columns["name"] = ["label" => "Nome"];
		// $columns["subject"] = ["label" => "Assunto"];
		return $columns;
	}

	public function canCreate()
	{
		return hasPermissionTo("create-campaigns");
	}

	public function canUpdate()
	{
		return hasPermissionTo("edit-campaigns");
	}

	public function canDelete()
	{
		return hasPermissionTo("destroy-campaigns");
	}

	public function canViewList()
	{
		return hasPermissionTo("viewlist-campaigns");
	}

	public function canUpdateRow($row)
	{
		$campaign = Campaign::findOrFail($row->id);
		return !$campaign->protected;
	}

	public function canDeleteRow($row)
	{
		$campaign = Campaign::findOrFail($row->id);
		return !$campaign->protected;
	}

	public function canView()
	{
		return false;
	}

	public function canViewReport()
	{
		return hasPermissionTo('report-campaigns');
	}

	public function canImport()
	{
		return false;
	}

	public function canExport()
	{
		return hasPermissionTo('report-campaigns');
	}

	public function export_columns()
	{
		return [
			"code" => ["label" => "Código"],
			"name" => ["label" => "Nome"]
		];
	}

	// public function fields()
	// {
	// 	$content = request("content");
	// 	$default = (object)["css" => "", "body" => ""];
	// 	if (!@$content->id && @request("template")) {
	// 		$template = EmailTemplate::where("slug", request("template"))->first();
	// 		$default = $template ? $template->body : (object)["css" => "", "body" => ""];
	// 	}
	// 	return [
	// 		new Card("Identificação", [
	// 			new Text([
	// 				"label" => "Nome",
	// 				"field" => "name",
	// 				"rules" => ["required", "max:255"],
	// 			]),
	// 		]),
	// 		new Card("Email", [
	// 			new Text([
	// 				"label" => "Assunto",
	// 				"field" => "subject",
	// 				"rules" => ["required", "max:255"]
	// 			]),
	// 			new HtmlEditor([
	// 				"label" => "Corpo do Email",
	// 				"field" => "body",
	// 				"mode" => "newsletter",
	// 				"default" => $default
	// 			]),
	// 		]),
	// 	];
	// }
}