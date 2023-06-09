<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PaymentReceivables;
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
            ->where('deleted', '0')
            ->selectRaw('COALESCE(SUM(total_amount), 0) AS total_amount')
            ->value('total_amount');

            // Get data for salary details table
            $salaryDetails = SalaryDetails:: where('created_at', '>=', '2023-01-01')
            ->where('created_at', '>=', DB::raw('CURRENT_DATE()'))
            ->where('deleted', '0')
            ->sum('total_salary');

            // Get data for purchase table
            $purchases =PaymentPayable::where('created_at', '>=', '2023-01-01')
             ->where('created_at', '>=', DB::raw('CURDATE()'))
             ->where('deleted', '0')
            ->selectRaw('COALESCE(SUM(CAST(closing_balance AS decimal(10,2))), 0) AS total_payment')
            ->value('total_payment');
            // ACCOUNT CHART
            $currentYear = date('Y');
            $current_year = $currentYear . '-01-01';
            $purchase_bar = PaymentPayable::selectRaw('MONTH(created_at) as month, SUM(invoice_amount) as purchase_bar')
                ->where('created_at', '>=', $current_year)
                ->where('created_at', '<=', date('Y-m-d'))
                ->where('deleted', '0')
                ->groupBy(DB::raw('MONTH(created_at)'))
                ->get();
                $months_bar = [];
            $purchases_bar = [];

            foreach ($purchase_bar as $purchase) {
                $months_bar[] = date('M', mktime(0, 0, 0, $purchase->month, 1));
                $purchases_bar[] = $purchase->purchase_bar;
            }
            $receivable_bar = PaymentReceivables::selectRaw('MONTH(created_at) as month, SUM(total_amount) as receivable_bar')
            ->where('created_at', '>=', $current_year)
            ->where('created_at', '<=', date('Y-m-d'))
            ->where('deleted', '0')
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();
        
        $receivable_months_bar = [];
        $receivable_amounts_bar = [];
        
        foreach ($receivable_bar as $receivable) {
            $receivable_months_bar[] = date('M', mktime(0, 0, 0, $receivable->month, 1));
            $receivable_amounts_bar[] = $receivable->receivable_bar;
        }
    


   
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
                'months_bar'=>$months_bar,
                'purchases_bar'=>$purchases_bar,
                'receivable_months_bar'=>$receivable_months_bar,
                'receivable_amounts_bar' => $receivable_amounts_bar
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