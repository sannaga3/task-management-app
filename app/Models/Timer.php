<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Timer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'start_time',
        'end_time',
        'task_id',
        'deleted_at',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}