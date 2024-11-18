<?php

// app/Models/Document.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipment_id',
        'type',
        'file_path',
        'generated_at',
        'expires_at',
        'status',
        'reference_number'
    ];

    protected $casts = [
        'generated_at' => 'datetime',
        'expires_at' => 'datetime'
    ];

    /**
     * Get the shipment that owns the document.
     */
    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }

    /**
     * Generate a unique reference number for the document.
     */
    public static function generateReferenceNumber()
    {
        return 'DOC-' . strtoupper(uniqid());
    }

    /**
     * Get the document's download URL.
     */
    public function getDownloadUrl()
    {
        return Storage::url($this->file_path);
    }

    /**
     * Check if the document has expired.
     */
    public function hasExpired()
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    /**
     * Get the document type display name.
     */
    public function getTypeDisplayName()
    {
        return [
            'airway_bill' => 'Airway Bill',
            'bill_of_lading' => 'Bill of Lading',
            'commercial_invoice' => 'Commercial Invoice',
            'packing_list' => 'Packing List',
        ][$this->type] ?? $this->type;
    }
}

