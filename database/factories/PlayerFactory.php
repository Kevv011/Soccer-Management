<?php

namespace Database\Factories;

use App\Enums\PlayerGender;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Player>
 */
class PlayerFactory extends Factory
{
    protected $model = Player::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'team_id' => Team::factory(),
            'name' => fake()->name(),
            'birth_date' => fake()->dateTimeBetween('-40 years', '-16 years')->format('Y-m-d'),
            'gender' => fake()->randomElement(PlayerGender::cases()),
        ];
    }
}
