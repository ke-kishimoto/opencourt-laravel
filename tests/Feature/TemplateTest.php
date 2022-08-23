<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\EventTemplate;

class TemplateTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create()
    {
      EventTemplate::truncate();
      // $user = User::factory()->create([]);
      $user = User::create(['role_level' => 'sysmte_admin',
            'tel' => '000-1111-2222',
            'name' => 'a',
            'email' => 'super@test.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'gender' => 'men',
            'status' => 'active',]);

      $response = $this->actingAs($user)
                       ->withSession(['banned' => false])
                       ->post('/api/eventTemplate', [
                           'isNew' => false,
                            'template_name' =>  'テスト-テンプレート名',
                            'title' => 'テスト-イベント名',
                            'short_title' => 'テスト-イベント略称',
                            'place' => '沖縄県沖縄市',
                            'limit_number' => '30',
                            'description' => '詳細サンプル',
                            'price1' => 500,
                            'price2' => 400,
                            'price3' => 300,
                            'price4' => 200,
                            'price5' => 100,
                       ]);
        $response->assertStatus(200);

     $this->assertDatabaseHas('event_templates', [
          'template_name' =>  'テスト-テンプレート名',
          'title' => 'テスト-イベント名',
          'short_title' => 'テスト-イベント略称',
          'place' => '沖縄県沖縄市',
          'limit_number' => '30',
          'description' => '詳細サンプル',
          'price1' => 500,
          'price2' => 400,
          'price3' => 300,
          'price4' => 200,
          'price5' => 100,
        ]);
    }
}
