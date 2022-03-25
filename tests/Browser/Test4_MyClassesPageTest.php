<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class Test4_MyClassesPageTest extends DuskTestCase
{
    /** @test */
    public function my_classes_buttons_exist()
    {
        $this->browse(function ($browser) {
            $browser->visit('/login')
                    ->type('email', 'lecturer@studentperformance.net')
                    ->type('password', 'lecturer')
                    ->press('Login')
                    ->visit('/classes')
                    ->assertSee('Create Class')
                    ->assertSee('View Class Records')
                    ->assertSee('Assignments')
                    ->assertSee('Attendance')
                    ->assertSee('View As Graph');
        });
    }

    /** @test */
    public function button_paths_correct()
    {
        $this->browse(function ($browser) {
            $browser->visit('/classes')
                ->press('View Class Records')
                ->assertPathBeginsWith('/classes/class_records/')
                ->press('Go Back')
                ->assertPathBeginsWith('/classes')
                ->press('Assignments')
                ->assertPathBeginsWith('/class/assignments/')
                ->press('Go Back')
                ->assertPathBeginsWith('/classes')
                ->press('Attendance')
                ->assertPathBeginsWith('/classes/attendance/')
                ->press('Go Back')
                ->assertPathBeginsWith('/classes')
                ->press('Graph')
                ->assertPathBeginsWith('/graphs/barchart/class_grades/')
                ->visit('/classes')
                ->press('Create Class')
                ->assertPathIs('/admin/classes/create');
        });
    }
}
