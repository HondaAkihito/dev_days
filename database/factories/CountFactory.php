<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Mmo\Faker\PicsumProvider;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Count>
 */
class CountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // - 開始→完了の順番を確定させるコード ----------------------------------------
        $start = $this->faker->dateTimeBetween('-2 months', '-1 month');
        $end = $this->faker->dateTimeBetween($start, 'now');
        

        // - 画像の生成 ----------------------------------------
        // `faker` に PicsumProvider を追加
        $this->faker->addProvider(new PicsumProvider($this->faker));

        // 1️⃣ 一時ディレクトリに画像をダウンロード
        $tempPath = $this->faker->picsum(null, 640, 480); // `null` で一時フォルダに保存

        if(!$tempPath) {
            throw new \Exception("画像が生成されませんでした。ディレクトリの権限を確認してください。");
        }

        // 2️⃣ `storage/app/public/images/` に保存
        $storagePath = Str::random(10) . '.jpg'; // ランダムなファイル名
        Storage::disk('public')->put('images/' . $storagePath, file_get_contents($tempPath)); // `storage/app/public/images/` に保存


        // - 実行 ----------------------------------------
        return [
            'user_id' => 1,
            'title' => $this->faker->sentence(2),
            'started_at' => $start->format('Y-m-d'),
            'completed_at' => $end->format('Y-m-d'),
            'is_completed' => 1, // 完了済み
            'image_path' => $storagePath,
            'url' => $this->faker->url(),
            'memo' => $this->faker->realText(100),
        ];
    }
}
