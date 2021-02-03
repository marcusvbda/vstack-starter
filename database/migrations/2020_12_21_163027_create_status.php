<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatus extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lead_statuses', function (Blueprint $table) {
			$table->charset = 'utf8mb4';
			$table->collation = 'utf8mb4_unicode_ci';
			$table->engine = 'InnoDB';
			$table->bigIncrements('id');
			$table->integer('seq')->default(0);
			$table->jsonb('data');
			$table->string("ref")->nullable();
			$table->string("value");
			$table->string("name");
			$table->timestamps();
		});

		Schema::create('lead_substatuses', function (Blueprint $table) {
			$table->charset = 'utf8mb4';
			$table->collation = 'utf8mb4_unicode_ci';
			$table->engine = 'InnoDB';
			$table->bigIncrements('id');
			$table->integer('seq')->default(0);
			$table->jsonb('data');
			$table->string("ref")->nullable();
			$table->string("value");
			$table->string("name");
			$table->unsignedBigInteger('lead_status_id');
			$table->foreign('lead_status_id')
				->references('id')
				->on('lead_statuses');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('lead_statuses');
		Schema::dropIfExists('lead_substatuses');
	}
}
