<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Laravel\Dusk\TestCase as DuskTestCase;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class StudentControllerTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function student_can_view_dashboard()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/student/dashboard')
                ->assertSee('Student Dashboard');
        });
    }

    /**
     * Prepare for Dusk test execution.
     *
     * @beforeClass
     */
    public static function prepare(): void
    {
        static::startChromeDriver();
    }

    /**
     * Create the RemoteWebDriver instance.
     */
    protected function driver(): RemoteWebDriver
    {
        return RemoteWebDriver::create(
            'http://localhost:9515',
            DesiredCapabilities::chrome()
        );
    }
}
