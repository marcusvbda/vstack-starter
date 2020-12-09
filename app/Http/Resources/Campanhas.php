<?php

namespace App\Http\Resources;

use marcusvbda\vstack\Resource;
use marcusvbda\vstack\Fields\{
	Card,
	Text,
	BelongsTo,
};
use App\Http\Constants\Statuses\CampaignStatus;
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
		return "el-icon-attract";
	}

	public function search()
	{
		return ["name"];
	}

	public function table()
	{
		$columns = [];
		$columns["code"] = ["label" => "Código", "sortable_index" => "id"];
		$columns["name"] = ["label" => "Nome"];
		$columns["period"] = ["label" => "Periodo", "sortable_index" => "starts_at"];
		return $columns;
	}

	public function canCreate()
	{
		return hasPermissionTo("create-campaign");
	}

	public function canUpdate()
	{
		return hasPermissionTo("edit-campaign");
	}

	public function canDelete()
	{
		return hasPermissionTo("destroy-campaign");
	}

	public function canViewList()
	{
		return hasPermissionTo("viewlist-campaign");
	}

	public function canView()
	{
		return hasPermissionTo("view-campaign");
	}

	public function canImport()
	{
		return false;
	}

	public function canExport()
	{
		return false;
	}

	public function fields()
	{
		return [
			new Card("Informações Básicas", [
				new Text([
					"label" => "Nome",
					"field" => "name",
					"rules" => ['required', 'max:255'],
					"description" => "Identificação da campanha que você está criando"
				]),
				new Text([
					"label" => "Data de Início",
					"field" => "starts_at",
					"description" => "Data de início da campanha",
					"type" => "date"
				]),
				new Text([
					"label" => "Data de Fim",
					"field" => "ends_at",
					"description" => "Data de finalização da campanha",
					"type" => "date"
				]),
				new BelongsTo([
					"label" => "Status",
					"field" => "status",
					"rules" => ['required', 'max:255'],
					"description" => "Status da campanha que você está criando",
					"options" => CampaignStatus::options()
				]),
			])
		];
	}

	public function afterViewSlot()
	{
		$campaign = Campaign::findOrFail(request('code'));
		return view("admin.campaign.funnel_creator", compact('campaign'))->render();
	}
}