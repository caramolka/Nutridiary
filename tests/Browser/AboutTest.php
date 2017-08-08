<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AboutTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testAbout()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/about')
                    ->assertSee('Nutridiary');
        });
    }
}
