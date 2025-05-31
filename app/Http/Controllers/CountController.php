<?php

namespace App\Http\Controllers;

use App\Models\Count;
use App\Models\User;
use Illuminate\Http\Request;
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
        $counts = $user
        ->counts()
        ->latest() // created_at の降順(最新順)
        ->first(); // 1件だけ取得

        // createへの分岐(レコードが存在しない or 完了済み)
        if(is_null($counts) || $counts->is_completed === true ) {
            return redirect()->route('counts.create');
        }

        // 本日の日付 - 開始日 = 経過日数
        $today = Carbon::today(); // 本日の日付 
        $start = Carbon::parse($counts->started_at); // 開始日
        $counts->elapsedDays = $start->diffInDays($today); // 経過日数
        // 日付を Carbon で表示(05月を5月と表示するため)
        $counts->formatted_started_at = Carbon::parse($counts->started_at)->format('n月j日');
        
        return view('counts.index', compact('counts'));
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
            return redirect()->route('counts.index');
        }

        return view('counts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Count::create([
            'title' => $request->title,
            'started_at' => $request->started_at,
            'memo' => $request->memo,
            'user_id' => Auth::id(),
        ]);

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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
