<?php

namespace App\Models;

use App\Enums\CargoTypeEnum;
use App\Enums\QuoteServiceTypeEnum;
use App\Enums\QuoteStatusEnum;
use App\Observers\QuoteObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy([QuoteObserver::class])]
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
        'country_id',
        'origin_country_id',
        'origin_city_id',
        'origin_postal_code',
        'destination_country_id',
        'destination_city_id',
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
        'valid_until' => 'datetime',
        'status' => QuoteStatusEnum::class,
        'service_type' => QuoteServiceTypeEnum::class,
        'cargo_type' => CargoTypeEnum::class,
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

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
    public function originCountry()
    {
        return $this->belongsTo(Country::class, 'origin_country_id');
    }

    public function originCity()
    {
        return $this->belongsTo(City::class, 'origin_city_id');
    }

    public function destinationCountry()
    {
        return $this->belongsTo(Country::class, 'destination_country_id');
    }

    public function destinationCity()
    {
        return $this->belongsTo(City::class, 'destination_city_id');
    }

    protected function countryName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->country->name,
        );
    }

    protected function originCountryName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->originCountry->name,
        );
    }

    protected function originCityName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->originCity->name,
        );
    }

    protected function destinationCountryName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->destinationCountry->name,
        );
    }

    protected function destinationCityName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->destinationCity->name,
        );
    }
}
