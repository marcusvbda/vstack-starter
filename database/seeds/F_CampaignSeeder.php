<?php

use Illuminate\Database\Seeder;
use App\Http\Models\{
	Campaign,
	Tenant
};

class F_CampaignSeeder extends Seeder
{
	public function run()
	{
		DB::statement('SET AUTOCOMMIT=0;');
		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		$this->createDefaultCampaign();
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
		DB::statement('SET AUTOCOMMIT=1;');
		DB::statement('COMMIT;');
	}

	private function createDefaultCampaign()
	{
		Campaign::truncate();
		foreach (Tenant::get() as $tenant) {
			Campaign::create([
				"name" => "Campanha Padrão",
				"tenant_id" => $tenant->id,
				"protected" => true
			]);
		}
	}
}