<?php

namespace App\Services;

use App\Models\Timer;
use Carbon\Carbon;

class TimerService
{
    protected $paginationService;

    public function __construct(PaginationService $paginationService)
    {
        $this->paginationService = $paginationService;
    }

    public function searchTimerList($task_id, $perPage, $page)
    {
        $query = Timer::where('task_id', $task_id)->orderByDesc('id');
        return $this->paginationService->paginate($query, $perPage, $page);
    }

    public function searchTotalTime(array $timers)
    {
        $totalTime = 0;
        foreach ($timers as $timer) {
            $startTime = Carbon::parse($timer['start_time']);
            $endTime = Carbon::parse($timer['end_time']);

            $totalTime += $startTime->diffInSeconds($endTime);
        }

        return $totalTime;
    }
}