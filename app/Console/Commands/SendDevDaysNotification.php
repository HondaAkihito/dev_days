<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\DevDaysNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Mail;

class SendDevDaysNotification extends Command
{
    protected $signature = 'notify:send-devdays';
    protected $description = '毎日、ユーザーにDevDaysの経過日数を通知';

    public function handle()
    {
        $users = User::with(['counts' => function ($query) {
            $query->where('is_completed', false)->latest('started_at');
        }])->get();

        Log::info('通知対象ユーザー数: ' . $users->count());



        foreach($users as $user) {
            $count = $user->counts->first();

            if ($count) {
                $startedAt = Carbon::parse($count->started_at);
                $days = $startedAt->diffInDays(now());

                $user->notify(new DevDaysNotification($user->name, $days));
            }
        }

        $this->info('通知を送信しました');
    }
}
