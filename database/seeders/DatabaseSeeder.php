<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@internlink.com',
            'role' => 'admin',
            'password' => 'password',
        ]);

        $teacher = User::factory()->create([
            'name' => 'Lina Coordinator',
            'email' => 'coordinator@internlink.com',
            'role' => 'coordinator',
            'password' => 'password',
        ]);

        $supervisor = User::factory()->create([
            'name' => 'Sam Supervisor',
            'email' => 'supervisor@workplace.com',
            'role' => 'supervisor',
            'company_name' => 'Acme Training Services',
            'department' => 'Operations',
            'password' => 'password',
        ]);

        User::factory()->create([
            'name' => 'Ava Student',
            'email' => 'student@school.edu',
            'role' => 'student',
            'teacher_id' => $teacher->id,
            'supervisor_id' => $supervisor->id,
            'required_hours' => 240,
            'password' => 'password',
        ]);
    }
}
