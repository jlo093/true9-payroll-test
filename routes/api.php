<?php

use App\Http\Controllers\PayrollController;
use Illuminate\Support\Facades\Route;

Route::post('/payroll/dates', [PayrollController::class, 'getPayrollDates']);
