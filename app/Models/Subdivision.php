<?php

namespace App\Models;

use Database\Factories\SubdivisionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['country_id', 'code', 'name'])]
class Subdivision extends Model
{
    /** @use HasFactory<SubdivisionFactory> */
    use HasFactory;

    /**
     * @return BelongsTo<Country, $this>
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * @return HasMany<Federation, $this>
     */
    public function federations(): HasMany
    {
        return $this->hasMany(Federation::class);
    }
}
