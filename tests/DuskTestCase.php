<?php

namespace Tests;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Laravel\Dusk\TestCase as BaseTestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;

abstract class DuskTestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Prepare for Dusk test execution.
     *
     * @beforeClass
     * @return void
     */
    public static function prepare()
    {
        if (! static::runningInSail()) {
            static::startChromeDriver();
        }
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver()
    {
        $options = (new ChromeOptions)->addArguments(collect([
            $this->shouldStartMaximized() ? '--start-maximized' : '--window-size=1920,1080',
        ])->unless($this->hasHeadlessDisabled(), function ($items) {
            return $items->merge([
                '--disable-gpu',
                '--headless',
                '--no-sandbox', //追記
            ]);
        })->all());

        return RemoteWebDriver::create(
            $_ENV['DUSK_DRIVER_URL'] ?? 'http://localhost:9515',
            DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY, $options
            )
        );
    }

    /**
     * Determine whether the Dusk command has disabled headless mode.
     *
     * @return bool
     */
    protected function hasHeadlessDisabled()
    {
        return isset($_SERVER['DUSK_HEADLESS_DISABLED']) ||
               isset($_ENV['DUSK_HEADLESS_DISABLED']);
    }

    /**
     * Determine if the browser window should start maximized.
     *
     * @return bool
     */
    protected function shouldStartMaximized()
    {
        return isset($_SERVER['DUSK_START_MAXIMIZED']) ||
               isset($_ENV['DUSK_START_MAXIMIZED']);
    }

    /**
     * Change .env DB_HOST to mysql
     */
    protected function changeDBHOSTtoMySQL()
    {
        $path = base_path('.env');

        if (file_exists($path)) {
          file_put_contents($path, str_replace(
            'DB_HOST=127.0.0.1',
            'DB_HOST=mysql',
              file_get_contents($path)
          ));
        }
    }

    /**
     * Change .env DB_HOST to IP Address
     */
    protected function changeDBHOSTtoIP()
    {
        $path = base_path('.env');

        if (file_exists($path)) {
          file_put_contents($path, str_replace(
            'DB_HOST=' . 'mysql',
            'DB_HOST=' . '127.0.0.1',
              file_get_contents($path)
          ));
        }
    }

    /**
     * Login
     */
    protected function login()
    {

      $this->changeDBHOSTtoIP();

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
          ->waitForLocation('/');
      });

    }
}
