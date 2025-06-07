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
        'completed_at',
        'is_completed',
        'image_path',
        'url',
    ];

    // キャスト
    protected $casts = [
        'is_completed' => 'boolean',
    ];

    // Userモデル リレーション
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // 検索
    public function scopeSearch($query, $search)
    {
        if($search !== null){
            $search_split = mb_convert_kana($search, 's'); // 全角スペースを半角
            $search_split2 = preg_split('/[\s]+/', $search_split); //空白で区切る
            
            foreach($search_split2 as $value){
                $query->where('title', 'like', '%' .$value. '%')
                      ->orWhere('memo', 'like', "%{$value}%");
            }
        }
        return $query;
    }
}
