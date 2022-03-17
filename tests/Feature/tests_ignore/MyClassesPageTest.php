<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class MyClassesPageTest extends DuskTestCase
{
    /** @test */
    public function my_classes_buttons()
    {
        $this->browse(function ($browser) {
            $browser->visit('/login')
                    ->type('email', 'admin@studentperformance.net')
                    ->type('password', 'admin')
                    ->press('Login');
        });

        $this->browse(function ($browser) {
            $browser->visit('/classes')
                    ->press('View Class Records')
                    ->assertPathIs('/classes/class_records/7');
        });

        $this->browse(function ($browser) {
            $browser->visit('/classes')
                    ->press('Assignments')
                    ->assertPathIs('/class/assignments/7');
        });

        $this->browse(function ($browser) {
            $browser->visit('/classes')
                    ->press('Attendance')
                    ->assertPathIs('/admin/classes/attendance/7');
        });

        $this->browse(function ($browser) {
            $browser->visit('/classes')
                    ->press('Graph')
                    ->assertPathIs('/graphs/barchart/class_grades/7');
        });

        $this->browse(function ($browser) {
            $browser->visit('/classes')
                    ->press('Create Class')
                    ->assertPathIs('/create/class');
        });

        $this->browse(function ($browser) {
            $browser->visit('/classes/class_records/7')
                    ->press('Go Back')
                    ->assertPathIs('/classes');
        });
    }
}
