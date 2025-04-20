<?php

namespace Tests\Browser\Auth;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class RegisterControllerTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_register_with_valid_credentials()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->assertSee('Register')
                ->type('name', 'John Doe')
                ->type('email', 'john@example.com')
                ->type('password', 'password123')
                ->type('password_confirmation', 'password123')
                ->press('Register')
                ->assertPathIs('/home') // Adjust to your success redirect
                ->assertSee('Registration successful');
        });

        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
            'name' => 'John Doe',
        ]);
    }

    /** @test */
    public function registration_fails_with_invalid_email()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('email', 'not-an-email')
                ->press('Register')
                ->assertPathIs('/register')
                ->assertSee('The email must be a valid email address');
        });
    }

    /** @test */
    public function registration_fails_with_mismatched_passwords()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('password', 'password123')
                ->type('password_confirmation', 'differentpassword')
                ->press('Register')
                ->assertPathIs('/register')
                ->assertSee('The password confirmation does not match');
        });
    }

    /** @test */
    public function registration_fails_with_existing_email()
    {
        User::factory()->create(['email' => 'john@example.com']);

        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('email', 'john@example.com')
                ->press('Register')
                ->assertPathIs('/register')
                ->assertSee('The email has already been taken');
        });
    }

    /** @test */
    public function registration_fails_with_short_password()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('password', 'short')
                ->type('password_confirmation', 'short')
                ->press('Register')
                ->assertPathIs('/register')
                ->assertSee('The password must be at least 8 characters');
        });
    }
}
