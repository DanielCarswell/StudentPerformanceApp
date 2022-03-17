<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    /** @test */
    public function failed_login()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/home')
                    ->assertPathIs('/home');
        });

        $this->browse(function ($browser) {
            $browser->visit('/login')
                    ->type('email', 'admin@studentperformance.net')
                    ->type('password', 'ad')
                    ->press('Login')
                    ->assertPathIs('/login');
        });
    }

    /** @test */
    public function admin_login_and_logout()
    {
        $this->browse(function ($browser) {
            $browser->visit('/login')
                    ->type('email', 'admin@studentperformance.net')
                    ->type('password', 'admin')
                    ->press('Login')
                    ->assertPathIs('/classes');
        });

        $this->browse(function ($browser) {
            $browser->press('Logout')
                    ->assertPathIs('/home');
        });
    }

    /** @test */
    public function lecturer_login()
    {
        $this->browse(function ($browser) {
            $browser->visit('/login')
                    ->type('email', 'lecturer@studentperformance.net')
                    ->type('password', 'lecturer')
                    ->press('Login')
                    ->assertPathIs('/classes');
        });
    }
}
