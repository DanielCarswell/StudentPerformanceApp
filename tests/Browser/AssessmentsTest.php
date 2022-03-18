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
                    ->assertSee('Add Assignment')
                    ->assertSee('Go Back')
                    ->press('Go Back')
                    ->assertPathIs('/classes')
                    ->press('Assignments')
                    ->press('Add Assignment')
                    ->assertPathIs('/admin/assignments/add_assignment/1')
                    ->assertSee('Add Assignment')
                    ->assertSee('Go Back');
        });
    }

    /** @test */
    public function create_assignment_fail()
    {
        #No Class Worth.
        $this->browse(function ($browser) {
            $browser->visit('/admin/assignments/add_assignment/1')
                    ->type('assignmentname', 'Test 2')
                    ->type('classworth', '')
                    ->press('Add Assignment')
                    ->assertPathIs('/admin/assignments/add_assignment/1');
        });

        #No Assignment name or class worth.
        $this->browse(function ($browser) {
            $browser->visit('/admin/assignments/add_assignment/1')
                    ->type('assignmentname', '')
                    ->type('classworth', '')
                    ->press('Add Assignment')
                    ->assertPathIs('/admin/assignments/add_assignment/1');
        });

        #No assignment name.
        $this->browse(function ($browser) {
            $browser->visit('/admin/assignments/add_assignment/1')
                    ->type('assignmentname', '')
                    ->type('classworth', '20')
                    ->press('Add Assignment')
                    ->assertPathIs('/admin/assignments/add_assignment/1');
        });
    }

    /** @test */
    public function create_assignment_success()
    {
        $this->browse(function ($browser) {
            $num = rand(0, 10000);
            
            $browser->visit('/admin/assignments/add_assignment/1')
                    ->type('assignmentname', 'Test')
                    ->type('classworth', '20')
                    ->press('Add Assignment')
                    ->assertPathIs('/admin/assignments/add_assignment');
        });
    }

    /** @test */
    public function admin_class_assignments_view_buttons()
    {                    
        $this->browse(function ($browser) {       
                $browser->assertSee('Add Assignment')
                    ->assertSee('View Assignment')
                    ->assertSee('Edit Assignment Details')
                    ->assertSee('Delete Assignment');
        });
    }
}
