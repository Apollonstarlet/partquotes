<?php

namespace App\Console\Commands;

use App\Models\QuoteRequest;
use App\Models\QuoteRequestPart;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use JsonException;
use Throwable;

class FetchQuoteRequests extends Command {
	protected $signature = 'fetch:quote-requests';

	protected $description = 'Fetch new quote requests from external endpoint';

	protected $makes = [
		'Alfa Romeo',
		'Audi',
		'Austin',
		'Bedford',
		'BMW',
		'Chevrolet',
		'Chrysler',
		'Citroen',
		'Dacia',
		'Daewoo',
		'Daihatsu',
		'Fiat',
		'Ford',
		'Honda',
		'Hyundai',
		'Isuzu',
		'Iveco',
		'Jaguar',
		'Jeep',
		'Kia',
		'Land Rover',
		'LDV',
		'Lexus',
		'Lotus',
		'Mazda',
		'Mercedes',
		'MG',
		'Mini',
		'Mitsubishi',
		'Morris',
		'Nissan',
		'Opel',
		'Peugeot',
		'Porsche',
		'Proton',
		'Reliant',
		'Renault',
		'Rover',
		'Saab',
		'Seat',
		'Skoda',
		'Smart',
		'Ssangyong',
		'Subaru',
		'Suzuki',
		'Talbot',
		'Toyota',
		'Vauxhall',
		'Volkswagen',
		'Volvo',
	];

	private const QUOTE_ATTRIBUTES = [
		'rfno',
		'cdes',
		'cmak',
		'cran',
		'cyer',
		'cbdy',
		'cbdt',
		'cgbx',
		'cfue',
		'cvin',
		'cenn',
		'cccs',
		'cclr',
		'creg',
		'unam',
		'uloc',
		'upos',
		'uphn',
		'umob',
		'ueml',
	];

	private const ATTRIBUTES_FORMAT_EXCLUDE = ['cyer', 'cenn', 'cvin'];

	protected static function formatText($text): string {
		return ucwords(strtolower($text));
	}

	/**
	 * @throws JsonException
	 */
	public function handle() {
		$lastReference = QuoteRequest::max('rfno') ?: 1;

		$params = http_build_query(['username' => 'c232', 'password' => env('FIRST_CHOICE_PASSWORD'), 'lastRef' => $lastReference]);
		$response = Http::get('http://webserv.1stchoice.co.uk/1stchoiceServices/SupplierPub.asmx/GetOrders?' . $params);

		if (!$response->successful()) {
			$this->error('Failed to fetch quote requests: ' . $response->body());

			return;
		}

		$xml = html_entity_decode($response->body());
		$xml = preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $xml);
		$xml = @simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);

		if (!$xml) {
			$this->error('Failed to parse XML: ' . $response->body());

			return;
		}

		$json = json_decode(json_encode($xml, JSON_THROW_ON_ERROR), true, 512, JSON_THROW_ON_ERROR);

		$quoteRequests = $json['rqs']['rq'] ?? [];

		if (empty($quoteRequests)) {
			$this->info('No new requests');

			return;
		}

		foreach ($quoteRequests as $quoteRequest) {
			try {
				$quoteRequestModel = new QuoteRequest();

				$partQuotes = isset($quoteRequest['part']['pid']) ? [$quoteRequest['part']] : $quoteRequest['part'];

				$quoteDate = Carbon::createFromFormat('d/m/Y H:i:s', $quoteRequest['date']);
				$quoteRequestModel->date = $quoteDate;
				$quoteRequestModel->multi = count($partQuotes) > 1;

				if (empty($quoteRequest['rfno'])) {
					Log::warning('Quote Request has no rfno');
					continue;
				}

				// Take possible values from description field if not present
				if (!empty($quoteRequest['cdes'])) {
					if (empty($quoteRequest['cfue'])) {
						if (stripos($quoteRequest['cdes'], 'petrol') !== false) {
							$quoteRequest['cfue'] = 'Petrol';
						}
						if (stripos($quoteRequest['cdes'], 'diesel') !== false) {
							$quoteRequest['cfue'] = 'Diesel';
						}
					}

					if (empty($quoteRequest['cyer'])) {
						preg_match('/\b\d{4}\b/', $quoteRequest['cdes'], $matches);
						$quoteRequest['cyer'] = $matches[0] && (int) $matches[0] > 1960 ? $matches[0] : null;
					}

					if (empty($quoteRequest['cmak'])) {
						foreach ($this->makes as $make) {
							if (str_contains(strtolower($quoteRequest['cdes']), strtolower($make))) {
								$quoteRequest['cmak'] = $make;
							}
						}
					}
				}

				foreach (self::QUOTE_ATTRIBUTES as $attribute) {
					if (empty($quoteRequest[$attribute])) {
						continue;
					}

					$quoteRequestModel->{$attribute} = in_array($attribute, self::ATTRIBUTES_FORMAT_EXCLUDE)
						? $quoteRequest[$attribute]
						: self::formatText($quoteRequest[$attribute]);
				}

				$quoteRequestModel->save();

				foreach ($partQuotes as $partQuote) {
					if (empty($partQuote['pid'])) {
						Log::warning('Part Quote has no PID');
						continue;
					}

					$requestPart = new QuoteRequestPart();
					$requestPart->rfno = $quoteRequest['rfno'];
					$requestPart->part_id = $partQuote['pid'];
					$requestPart->part_desc = self::formatText($partQuote['pdsc']);
					$requestPart->part_comment = is_array($partQuote['pcmt']) ? implode(', ', $partQuote['pcmt']) : $partQuote['pcmt'];
					$requestPart->save();
				}
			} catch (Throwable $t) {
				$this->error($t->getMessage());
			}
		}

		$this->info('Finished processing.');
	}
}
