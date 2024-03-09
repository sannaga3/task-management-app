<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'content',
        'begin',
        'end',
        'status',
        'published',
        'remarks',
        'user_id',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeWithUser($query, $isShowOrEdit = false)
    {
        if ($isShowOrEdit) return $query->with(['user' => function ($query) {
            $query->select('id', 'name');
        }]);

        return $query->select('id', 'title', 'content', 'begin', 'end', 'status', 'published', 'remarks', 'user_id')
            ->with(['user' => function ($query) {
                $query->select('id', 'name');
            }])
            ->orderBy('id', 'desc');
    }
}