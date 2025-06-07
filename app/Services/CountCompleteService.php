<?php

namespace App\Services;

use Carbon\Carbon;

class CountCompleteService
{
  // ⭐️ - common ------------------------------------------------------------
  // 制作日数の取得(開始日 - 完了日 = 制作日数)
  public static function getCompletedDays($completedCount) {
    $start = Carbon::parse($completedCount->started_at); // 開始日
    $end = Carbon::parse($completedCount->completed_at); // 完了日 
    $completedCount->elapsedDays = $start->diffInDays($end); // 経過日数
    
    return $completedCount;
  }
  
  // ⭐️ - update ------------------------------------------------------------
  // 更新処理
  public static function updateCompletedCount($request, $completedCount) {
    // 更新処理(画像保存処理)
    if($request->hasFile('image_path')) {
      $filename = uniqid() . '_' . $request->file('image_path')->getClientOriginalName();; // ファイル名を自分で作る
      $request->file('image_path')->storeAs('images', $filename, 'public'); // images ディレクトリに保存（publicディスクを使って）
      $completedCount->image_path = $filename; // DBにはファイル名だけを保存
  }

    // 更新処理(画像以外)
    $completedCount->title = $request->title;
    $completedCount->started_at = $request->started_at;
    $completedCount->completed_at = $request->completed_at;
    $completedCount->url = $request->url;
    $completedCount->memo = $request->memo;
    $completedCount->save();
  }
}