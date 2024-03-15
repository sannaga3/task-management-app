<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Services\TaskService;
use App\Services\TimerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TaskController extends Controller
{
    protected $taskService;
    protected $timerService;

    public function __construct(TaskService $taskService, TimerService $timerService)
    {
        $this->taskService = $taskService;
        $this->timerService = $timerService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $result = $this->taskService->getTaskList($request);

        return Inertia::render('Task/Index', [
            'tasks' => $result['data'],
            'meta' => $result['meta'],
        ]);
    }

    public function searchTaskList(Request $request)
    {
        $result = $this->taskService->getTaskList($request);

        return response()->json([
            'tasks' => $result['data'],
            'meta' => $result['meta'],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Task/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $userId = Auth::user()->id;
        $request->merge(['user_id' => $userId]);
        Task::create($request->all());

        return to_route('tasks.index')->with(['message' => 'タスクを作成しました', 'status' => 'success']);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id, Request $request)
    {
        $perPage = isset($request) ? $request['per_page'] : 10;
        $page = isset($request) ? $request['page'] : 1;

        $task = Task::where('tasks.id', $id)
            ->withUser(true)
            ->first();

        $timers = $this->timerService->searchTimerList(
            $id,
            $perPage,
            $page
        );

        $totalTime = $this->timerService->searchTotalTime($timers['data']);

        return Inertia::render('Task/Show', [
            'task' => $task,
            'timers' => $timers['data'],
            'meta' => $timers['meta'],
            'total_time' => $totalTime,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $task = Task::where('tasks.id', $id)->withUser(true)->first();

        return Inertia::render('Task/Edit', [
            'task' => $task,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->all());

        return redirect()
            ->route('tasks.show', $task)
            ->with(['message' => 'タスクを更新しました', 'status' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $id = $task->id;
        $task->delete();
        $message = 'ID : ' . $id . " を削除しました";

        return redirect()
            ->route('tasks.index')
            ->with(['message' => $message, 'status' => 'danger']);
    }
}