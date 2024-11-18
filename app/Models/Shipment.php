<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'tracking_number',
        'type', // air or sea
        'status',
        'origin',
        'destination',
        'estimated_delivery',
        'actual_delivery',
        'description',
        'shipper_name',
        'receiver_name',
        'current_location',
        'container_size',
        'service_type'
    ];

    protected $casts =[
        'estimated_delivery' => 'datetime',
        'actual_delivery' => 'datetime',
    ]
;
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
}
