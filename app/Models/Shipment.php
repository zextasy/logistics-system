<?php

namespace App\Models;

use App\Enums\ContainerSizeEnum;
use App\Enums\ShipmentServiceTypeEnum;
use App\Enums\ShipmentStatusEnum;
use App\Enums\ShipmentTypeEnum;
use App\Observers\ShipmentObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

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
        'origin_country_id',
        'origin_city_id',
        'loading_port',
        'origin_address',
        'origin_postal_code',
        'destination_country_id',
        'destination_city_id',
        'discharge_port',
        'destination_address',
        'destination_postal_code',
        'final_place_for_delivery',
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
        'date_of_shipment' => 'datetime',
        'insurance_required' => 'boolean',
        'customs_cleared' => 'boolean',
        'type' => ShipmentTypeEnum::class,
        'status' => ShipmentStatusEnum::class,
        'service_type' => ShipmentServiceTypeEnum::class,
        'container_size' => ContainerSizeEnum::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function routes(): HasMany
    {
        return $this->hasMany(ShipmentRoute::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function initialDocument(): HasOne
    {
        return $this->documents()->one()->ofMany()->oldest();
    }

    public function originCountry(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'origin_country_id');
    }

    public function originCity(): BelongsTo
    {
        return $this->belongsTo(City::class, 'origin_city_id');
    }

    public function destinationCountry(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'destination_country_id');
    }

    public function destinationCity(): BelongsTo
    {
        return $this->belongsTo(City::class, 'destination_city_id');
    }
    public function getCurrentRouteAttribute()
    {
        return $this->routes()
            ->where('arrival_date', '<=', now())
            ->orderBy('order', 'desc')
            ->first();
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
    protected function dimensionsSummarized(): Attribute
    {
        return Attribute::make(
            get: fn () => ($this->getDimensionsSummary()),
        );
    }

    protected function dimensionsInHTML(): Attribute
    {
        return Attribute::make(
            get: fn () => ($this->getArrayText($this->dimensions)),
        );
    }

    protected function chargesInHtml(): Attribute
    {
        return Attribute::make(
            get: fn () => ($this->getArrayText($this->charges)),
        );
    }

    private function getArrayText(array $array)
    {
        $text = json_encode($array);

        return Str::of($text)->replace('{','')->replace('}','')
            ->replace(',','<br>');
    }

    private function getDimensionsSummary(): string
    {
        $length = $this->dimensions['length'];
        $width = $this->dimensions['width'];
        $height = $this->dimensions['height'];
        $unit = $this->dimensions['unit'];
        return  "$length x $width x $height  $unit";
    }

    public function hasBeenDelivered(): bool
    {
        if (isset($this->actual_delivery)){
            return $this->actual_delivery->isPast();
        }
        return $this->estimated_delivery->isPast();
    }

    public function calculateStatus(): void
    {
        $status = ShipmentStatusEnum::PENDING;

        if (isset($this->date_of_shipment) && $this->date_of_shipment->isPast()){
            $status = ShipmentStatusEnum::IN_TRANSIT;
        }

        if ($this->hasBeenDelivered()){
            $status = ShipmentStatusEnum::DELIVERED;
        }

        $this->status = $status;
    }
}
