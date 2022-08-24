<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Support\Facades\DB;
use App\Models\EventTemplate;
use Tests\DBTestUtil;

class TemplateTest extends DuskTestCase
{
    /**
     * create
     */
    public function testCreate()
    {
        $this->changeDBHOSTtoIP();
      
        EventTemplate::truncate();
        
        $this->login();
        
        DBTestUtil::createCategory();

        $this->changeDBHOSTtoMySQL();
  
        $this->browse(function (Browser $browser) {
            $browser->visit('/newEventtemplate')
                    ->waitForText('社会人')
                    ->append('#template-name', 'テスト-テンプレート名')
                    ->append('#event-name', 'テスト-イベント名')
                    ->append('#event-short-name', 'テスト-イベント略称')
                    ->append('#place', '沖縄県沖縄市')
                    ->append('#limit-number', '30')
                    ->append('#description', '詳細サンプル')
                    ->append('#user-category1', '500')
                    ->append('#user-category2', '400')
                    ->append('#user-category3', '300')
                    ->append('#user-category4', '200')
                    ->append('#user-category5', '100')
                    ->press('#register-btn')
                    ->press('#register-ok')
                    ->pause(1000)
                    ->assertPathIs('/templateManagement')
                    ->visit('/eventTemplate/1')
                    ->assertValue('#event-name', 'テスト-イベント名')
                    ->assertValue('#event-short-name', 'テスト-イベント略称')
                    ->assertValue('#place', '沖縄県沖縄市')
                    ->assertValue('#limit-number', '30')
                    ->assertValue('#description', '詳細サンプル')
                    ->assertValue('#user-category1', '500')
                    ->assertValue('#user-category2', '400')
                    ->assertValue('#user-category3', '300')
                    ->assertValue('#user-category4', '200')
                    ->assertValue('#user-category5', '100');
        });
    }
}
