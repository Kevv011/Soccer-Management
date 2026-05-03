<?php

namespace Database\Factories;

use App\Enums\ReportGenerationStatus;
use App\Enums\ReportType;
use App\Models\ReportGeneration;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ReportGeneration>
 */
class ReportGenerationFactory extends Factory
{
    protected $model = ReportGeneration::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'report_type' => fake()->randomElement(ReportType::cases()),
            'status' => fake()->randomElement(ReportGenerationStatus::cases()),
            'selection_summary' => fake()->sentence(3),
            'requested_by_name' => fake()->name(),
            'requested_by_email' => fake()->safeEmail(),
            'file_disk' => 'public',
            'file_path' => null,
            'file_name' => null,
            'filters' => [],
            'requested_at' => now(),
            'completed_at' => null,
            'error_message' => null,
        ];
    }
}
