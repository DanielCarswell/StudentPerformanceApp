<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterTest extends DuskTestCase
{
    /** @test */
    public function failed_register_registered_email()
    {
        $this->browse(function ($browser) {
            $browser->visit('/register')
                    ->type('firstname', 'daniel')
                    ->type('lastname', 'carswell')
                    ->type('email', 'admin@studentperformance.net')
                    ->type('password', 'danielCarswell1234!')
                    ->type('confirmpassword', 'danielCarswell1234!')
                    ->press('Register')
                    ->assertPathIs('/register');
        });
    }

    /** @test */
    public function failed_register_different_passwords()
    {
        $this->browse(function ($browser) {
            $browser->visit('/register')
                    ->type('firstname', 'daniel')
                    ->type('lastname', 'carswell')
                    ->type('email', 'abcwjfwi@studentperformance.net')
                    ->type('password', 'danielCarswell1234!')
                    ->type('confirmpassword', 'danielCarswel!')
                    ->press('Register')
                    ->assertPathIs('/register');
        });
    }

    /** @test */
    public function failed_register_missing_field()
    {
        $this->browse(function ($browser) {
            $browser->visit('/register')
                    ->type('firstname', 'daniel')
                    ->type('lastname', '')
                    ->type('email', 'admin@studentperformance.net')
                    ->type('password', 'danielCarswell1234!')
                    ->type('confirmpassword', 'danielCarswell1234!')
                    ->press('Register')
                    ->assertPathIs('/register');
        });
    }

    /** @test */
    public function successful_register()
    {
        $this->browse(function ($browser) {
            $num = rand(0, 10000);

            $browser->visit('/register')
                    ->type('firstname', 'daniel')
                    ->type('lastname', 'carswell')
                    ->type('email', 'daniel'. $num .'@studentperformance.net')
                    ->type('password', 'danielCarswell1234!')
                    ->type('confirmpassword', 'danielCarswell1234!')
                    ->press('Register')
                    ->assertPathIs('/home');
        });
    }
}
