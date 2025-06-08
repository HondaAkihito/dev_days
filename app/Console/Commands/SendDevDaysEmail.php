<?php

namespace App\Console\Commands;

use App\Mail\DevDaysEmail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendDevDaysEmail extends Command
{
    protected $signature = 'email:send-devdays'; // artisanコマンド名
    protected $description = '毎日、ユーザーにDevDaysの経過日数をメール送信'; // $description =「php artisan list」などで説明として表示される。

    public function handle()
    {
        // 各ユーザーに対して「未完了の counts(制作記録)を1つだけ最新順に取得」
        $users = User::with(['counts' => function ($query) { // with() で eager load(遅延じゃなく一括読み込み)
            $query->where('is_completed', false)->latest('started_at');
        }])->get();

        // with で読み込んだ counts のコレクションから、最初の1件(=最新の未完了)を取り出す。
        foreach($users as $user) {
            $count = $user->counts->first(); // 未完了の最新Count

            if($count) {
                $startedAt = Carbon::parse($count->started_at);
                $days = $startedAt->diffInDays(now());

                // ログ出力
                Log::info('メールをキューに入れました: ' . $user->email);

                // メール送信
                // Mail::to($user->email)->send(new DevDaysEmail($user->name, $days));
                Mail::to($user->email)->queue(new DevDaysEmail($user->name, $days));
            }
        }

        $this->info('メール送信完了');
    }
}

