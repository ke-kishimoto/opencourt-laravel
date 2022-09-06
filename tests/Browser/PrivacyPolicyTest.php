<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\PrivacyPolicy;
use Tests\DBTestUtil;

class PrivacyPolicyTest extends DuskTestCase
{
    /**
     * create
     */
    public function testCreate()
    {
        $this->changeDBHOSTtoIP();
      
        PrivacyPolicy::truncate();
        $this->login();
        
        $this->changeDBHOSTtoMySQL();
$pp = "aaa\nbbb\nccc";
        $this->browse(function (Browser $browser) use ($pp) {
            $browser->visit('/privacyPolicyManagement')
                    ->pause(1000)
                    ->append('#privacy-policy', $pp)
                    ->press('#register-btn')
                    ->press('#register-ok')
                    ->pause(1000)
                    ->visit('/')
                    ->pause(1000)
                    ->visit('/privacyPolicyManagement')
                    ->pause(1000)
                    ->assertValue('#privacy-policy', $pp);
                  });
    }

    /**
     * update
     */
    public function testUpdate()
    {
      $this->changeDBHOSTtoIP();

      PrivacyPolicy::truncate();
      PrivacyPolicy::create([
        'content' => "aaa\nbbb\nccc"
      ]);
      
      $this->login();
      
      $this->changeDBHOSTtoMySQL();
$pp = "ddd\neee\nfff";
      $this->browse(function (Browser $browser) use ($pp) {
          $browser->visit('/privacyPolicyManagement')
                  ->pause(1000)
                  ->clear('#privacy-policy')
                  ->pause(1000)
                  ->append('#privacy-policy', $pp)
                  ->press('#register-btn')
                  ->press('#register-ok')
                  ->pause(1000)
                  ->visit('/')
                  ->pause(1000)
                  ->visit('/privacyPolicyManagement')
                  ->pause(1000)
                  ->assertValue('#privacy-policy', $pp);
                });
    }
}
