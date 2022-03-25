<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class Test11_UserAdminPageTest extends DuskTestCase
{
    /** @test */
    public function login_and_users_admin_page_tests()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'admin@studentperformance.net')
                    ->type('password', 'admin')
                    ->press('Login')
                    ->visit('/admin/accounts')
                    ->assertSee('Upload Student Accounts - CSV File')
                    ->assertSee('NAME')
                    ->assertSee('EMAIL')
                    ->assertSee('ROLES')
                    ->assertSee('ACCOUNT ACTIONS')
                    ->assertSee('User Roles')
                    ->assertSee('Edit Account')
                    ->assertSee('Delete Account')
                    ->assertSee('Manage Advisors');
        });
    }

    /** @test */
    public function Upload_students_button_test() {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/accounts');
        });
    }
}
