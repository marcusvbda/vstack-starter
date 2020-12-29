<?php

use Illuminate\Database\Seeder;
use App\Http\Models\{
	Lead,
	ApiUser
};

class LeadsSeeder extends Seeder
{
	private $user_api = null;
	private $status_dictonary = [
		"AGENDAMENTO_I" => "Oportunidade",
		"AGENDAMENTO_A" => "Qualificado",
		"AGENDAMENTO_C" => "Não Qualificado",
		"AGENDAMENTO_F" => "Não Qualificado",
		"AGENDAMENTO_V" => "Cliente Convertido",
	];

	public function run()
	{
		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		$this->createUserApi();
		$this->createleads();
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
	}

	private function createUserApi()
	{
		DB::table("api_users")->truncate();
		$api_user = DB::connection("old_root_mysql")->table("_api_users")->where("client_id", "cb48038ef78ec109d520a673e1ee486b")->first();
		$this->user_api = ApiUser::create([
			"name" => $api_user->nome,
			"token" => $api_user->client_id,
			"secret_key" => $api_user->secret_key,
			"tenant_id" => 1,
		]);
	}

	private function createleads()
	{
		DB::table("leads")->truncate();
		$old_leads = DB::connection("old_mysql")->table("_leads")->join("_fila_contato", "_fila_contato.lead_id", "=", "_leads.id")
			->select("_leads.*", "_fila_contato.status_id")->get();
		foreach ($old_leads as $old_lead) {
			if (@$old_lead->id) {
				Lead::create([
					"tenant_id" => 1,
					"data" => [
						"name" => @$old_lead->nome,
						"email" => @$old_lead->email,
						"phones" => $this->getPhones($old_lead),
						"city" => @$old_lead->cidade,
						"interest" => @$old_lead->curso,
					],
					"api_user_id" => @$old_lead->observacoes == 'via RD Station' ? $this->user_api->id : null,
					"user_id" => @$old_lead->observacoes != 'via RD Station' ? 1 : null,
					"status" => $this->getCurrentStatus($old_lead),
					"created_at" => @$old_lead->created_at
				]);
			}
		}
	}

	private function getPhones($row)
	{
		$result = [];
		$result[] = @$row->telefone ?? "";
		$result[] = @$row->telefone_2 ?? "";
		return $result;
	}

	private function getCurrentStatus($row)
	{
		$status = DB::connection("old_mysql")->table("_status")->where("id", @$row->status_id)->first();
		return  @$this->status_dictonary[$status->for . "_" . $status->value];
	}
}