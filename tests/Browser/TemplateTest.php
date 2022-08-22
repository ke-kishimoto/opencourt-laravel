<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Support\Facades\DB;
use App\Models\EventTemplate;

class TemplateTest extends DuskTestCase
{
    /**
     * @return void
     */
    public function testDisplay()
    {
        $this->login();

        $this->browse(function (Browser $browser) {
            $browser->visit('/templateManagement')
                    ->assertSee('テンプレート管理')
                    ;
        });
    }

    /**
     * @return void
     */
    public function testDisplayCategory()
    {
        $this->changeDBHOSTtoIP();

        $this->login();

        $this->createCategory();

        $this->browse(function (Browser $browser) {
            $browser->visit('/templateManagement')
                    ->waitForText('社会人')
                    ->assertSee('社会人');
        });
    }

    /**
     * create
     */
    public function testCreate()
    {
      $this->changeDBHOSTtoIP();
      
        $templates = EventTemplate::all();
        $templates->each(function($template) {
          $template->forceDelete();
        });
        
        $this->login();
        
        $this->createCategory();

        $this->changeDBHOSTtoMySQL();
  
        $this->browse(function (Browser $browser) {
            $browser->visit('/templateManagement')
                    ->append('#template-name', 'テスト-テンプレート名')
                    ->append('#event-name', 'テスト-イベント名')
                    ->append('#event-short-name', 'テスト-イベント略称')
                    ->append('#place', '沖縄県沖縄市')
                    ->append('#limit-number', '30')
                    ->append('#description', '詳細サンプル')
                    ->waitForText('社会人')
                    ->append('#user-category1', '500')
                    ->append('#user-category2', '400')
                    ->append('#user-category3', '300')
                    ->append('#user-category4', '200')
                    ->append('#user-category5', '100')
                    ->press('#register-btn')
                    ->press('#register-ok')
                    ->waitForText('登録完了しました。')
                    ;
        });
  
        $this->changeDBHOSTtoIP();
        // $this->assertDatabaseCount('event_templates', 1);
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
