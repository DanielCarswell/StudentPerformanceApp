<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class Test5_AdvisingStudentsPageTest extends DuskTestCase
{
    /** @test */
    public function login_and_navigate_to_advising_students_test()
    {
        $this->browse(function ($browser) {
            $browser->visit('/login')
                    ->type('email', 'johndoe@studentperformance.net')
                    ->type('password', 'JohnDoe')
                    ->press('Login')
                    ->assertsee('Advising Students');
        });
    }

    /** @test */
    public function page_contents_test()
    {
        $this->browse(function ($browser) {
            $browser->visit('/students')
                    ->assertSee('Student Name')
                    ->assertSee('Average Grade')
                    ->assertSee('Average Attendance')
                    ->assertSee('View Students Records')
                    ->assertSee('View Circumstances')
                    ->assertSee('View Advisor Notes')
                    ->assertSee('View Performance Graph');
        });
    }

    /** @test */
    public function student_records_test()
    {
        $this->browse(function ($browser) {
            $browser->visit('/students')
                    ->press('View Students Records')
                    ->assertPathBeginsWith('/classes/student_records/')
                    ->assertSee('CLASS NAME')
                    ->assertSee('GRADE')
                    ->assertSee('ATTENDANCE')
                    ->assertSee('RATING')
                    ->assertSee('Go Back')
                    ->press('Go Back')
                    ->assertPathBeginsWith('/students');
        });
    }

    /** @test */
    public function view_circumstances_test()
    {
        $this->browse(function ($browser) {
            $browser->visit('/students')
                    ->press('View Circumstances')
                    ->assertPathBeginsWith('/student/circumstances/')
                    ->assertSee('Name')
                    ->assertSee('Information')
                    ->assertSee('Option Links')
                    ->assertSee('Depression')
                    ->assertSee('Remove Circumstance')
                    ->assertSee('Go Back')
                    ->press('Go Back')
                    ->assertPathBeginsWith('/students');
        });
    }

    /** @test */
    public function delete_circumstance_test()
    {
        $this->browse(function ($browser) {
            $browser->visit('/students')
                    ->press('View Circumstances')
                    ->assertSee('Depression')
                    ->press('Remove Circumstance')
                    ->assertDontSee('Depression')
                    ->assertSee('There is no data')
                    ->assertPathBeginsWith('/student/circumstances/');
        });
    }

    /** @test */
    public function add_circumstance_tests()
    {
        $this->browse(function ($browser) {
            $browser->visit('/students')
                    ->press('View Circumstances')
                    ->press('Add Circumstance')
                    ->assertPathBeginsWith('/student/circumstance/add/')
                    ->assertSee('Add Circumstance for Student ')
                    ->assertSee('Select Circumstance')
                    ->assertSee('Add Student Circumstance')
                    ->assertSee('Go Back')
                    ->press('Go Back')
                    ->assertPathBeginsWith('/student/circumstances/')
                    ->press('Add Circumstance')
                    ->press('Add Student Circumstance')
                    ->assertSee('Please select a circumstance from dropdown.')
                    ->select('circumstance', 'Depression')
                    ->press('Add Student Circumstance')
                    ->assertPathBeginsWith('/student/circumstances/')
                    ->assertSee('Depression')
                    ->press('Add Circumstance')
                    ->select('circumstance', 'Depression')
                    ->press('Add Student Circumstance')
                    ->assertSee('This circumstance is already assigned to the Student.');
        });
    }

    /** @test */
    public function view_notes_tests()
    {
        $this->browse(function ($browser) {
            $browser->visit('/students')
                    ->press('View Advisor Notes')
                    ->assertPathBeginsWith('/student/notes/')
                    ->assertSee('Go Back')
                    ->assertSee('Topic')
                    ->assertSee('Note')
                    ->assertSee('Option Links')
                    ->assertSee('There is no data')
                    ->press('Go Back')
                    ->assertPathBeginsWith('/students')
                    ->press('View Advisor Notes')
                    ->press('Add Note')
                    ->assertPathBeginsWith('/student/note/add/')
                    ->assertSee('Student Note')
                    ->assertSee('Topic')
                    ->assertSee('Note')
                    ->assertSee('Go Back')
                    ->press('Go Back')
                    ->assertPathBeginsWith('/student/notes/')
                    ->press('Add Note')
                    ->type('topic', '')
                    ->type('note', '')
                    ->press('Add Note')
                    ->assertSee('The topic field is required.')
                    ->assertSee('The note field is required.')
                    ->type('topic', 'Lab')
                    ->type('note', '')
                    ->press('Add Note')
                    ->assertSee('The note field is required.')
                    ->type('topic', '')
                    ->type('note', 'Worked Well in Group, asked good questions')
                    ->press('Add Note')
                    ->assertSee('The topic field is required.')
                    ->type('topic', 'Lab')
                    ->type('note', 'Worked Well in Group, asked good questions')
                    ->press('Add Note')
                    ->assertPathBeginsWith('/student/notes/')
                    ->assertSee('Lab')
                    ->assertSee('Edit Note')
                    ->assertSee('Remove Note')
                    ->press('Remove Note')
                    ->assertDontSee('Edit Note')
                    ->assertDontSee('Remove Note');
        });
    }

    /** @test */
    public function edit_notes_tests()
    {
        $this->browse(function ($browser) {
            $browser->visit('/students')
                    ->press('View Advisor Notes')
                    ->press('Add Note')
                    ->type('topic', 'Lab')
                    ->type('note', 'Worked Well in Group, asked good questions')
                    ->press('Add Note')
                    ->press('Edit Note')
                    ->type('topic', '')
                    ->type('note', '')
                    ->press('Edit Note')
                    ->assertSee('The topic field is required.')
                    ->assertSee('The note field is required.')
                    ->type('topic', 'Lab')
                    ->type('note', '')
                    ->press('Edit Note')
                    ->assertSee('The note field is required.')
                    ->type('topic', '')
                    ->type('note', 'Worked Well in Group, asked good questions')
                    ->press('Edit Note')
                    ->assertSee('The topic field is required.')
                    ->type('topic', 'Lecture')
                    ->type('note', 'Worked Well in Group, asked good questions.')
                    ->press('Edit Note')
                    ->assertPathBeginsWith('/student/notes/')
                    ->assertSee('Lecture')
                    ->assertSee('Edit Note')
                    ->press('Remove Note');
        });
    }
}
