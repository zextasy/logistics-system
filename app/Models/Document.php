<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'shipment_id',
        'type',
        'reference_number',
        'file_path',
        'status',
        'generated_at',
        'expires_at',
        'notes',
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'array',
        'generated_at' => 'datetime',
        'expires_at' => 'datetime'
    ];

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }

    public function hasExpired()
    {
        return $this->expires_at && $this->expires_at->isPast();
    }
}
