<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Count extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'started_at',
        'memo',
        'user_id',
    ];
}
