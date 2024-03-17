<?php

namespace App\Models;

use App\Models\Scopes\MonthAggregate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aggregate extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope(new MonthAggregate);
    }
}