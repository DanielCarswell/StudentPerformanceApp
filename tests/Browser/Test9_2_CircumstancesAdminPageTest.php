<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class Test10_CircumstancesAdminPageTest extends DuskTestCase
{
    /** @test */
    public function login_and_page_contents_test()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'admin@studentperformance.net')
                    ->type('password', 'admin')
                    ->press('Login')
                    ->visit('/admin/circumstances')
                    ->assertSee('Name')
                    ->assertSee('Information')
                    ->assertSee('Email Help Links')
                    ->assertSee('Helpful Links')
                    ->assertSee('Edit Circumstance Details')
                    ->assertSee('Delete Circumstance')
                    ->assertSee('Add Circumstance');
        });
    }

    /** @test */
    public function delete_circumstance_test()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/circumstances')
                    ->press('Delete Circumstance')
                    ->assertPathBeginsWith('/admin/circumstances/delete/')
                    ->assertSee('Delete Circumstance')
                    ->assertSee('Cancel')
                    ->press('Cancel')
                    ->assertPathBeginsWith('/admin/circumstances')
                    ->press('Delete Circumstance')
                    ->press('Delete')
                    ->assertDontSee('Depression')
                    ->assertDontSee('Delete Circumstance')
                    ->assertSee('There is no data');
        });
    }

    /** @test */
    public function Add_circumstance_page_tests()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/circumstances')
                    ->press('Add Circumstance')
                    ->assertPathBeginsWith('/admin/circumstances/add')
                    ->assertSee('Create New Circumstance')
                    ->assertSee('Add Circumstance')
                    ->assertSee('Go Back')
                    ->press('Go Back')
                    ->assertPathBeginsWith('/admin/circumstances')
                    ->assertSee('Name')
                    ->assertSee('Information')
                    ->assertSee('Email Help Links')
                    ->press('Add Circumstance')
                    ->press('Add Circumstance')
                    ->assertSee('The name field is required.')
                    ->assertSee('The information field is required.')
                    ->type('name', 'Depression')
                    ->type('information', '')
                    ->press('Add Circumstance')
                    ->assertSee('The information field is required.')
                    ->type('name', '')
                    ->type('information', 'Dealing with Depression can be hard and mentally draining, there are many online sources that can advise you and help ease the burden')
                    ->press('Add Circumstance')
                    ->assertSee('The name field is required.')
                    ->type('name', 'Depression')
                    ->type('information', 'Dealing with Depression can be hard and mentally draining, there are many online sources that can advise you and help ease the burden')
                    ->press('Add Circumstance')
                    ->assertPathBeginsWith('/admin/circumstances')
                    ->assertSee('Helpful Links')
                    ->assertSee('Depression');
        });
    }

    /** @test */
    public function helpful_links_test()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/circumstances')
                    ->press('Helpful Links')
                    ->assertSee('Add Helpful Link:')
                    ->assertSee('There is no data')
                    ->assertSee('Go Back')
                    ->assertSee('Enter Link')
                    ->assertDontSee('Delete Link')
                    ->press('Enter Link')
                    ->assertSee('The link field is required.')
                    ->type('link', 'https://www.nhs.uk/mental-health/conditions/clinical-depression/overview/')
                    ->press('Enter Link')
                    ->assertDontSee('The link field is required.')
                    ->assertSee('Delete Link')
                    ->press('Delete Link')
                    ->assertDontSee('https://www.nhs.uk/mental-health/conditions/clinical-depression/overview/')
                    ->type('link', 'https://www.nhs.uk/mental-health/conditions/clinical-depression/overview/')
                    ->press('Enter Link')
                    ->type('link', 'https://www.nhsinform.scot/illnesses-and-conditions/mental-health/depression')
                    ->press('Enter Link')
                    ->type('link', 'https://www.verywellmind.com/tips-for-living-with-depression-1066834')
                    ->press('Enter Link')
                    ->press('Go Back')
                    ->assertPathBeginsWith('/admin/circumstances')
                    ->assertSee('https://www.nhs.uk/mental-health/conditions/clinical-depression/overview/')
                    ->assertSee('https://www.nhsinform.scot/illnesses-and-conditions/mental-health/depression')
                    ->assertSee('https://www.verywellmind.com/tips-for-living-with-depression-1066834');
        });
    }

    /** @test */
    public function edit_circumstance_tests()
    {
        $this->browse(function ($browser) {
            $browser->visit('/admin/circumstances')
                    ->press('Edit Circumstance Details')
                    ->assertPathBeginsWith('/admin/circumstances/edit/')
                    ->assertSee('Edit Circumstance Details')
                    ->assertSee('Go Back')
                    ->press('Go Back')
                    ->assertPathBeginsWith('/admin/circumstances')
                    ->press('Edit Circumstance Details')
                    ->type('name', '')
                    ->type('information', '')
                    ->press('Edit Circumstance')
                    ->assertSee('The name field is required.')
                    ->assertSee('The information field is required.')
                    ->type('name', 'Depression')
                    ->type('information', '')
                    ->press('Edit Circumstance')
                    ->assertSee('The information field is required.')
                    ->type('name', '')
                    ->type('information', 'Dealing with Depression can be hard and mentally draining, there are many online sources that can advise you and help ease the burden.')
                    ->press('Edit Circumstance')
                    ->assertSee('The name field is required.')
                    ->type('name', 'Depression')
                    ->type('information', 'Dealing with Depression can be hard and mentally draining, there are many online sources that can advise you and help ease the burden.')
                    ->press('Edit Circumstance')
                    ->assertPathBeginsWith('/admin/circumstances')
                    ->assertSee('Dealing with Depression can be hard and mentally draining, there are many online sources that can advise you and help ease the burden.');
        });
    }
}
