<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CorrectionRequestBreak>
 */
class CorrectionRequestBreakFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'correction_request_id' => fake()->numberBetween(1, 10),
            'start_time' => '12:30:00',
            'end_time' => '13:00:00',
        ];
    }
}
