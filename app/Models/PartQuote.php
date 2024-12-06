<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PartQuote extends Model {
	protected $table = 'part_quote';
	protected $primaryKey = 'id';

	protected $fillable = ['rfno', 'quote_request_part_id', 'price', 'delivery', 'condition', 'user_id'];

	public function quoteRequestPart(): BelongsTo {
		return $this->belongsTo(QuoteRequestPart::class, 'quote_request_part_id', 'id');
	}

	public function quoteRequest(): BelongsTo {
		return $this->belongsTo(QuoteRequest::class, 'rfno', 'rfno');
	}

	public function user(): BelongsTo {
		return $this->belongsTo(User::class, 'user_id', 'id');
	}
}
