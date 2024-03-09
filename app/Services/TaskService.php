<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskService
{
    protected $paginationService;

    public function __construct(PaginationService $paginationService)
    {
        $this->paginationService = $paginationService;
    }

    public function getTaskList(Request $request)
    {
        $query = Task::withUser();
        return $this->paginationService->paginate($query, $request['per_page'], $request['page']);
    }
}