<?php

namespace App\Models;

use App\Enums\ShipmentRouteLocationTypeEnum;
use App\Enums\ShipmentRouteStatusEnum;
use App\Observers\ShipmentRouteObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy([ShipmentRouteObserver::class])]
class ShipmentRoute extends Model
{
    use HasFactory;
//    use SoftDeletes;
    protected $fillable = [
        'shipment_id',
        'location',
        'location_type',
        'arrival_date',
        'departure_date',
        'actual_arrival_date',
        'actual_departure_date',
        'status',
        'notes',
        'metadata'
    ];

    protected $casts = [
        'arrival_date' => 'datetime',
        'departure_date' => 'datetime',
        'actual_arrival_date' => 'datetime',
        'actual_departure_date' => 'datetime',
        'metadata' => 'array',
        'status' => ShipmentRouteStatusEnum::class,
        'location_type' => ShipmentRouteLocationTypeEnum::class
    ];

    public function shipment(): BelongsTo
    {
        return $this->belongsTo(Shipment::class);
    }

    public function hasArrived(): bool
    {
        if (isset($this->actual_arrival_date)){
            return $this->actual_arrival_date->isPast();
        }
        return $this->arrival_date->isPast();
    }

    public function hasDeparted(): bool
    {
        if (isset($this->actual_departure_date)){
            return $this->actual_departure_date->isPast();
        }
        return $this->departure_date->isPast();
    }


    public function calculateStatus(): void
    {
        $status = ShipmentRouteStatusEnum::PENDING;

        if ($this->hasArrived()){
            $status = ShipmentRouteStatusEnum::ARRIVED;
        }

        if ($this->hasDeparted()){
            $status = ShipmentRouteStatusEnum::DEPARTED;
        }

        $this->status = $status;
    }
}
