<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class Test1_RegisterTest extends DuskTestCase
{
    /** @test */
    public function register_buttons()
    {
        $this->browse(function ($browser) {
            $browser->visit('/register')
            ->assertSee('Complete Registration');
        });
    }

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
                    ->type('email', 'testawjdf@studentperformance.net')
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
                    ->type('firstname', '')
                    ->type('lastname', 'carswell')
                    ->type('email', 'testawjdf@studentperformance.net')
                    ->type('password', 'danielCarswell1234!')
                    ->type('confirmpassword', 'danielCarswell1234!')
                    ->press('Register')
                    ->assertSee('The firstname field is required.')
                    ->assertPathIs('/register');
        });

        $this->browse(function ($browser) {
            $browser->visit('/register')
                    ->type('firstname', 'daniel')
                    ->type('lastname', '')
                    ->type('email', 'testawjdf@studentperformance.net')
                    ->type('password', 'danielCarswell1234!')
                    ->type('confirmpassword', 'danielCarswell1234!')
                    ->press('Register')
                    ->assertSee('The lastname field is required.')
                    ->assertPathIs('/register');
        });

        $this->browse(function ($browser) {
            $browser->visit('/register')
                    ->type('firstname', 'daniel')
                    ->type('lastname', 'carswell')
                    ->type('email', '')
                    ->type('password', 'danielCarswell1234!')
                    ->type('confirmpassword', 'danielCarswell1234!')
                    ->press('Register')
                    ->assertSee('The email field is required.')
                    ->assertPathIs('/register');
        });

        $this->browse(function ($browser) {
            $browser->visit('/register')
                    ->type('firstname', 'daniel')
                    ->type('lastname', 'carswell')
                    ->type('email', 'testawjdf@studentperformance.net')
                    ->type('password', '')
                    ->type('confirmpassword', 'danielCarswell1234!')
                    ->press('Register')
                    ->assertSee('The password field is required.')
                    ->assertPathIs('/register');
        });

        $this->browse(function ($browser) {
            $browser->visit('/register')
                    ->type('firstname', 'daniel')
                    ->type('lastname', 'carswell')
                    ->type('email', 'testawjdf@studentperformance.net')
                    ->type('password', 'danielCarswell1234!')
                    ->type('confirmpassword', '')
                    ->press('Register')
                    ->assertSee('Password and Confirm Password do not match.')
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
                    ->type('email', 'test'. $num .'@studentperformance.net')
                    ->type('password', 'danielCarswell1234!')
                    ->type('confirmpassword', 'danielCarswell1234!')
                    ->press('Register')
                    ->assertPathIs('/home');
        });
    }
}
