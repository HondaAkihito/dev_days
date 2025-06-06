<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Services\CountCompleteService;

class CountCompleteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 完了データの取得
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $completedCounts = $user
        ->counts()
        ->where('is_completed', 1)
        ->orderByDesc('completed_at')
        ->get();

        // 制作日数の取得
        foreach($completedCounts as $completedCount) {
            // 制作日数の取得(開始日 - 完了日 = 制作日数)
            $completedCount = CountCompleteService::getCompletedDays($completedCount);
        }

        return view('completes.index', compact('completedCounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // 完了PFのデータ取得
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $completedCount = $user->counts()->find($id);

        // 制作日数の取得(開始日 - 完了日 = 制作日数)
        $completedCount = CountCompleteService::getCompletedDays($completedCount);

        return view('completes.show', compact('completedCount'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // 完了PFのデータ取得
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $completedCount = $user->counts()->find($id);

        // 制作日数の取得(開始日 - 完了日 = 制作日数)
        $completedCount = CountCompleteService::getCompletedDays($completedCount);

        return view('completes.edit', compact('completedCount'));
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
        // 完了PFのデータ取得
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $completedCount = $user->counts()->find($id);

        // 更新処理
        CountCompleteService::updateCompletedCount($request, $completedCount);

        return to_route('completes.show', ['complete' => $completedCount->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // // 完了PFのデータ取得
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $completedCount = $user->counts()->find($id);

        $completedCount->delete();

        return to_route('completes.index');
    }
}
