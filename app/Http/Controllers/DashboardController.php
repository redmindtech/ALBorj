<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\VisaDetails;
use Illuminate\Http\Request;
use App\Models\ProjectMaster;
use App\Models\EmployeeMaster;
use Exception;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
       

        try {
            if ($request->session()->has('user')) {
                 $user = $request->session()->get('user');
                // ongoing projects
                 $ApipiechartData = ProjectMaster::select(DB::raw('count(status) as ongoing_pro'))
                 ->where('status', '!=', 'Closed')
                 ->where('status', '!=', 'Completed')
                 ->get();
            //  completed projects
             $complete=ProjectMaster::select(DB::raw('count(status) as complete'))
             ->where('status', '=', 'Completed')
             ->get();
             info($complete);
            //  active employeess
            $emp_active=EmployeeMaster::select(DB::raw('count(status) as Working'))
            ->where('status', '=', 'Working')
            ->where('deleted', '=','0')
            ->get();
            info($emp_active);
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
        
            info($visa_date);
             return view('home')
            ->with([
                'user'=>$user,
                'ApipiechartData' => $ApipiechartData,              
                'complete'=>$complete,
                'emp_active'=>$emp_active,
                'emp_inactive'=>$emp_inactive,
                'visa_date'=>$visa_date,
               
             ]);

            // return view('home', compact('ApipiechartData','user'));
            }
            else{
                return redirect("/");
            }

        } catch (Exception $e) {
            info($e);
            return response()->json('Error occured in the edit', 400);
        }


    }
}