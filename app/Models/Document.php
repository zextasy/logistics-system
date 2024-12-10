<?php

namespace App\Models;

use App\Helpers\DocumentTextHelper;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use SoftDeletes;
    use HasFactory;

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

    protected function additionalClause(): Attribute
    {
        return Attribute::make(
            get: fn () => ((new DocumentTextHelper())->getTextForDocumentAdditionalClause($this)),
        );
    }

    protected function exportReference(): Attribute
    {
        return Attribute::make(
            get: fn () => ((new DocumentTextHelper())->getTextForDocumentExportReference($this)),
        );
    }


}
