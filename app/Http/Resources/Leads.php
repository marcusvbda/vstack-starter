<?php

namespace App\Http\Resources;

use marcusvbda\vstack\Resource;
use App\Http\Models\Lead;
use App\Http\Filters\Leads\{
	LeadsByName,
	LeadsByCreatedDate,
	LeadsByStatus
};
use App\Http\Actions\Leads\{
	LeadTransfer,
};
use marcusvbda\vstack\Fields\{
	Card,
	Text,
	TextArea,
};

class Leads extends Resource
{
	public $model = Lead::class;
	public $_filters = [];

	public function __construct()
	{
		$this->_filters = [
			new LeadsByName(),
			new LeadsByStatus(),
			new LeadsByCreatedDate()
		];
		parent::__construct();
	}

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
		$columns["btn_conversion"] = ["label" => "", "sortable" => false, "size" => "300px"];
		$columns["name"] = ["label" => "Nome", "sortable_index" => "data->name"];
		$columns["profession"] = ["label" => "Profissão", "sortable_index" => "data->profession"];
		$columns["email_url"] = ["label" => "Email", "sortable_index" => "data->email"];
		$columns["phones_url"] = ["label" => "Telefones", "sortable_index" => "data->phones"];
		$columns["origin"] = ["label" => "Origem", "sortable" => false];
		$columns["f_complete_created"] = ["label" => "Data", "sortable_index" => "created_at"];
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
		return false;
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
		return hasPermissionTo("view-report-leads");
	}


	public function export_columns()
	{
		return [
			"code" => ["label" => "Código"],
			"name" => ["label" => "Nome"],
			"f_status" => ["label" => "Status"],
			"profession" => ["label" => "Profissão"],
			"email" => ["label" => "Email"],
			"phones" => ["label" => "Telefones", "handler" => function ($row) {
				return implode(" - ", $row->data->phones);
			}],
			"interest" => ["label" => "Interesse"],
			"data" => ["label" => "Data", "handler" => function ($row) {
				return formatDate($row->created_at);
			}],
		];
	}

	public function filters()
	{
		return $this->_filters;
	}

	public function actions()
	{
		return [
			new LeadTransfer()
		];
	}

	public function fields()
	{
		return [
			new Card("Identificação", [
				new Text([
					"label" => "Nome Completo",
					"field" => "name",
					"rules" => ["required", "max:255"]
				]),
				new Text([
					"label" => "Profissão",
					"field" => "profession",
					"rules" => ["max:255"]
				]),
				new TextArea([
					"label" => "Interesse",
					"field" => "interest",
					"rows" => 10,
					"rules" => ["max:255"]
				]),
			]),
			new Card("Contato", [
				new Text([
					"label" => "Email",
					"field" => "email",
					"rules" => ["nullable", "max:255", "email"]
				]),
				new Text([
					"label" => "Telefone",
					"field" => "phone_number",
					"mask" => ["(##) ####-####", "(##) #####-####"],
					"rules" => ["max:255"]
				]),
				new Text([
					"label" => "Celular",
					"field" => "cellphone_number",
					"mask" => ["(##) ####-####", "(##) #####-####"],
					"rules" => ["max:255"]
				]),
			]),
			new Card("Localidade", [
				new Text([
					"label" => "Cep",
					"field" => "zipcode",
					"mask" => ["#####-###"],
					"rules" => ["max:255"]
				]),
				new Text([
					"label" => "Cidade",
					"field" => "city",
					"rules" => ["max:255"]
				]),
				new Text([
					"label" => "Bairro",
					"field" => "district",
					"rules" => ["max:255"]
				]),
				new Text([
					"label" => "Número",
					"field" => "address_number",
					"rules" => ["max:255"]
				]),
				new Text([
					"label" => "Complemento",
					"field" => "complementary",
					"rules" => ["max:255"]
				]),
			]),
			new Card("Informações Adicionais", [
				new TextArea([
					"label" => "Comentários",
					"field" => "comment",
					"rows" => 10,
					"rules" => ["max:255"]
				]),
				new TextArea([
					"label" => "Observações",
					"field" => "obs",
					"rows" => 10,
					"rules" => ["max:255"]
				]),
			]),
		];
	}

	// public function maxWaitingReportsByUser()
	// {
	// 	return 5;
	// }
}