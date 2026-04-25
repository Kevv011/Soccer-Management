<?php

namespace Database\Factories;

use App\Models\Federation;
use App\Models\Subdivision;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Federation>
 */
class FederationFactory extends Factory
{
    protected $model = Federation::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => sprintf('Federation of %s', fake()->unique()->city()),
            'foundation_date' => fake()->dateTimeBetween('-100 years', '-5 years')->format('Y-m-d'),
            'subdivision_id' => Subdivision::factory(),
            'municipality' => fake()->city(),
            'address_line' => fake()->streetAddress(),
        ];
    }
}
