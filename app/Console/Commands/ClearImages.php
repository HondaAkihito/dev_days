<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ClearImages extends Command
{
    // コマンド名（ここが実行時に使うやつ）
    protected $signature = 'storage:clear-images';

    // 説明（`php artisan list` に出るやつ）
    protected $description = 'storage/app/public/images の画像をすべて削除します';

    public function handle()
    {
        $directory = 'images';

        if (!Storage::disk('public')->exists($directory)) {
            $this->warn("📂 ディレクトリが存在しません: storage/app/public/{$directory}");
            return Command::SUCCESS;
        }

        $files = Storage::disk('public')->files($directory);

        if (empty($files)) {
            $this->info("🧼 削除する画像はありませんでした。");
            return Command::SUCCESS;
        }

        foreach ($files as $file) {
            Storage::disk('public')->delete($file);
        }

        $this->info("🗑️ {$directory} 内の画像を削除しました。削除数: " . count($files));

        return Command::SUCCESS;
    }
}
