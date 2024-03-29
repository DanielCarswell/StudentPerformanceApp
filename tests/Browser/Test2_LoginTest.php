<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class Test2_LoginTest extends DuskTestCase
{
    /** @test */
    public function login_buttons()
    {
        $this->browse(function ($browser) {
            $browser->visit('/login')
                    ->assertSee('Login');
        });
    }

    /** @test */
    public function failed_login()
    {
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
                    ->assertPathBeginsWith('/logout');
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
