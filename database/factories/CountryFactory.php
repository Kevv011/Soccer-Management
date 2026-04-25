<?php

namespace Database\Factories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Country>
 */
class CountryFactory extends Factory
{
    protected $model = Country::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $countryName = fake()->unique()->country();

        return [
            'iso_name' => $countryName,
            'iso' => strtoupper(fake()->unique()->countryCode()),
            'iso3' => strtoupper(fake()->unique()->lexify('???')),
            'name' => Str::title($countryName),
        ];
    }
}
