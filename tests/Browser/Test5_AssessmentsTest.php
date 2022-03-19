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
                    ->assertPathBeginsWith('/class/assignments/')
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
                    ->assertPathIs('/admin/assignments/index/1');
        });
    }

    /** @test */
    public function change_assignment_mark()
    {                    
        $this->browse(function ($browser) {
            $browser->visit('/classes')
                    ->press('Assignments')
                    ->press('Add/Change Assignment Marks')
                    ->assertPathBeginsWith('/admin/classes/assignment_grades/')
                    ->assertSee('Upload Assignment Marks')
                    ->assertSee('Go Back')
                    ->assertSee('Enter Mark')
                    ->type('percent', '83')
                    ->press('Enter Mark')
                    ->assertPathBeginsWith('/admin/classes/assignment_grades/')
                    ->assertSee('83%');
        });
    }

    /** @test */
    public function admin_class_assignments_view_buttons()
    {                    
        $this->browse(function ($browser) {       
                $browser->visit('/admin/assignments/index/1')
                    ->assertSee('Add Assignment')
                    ->assertSee('View Assignment')
                    ->assertSee('Edit Assignment Details')
                    ->assertSee('Delete Assignment');
        });
    }

    /** @test */
    public function delete_assignment_view_buttons()
    {                    
        $this->browse(function ($browser) {       
                $browser->visit('/admin/assignments/index/1')
                    ->press('Delete')
                    ->assertSee('Delete')
                    ->assertSee('Cancel');
        });
    }

    /** @test */
    public function view_assignment()
    {                    
        $this->browse(function ($browser) { 
            $browser->visit('/admin/assignments/index/1')
                    ->press('View Assignment')
                    ->assertPathIs('/class/assignments/1');
        });
    }

    /** @test */
    public function edit_assignment_page()
    {                    
        $this->browse(function ($browser) { 
            $browser->visit('/admin/assignments/index/1')
                    ->press('Edit Assignment Details')
                    ->assertSee('Edit Assignment')
                    ->assertSee('Go Back')
                    ->assertSee('Assignment name:')
                    ->assertSee('Class Worth(% of Class Total):')
                    ->assertPathBeginsWith('/admin/assignments/edit/');
        });
    }

    /** @test */
    public function edit_assignment_go_back()
    {                    
        $this->browse(function ($browser) { 
            $browser->visit('/admin/assignments/index/1')
                    ->press('Edit Assignment Details')
                    ->press('Go Back')
                    ->assertPathIs('/admin/assignments/index/1');
        });
    }

    /** @test */
    public function edit_assignment_fail()
    {                    
        $this->browse(function ($browser) { 
            $browser->visit('/admin/assignments/index/1')
                    ->press('Edit Assignment Details')
                    ->type('assignmentname', '')
                    ->type('classworth', '20')
                    ->press('Edit Assignment')
                    ->assertPathBeginsWith('/admin/assignments/edit/');
        });

        $this->browse(function ($browser) { 
            $browser->visit('/admin/assignments/index/1')
                    ->press('Edit Assignment Details')
                    ->type('assignmentname', '')
                    ->type('classworth', '')
                    ->press('Edit Assignment')
                    ->assertPathBeginsWith('/admin/assignments/edit/');
        });

        $this->browse(function ($browser) { 
            $browser->visit('/admin/assignments/index/1')
                    ->press('Edit Assignment Details')
                    ->type('assignmentname', 'TestA')
                    ->type('classworth', '')
                    ->press('Edit Assignment')
                    ->assertPathBeginsWith('/admin/assignments/edit/');
        });
    }

    /** @test */
    public function edit_assignment_success()
    {                    
        $this->browse(function ($browser) { 
            $browser->visit('/admin/assignments/index/1')
                    ->press('Edit Assignment Details')
                    ->type('assignmentname', 'TestA')
                    ->type('classworth', '20')
                    ->press('Edit Assignment')
                    ->assertPathBeginsWith('/admin/assignments/index/');
        });
    }

    /** @test */
    public function delete_assignment_cancel()
    {                    
        $this->browse(function ($browser) { 
            $browser->visit('/admin/assignments/index/1')
                    ->press('Delete Assignment')
                    ->press('Cancel')
                    ->assertPathIs('/admin/assignments/index/1');
        });
    }

    /** @test */
    public function delete_assignment_confirm()
    {                    
        $this->browse(function ($browser) { 
            $browser->visit('/admin/assignments/index/1')
                    ->press('Delete Assignment')
                    ->press('Delete')
                    ->assertPathIs('/admin/assignments/index/1');
        });
    }
}
