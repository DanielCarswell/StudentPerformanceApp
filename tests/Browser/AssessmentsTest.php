<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AssessmentsTest extends DuskTestCase
{
    /** @test */
    public function class_view_assignments_buttons()
    {
        $this->browse(function ($browser) {
            $browser->visit('/login')
                    ->type('email', 'admin@studentperformance.net')
                    ->type('password', 'admin')
                    ->press('Login');
        });

        $this->browse(function ($browser) {
            $browser->visit('/classes')
                    ->press('Assignments')
                    ->press('Go Back')
                    ->assertPathIs('/classes');
        });

        $this->browse(function ($browser) {
            $browser->visit('/classes')
                    ->press('Assignments')
                    ->press('Add Assignment')
                    ->assertPathIs('/admin/assignments/add_assignment/7');
        });
    }

    /** @test */
    public function create_assignment_fail()
    {
        $this->browse(function ($browser) {
            $browser->visit('/classes')
                    ->press('Assignments')
                    ->press('Add Assignment')
                    ->type('assignmentname', 'Test 2')
                    ->type('classworth', '')
                    ->press('Add Assignment')
                    ->assertPathIs('/admin/assignments/add_assignment/7');
        });

        $this->browse(function ($browser) {
            $browser->visit('/classes')
                    ->press('Assignments')
                    ->press('Add Assignment')
                    ->type('assignmentname', '')
                    ->type('classworth', '')
                    ->press('Add Assignment')
                    ->assertPathIs('/admin/assignments/add_assignment/7');
        });
    }

    /** @test */
    public function create_assignment_success()
    {
        $this->browse(function ($browser) {
            $num = rand(0, 10000);
            
            $browser->visit('/classes')
                    ->press('Assignments')
                    ->press('Add Assignment')
                    ->type('assignmentname', 'Test' . $num)
                    ->type('classworth', '20')
                    ->press('Add Assignment')
                    ->assertPathIs('/admin/assignments/add_assignment');
        });
    }
}
