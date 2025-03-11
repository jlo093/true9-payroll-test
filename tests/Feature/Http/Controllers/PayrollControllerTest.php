<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;

class PayrollControllerTest extends TestCase
{
    public function testValidationFailsWithFullyMissingParameters()
    {
        $response = $this->json('POST', '/api/payroll/dates', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['year', 'month']);
    }

    public function testValidationFailsWithInvalidYear()
    {
        $response = $this->json('POST', '/api/payroll/dates', [
            'year' => 1800,
            'month' => 6
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['year']);
    }

    public function testValidationFailsWithInvalidMonth()
    {
        $response = $this->json('POST', '/api/payroll/dates', [
            'year' => 2023,
            'month' => 13
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['month']);
    }

    public function testSuccessfulResponse()
    {
        $response = $this->json('POST', '/api/payroll/dates', [
            'year' => 2023,
            'month' => 6
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'payday' => '2023-06-29',
                    'payment_date' => '2023-06-23'
                ]
            ]);
    }
}
