<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuoteRequestPart extends Model {
	protected $table = 'quote_request_parts';
	protected $primaryKey = 'part_id';

	protected $fillable = ['rfno', 'part_id', 'part_desc', 'part_comment'];

	public function quoteRequest(): BelongsTo {
		return $this->belongsTo(QuoteRequest::class, 'rfno', 'rfno');
	}

	public function partQuote(): HasMany {
		return $this->hasMany(PartQuote::class, 'id', 'quote_request_part_id');
	}
}
