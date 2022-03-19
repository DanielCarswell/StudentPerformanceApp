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
                    ->type('email', 'admin@studentperformance.net')
                    ->type('password', 'admin')
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
                ->assertPathIs('/classes/class_records/1')
                ->visit('/classes')
                ->press('Assignments')
                ->assertPathIs('/class/assignments/1')
                ->visit('/classes')
                ->press('Attendance')
                ->assertPathIs('/admin/classes/attendance/1')
                ->visit('/classes')
                ->press('Graph')
                ->assertPathIs('/graphs/barchart/class_grades/1')
                ->visit('/classes')
                ->press('Create Class')
                ->assertPathIs('/create/class');
        });
    }
}
