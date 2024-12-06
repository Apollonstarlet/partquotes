<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('quote_request_parts', function (Blueprint $table) {
			$table->id();
			$table->timestamps();
			$table->unsignedBigInteger('rfno')->index();
			$table->string('part_id')->unique();
			$table->string('part_desc')->nullable();
			$table->text('part_comment')->nullable();

			$table
				->foreign('rfno')
				->references('rfno')
				->on('quote_requests')
				->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('quote_request_parts');
	}
};
