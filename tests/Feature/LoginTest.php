<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    // テストごとにデータベースをリセット
    use RefreshDatabase;

    /** @test */
    public function test_user_can_login_with_correct_credentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'), // パスワードを設定
        ]);

        // ログインフォームに入力して送信したシュミレーション内容
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/counts'); // 成功時のリダイレクト先
        $this->assertAuthenticatedAs($user); // ログイン済みであることを確認
    }

    /** @test */
    public function test_user_can_not_login_with_wrong_password()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('correct-password'),
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertRedirect('/login'); // 失敗後に戻る
        // 📝 「パスワードが間違ってる → バリデーションエラーが発生 → セッションに email のエラーがあるはず」と確認している。
        // 📝 Laravelでは「パスワードが間違っていても email にエラーを付ける」設計になっている
        $response->assertSessionHasErrors('email');  // セッションに email フィールドのエラーが含まれているか？

        $this->assertGuest(); // ログインしていないことを確認
    }
}
