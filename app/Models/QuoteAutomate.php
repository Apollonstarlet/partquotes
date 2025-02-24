<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteAutomate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['part', 'make', 'model', 'year_from', 'year_to', 'price', 'delivery', 'condition', 'guarantee', 'supplier', 'comment', 'private'];
}
