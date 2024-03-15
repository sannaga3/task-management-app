<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTimerRequest;
use App\Http\Requests\UpdateTimerRequest;
use App\Models\Timer;
use App\Services\TimerService;
use Illuminate\Http\Request;

class TimerController extends Controller
{
    protected $timerService;

    public function __construct(TimerService $timerService)
    {
        $this->timerService = $timerService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $result = $this->timerService->searchTimerList(
            $request['task_id'],
            $request['per_page'],
            $request['page']
        );

        return response()->json([
            'timers' => $result['data'],
            'meta' => $result['meta'],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTimerRequest $request)
    {
        Timer::create($request->all());

        return redirect()
            ->route(
                'tasks.show',
                ['task' => $request['task_id']]
            )
            ->with(['message' => 'タスクの実行を保存しました', 'status' => 'success']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTimerRequest $request, Timer $timer)
    {
        $timer->update($request->all());

        return redirect()
            ->route(
                'tasks.show',
                ['task' => $timer['task_id']]
            )
            ->with(['message' => 'タスク履歴を更新しました', 'status' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Timer $timer)
    {
        $timerId = $timer->id;
        $taskId = $timer->task_id;
        $timer->delete();
        $message = '履歴ID : ' . $timerId . " を削除しました";

        return redirect()
            ->route('tasks.show', $taskId)
            ->with(['message' => $message, 'status' => 'danger']);
    }
}