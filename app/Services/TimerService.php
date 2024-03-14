<?php

namespace App\Services;

use App\Models\Timer;

class TimerService
{
    protected $paginationService;

    public function __construct(PaginationService $paginationService)
    {
        $this->paginationService = $paginationService;
    }

    public function getTimerList($task_id, $perPage, $page)
    {
        $query = Timer::where('task_id', $task_id)->orderByDesc('id');
        return $this->paginationService->paginate($query, $perPage, $page);
    }
}