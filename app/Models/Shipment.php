<?php

namespace App\Models;

use App\Observers\ShipmentObserver;
use App\Enums\ShipmentServiceTypeEnum;
use App\Enums\ShipmentStatusEnum;
use App\Enums\ShipmentTypeEnum;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy([ShipmentObserver::class])]
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
        'loading_port',
        'origin_address',
        'origin_postal_code',
        'destination_country',
        'destination_city',
        'discharge_port',
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
        'shipper_address',
        'receiver_name',
        'receiver_phone',
        'receiver_email',
        'receiver_address',
        'consignee_name',
        'consignee_phone',
        'consignee_email',
        'consignee_address',
        'current_location',
        'vessel',
        'estimated_delivery',
        'actual_delivery',
        'date_of_shipment',
        'cargo_description',
        'cargo_weight',
        'cargo_weight_unit',
        'cargo_dimensions',
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
        'cargo_dimensions' => 'array',
        'metadata' => 'array',
        'estimated_delivery' => 'datetime',
        'actual_delivery' => 'datetime',
        'insurance_required' => 'boolean',
        'customs_cleared' => 'boolean',
        'type' => ShipmentTypeEnum::class,
        'status' => ShipmentStatusEnum::class,
        'service_type' => ShipmentServiceTypeEnum::class,
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
