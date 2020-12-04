<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePolos extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('polos', function (Blueprint $table) {
			$table->charset = 'utf8';
			$table->collation = 'utf8_unicode_ci';
			$table->engine = 'InnoDB';
			$table->bigIncrements('id');
			$table->string('name');
			$table->jsonb('data')->nullable();
			$table->unsignedBigInteger('tenant_id');
			$table->foreign('tenant_id')
				->references('id')
				->on('tenants')
				->onDelete('restrict');
			$table->softDeletes();
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
		Schema::dropIfExists('tenants');
	}
}