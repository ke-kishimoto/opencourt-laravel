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
                    ->append('#event-title', 'テスト-イベント名')
                    ->append('#event-short-title', 'テスト-イベント略称')
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
                    ->pause(1000)
                    ->assertValue('#template-name', 'テスト-テンプレート名')
                    ->assertValue('#event-title', 'テスト-イベント名')
                    ->assertValue('#event-short-title', 'テスト-イベント略称')
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

    /**
     * update
     */
    public function testUpdate()
    {
        $this->changeDBHOSTtoIP();
          
        EventTemplate::truncate();
        
        $this->login();
        
        DBTestUtil::createCategory();
        DBTestUtil::createTemplate();
    
        $this->changeDBHOSTtoMySQL();

        $this->browse(function (Browser $browser) {
          $browser->visit('/eventTemplate/1')
                  ->pause(2000)
                  ->waitForText('社会人')
                  // ->clear('#template-name')
                  ->append('#template-name', '-更新用')
                  // ->clear('#event-title')
                  ->append('#event-title', '-更新用')
                  // ->clear('#event-short-title')
                  ->append('#event-short-title', '-更新用')
                  // ->clear('#place')
                  ->append('#place', '-更新用')
                  // ->clear('#limit-number')
                  ->append('#limit-number', '0')
                  // ->clear('#description')
                  ->append('#description', '-更新用')
                  ->clear('#user-category1')
                  ->append('#user-category1', '0')
                  ->clear('#user-category2')
                  ->append('#user-category2', '0')
                  ->clear('#user-category3')
                  ->append('#user-category3', '0')
                  ->clear('#user-category4')
                  ->append('#user-category4', '0')
                  ->clear('#user-category5')
                  ->append('#user-category5', '0')
                  ->press('#register-btn')
                  ->press('#register-ok')
                  ->pause(1000)
                  ->assertPathIs('/templateManagement')
                  ->visit('/eventTemplate/1')
                  ->pause(1000)
                  ->assertValue('#template-name', 'サンプルテンプレート-更新用')
                  ->assertValue('#event-title', 'サンプルイベント名-更新用')
                  ->assertValue('#event-short-title', 'サンプルイベント略称-更新用')
                  ->assertValue('#place', 'サンプル場所-更新用')
                  ->assertValue('#limit-number', '300')
                  ->assertValue('#description', '詳細サンプル-更新用')
                  ->assertValue('#user-category1', '5000')
                  ->assertValue('#user-category2', '4000')
                  ->assertValue('#user-category3', '3000')
                  ->assertValue('#user-category4', '2000')
                  ->assertValue('#user-category5', '1000');
      });
    }

    /**
     * delete
     */
    public function testDelete()
    {
      $this->changeDBHOSTtoIP();
          
      EventTemplate::truncate();
      
      $this->login();
      
      DBTestUtil::createCategory();
      DBTestUtil::createTemplate();
  
      $this->changeDBHOSTtoMySQL();

      $this->browse(function (Browser $browser) {
        $browser->visit('/eventTemplate/1')
        ->press('#delete-btn')
        ->press('#register-ok')
        ->pause(1000)
        ->visit('/eventTemplate/1')
        ->pause(1000)
        ->assertPathIs('/error');
      });

    }


}
