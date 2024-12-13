<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuoteAttachment extends Model
{
    protected $fillable = [
        'quote_id',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
        'description'
    ];

    public function quote(): BelongsTo
    {
        return $this->belongsTo(Quote::class);
    }
}
