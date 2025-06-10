<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    // テストごとにデータベースをリセット
    use RefreshDatabase;

    public function test_user_can_register()
    {
        $formData = [
            'name' => 'テスト太郎',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        // 登録リクエストを送信
        $response = $this->post('/register', $formData); // /register に POSTリクエストを送る

        // /counts にリダイレクトされることを確認
        $response->assertRedirect('/counts');

        // users テーブルにデータが存在するか確認
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);
    }
}
