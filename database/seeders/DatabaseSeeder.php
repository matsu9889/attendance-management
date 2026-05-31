<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Attendance;
use App\Models\BreakRecord;
use App\Models\CorrectionRequest;
use App\Models\CorrectionRequestBreak;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Attendance::factory(3)->create();
        User::factory(3)->create();
        BreakRecord::factory(3)->create();
        CorrectionRequest::factory(3)->create();
        CorrectionRequestBreak::factory(3)->create();
    }
}
