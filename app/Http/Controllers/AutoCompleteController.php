<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ClientMaster;
use App\Models\EmployeeMaster;
use App\Models\ItemMaster;
use App\Models\ProjectMaster;
use App\Models\ProjectMasterItem;
use App\Models\PurchaseOrder;
use App\Models\SiteMaster;
use App\Models\SupplierMaster;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Models\MaterialRequisition;


class AutoCompleteController extends Controller
{
  // to populate date from po in grn
  public function get_po_details(){
    try {


// DB::enableQueryLog();
      // For po_id get from po table
      $po_code = $_GET['po_code'];
      info($po_code);
      $po_info = DB::table('purchase_order')
      ->join('supplier_masters', 'purchase_order.supplier_no', '=', 'supplier_masters.supplier_no')
      ->select('purchase_order.po_no', 'purchase_order.po_date', 'purchase_order.supplier_no', 'supplier_masters.name','purchase_order.po_type',
      'purchase_order.freight','purchase_order.misc_expenses','purchase_order.discount','purchase_order.discount_type',
     'purchase_order.vat','purchase_order.total_vat' )
      ->where('po_status', '=', '0')
      ->where('purchase_order.deleted','0')
      ->where('purchase_order.po_code', $po_code)
      ->first();
      
      if ($po_info) {
        
          $po_no = $po_info->po_no;
          $po_date = $po_info->po_date;
          $supplier_name=$po_info->name;
          $supplier_no=$po_info->supplier_no;
          $purchase_type=$po_info->po_type;
          $freight=$po_info->freight;
          $misc_expenses=$po_info->misc_expenses;
          $discount=$po_info->discount;
          $discount_type=$po_info->discount_type;
          $vat=$po_info->vat;
          $total_vat=$po_info->total_vat;



          // Items get from po_item table
          $po_items = DB::table('purchase_order_item')
              ->join('item_masters', 'purchase_order_item.item_no', '=', 'item_masters.id')
              ->select('purchase_order_item.*', 'item_masters.item_name','item_masters.item_unit')
              ->where('po_no', $po_no)
              ->where('purchase_order_item.deleted','0')
               ->where('pending_qty', '!=', 0)
              ->get();

          return response()->json([
              'po_no' => $po_no,
              'po_date' => $po_date, // Include po_date in the response
              'po_items' => $po_items,
              'supplier_name'=>$supplier_name,
              'supplier_no'=> $supplier_no,
              'purchase_type'=>$purchase_type,
              'freight'=>$freight,
              'misc_expenses'=>$misc_expenses,
              'discount'=>$discount,
              'discount_type'=>$discount_type,
              'total_vat'=>$total_vat,
              'vat'=>$vat

    
          ]);

      } else {
          // Handle case when no matching record is found
          return response()->json([
              'error' => 'No purchase order found with the given code.'
          ], 404);
      }
  } catch (Exception $e) {
      // Handle any exceptions that occur during the process
      return response()->json([
          'error' => 'An error occurred while retrieving purchase order data.'
      ], 500);
  }

   }
    //  auto complete data for item name populated in GRN and material issue item name
     public function  getitemnamedata(){
      try{
          $itemname = $_GET['itemname'];
          $data = ItemMaster::where('item_name','LIKE',$itemname.'%')->get();
          return $data;
      }
       catch (Exception $e) {
          info($e);
          return response()->json('Error occured in the loading page', 400);
      }
  }
  // to get employee firstname used in site master(site manager)
  public function  getemployeedata(){

     $firstname = $_GET['firstname'];
    // $empname = $_GET['empname'];
    $data = EmployeeMaster::where('firstname','LIKE',$firstname.'%')
    ->orwhere('lastname', 'LIKE', $firstname . '%')
    ->where('employee_masters.deleted','0')
    ->get();

    if ($data) {
        $data = $data->toArray();

        // Convert the data to UTF-8 encoding
        array_walk_recursive($data, function (&$value) {
            if (is_object($value)) {
                $value = (array) $value; // Convert the stdClass object to an array
            }

            if (is_array($value)) {
                array_walk_recursive($value, function (&$item) {
                    if (!mb_check_encoding($item, 'UTF-8')) {
                        // Handle invalid characters
                        $item = mb_convert_encoding($item, 'UTF-8', 'UTF-8');
                    }
                });
            } else {
                if (!mb_check_encoding($value, 'UTF-8')) {
                    // Handle invalid characters
                    $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                }
            }
        });
    }

    return $data;
}
  // autocomplete data for project master form clientnaster( company name)
  public function  getclientdata(){

    $company_name = $_GET['company_name'];
    $data = ClientMaster::where('company_name','LIKE',$company_name.'%')->get();
    if ($data) {
        $data = $data->toArray();

        // Convert the data to UTF-8 encoding
        array_walk_recursive($data, function (&$value) {
            if (is_object($value)) {
                $value = (array) $value; // Convert the stdClass object to an array
            }

            if (is_array($value)) {
                array_walk_recursive($value, function (&$item) {
                    if (!mb_check_encoding($item, 'UTF-8')) {
                        // Handle invalid characters
                        $item = mb_convert_encoding($item, 'UTF-8', 'UTF-8');
                    }
                });
            } else {
                if (!mb_check_encoding($value, 'UTF-8')) {
                    // Handle invalid characters
                    $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                }
            }
        });
    }
    return $data;
}
//  autocomplete data for project master form sitmaster(site name)
public function  getsitedata(){

  $site_name = $_GET['site_name'];
  $data = SiteMaster::where('site_name','LIKE',$site_name.'%')->get();

  return $data;
}
// auto complete for employee master for project current location
public function  getlocdata(){

  $projectname = $_GET['projectname'];
  $data = ProjectMaster::where('project_name','LIKE',$projectname.'%')->get();
  return $data;
}
// auto complete for itemmaster for supplier_name
public function  getempdata(){

  $suppliername = $_GET['suppliername'];
  $data = SupplierMaster::where('name','LIKE',$suppliername.'%')->get();

  return $data;
}
public function  getempdata_supplier_company(){

    $suppliername = $_GET['suppliername'];
    $data = SupplierMaster::where('company_name','LIKE',$suppliername.'%')->get();

    return $data;
  }
// sitemaster location for  material issue (location)
public function  getsitelocationdata(){

  $site_name = $_GET['site_name'];

  $data = SiteMaster::where('site_location','LIKE',$site_name.'%')->get();
  //info($data);

  return $data;
}
// purchase order item population for price from item supplier
public function getpopricedata(){
  try {
      $itemname = $_GET['itemname'];
      $data = DB::table('item_masters')
          ->select('item_masters.id', 'item_masters.item_name', 'item_supplier.*','item_supplier.supplier_no')
          ->join('item_supplier', 'item_masters.id', '=', 'item_supplier.item_no','item_master.item_unit')
          ->where('item_masters.item_name', 'LIKE', $itemname.'%')
          ->get();

      if (count($data) == 0) {
          return response()->json('No data found', 404);
      }

      return $data;
  } catch (Exception $e) {
      info($e);
      return response()->json('Error occurred in the loading page', 400);
  }

}
// item auto complete for purchase return
public function purchase_return_data(){
  try {
      $itemname = $_GET['itemname'];
      $supplier_id = $_GET['supplier_id'];
      $data = ItemMaster::
          join('item_supplier', 'item_masters.id', '=', 'item_supplier.item_no')
          ->select('item_masters.', 'item_supplier.')
          ->where('item_masters.item_name', 'LIKE', $itemname.'%')
          ->where('item_supplier.supplier_no', '=', $supplier_id)
          ->get();

      if (count($data) == 0) {
          return response()->json('No data found', 404);
      }

      return $data;
  } catch (Exception $e) {
      info($e);
      return response()->json('Error occurred in the loading page', 400);
  }

}
//get MR code from MaterialRequisition
public function  getmrcode(){

    $mrcode = $_GET['mrcode'];
    $data = MaterialRequisition::where('mr_reference_code','LIKE',$mrcode.'%')
    ->where('deleted','=', '0')
    ->get();
  
    return $data;
    
  }
//   auto complete for po number
public function po_number()
{
    $pocode = $_GET['po_code'];
    $data = PurchaseOrder::where('po_code','LIKE',$pocode.'%')
    ->where('po_status', '=', '0')
    ->where('deleted', '=', '0')->get();
    return $data;
}
  
//auto complete for payroll
public function getpaydata(Request $request)
{
    $month = $request->input('month');
    $year = $request->input('year');
    $employee_id = $request->input('employee_id');

    $empTimesheets = DB::table('emp_timesheets')
        ->where('emp_no', $employee_id)
        ->whereMonth('emp_timesheets.from_date', '=', $month)
        ->pluck('id')
        ->toArray();
info($empTimesheets);
    $emp = count($empTimesheets);
    info($emp);

    $data = [];
    $data1 = [];
    $data2 = [];

    if ($emp > 0) {
        for ($i = 0; $i < $emp; $i++) {
            $currentTimesheetId = $empTimesheets[$i];

            $attendanceData = DB::table('employee_attendance_sheets')
                ->join('emp_timesheets', 'emp_timesheets.id', '=', 'employee_attendance_sheets.timesheet_id')
                ->join('employee_masters', 'employee_masters.id', '=', 'emp_timesheets.emp_no')
                ->join('salary_details', 'salary_details.employee_id', '=', 'employee_masters.id')
                ->whereMonth('employee_attendance_sheets.date', '=', $month)
                ->where('emp_timesheets.id', $currentTimesheetId)
                ->whereYear('employee_attendance_sheets.date', '=', $year)
                ->where('employee_attendance_sheets.holiday', 0)
                ->where('employee_attendance_sheets.leave', 0)
                ->groupBy('salary_details.basic', 'salary_details.hra')
                ->select(DB::raw('count(*) as count, salary_details.basic, salary_details.hra'))
                ->first();

            $leaveData = DB::table('employee_attendance_sheets')
                ->join('emp_timesheets', 'emp_timesheets.id', '=', 'employee_attendance_sheets.timesheet_id')
                ->join('employee_masters', 'employee_masters.id', '=', 'emp_timesheets.emp_no')
                ->join('salary_details', 'salary_details.employee_id', '=', 'employee_masters.id')
                ->whereMonth('employee_attendance_sheets.date', '=', $month)
                ->where('emp_timesheets.id', $currentTimesheetId)
                ->whereYear('employee_attendance_sheets.date', '=', $year)
                ->where('employee_attendance_sheets.leave', 1)
                ->select(DB::raw('count(*) as `leave`'))
                ->first();

            $otData = DB::table('employee_attendance_sheets')
                ->join('emp_timesheets', 'emp_timesheets.id', '=', 'employee_attendance_sheets.timesheet_id')
                ->join('employee_masters', 'employee_masters.id', '=', 'emp_timesheets.emp_no')
                ->join('salary_details', 'salary_details.employee_id', '=', 'employee_masters.id')
                ->whereMonth('employee_attendance_sheets.date', '=', $month)
                ->where('emp_timesheets.id', $currentTimesheetId)
                ->whereYear('employee_attendance_sheets.date', '=', $year)
                ->whereNotNull('employee_attendance_sheets.ot_total_time')
                ->select(DB::raw('sum(ot_total_time) as `ot`'))
                ->first();

            $data[] = $attendanceData;
            $data1[] = $leaveData;
            $data2[] = $otData;
        }
    }

    return response()->json([
        'data' => $data,
        'data1' => $data1,
        'data2' => $data2
    ]);
}
public function  get_project_boq(){

    $projectname = $_GET['projectname'];
    $project_name = ProjectMaster::where('project_name','LIKE',$projectname.'%')
    ->get();
     $project_no = ProjectMaster::where('project_name',$projectname)->value('project_no');
     $project_master_item = ProjectMasterItem::where('proj_no',$project_no)
     ->join('item_masters','item_masters.id','=','project_master_item.item_no')
     ->select('item_masters.*','project_master_item.*')->get();
    
    return response()->json([
         'project_master_item' => $project_master_item,
        'project_no'=>$project_no,
        'project_name'=>$project_name
    ]);
  }
}