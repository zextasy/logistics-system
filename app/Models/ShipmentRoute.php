<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentRoute extends Model
{
    use HasFactory;
    protected $fillable = [
        'shipment_id',
        'location',
        'arrival_date',
        'departure_date',
        'status',
        'order'
    ];

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }
}
