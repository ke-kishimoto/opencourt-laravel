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
                    ->assertSee('テンプレート管理');
        });
    }

    /**
     * 
     */
    public function testCreate()
    {
      $this->changeDBHOSTtoIP();

      DB::beginTransaction();

      try {
        $templates = EventTemplate::all();
        $templates->each(function($template) {
          $template->forceDelete();
        });
    
        $this->login();
  
        $this->changeDBHOSTtoMySQL();
  
        $this->browse(function (Browser $browser) {
            $browser->visit('/templateManagement')
                    ->append('#template-name', 'テスト-テンプレート名')
                    ->append('#event-name', 'テスト-イベント名')
                    ->append('#event-short-name', 'テスト-イベント略称')
                    ->append('#place', '沖縄県沖縄市')
                    ->append('#limit-number', '30')
                    ->append('#description', '詳細サンプル')
                    ->press('#register-btn')
                    ->press('#register-ok')
                    ->waitForText('登録完了しました。')
                    ->pause(1000);
        });
  
        $this->changeDBHOSTtoIP();
  
        $this->assertDatabaseCount('event_templates', 1);
        DB::rollBack();
      } catch (\Exception $e) {
        DB::rollBack();
      }


      

    }
}
