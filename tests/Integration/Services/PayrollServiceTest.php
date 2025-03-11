<?php

namespace Integration\Services;

use App\Services\PayrollService;
use Carbon\Carbon;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PayrollServiceTest extends TestCase
{
    private PayrollService $payrollService;

    public function setUp(): void
    {
        $this->payrollService = new PayrollService();
    }

    #[DataProvider('bankHolidayDateDataProvider')]
    public function testBankHolidayCheck(Carbon $date, bool $expected)
    {
        $this->assertEquals($expected, $this->payrollService->isBankHoliday($date));
    }

    public static function bankHolidayDateDataProvider(): array
    {
        return [
            '21st February (no holiday)' => [Carbon::createFromDate(2025, 2, 21), false],
            '25th December (christmas)' => [Carbon::createFromDate(2025, 12, 25), true],
        ];
    }
}
