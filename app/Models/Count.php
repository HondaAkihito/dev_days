<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Count extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'started_at',
        'memo',
        'user_id',
    ];

    // キャスト
    protected $casts = [
        'started_at' => 'date',
        'is_completed' => 'boolean',
    ];

    // Userモデル リレーション
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
