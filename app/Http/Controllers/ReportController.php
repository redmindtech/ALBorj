<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

require_once(app_path('constants.php'));

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $report_month = REPORT_MONTH;
        $report_year = REPORT_YEARS;
        return view('reports.index')->with([
            'report_month' =>$report_month,
            'report_year' => $report_year,
            // 'reports'=>$reports
        ]);
       
    }

    public function dateReport()
    {
        $startdate = $_POST['startdate'];
        $enddate = $_POST['enddate'];

        $reports = DB::table('payment_receivables AS grn')
                    ->leftJoin('project_masters AS project', 'grn.project_no', '=', 'project.project_no')
                    ->leftJoin('site_masters AS site', 'project.site_no', '=', 'site.site_no')
                    ->leftJoin('client_masters AS client', 'project.client_no', '=', 'client.client_no')
                    ->where('site.site_location', '=', 'Dubai')
                    ->whereBetween('grn.created_at', [$startdate, $enddate])
                    ->select('grn.total_amount', 'grn.vat_amount', 'grn.item_amount', 'grn.created_at', 'grn.receivables_code', 'project.project_code', 'site.site_location', 'client.company_name')
                    ->get();

info($reports);
        $reports2 = DB::table('payment_receivables AS grn')
                    ->leftJoin('project_masters AS project', 'grn.project_no', '=', 'project.project_no')
                    ->leftJoin('site_masters AS site', 'project.site_no', '=', 'site.site_no')
                    ->leftJoin('client_masters AS client', 'project.client_no', '=', 'client.client_no')
                    ->where('site.site_location', '=', 'Abu Dhabi')
                    ->whereBetween('grn.created_at', [$startdate, $enddate])
                    ->select('grn.total_amount', 'grn.vat_amount', 'grn.item_amount', 'grn.created_at', 'grn.receivables_code', 'project.project_code', 'site.site_location', 'client.company_name')
                    ->get();

        $reports3 = DB::table('payment_receivables AS grn')
                    ->leftJoin('project_masters AS project', 'grn.project_no', '=', 'project.project_no')
                    ->leftJoin('site_masters AS site', 'project.site_no', '=', 'site.site_no')
                    ->leftJoin('client_masters AS client', 'project.client_no', '=', 'client.client_no')
                    ->where('site.site_location', '=', 'Ras Al Khaimah')
                    ->whereBetween('grn.created_at', [$startdate, $enddate])
                    ->select('grn.total_amount', 'grn.vat_amount', 'grn.item_amount', 'grn.created_at', 'grn.receivables_code', 'project.project_code', 'site.site_location', 'client.company_name')
                    ->get();
        $reports4 = DB::table('payment_receivables AS grn')
                    ->leftJoin('project_masters AS project', 'grn.project_no', '=', 'project.project_no')
                    ->leftJoin('site_masters AS site', 'project.site_no', '=', 'site.site_no')
                    ->leftJoin('client_masters AS client', 'project.client_no', '=', 'client.client_no')
                    ->where('site.site_location', '=', 'Ajman')
                    ->whereBetween('grn.created_at', [$startdate, $enddate])
                    ->select('grn.total_amount', 'grn.vat_amount', 'grn.item_amount', 'grn.created_at', 'grn.receivables_code', 'project.project_code', 'site.site_location', 'client.company_name')
                    ->get();
        $reports5 = DB::table('payment_receivables AS grn')
                    ->leftJoin('project_masters AS project', 'grn.project_no', '=', 'project.project_no')
                    ->leftJoin('site_masters AS site', 'project.site_no', '=', 'site.site_no')
                    ->leftJoin('client_masters AS client', 'project.client_no', '=', 'client.client_no')
                    ->where('site.site_location', '=', 'Fujairah')
                    ->whereBetween('grn.created_at', [$startdate, $enddate])
                    ->select('grn.total_amount', 'grn.vat_amount', 'grn.item_amount', 'grn.created_at', 'grn.receivables_code', 'project.project_code', 'site.site_location', 'client.company_name')
                    ->get();
        $reports6 = DB::table('payment_receivables AS grn')
                    ->leftJoin('project_masters AS project', 'grn.project_no', '=', 'project.project_no')
                    ->leftJoin('site_masters AS site', 'project.site_no', '=', 'site.site_no')
                    ->leftJoin('client_masters AS client', 'project.client_no', '=', 'client.client_no')
                    ->where('site.site_location', '=', 'Sharjah')
                    ->whereBetween('grn.created_at', [$startdate, $enddate])
                    ->select('grn.total_amount', 'grn.vat_amount', 'grn.item_amount', 'grn.created_at', 'grn.receivables_code', 'project.project_code', 'site.site_location', 'client.company_name')
                    ->get();
        $reports7 = DB::table('payment_receivables AS grn')
                    ->leftJoin('project_masters AS project', 'grn.project_no', '=', 'project.project_no')
                    ->leftJoin('site_masters AS site', 'project.site_no', '=', 'site.site_no')
                    ->leftJoin('client_masters AS client', 'project.client_no', '=', 'client.client_no')
                    ->where('site.site_location', '=', 'Umm Al Quwain')
                    ->whereBetween('grn.created_at', [$startdate, $enddate])
                    ->select('grn.total_amount', 'grn.vat_amount', 'grn.item_amount', 'grn.created_at', 'grn.receivables_code', 'project.project_code', 'site.site_location', 'client.company_name')
                    ->get();
                    
        return response()->json([
            'reports' => $reports,
            'reports2'=>$reports2,
            'reports3'=>$reports3,
            'reports4'=>$reports4,
            'reports5'=>$reports5,
            'reports6'=>$reports6,
            'reports7'=>$reports7,
            'startdate' => $startdate,
            'enddate' => $enddate
        ]);
    }
    public function purchaseReport()
    {
        $startdate = $_POST['startdate'];
        $enddate = $_POST['enddate'];

        $pur_report = DB::table('goods_received_note AS grn')
        ->leftJoin('payment_payable AS pay', 'pay.grn_no', '=', 'grn.grn_no')
        ->leftJoin('project_masters AS project', 'grn.project_no', '=', 'project.project_no')
        ->leftJoin('site_masters AS site', 'project.site_no', '=', 'site.site_no')
        ->leftJoin('supplier_masters AS supplier', 'grn.supplier_no', '=', 'supplier.supplier_no')
        ->whereBetween('pay.created_at', [$startdate, $enddate])
        ->where('pay.deleted', 0)

        ->select(
            DB::raw('SUM(grn.total_amount) as total_amount'),
            DB::raw('SUM(grn.vat_amount) as vat_amount'),
            DB::raw('SUM(grn.gross_amount) as gross_amount'),

            'site.site_location',

        )
        ->groupBy(

            'site.site_location',

        )
        ->get();
return response()->json([
    'pur_report' =>$pur_report,
    'startdate'=>$startdate,
    'enddate'=>$enddate
 ]);
}

}