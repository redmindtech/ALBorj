<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProjectMaster;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $ApipiechartData = ProjectMaster::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->orderBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();
            info ($ApipiechartData);
            
            return view('home', compact('ApipiechartData'));
            

        } catch (Exception $e) {
            info($e);
            return response()->json('Error occured in the edit', 400);
        }

        
    }
}