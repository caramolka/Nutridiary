<?php

namespace Tests\Browser;

use Tests\DuskTestCase;

use App\User;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Log;

class RegisterUserTest extends DuskTestCase
{
      use DatabaseMigrations;
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testRegisterUser()
    {
        
/*
        $user = User::where('email', '=', 'me@example.com')->first();        
        
        Log::info('testRegisterUser'. ($user ? 'User Not Null.'  : 'User Is Null. '));
        
        if($user){
            $user->delete();
        }
*/        
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
            ->type( 'name', 'Me')
            ->type( 'email', 'me@example.com')
            ->type( 'password', 'secret')
            ->type( 'password_confirmation', 'secret')
            ->press('Register')
            ->assertSee('You are logged in!')
			->assertSee('Me');
        });
    }
}
