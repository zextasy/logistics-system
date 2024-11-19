<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shipment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'tracking_number',
        'type',
        'status',
        'origin_country',
        'origin_city',
        'origin_address',
        'origin_postal_code',
        'destination_country',
        'destination_city',
        'destination_address',
        'destination_postal_code',
        'weight',
        'weight_unit',
        'dimensions',
        'description',
        'container_size',
        'service_type',
        'shipper_name',
        'shipper_phone',
        'shipper_email',
        'receiver_name',
        'receiver_phone',
        'receiver_email',
        'current_location',
        'estimated_delivery',
        'actual_delivery',
        'special_instructions',
        'customs_status',
        'customs_documents',
        'customs_cleared',
        'declared_value',
        'currency',
        'charges',
        'insurance_required',
        'insurance_amount',
        'metadata'
    ];

    protected $casts = [
        'dimensions' => 'array',
        'customs_documents' => 'array',
        'charges' => 'array',
        'metadata' => 'array',
        'estimated_delivery' => 'datetime',
        'actual_delivery' => 'datetime',
        'insurance_required' => 'boolean',
        'customs_cleared' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function routes()
    {
        return $this->hasMany(ShipmentRoute::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function getCurrentRouteAttribute()
    {
        return $this->routes()
            ->where('arrival_date', '<=', now())
            ->orderBy('order', 'desc')
            ->first();
    }
}
