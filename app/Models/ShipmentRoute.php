<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        'order',
        'carrier',
        'vessel_number',
        'container_number',
        'notes',
        'metadata'
    ];

    protected $casts = [
        'arrival_date' => 'datetime',
        'departure_date' => 'datetime',
        'actual_arrival_date' => 'datetime',
        'actual_departure_date' => 'datetime',
        'metadata' => 'array'
    ];

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }
}
