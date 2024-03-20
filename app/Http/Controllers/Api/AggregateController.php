<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Aggregate;
use App\Services\TimerService;


class AggregateController extends Controller
{
    protected $timerService;

    public function __construct(TimerService $timerService)
    {
        $this->timerService = $timerService;
    }

    /**
     * Display a listing of the resource.
     */
    public function searchAggregate()
    {
        $aggregate = Aggregate::first();

        return response()->json(['aggregate' => $aggregate]);
    }
}