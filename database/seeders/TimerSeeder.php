<?php

namespace Database\Seeders;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $date = Carbon::now();

        for ($i = 20; $i >= 0; $i--) {
            $start_time = Carbon::create($date)->subDay($i);
            $end_time = Carbon::create($start_time)->addHours(rand(1, 10));

            DB::table('timers')->insert([
                'start_time' => $start_time,
                'end_time' => $end_time,
                'task_id' => Task::orderBy('id', 'desc')->first()->id,
            ]);
        }
    }
}