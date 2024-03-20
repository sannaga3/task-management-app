<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TaskService;
use App\Services\TimerService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected $taskService;
    protected $timerService;

    public function __construct(TaskService $taskService, TimerService $timerService)
    {
        $this->taskService = $taskService;
        $this->timerService = $timerService;
    }

    public function searchTaskList(Request $request)
    {
        $result = $this->taskService->getTaskList($request);

        return response()->json([
            'tasks' => $result['data'],
            'meta' => $result['meta'],
        ]);
    }
}