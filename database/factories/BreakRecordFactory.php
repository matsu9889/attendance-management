<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Attendance;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BreakRecord>
 */
class BreakRecordFactory extends Factory
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
            'start_time' => '12:00:00',
            'end_time' => '13:00:00',
        ];
    }
}
