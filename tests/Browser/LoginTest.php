<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    // use DatabaseMigrations;
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {

        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
            ->append('#email', 'super@test.com')
            ->append('#password', 'password')
            ->press('#login')
            ->pause(1000)
            ->assertSee('お知らせ');
        });
    }
}
