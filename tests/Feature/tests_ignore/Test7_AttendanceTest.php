<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class Test7_AttendanceTest extends DuskTestCase
{
        /** @test */
    public function Attendance_page()
    {
        $this->browse(function ($browser) {
            $browser->visit('/login')
                    ->type('email', 'admin@studentperformance.net')
                    ->type('password', 'admin')
                    ->press('Login');
        });

        $this->browse(function ($browser) {
            $browser->visit('/classes')
                    ->press('Attendance')
                    ->assertSee('Test Class - Attendance')
                    ->assertSee('Upload Attendance')
                    ->assertSee('Go Back')
                    ->assertSee('Enter Attendance:')
                    ->assertPathBeginsWith('/classes/attendance/');
        });
    }

    public function go_back_button() {
        $this->browse(function ($browser) {
            $browser->visit('/classes')
                    ->press('Attendance')
                    ->press('Go Back')
                    ->assertPathBeginsWith('/classes');
        });
    }

    public function upload_attendance_button() {
        $this->browse(function ($browser) {
            $browser->visit('/classes')
                    ->press('Attendance')
                    ->press('Upload Attendance')
                    ->assertPathBeginsWith('/classes/upload_attendance')
                    ->assertSee('Upload Class Assignment Rates')
                    ->assertSee('Choose file')
                    ->assertSee('Upload Attendance Rates')
                    ->assertSee('Go Back');
        });
    }

    public function upload_attendance_go_back() {
        $this->browse(function ($browser) {
            $browser->visit('/classes')
                    ->press('Attendance')
                    ->press('Upload Attendance')
                    ->assertPathBeginsWith('/classes/upload_attendance')
                    ->press('Go Back')
                    ->assertPathIs('/classes/attendance/');
        });
    }

    /** @test */
    public function change_attendance()
    {                    
        $this->browse(function ($browser) {
            $browser->visit('/classes')
                    ->press('Attendance')
                    ->assertPathBeginsWith('/classes/attendance/')
                    ->type('attendance', '83')
                    ->press('Enter Attendance')
                    ->assertPathBeginsWith('/classes/attendance/')
                    ->assertSee('83%');
        });
    }
}
