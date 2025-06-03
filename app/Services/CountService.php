<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Count;

class CountService
{
  // ⭐️ - index ------------------------------------------------------------
  // 経過日数の取得(本日の日付 - 開始日 = 経過日数)
  public static function getElapsedDays($count) {
    $today = Carbon::today(); // 本日の日付 
    $start = Carbon::parse($count->started_at); // 開始日
    $count->elapsedDays = $start->diffInDays($today); // 経過日数

    return $count;
  }

  // ⭐️ - store ------------------------------------------------------------
  // カウントを保存
  public static function storeCount($request) {
      Count::create([
        'title' => $request->title,
        'started_at' => $request->started_at,
        'memo' => $request->memo,
        'user_id' => Auth::id(),
      ]);
  }

  // ⭐️ - update -----------------------------------------------------------
  // カウントを保存
  public static function updateCount($count, $request) {
      $count->title = $request->title;
      $count->started_at = $request->started_at;
      $count->memo = $request->memo;
      $count->save();
  }
}