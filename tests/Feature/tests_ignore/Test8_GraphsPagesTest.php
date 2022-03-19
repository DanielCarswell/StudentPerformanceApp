<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class Test8_GraphsPagesTest extends DuskTestCase
{
   /** @test */
   public function class_graphs()
   {
       $this->browse(function ($browser) {
           $browser->visit('/login')
                   ->type('email', 'admin@studentperformance.net')
                   ->type('password', 'admin')
                   ->press('Login')
                   ->visit('/classes')
                   ->press('View As Graph')
                   ->assertPathBeginsWith('/graphs/barchart/class_grades/')
                   ->select('graphtype', 'Student Attendance')
                   ->press('Generate')
                   ->assertPathBeginsWith('/graphs/select')
                   ->assertSee('Attendance Rates')
                   ->select('graphtype', 'Student Ratings')
                   ->press('Generate')
                   ->assertPathBeginsWith('/graphs/select')
                   ->assertSee('Student Ratings')
                   ->select('graphtype', 'Student Grades')
                   ->press('Generate')
                   ->assertPathBeginsWith('/graphs/select')
                   ->assertSee('Student Grades');
       });
   }

   /** @test */
   public function student_graphs()
   {
       $this->browse(function ($browser) {
           $browser->press('Logout')
                    ->visit('/login')
                   ->type('email', 'johndoe@studentperformance.net')
                   ->type('password', 'JohnDoe')
                   ->press('Login')
                   ->visit('/students')
                   ->press('View Performance Graph')
                   ->assertPathBeginsWith('/graphs/student_details/')
                   ->select('graphtype', 'Student')
                   ->press('Generate')
                   ->assertPathBeginsWith('/graphs/select')
                   ->assertSee('Class Ratings')
                   ->select('graphtype', 'Combo')
                   ->press('Generate')
                   ->assertPathBeginsWith('/graphs/select')
                   ->assertSee('Class Details');
       });
   }
}
