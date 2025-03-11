<?php

namespace App\Http\Controllers;

use App\Services\PayrollService;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function __construct(private PayrollService  $payrollService) {}

    public function getPayrollDates(Request $request)
    {
        $request->validate([
            'year' => 'required|integer|min:1900|max:2100',
            'month' => 'required|integer|min:1|max:12'
        ]);

        $year = $request->input('year');
        $month = $request->input('month');

        try {
            $payDay = $this->payrollService->getPayDay($year, $month);
            $paymentDate = $this->payrollService->getPaymentDate($payDay);

            return response()->json([
                'success' => true,
                'data' => [
                    'payday' => $payDay->format('Y-m-d'),
                    'payment_date' => $paymentDate->format('Y-m-d')
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error calculating payroll dates: ' . $e->getMessage()
            ], 500);
        }
    }
}
