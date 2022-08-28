<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\UserCategory;
use Tests\DBTestUtil;

class UserCategoryTest extends DuskTestCase
{
    /**
     * create
     */
    public function testCreate()
    {
        $this->changeDBHOSTtoIP();
      
        UserCategory::truncate();
        
        $this->login();
        
        $this->changeDBHOSTtoMySQL();
  
        $this->browse(function (Browser $browser) {
            $browser->visit('/UserCategory')
                    ->pause(1000)
                    ->appendSlowly('#user-category1', '社会人')
                    ->appendSlowly('#user-category2', '大学生')
                    ->appendSlowly('#user-category3', '高校生')
                    ->appendSlowly('#user-category4', '中学生')
                    ->appendSlowly('#user-category5', '小学生')
                    ->press('#register-btn')
                    ->press('#register-ok')
                    ->pause(1000)
                    ->visit('/')
                    ->pause(1000)
                    ->visit('/UserCategory')
                    ->pause(1000)
                    ->assertValue('#user-category1', '社会人')
                    ->assertValue('#user-category2', '大学生')
                    ->assertValue('#user-category3', '高校生')
                    ->assertValue('#user-category4', '中学生')
                    ->assertValue('#user-category5', '小学生');
        });
    }

    /**
     * update
     */
    public function testUpdate()
    {
      $this->changeDBHOSTtoIP();
      
      DBTestUtil::createCategory();
      
      $this->login();
      
      $this->changeDBHOSTtoMySQL();

      $this->browse(function (Browser $browser) {
        $browser->visit('/UserCategory')
                ->pause(1000)
                ->appendSlowly('#user-category1', '-更新用')
                ->appendSlowly('#user-category2', '-更新用')
                ->appendSlowly('#user-category3', '-更新用')
                ->appendSlowly('#user-category4', '-更新用')
                ->appendSlowly('#user-category5', '-更新用')
                ->press('#register-btn')
                ->press('#register-ok')
                ->pause(1000)
                ->visit('/')
                ->pause(1000)
                ->visit('/UserCategory')
                ->pause(1000)
                ->assertValue('#user-category1', '社会人-更新用')
                ->assertValue('#user-category2', '大学生-更新用')
                ->assertValue('#user-category3', '高校生-更新用')
                ->assertValue('#user-category4', '中学生-更新用')
                ->assertValue('#user-category5', '小学生-更新用');
    });
    }
}
