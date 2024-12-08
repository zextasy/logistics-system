<?php

namespace App\Models;

use App\Enums\CountryStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
//    use SoftDeletes;

    protected $fillable = [
        'id', 'name', 'status'
    ];

    protected $casts = [
        'status' => CountryStatusEnum::class,
    ];

    public $timestamps = false;

    public function states(): HasMany
    {
        return $this->hasMany(State::class);
    }

    public function cities(): HasManyThrough
    {
        return $this->hasManyThrough(City::class, State::class);
    }
}
