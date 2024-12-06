<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migration.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('quote_requests', function (Blueprint $table) {
			$table->timestamp('completed')->nullable();
			$table->index('completed');
		});
	}

	/**
	 * Reverse the migration.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('quote_requests', function (Blueprint $table) {
			$table->dropIndex(['completed']);
			$table->dropColumn('completed');
		});
	}
};
