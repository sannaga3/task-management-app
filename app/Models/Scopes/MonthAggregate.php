<?php

namespace App\Models\Scopes;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MonthAggregate implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $now = Carbon::now();
        $month['start'] = $now->startOfMonth()->format('Y-m-d H:i:s');
        $month['end'] = $now->endOfMonth()->format('Y-m-d H:i:s');
        $user = Auth::user();

        $sub = DB::table('tasks')
            ->select(
                DB::raw('SUM(TIMESTAMPDIFF(SECOND, timers.start_time, timers.end_time)) as total_timer_seconds')
            )
            ->leftJoin('timers', function ($join) use ($month) {
                $join->on('tasks.id', '=', 'timers.task_id')
                    ->whereBetween('timers.start_time', [$month['start'], $month['end']]);
            })
            ->where('tasks.user_id', $user->id);

        $sql = DB::table('tasks')
            ->select(
                DB::raw('COUNT(*) as total_tasks'),
                DB::raw('SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) as completed_tasks'),
                DB::raw('SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as in_progress_tasks'),
                DB::raw('SUM(CASE WHEN status = 2 THEN 1 ELSE 0 END) as not_started_tasks'),
            )
            ->where('tasks.user_id', $user->id)
            ->whereBetween('begin', [$month['start'], $month['end']])
            ->addSelect(['total_timer_seconds' => $sub]);

        $builder->fromSub($sql, 'aggregate');
    }
}