<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quote extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'reference_number',
        'user_id',
        'name',
        'company',
        'email',
        'phone',
        'country',
        'origin_country',
        'origin_city',
        'origin_postal_code',
        'destination_country',
        'destination_city',
        'destination_postal_code',
        'description',
        'cargo_type',
        'estimated_weight',
        'weight_unit',
        'dimensions',
        'pieces_count',
        'service_type',
        'container_size',
        'incoterm',
        'expected_ship_date',
        'insurance_required',
        'customs_clearance_required',
        'pickup_required',
        'packing_required',
        'special_requirements',
        'status',
        'assigned_to',
        'quoted_price',
        'currency',
        'admin_notes',
        'pricing_details',
        'processed_at',
        'valid_until'
    ];

    protected $casts = [
        'dimensions' => 'array',
        'pricing_details' => 'array',
        'insurance_required' => 'boolean',
        'customs_clearance_required' => 'boolean',
        'pickup_required' => 'boolean',
        'packing_required' => 'boolean',
        'expected_ship_date' => 'date',
        'processed_at' => 'datetime',
        'valid_until' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function attachments()
    {
        return $this->hasMany(QuoteAttachment::class);
    }
}
