<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\Subdivision;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Subdivision>
 */
class SubdivisionFactory extends Factory
{
    protected $model = Subdivision::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'country_id' => Country::factory(),
            'code' => strtoupper(fake()->unique()->bothify('??-##')),
            'name' => fake()->unique()->state(),
        ];
    }
}
