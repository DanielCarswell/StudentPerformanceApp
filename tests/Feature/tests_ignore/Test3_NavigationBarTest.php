<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class Test4_NavigationBarTest extends DuskTestCase
{
    /** @test */
    public function not_logged_in_nav_links()
    {
        $this->browse(function ($browser) {
            $browser->visit('/')
                    ->assertSeeLink('Home')
                    ->assertSeeLink('Login')
                    ->assertSeeLink('Register');
        });
    }

    /** @test */
    public function logged_in_nav_links()
    {
        $this->browse(function ($browser) {
            $browser->clickLink('Login')
                    ->type('email', 'admin@studentperformance.net')
                    ->type('password', 'admin')
                    ->press('Login')
                    ->clickLink('Home')
                    ->assertSeeLink('My Classes')
                    ->visit(
                        $browser->attribute('#My-Classes', 'href')
                    )
                    ->assertPathIs('/classes')
                    ->assertSeeLink('Advising Students')
                    ->visit(
                        $browser->attribute('#Advising-Students', 'href')
                    )
                    ->assertPathIs('/students');
        });
    }
}
