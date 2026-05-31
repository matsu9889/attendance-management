<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Attendance;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CorrectionRequest>
 */
class CorrectionRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'attendance_id' => Attendance::inRandomOrder()->value('id'),
            'start_time' => '10:00:00',
            'end_time' => '19:00:00',
            'comment' => 'test',
            'approval' => '0',
        ];
    }
}
