<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PayrollDatesTest extends DuskTestCase
{
    public function testSuccessfulDateCalculation()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/payroll-dates')
                ->type('year', '2023')
                ->select('month', '6')
                ->press('Calculate Dates')
                ->waitFor('#resultBox', 8)
                ->assertVisible('#resultBox')
                ->assertSeeIn('#paydayResult', '2023-06')
                ->assertSeeIn('#paymentDateResult', '2023-06');
        });
    }

    public function testValidationErrorWithInvalidYear()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/payroll-dates')
                ->type('year', '1800')
                ->select('month', '6')
                ->press('Calculate Dates')
                ->waitFor('#errorMessage', 5)
                ->assertVisible('#errorMessage')
                ->assertSeeIn('#errorMessage', 'Error');
        });
    }

    public function testMissingFieldsShowError()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/payroll-dates')
                ->press('Calculate Dates')
                ->assertVisible('#errorMessage')
                ->assertSeeIn('#errorMessage', 'error');
        });
    }
}
