<?php

namespace App\Http\Controllers;

use App\Services\CountService;
use App\Http\Requests\StoreCountRequest;
use App\Http\Requests\UpdateCountRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // countsテーブルのデータ取得
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $count = $user->latestCount(); // Counts に記載

        // createへの分岐(レコードが存在しない or 完了済み)
        if(is_null($count) || $count->is_completed === true ) {
            return to_route('counts.create');
        }

        // 経過日数の取得(本日の日付 - 開始日 = 経過日数)
        $count = CountService::getElapsedDays($count);

        // 日付を Carbon で表示(05月を5月と表示するため)
        $count->formatted_started_at = Carbon::parse($count->started_at)->format('n月j日');
        
        return view('counts.index', compact('count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // countsテーブルのデータ取得
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $counts = $user->latestCount(); // Counts に記載

        // createへの分岐(レコードが存在 かつ 未完了)
        if($counts && $counts->is_completed === false ) {
            return to_route('counts.index');
        }

        return view('counts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCountRequest $request)
    {
        // カウントを保存
        CountService::storeCount($request);

        return to_route('counts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // countsテーブルのデータ取得
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $count = $user->counts()->latest()->find($id);

        // 他人のレコード → !$count で弾かれる
        // 存在しないID → !$count で弾かれる
        // 自分の古いレコード → id !== latest->id で弾かれる
        $latest = $user->counts()->latest()->first();
        if(!$count || $count->id !== $latest->id) {
            abort(403);
        }

        return view('counts.edit', compact('count'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCountRequest $request, $id)
    {
        // countsテーブルのデータ取得
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $count = $user->counts()->latest()->find($id);

        // カウントを保存
        CountService::updateCount($count, $request);

        return to_route('counts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // countsテーブルのデータ取得
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $count = $user->counts()->latest()->find($id);

        $count->delete();

        return to_route('counts.create');
    }

    public function complete($id)
    {
        // countsテーブルのデータ取得
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $count = $user->counts()->latest()->find($id);

        $count->completed_at = Carbon::today();
        $count->is_completed = true;
        $count->save();

        return to_route('counts.create'); 
    }
}
