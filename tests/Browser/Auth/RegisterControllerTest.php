<?php

namespace Tests\Browser\Auth;

use App\Data\UserData;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;

class RegisterControllerTest extends DuskTestCase
{
    use DatabaseMigrations;
    use WithFaker;

    /** @test */
    public function user_can_register_successfully()
    {
        $password = $this->faker->password(8);
        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => $password,
            'password_confirmation' => $password,
        ];

        $this->browse(function (Browser $browser) use ($userData) {
            $browser->visit('/register')
                ->waitFor('form')
                ->type('input[id="name"]', $userData['name'])
                ->type('input[id="email"]', $userData['email'])
                ->type('input[id="password"]', $userData['password'])
                ->type('input[id="password_confirmation"]', $userData['password'])
                ->press('button[id="submit-signup"]')
                ->waitForLocation('/dashboard')
                ->assertPathIs('/dashboard');
        });

        $this->assertDatabaseHas('users', [
            'email' => $userData['email'],
            'name' => $userData['name'],
        ]);
    }

    /** @test */
    public function user_can_login_successfully()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123')
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                ->waitFor('form')
                ->type('#email', $user->email)
                ->type('#password', 'password123')
                ->press('button[type="submit"]')
                ->waitForLocation('/dashboard')
                ->assertPathIs('/dashboard');
        });
    }

    /** @test */
    public function login_fails_with_invalid_credentials()
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                ->waitFor('form')
                ->type('#email', $user->email)
                ->type('#password', 'wrong-password')
                ->press('button[type="submit"]')
                ->waitForText('These credentials do not match our records')
                ->assertSee('These credentials do not match our records');
        });
    }

    /** @test */
    public function registration_fails_with_invalid_email()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->waitFor('form')
                ->type('#name', 'John Doe')
                ->type('#email', 'not-an-email')
                ->type('#password', 'password123')
                ->type('#password_confirmation', 'password123')
                ->press('button[type="submit"]')
                ->waitForText('The email must be a valid email address')
                ->assertSee('The email must be a valid email address');
        });
    }

    /** @test */
    public function registration_fails_with_mismatched_passwords()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->waitFor('form')
                ->type('#name', 'John Doe')
                ->type('#email', 'john@example.com')
                ->type('#password', 'password123')
                ->type('#password_confirmation', 'differentpassword')
                ->press('button[type="submit"]')
                ->waitForText('The password confirmation does not match')
                ->assertSee('The password confirmation does not match');
        });
    }

    /** @test */
    public function registration_fails_with_existing_email()
    {
        User::factory()->create(['email' => 'john@example.com']);

        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->waitFor('form')
                ->type('#name', 'John Doe')
                ->type('#email', 'john@example.com')
                ->type('#password', 'password123')
                ->type('#password_confirmation', 'password123')
                ->press('button[type="submit"]')
                ->waitForText('The email has already been taken')
                ->assertSee('The email has already been taken');
        });
    }

    /** @test */
    public function registration_fails_with_short_password()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->waitFor('form')
                ->type('#name', 'John Doe')
                ->type('#email', 'john@example.com')
                ->type('#password', 'short')
                ->type('#password_confirmation', 'short')
                ->press('button[type="submit"]')
                ->waitForText('The password must be at least 8 characters')
                ->assertSee('The password must be at least 8 characters');
        });
    }

    /** @test */
    public function user_can_logout_successfully()
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/dashboard')
                ->waitFor('form[action*="logout"]')
                ->press('button[type="submit"]')
                ->waitForLocation('/')
                ->assertPathIs('/')
                ->assertGuest();
        });
    }
}
