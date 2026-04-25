<?php

namespace App\Models;

use Database\Factories\CountryFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['iso_name', 'iso', 'iso3', 'name'])]
class Country extends Model
{
    /** @use HasFactory<CountryFactory> */
    use HasFactory;

    /**
     * @return HasMany<Subdivision, $this>
     */
    public function subdivisions(): HasMany
    {
        return $this->hasMany(Subdivision::class);
    }
}
