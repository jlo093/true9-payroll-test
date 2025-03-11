<?php

namespace Tests\Unit\Services;

use App\Services\PayrollService;
use Carbon\Carbon;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PayrollServiceTest extends TestCase
{
    #[DataProvider('payDayDataProvider')]
    public function testPayDayCalculation(int $year, int $month, string $expected)
    {
        $this->assertEquals($expected, (new PayrollService())->getPayDay($year, $month)->format('Y-m-d'));
    }

    #[DataProvider('paymentDateDataProvider')]
    public function testPaymentDateCalculation(Carbon $date, string $expected)
    {
        $this->assertEquals($expected, (new PayrollService())->getPaymentDate($date)->format('Y-m-d'));
    }

    public static function paymentDateDataProvider(): array
    {
        return [
            '27th February -> 21st February' => [Carbon::createFromDate(2025, 2, 27), '2025-02-21'],
            '28th March -> 24th March' => [Carbon::createFromDate(2025, 3, 28), '2025-03-24'],
        ];
    }

    public static function payDayDataProvider(): array
    {
        return [
            'February 2025 (Thursday)' => [2025, 2, '2025-02-27'],
            'March 2025 (Sunday becomes Friday)' => [2025, 3, '2025-03-28'],
            'June 2024 (Saturday becomes Friday)' => [2024, 6, '2024-06-28'],
        ];
    }
}
