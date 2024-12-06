<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuoteRequest extends Model {
	protected $table = 'quote_requests';
	protected $primaryKey = 'rfno';

	protected $fillable = [
		'rfno',
		'date',
		'multi',
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
		'completed',
	];

	public function quoteParts(): HasMany {
		return $this->hasMany(QuoteRequestPart::class, 'rfno', 'rfno')->orderBy('created_at');
	}

	public function partQuotes(): HasMany {
		return $this->hasMany(PartQuote::class, 'rfno', 'rfno');
	}
}
