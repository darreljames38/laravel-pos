<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class TasksDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $database = DB::connection('tasks');

        $database->table('tasks')->delete();
        $database->table('users')->delete();

        $today = Carbon::today();

        $database->table('tasks')->insert([
            [
                'title' => 'Review daily schedule',
                'status' => 'completed',
                'task_date' => $today->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Finish Laravel activity',
                'status' => 'pending',
                'task_date' => $today->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Submit project files',
                'status' => 'pending',
                'task_date' => $today->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Check database records',
                'status' => 'completed',
                'task_date' => $today->subDay()->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Prepare system documentation',
                'status' => 'pending',
                'task_date' => $today->subDay()->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Update project repository',
                'status' => 'completed',
                'task_date' => $today->addDays(3)->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Study Laravel Eloquent',
                'status' => 'pending',
                'task_date' => $today->addDays(3)->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Prepare activity presentation',
                'status' => 'pending',
                'task_date' => $today->addDays(5)->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $database->table('users')->insert([
            'username' => 'darrel01',
            'full_name' => 'Darrel James Sanchez',
            'email' => 'darrel@example.com',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}