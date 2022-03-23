<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class Test7_AssessmentsTest extends DuskTestCase
{
    /** @test */
    public function create_test_class_and_student()
    {
        $this->browse(function ($browser) {
            $browser->visit('/login')
                    ->type('email', 'test@studentperformance.net')
                    ->type('password', 'testAcc12345!')
                    ->press('Login')
                    ->visit('/classes')
                    ->press('Create Class')
                    ->type('classname', 'test class')
                    ->press('Add Class')
                    ->assertPathIs('/admin/classes')
                    ->assertSee('test class')
                    ->press('Manage Students')
                    ->press('Add Student')
                    ->press('Add Student')
                    ->assertSee('Delete from Class');
        });
    }

    /** @test */
    public function class_view_assignments_buttons()
    {
        $this->browse(function ($browser) {
            $browser->visit('/classes')
                    ->press('Assignments')
                    ->assertPathBeginsWith('/class/assignments/')
                    ->assertSee('Add Assignment')
                    ->assertSee('Go Back')
                    ->press('Go Back')
                    ->assertPathBeginsWith('/classes')
                    ->press('Assignments')
                    ->press('Add Assignment')
                    ->assertPathBeginsWith('/admin/assignments/add_assignment/')
                    ->assertSee('Add Assignment')
                    ->assertSee('Go Back');
        });
    }

    /** @test */
    public function create_assignment_fail()
    {
        #No Class Worth.
        $this->browse(function ($browser) {
            $browser->visit('/admin/classes')
                    ->press('View Assignments')
                    ->press('Add Assignment')
                    ->type('assignmentname', 'Test 2')
                    ->type('classworth', '')
                    ->press('Add Assignment')
                    ->assertPathBeginsWith('/admin/assignments/add_assignment/');
        });

        #No Assignment name or class worth.
        $this->browse(function ($browser) {
            $browser->visit('/admin/classes')
                    ->press('View Assignments')
                    ->press('Add Assignment')
                    ->type('assignmentname', '')
                    ->type('classworth', '')
                    ->press('Add Assignment')
                    ->assertPathBeginsWith('/admin/assignments/add_assignment/');
        });

        #No assignment name.
        $this->browse(function ($browser) {
            $browser->visit('/admin/classes')
                    ->press('View Assignments')
                    ->press('Add Assignment')
                    ->type('assignmentname', '')
                    ->type('classworth', '20')
                    ->press('Add Assignment')
                    ->assertPathBeginsWith('/admin/assignments/add_assignment/');
        });
    }

    /** @test */
    public function create_assignment_success()
    {
        $this->browse(function ($browser) {
            $num = rand(0, 10000);
            
            $browser->visit('/admin/classes')
                    ->press('View Assignments')
                    ->press('Add Assignment')
                    ->type('assignmentname', 'Test')
                    ->type('classworth', '20')
                    ->press('Add Assignment')
                    ->assertPathBeginsWith('/admin/assignments/index/');
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
                $browser->visit('/admin/classes')
                        ->press('View Assignments')
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
                $browser->visit('/admin/classes')
                        ->press('View Assignments')
                        ->press('Delete')
                        ->assertSee('Delete')
                        ->assertSee('Cancel');
        });
    }

    /** @test */
    public function view_assignment()
    {                    
        $this->browse(function ($browser) { 
            $browser->visit('/admin/classes')
                    ->press('View Assignments')
                    ->press('View Assignment')
                    ->assertPathBeginsWith('/class/assignments/');
        });
    }

    /** @test */
    public function edit_assignment_page()
    {                    
        $this->browse(function ($browser) { 
            $browser->visit('/admin/classes')
                    ->press('View Assignments')
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
            $browser->visit('/admin/classes')
                    ->press('View Assignments')
                    ->press('Edit Assignment Details')
                    ->press('Go Back')
                    ->assertPathBeginsWith('/admin/assignments/index/');
        });
    }

    /** @test */
    public function edit_assignment_fail()
    {                    
        $this->browse(function ($browser) { 
            $browser->visit('/admin/classes')
                    ->press('View Assignments')
                    ->press('Edit Assignment Details')
                    ->type('assignmentname', '')
                    ->type('classworth', '20')
                    ->press('Edit Assignment')
                    ->assertSee('The assignmentname field is required.')
                    ->assertPathBeginsWith('/admin/assignments/edit/');
        });

        $this->browse(function ($browser) { 
            $browser->visit('/admin/classes')
                    ->press('View Assignments')
                    ->press('Edit Assignment Details')
                    ->type('assignmentname', '')
                    ->type('classworth', '')
                    ->press('Edit Assignment')
                    ->assertSee('The assignmentname field is required.')
                    ->assertSee('The classworth field is required.')
                    ->assertPathBeginsWith('/admin/assignments/edit/');
        });

        $this->browse(function ($browser) { 
            $browser->visit('/admin/classes')
                    ->press('View Assignments')
                    ->press('Edit Assignment Details')
                    ->type('assignmentname', 'TestA')
                    ->type('classworth', '')
                    ->press('Edit Assignment')
                    ->assertSee('The classworth field is required.')
                    ->assertPathBeginsWith('/admin/assignments/edit/');
        });
    }

    /** @test */
    public function edit_assignment_success()
    {                    
        $this->browse(function ($browser) { 
            $browser->visit('/admin/classes')
                    ->press('View Assignments')
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
            $browser->visit('/admin/classes')
                    ->press('View Assignments')
                    ->press('Delete Assignment')
                    ->press('Cancel')
                    ->assertPathBeginsWith('/admin/assignments/index/');
        });
    }

    /** @test */
    public function delete_assignment_confirm()
    {                    
        $this->browse(function ($browser) { 
            $browser->visit('/admin/classes')
                    ->press('View Assignments')
                    ->press('Delete Assignment')
                    ->press('Delete')
                    ->assertPathBeginsWith('/admin/assignments/index/');
        });
    }

    /** @test */
    public function delete_test_class()
    {
        $this->browse(function ($browser) {
            $browser->visit('/admin/classes')
                    ->assertSee('test class')
                    ->press('Delete Class')
                    ->press('Delete')
                    ->assertDontSee('test class');
        });
    }
}
