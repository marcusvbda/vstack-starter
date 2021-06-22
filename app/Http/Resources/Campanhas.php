<?php

namespace App\Http\Resources;

use marcusvbda\vstack\Resource;
use App\Http\Models\{Campaign, Polo};
use marcusvbda\vstack\Fields\{
	BelongsTo,
	Card,
	Text,
	DateTime,
};
use ResourcesHelpers;
use Auth;

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
		$columns["f_code"] = ["label" => "Código", "sortable_index" => "id", "size" => "100px"];
		$columns["name"] = ["label" => "Nome"];
		$columns["duration"] = ["label" => "Duração", "sortable" => false];
		$columns["f_coverage"] = ["label" => "Abrangencia", "sortable" => false];
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

	public function export_columns($cx)
	{
		return [
			"code" => ["label" => "Código"],
			"name" => ["label" => "Nome"]
		];
	}

	public function fields()
	{
		$content = @request()->content;
		$cards = [];
		$create_campaing_to_another_polo = hasPermissionTo('create-campaing-to-another-polo');
		$cards[] = new Card("Identificação", [
			new Text([
				"label" => "Nome",
				"field" => "name",
				"rules" => ["required", "max:255"]
			]),
			new DateTime([
				"label" => "Validade",
				"field" => "duedate",
				"required" => true,
				"type"  => "date",
				"format" => "dd/MM/yyyy",
				"value_format" => "yyyy-MM-dd"
			]),
			new BelongsTo([
				"label" => "Polo",
				"field" => "polo_id",
				"description" => $create_campaing_to_another_polo ? "Caso queira esta campanha seja para todos os polos apenas deixa esta opção em branco" : "",
				"options" => Polo::selectRaw("id as id, name as value")->get()->toArray(),
				"default" => (string)Auth::user()->polo_id,
				"disabled" => !$create_campaing_to_another_polo
			])
		]);

		$resource_leads = ResourcesHelpers::find("leads");
		$fields = [];
		foreach ($resource_leads->filters() as $filter) {
			switch ($filter->component) {
				case "text-filter":
					$fields[] = new Text([
						"label" => $filter->label,
						"field" => "filter_" . $filter->index,
						"type"  => "text",
						"default" => @$content->query_filters["filter_" . $filter->index]
					]);
					break;
				case "select-filter":
					$options = array_map(function ($row) {
						return (object)["id" => $row["value"], "value" => $row["label"]];
					}, $filter->options->toArray());
					$fields[] = new BelongsTo([
						"label" => $filter->label,
						"field" => "filter_" . $filter->index,
						"options"  => $options,
						"default" => @$content->query_filters["filter_" . $filter->index]
					]);
					break;
				case "rangedate-filter":
					$fields[] = new DateTime([
						"label" => $filter->label,
						"field" => "filter_" . $filter->index,
						"type"  => "daterange",
						"format" => "dd/MM/yyyy",
						"value_format" => "yyyy-MM-dd",
						"default" => @$content->query_filters["filter_" . $filter->index]
					]);
					break;
				default:
					// dd($filter, $fields);
					break;
			}
		}
		$cards[] = new Card("Parâmetros", $fields);
		return $cards;
	}
}
