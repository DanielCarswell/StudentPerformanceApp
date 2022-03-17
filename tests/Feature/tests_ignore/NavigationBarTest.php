<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class NavigationBarTest extends DuskTestCase
{
    /** @test */
    public function navbar_links()
    {
        $this->browse(function ($browser) {
            $browser->visit('/login')
                    ->type('email', 'admin@studentperformance.net')
                    ->type('password', 'admin')
                    ->press('Login');
        });

        $this->browse(function ($browser) {
            $browser->visit('/home')
                    ->assertVisible('#My-Classes')
                    ->visit(
                        $browser->attribute('#My-Classes', 'href')
                    )
                    ->assertPathIs('/classes');
        });

        $this->browse(function ($browser) {
            $browser->visit('/home')
                    ->assertVisible('#Advising-Students')
                    ->visit(
                        $browser->attribute('#Advising-Students', 'href')
                    )
                    ->assertPathIs('/students');
        });
    }
}
