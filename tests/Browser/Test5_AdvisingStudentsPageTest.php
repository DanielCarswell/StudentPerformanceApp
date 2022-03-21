<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class Test5_AdvisingStudentsPageTest extends DuskTestCase
{
    /** @test */
    public function setup_test()
    {
        $this->browse(function ($browser) {
            $browser->visit('/login')
                    ->type('email', 'test@studentperformance.net')
                    ->type('password', 'testAcc12345!')
                    ->press('Login')
                    ->visit('/classes')
                    ->press('Create Class')
                    ->type('classname', 'test class')
                    ->press('Add Class');
        });
    }
}
