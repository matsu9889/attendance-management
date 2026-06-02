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
        User::factory()->create([
            'name' => '管理者',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 1,
        ]);
        User::factory()->create([
            'name' => '一般ユーザー',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role' => 0,
        ]);
        User::factory(5)->create();
        Attendance::factory(10)->create();
        BreakRecord::factory(10)->create();
        CorrectionRequest::factory(5)->create();
        CorrectionRequestBreak::factory(5)->create();
    }
}
