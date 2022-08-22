<?php

namespace Tests\Browser;

use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginTest extends DuskTestCase
{
  // php artisan dusk で実行
  // マイグレーションをし直すっぽいが、DB_HOST=mysqlだとエラーでうまくいかない
  // DB_HOST=127.0.0.1にすると、実行でエラーは出ないが、マイグレーションがされた気配がない
  // sail dusk使うと、Connection refusedでエラー
  // use DatabaseMigrations;

  /**
   * login success test
   *
   * @return void
   */
  public function testLoginSuccess()
  {

    $this->changeDBHOSTtoIP();

    DB::beginTransaction();

    User::destroy(User::all()->pluck('id'));

    $user = User::factory()->create([
      'email' => 'super@test.com',
      'password' => Hash::make('password'),
    ]);

    $user->save();

    $this->changeDBHOSTtoMySQL();

    $this->browse(function (Browser $browser) {
      $browser->visit('/login')
        // valueで値をセットすると、Reactでstateにうまく反映されない
        ->append('#email', 'super@test.com')
        ->append('#password', 'password')
        ->press('#login')
        ->pause(1500)
        ->assertSee('お知らせ');
    });

    $this->changeDBHOSTtoIP();

    DB::rollBack();

  }

  public function testLoginFaild()
  {
    $this->browse(function (Browser $browser) {
      $browser->visit('/login')
        // valueで値をセットすると、Reactでstateにうまく反映されない
        ->append('#email', 'superr@test.com')
        ->append('#password', 'password')
        ->press('#login')
        ->pause(1500)
        ->assertSee('メールアドレスかパスワードが間違っています。');
    });
  }
}
