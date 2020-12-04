<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run()
	{
		Auth::logout();
		$this->call($this->getAllSeeder());
	}

	private function getAllSeeder()
	{
		$seeders = glob(database_path('/seeds/*.php'));
		$_seeders = [];
		foreach ($seeders as $file) {
			require_once $file;
			$classString = basename($file, '.php');
			if ($classString != "DatabaseSeeder") $_seeders[] = get_class(new $classString);
		}
		return $_seeders;
	}
}