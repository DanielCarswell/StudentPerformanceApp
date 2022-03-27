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
            $browser->visit('/admin/accounts')
                    ->press('Upload Student Accounts - CSV File')
                    ->assertPathBeginsWith('/admin/accounts/create_students')
                    ->assertSee('Upload Student(s) Details')
                    ->assertSee('Upload Students')
                    ->assertSee('Go Back')
                    ->press('Go Back')
                    ->assertSee('Users');
        });
    }

    /** @test */
    public function Manage_advisors_tests()
    {
        $this->browse(function ($browser) {
            $browser->visit('/admin/accounts')
                    ->press('Manage Advisors')
                    ->assertPathBeginsWith('/admin/student/advisors/')
                    ->assertSee('Add Advisor')
                    ->assertDontSee('Remove Student Advisor')
                    ->press('Add Advisor')
                    ->assertPathBeginsWith('/admin/student/advisors/add/')
                    ->assertSee('Reset Search')
                    ->assertSee('Add Advisor')
                    ->press('Add Advisor')
                    ->assertPathBeginsWith('/admin/student/advisors/')
                    ->assertSee('Remove Student Advisor')
                    ->press('Remove Student Advisor')
                    ->assertPathBeginsWith('/admin/student/advisors/')
                    ->assertDontSee('Remove Student Advisor')
                    ->press('Add Advisor')
                    ->type('q', 'Daniel')
                    ->press('Search Advisors')
                    ->assertPathIs('/admin/student/advisors/search_advisors')
                    ->press('Go Back')
                    ->assertPathBeginsWith('/admin/student/advisors/')
                    ->press('Go Back')
                    ->assertPathBeginsWith('/admin/accounts');
        });
    }

    /** @test */
    public function Manage_roles_tests()
    {
        $this->browse(function ($browser) {
            $browser->visit('/admin/accounts')
                    ->press('User Roles')
                    ->assertPathBeginsWith('/admin/user/roles/index/')
                    ->assertSee('User - ')
                    ->assertSee('Give Role')
                    ->assertSee('Go Back')
                    ->assertSee('Remove Role')
                    ->press('Go Back')
                    ->assertPathBeginsWith('/admin/accounts')
                    ->press('User Roles')
                    ->press('Remove Role')
                    ->assertDontSee('Delete Role')
                    ->assertSee('There is no data')
                    ->press('Give Role')
                    ->assertPathBeginsWith('/admin/user/roles/add/')
                    ->assertSee('Add Role for')
                    ->assertSee('Add User Role')
                    ->assertSee('Go Back')
                    ->press('Go Back')
                    ->assertPathBeginsWith('/admin/user/roles/index/')
                    ->press('Give Role')
                    ->press('Add User Role')
                    ->assertSee('Please select a role.')
                    ->select('role', 'Lecturer')
                    ->press('Add User Role')
                    ->assertPathBeginsWith('/admin/user/roles/index/')
                    ->assertSee('Lecturer')
                    ->assertSee('Remove Role')
                    ->press('Give Role')
                    ->select('role', 'Lecturer')
                    ->press('Add User Role')
                    ->assertSee('This role is already assigned to the user.');
        });
    }

    /** @test */
    public function Edit_account_tests()
    {
        $this->browse(function ($browser) {
            $browser->visit('/admin/accounts')
                    ->press('Edit Account')
                    ->assertPathBeginsWith('/admin/accounts/edit/')
                    ->assertSee('Edit Account')
                    ->assertSee('Edit Account Details')
                    ->assertSee('Go Back')
                    ->press('Go Back')
                    ->assertSee('Users')
                    ->press('Edit Account')
                    ->press('Edit Account Details')
                    ->assertSee('Users')
                    ->press('Edit Account')
                    ->type('email', 'admin@studentperformance.net')
                    ->press('Edit Account Details')
                    ->assertSee('The email entered is already registered to another user.')
                    ->type('email', '')
                    ->press('Edit Account Details')
                    ->assertSee('The email field is required.')
                    ->type('firstname', '')
                    ->press('Edit Account Details')
                    ->assertSee('The firstname field is required.')
                    ->type('lastname', '')
                    ->press('Edit Account Details')
                    ->assertSee('The lastname field is required.')
                    ->type('email', '')
                    ->type('firstname', '')
                    ->type('lastname', '')
                    ->press('Edit Account Details')
                    ->assertSee('The email field is required.')
                    ->assertSee('The firstname field is required.')
                    ->assertSee('The lastname field is required.')
                    ->type('email', 'testemail@studentperformance.net')
                    ->type('firstname', 'test')
                    ->type('lastname', 'email')
                    ->press('Edit Account Details')
                    ->assertSee('Users')
                    ->assertSee('test email')
                    ->assertSee('testemail@studentperformance.net');
        });
    }

    /** @test */
    public function delete_account_tests()
    {
        $this->browse(function ($browser) {
            $browser->visit('/admin/accounts')
                    ->assertSee('Showing 1 to 8 of 45 results')
                    ->press('Delete Account')
                    ->assertSee('Showing 1 to 8 of 44 results');
        });
    }
}
