<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
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
        Task::create($request->all());

        return to_route('tasks.index')->with(['message' => '登録成功', 'status' => 'success']);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $task = Task::where('tasks.id', $id)->withUser(true)->first();

        return Inertia::render('Task/Show', [
            'task' => $task,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $task = Task::where('tasks.id', $id)->withUser()->first();

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
            ->with(['message' => '編集成功', 'status' => 'success']);
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