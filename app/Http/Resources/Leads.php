<?php

namespace App\Http\Resources;

use marcusvbda\vstack\Resource;
use App\Http\Models\Lead;
use App\Http\Filters\Leads\{LeadsByName};
use App\Http\Actions\Leads\TestAction;

class Leads extends Resource
{
	public $model = Lead::class;

	public function label()
	{
		return "Leads";
	}

	public function resultsPerPage()
	{
		return [20, 50, 100, 200, 500];
	}

	public function singularLabel()
	{
		return "Lead";
	}

	public function icon()
	{
		return "el-icon-attract";
	}

	public function search()
	{
		return ["data->name", "data->email"];
	}

	public function table()
	{
		$columns = [];
		$columns["code"] = ["label" => "Código", "sortable_index" => "id", "size" => "100px"];
		$columns["data->name"] = ["label" => "Nome", "sortable_index" => "data->name"];
		$columns["email_url"] = ["label" => "Email", "sortable_index" => "data->email"];
		$columns["phones_url"] = ["label" => "Telefones", "sortable_index" => "data->phones"];
		$columns["origin"] = ["label" => "Origem", "sortable" => false];
		$columns["f_created"] = ["label" => "Data", "sortable_index" => "created_at"];
		return $columns;
	}

	public function canCreate()
	{
		return hasPermissionTo("create-leads");
	}

	public function canUpdate()
	{
		return hasPermissionTo("edit-leads");
	}

	public function canDelete()
	{
		return hasPermissionTo("destroy-leads");
	}

	public function canViewList()
	{
		return hasPermissionTo("viewlist-leads");
	}

	public function canView()
	{
		return hasPermissionTo("view-leads");
	}

	public function canViewReport()
	{
		return hasPermissionTo("view-report-leads");
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
			"data->name" => ["label" => "Nome"],
			"data->email" => ["label" => "Email"],
			"phones" => ["label" => "Telefones", "handler" => function ($row) {
				return implode(" - ", $row->data->phones);
			}],
			"data->interest" => ["label" => "Interesse"],
			"data" => ["label" => "Data", "handler" => function ($row) {
				return formatDate($row->created_at);
			}],
		];
	}

	public function filters()
	{
		$filters[] = new LeadsByName();
		return $filters;
	}

	public function actions()
	{
		return [
			new TestAction()
		];
	}
}