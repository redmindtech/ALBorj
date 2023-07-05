<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\VisaDetails;
use Illuminate\Http\Request;
use App\Models\ProjectMaster;
use App\Models\EmployeeMaster;
use App\Models\Expenses;
use App\Models\SalaryDetails;
use App\Models\PaymentPayable;

use Exception;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
{
    try {
        if ($request->session()->has('user')) {
            $user = $request->session()->get('user');

            // Get data for daily expenses table
            $dailyExpenses = Expenses::where('created_at', '>=', '2023-01-01')
            ->where('created_at', '<=', DB::raw('CURDATE()'))
            ->selectRaw('COALESCE(SUM(total_amount), 0) AS total_amount')
            ->value('total_amount');

            // Get data for salary details table
            $salaryDetails = SalaryDetails:: where('created_at', '>=', '2023-01-01')
            ->where('created_at', '>=', DB::raw('CURRENT_DATE()'))
            ->sum('total_salary');

            // Get data for purchase table
            $purchases =PaymentPayable::where('created_at', '>=', '2023-01-01')
             ->where('created_at', '>=', DB::raw('CURDATE()'))
            ->selectRaw('COALESCE(SUM(CAST(closing_balance AS decimal(10,2))), 0) AS total_payment')
            ->value('total_payment');

            // Prepare data for the pie chart
            $expenseData = [
                'labels' => ['Purchase', 'Daily Expense', 'Salary'],
                'datasets' => [
                    [
                        'data' => [
                            number_format($purchases, 2, '.', ''),
                            number_format($dailyExpenses, 2, '.', ''),
                            number_format($salaryDetails, 2, '.', '')
                        ],
                        'backgroundColor' => [
                            'rgba(255, 99, 132, 0.8)',
                            'rgba(54, 162, 235, 0.8)',
                            'rgba(255, 206, 86, 0.8)'
                        ],
                        'borderColor' => '#fff',
                        'borderWidth' => 1
                    ]
                ]
            ];




            $pieChartOptions = [
                'responsive' => true,
                'maintainAspectRatio' => false,
                'legend' => [
                    'position' => 'bottom',
                    'labels' => [
                        'fontColor' => '#333',
                        'fontSize' => 12,
                        'padding' => 10
                    ]
                ]
            ];

            // Retrieve additional data for the pie chart
            $ApipiechartData = ProjectMaster::select(DB::raw('count(status) as ongoing_pro'))
                ->where('status', '!=', 'Closed')
                ->where('status', '!=', 'Completed')
                ->get();
            $complete = ProjectMaster::select(DB::raw('count(status) as complete'))
                ->where('status', '=', 'Completed')
                ->get();
            $emp_active = EmployeeMaster::select(DB::raw('count(status) as Working'))
                ->where('status', '=', 'Working')
                ->where('deleted', '=', '0')
                ->get();
            $emp_inactive = EmployeeMaster::select(DB::raw('count(status) as inactive'))
                ->where('deleted', '=', 0)
                ->where(function ($query) {
                    $query->where('status', '=', 'On leave')
                        ->orWhere('status', '=', 'Vacation')
                        ->orWhere('status', '=', 'Long Leave');
                })
                ->get();
            $visa_date = VisaDetails::select(DB::raw('count(expiry_date) as expiry_date'))
                ->where('deleted', '=', 0)
                ->whereDate('expiry_date', '<=', now()->toDateString())
                ->get();

            return view('home')->with([
                'user' => $user,
                'dailyExpenses' => $dailyExpenses,
                'salaryDetails' => $salaryDetails,
                'purchases' => $purchases,
                'expenseData' => $expenseData,
                'pieChartOptions' => $pieChartOptions,
                'ApipiechartData' => $ApipiechartData,
                'complete' => $complete,
                'emp_active' => $emp_active,
                'emp_inactive' => $emp_inactive,
                'visa_date' => $visa_date,
            ]);
        } else {
            return redirect("/");
        }
    } catch (Exception $e) {
        info($e);
        return response()->json('Error occurred in the edit', 400);
    }
}

}