<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('campaigns', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->string('images')->nullable();
			$table->float('total_budget', 8, 2)->default(0);
			$table->float('daily_budget', 8, 2)->default(0);
			$table->timestamp('start_date')->nullable();
			$table->timestamp('end_date')->nullable();
			$table->integer('order_index')->nullable();
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
		Schema::dropIfExists('campaigns');
	}
}
