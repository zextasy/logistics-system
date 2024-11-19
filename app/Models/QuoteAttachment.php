<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }
}
