<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

// 「名前」と「経過日数」をもとに、ユーザーにメールを送る処理をまとめたクラス。
class DevDaysEmail extends Mailable
{
    use Queueable, SerializesModels; // メール送信をキュー処理に対応させたり、モデルなどを安全にシリアライズ(保存用に変換)するための機能

    // メール本文の中で使いたいデータ(ユーザー名と経過日数)を外部から渡せるようにプロパティとして定義。
    // これで Blade の中で {{ $name }} や {{ $days }} が使えるようになる。
    public $name;
    public $days;

    public function __construct($name, $days)
    {
        $this->name = $name;
        $this->days = $days;
    }

    // メールの内容を組み立てる部分
    public function build()
    {
        // ログ
        Log::info('DevDaysEmail を build: ' . $this->name . ' さん, 経過日数: ' . $this->days);

        return $this->subject("DevDaysの経過日数のお知らせ") // .subject(...) → メールの件名を設定
                    ->view('emails.devdays'); // .view(...) → 本文に使う Blade テンプレート(resources/views/emails/devdays.blade.php)を指定
    }
}
