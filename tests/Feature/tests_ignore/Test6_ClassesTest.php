<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class Test6_ClassesTest extends DuskTestCase
{
    /** @test */
    public function admin_classes_page_and_create_test_class()
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
                    ->visit(
                        $browser->attribute('#Admin-Page', 'href')
                    )
                    ->assertPathIs('/admin')
                    ->press('Classes')
                    ->assertPathBeginsWith('/admin/classes')
                    ->assertSee('Create Class')
                    ->assertSee('Reset Search')
                    ->assertSee('Manage Students')
                    ->assertSee('View Assignments')
                    ->assertSee('Edit Class Details')
                    ->assertSee('Delete Class')
                    ->assertSee('Search Classes:');
        });
    }

    /** @test */
    public function Create_Classes_Button()
    {
        $this->browse(function ($browser) {
            $browser->visit('/admin/classes')
            ->press('Create Class')
            ->assertPathBeginsWith('/admin/classes/create')
            ->press('Go Back')
            ->assertPathBeginsWith('/admin/classes');
        });
    }

    /** @test */
    public function search_and_reset_search_test()
    {
        $this->browse(function ($browser) {
            $browser->visit('/admin/classes')
                    ->type('q', 'test class')
                    ->press('Search Classes')
                    ->assertPathBeginsWith('/admin/search_classes')
                    ->assertSee('test class')
                    ->type('q', 'dawdaGWAFGAWF')
                    ->press('Search Classes')
                    ->assertPathBeginsWith('/admin/search_classes')
                    ->assertSee('There is no data')
                    ->press('Reset Search')
                    ->assertPathBeginsWith('/admin/classes');
        });
    }

    /** @test */
    public function View_students_tests()
    {
        $this->browse(function ($browser) {
            $browser->visit('/admin/classes')
                    ->press('Manage Students')
                    ->assertPathBeginsWith('/admin/class/students/')
                    ->assertSee('Add Student')
                    ->assertSee('Upload Students')
                    ->assertDontSee('Delete from Class')
                    ->press('Add Student')
                    ->assertPathBeginsWith('/admin/class/students/add/')
                    ->assertSee('Reset Search')
                    ->assertSee('Add Student')
                    ->press('Add Student')
                    ->assertPathBeginsWith('/admin/class/students/')
                    ->assertSee('100%')
                    ->assertSee('Delete from Class')
                    ->press('Delete from Class')
                    ->assertPathBeginsWith('/admin/class/students/')
                    ->assertDontSee('Delete from Class')
                    ->press('Add Student')
                    ->type('q', 'Daniel')
                    ->press('Search Students')
                    ->assertPathIs('/admin/class/students/search_students')
                    ->press('Go Back')
                    ->assertPathBeginsWith('/admin/class/students/')
                    ->press('Go Back')
                    ->assertPathBeginsWith('/admin/classes');
        });
    }

    /** @test */
    public function view_assignments_button()
    {
        $this->browse(function ($browser) {
            $browser->visit('/admin/classes')
                    ->press('View Assignments')
                    ->assertPathBeginsWith('/admin/assignments/index/');
        });
    }

    /** @test */
    public function edit_class_test()
    {
        $this->browse(function ($browser) {
            $browser->visit('/admin/classes')
                    ->press('Edit Class Details')
                    ->assertPathBeginsWith('/admin/class/edit/')
                    ->type('classname', '')
                    ->press('Edit Class')
                    ->assertPathBeginsWith('/admin/class/edit/')
                    ->assertSee('The classname field is required.')
                    ->type('classname', 'Test Class Renamed')
                    ->press('Edit Class')
                    ->assertPathIs('/admin/classes')
                    ->assertSee('Test Class Renamed')
                    ->press('Edit Class Details')
                    ->assertPathBeginsWith('/admin/class/edit/')
                    ->press('Go Back')
                    ->assertPathIs('/admin/classes');
        });
    }

    /** @test */
    public function delete_class_test()
    {
        $this->browse(function ($browser) {
            $browser->visit('/admin/classes')
                    ->assertSee('Test Class Renamed')
                    ->press('Delete Class')
                    ->assertPathBeginsWith('/admin/classes/delete/')
                    ->press('Cancel')
                    ->assertPathBeginsWith('/admin/classes')
                    ->press('Delete Class')
                    ->press('Delete')
                    ->assertPathBeginsWith('/admin/classes')
                    ->assertDontSee('Test Class Renamed');
        });
    }
}