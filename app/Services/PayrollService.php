<?php

namespace App\Services;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Http;

class PayrollService
{
    public function getPayDay(int $year, int $month): Carbon
    {
        $lastDay = Carbon::create($year, $month)->endOfMonth();

        $payDay = $lastDay->copy()->subDays();
        if ($payDay->isSaturday()) {
            $payDay->subDays();
        } elseif ($payDay->isSunday()) {
            $payDay->subDays(2);
        }

        return $payDay;
    }

    public function getPaymentDate(Carbon $payDay): Carbon
    {
        $workingDaysToSubtract = 4;
        $currentDate = $payDay->copy();

        /* The task description specifies working days, so we skip days
           that fall onto a weekend to correctly calculate payment day. */
        while ($workingDaysToSubtract > 0) {
            $currentDate->subDay();

            if (!$currentDate->isWeekend() && !$this->isBankHoliday($currentDate)) {
                $workingDaysToSubtract--;
            }
        }

        return $currentDate;
    }

    /**
     * @throws Exception
     */
    public function isBankHoliday(Carbon $date): bool
    {
        // this is a free API that requires no access token/registration
        $url = "https://date.nager.at/api/v3/PublicHolidays/{$date->year}/GB";

        $response = Http::get($url);

        if ($response->getStatusCode() !== 200) {
            throw new Exception('Failed to fetch bank holidays.');
        }

        $holidays = json_decode($response->getBody(), true);
        if (!is_array($holidays)) {
            throw new Exception('Invalid bank holiday data received.');
        }

        $dateString = $date->format('Y-m-d');
        foreach ($holidays as $holiday) {
            if ($holiday['date'] === $dateString) {
                return true;
            }
        }

        return false;
    }
}
