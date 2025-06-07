<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CountController;
use App\Http\Controllers\CountCompleteController;
use App\Http\Controllers\GuestLoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// ゲストログイン
Route::get('/guest-login', [GuestLoginController::class, 'login'])->name('guest.login');

// 通常ログイン
Route::middleware('auth')->group(function () {
    // 日数カウンター
    Route::resource('counts', CountController::class);
    Route::post('counts/{count}', [CountController::class, 'complete'])->name('counts.complete');
    
    // カウンター完了
    Route::resource('completes', CountCompleteController::class);
});

// ログインなし(トップページ)
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// プロフィール
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
