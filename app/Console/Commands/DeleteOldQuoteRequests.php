<?php

namespace App\Console\Commands;

use App\Models\QuoteRequest;
use Illuminate\Console\Command;

class DeleteOldQuoteRequests extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'cleanup:quote-requests';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Removes Old Quote Requests';

	/**
	 * Execute the console command.
	 *
	 * @return int
	 */
	public function handle() {
		$date = now()->subDays(14);

		// Delete the old QuoteRequests
		QuoteRequest::where('created_at', '<=', $date)
			->whereNull('completed')
			->delete();

		// Output a success message
		$this->info('Old QuoteRequests deleted successfully.');
	}
}
