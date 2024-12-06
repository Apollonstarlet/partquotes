<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up() {
		Schema::create('part_quote', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('rfno');
			$table
				->foreign('rfno')
				->references('rfno')
				->on('quote_requests');
			$table->unsignedBigInteger('quote_request_part_id');
			$table
				->foreign('quote_request_part_id')
				->references('id')
				->on('quote_request_parts')
				->onDelete('cascade');
			$table->unsignedBigInteger('price');
			$table->string('condition');
			$table->string('guarantee');
			$table->unsignedBigInteger('user_id');
			$table
				->foreign('user_id')
				->references('id')
				->on('users');
			$table->timestamps();
		});
	}

	public function down() {
		Schema::dropIfExists('part_quote');
	}
};
