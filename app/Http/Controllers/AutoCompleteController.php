<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ClientMaster;
use App\Models\EmployeeMaster;
use App\Models\ItemMaster;
use App\Models\ProjectMaster;
use App\Models\SiteMaster;
use App\Models\SupplierMaster;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;

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
        ->select('purchase_order.po_no', 'purchase_order.po_date', 'purchase_order.supplier_no', 'supplier_masters.name')
        ->where('purchase_order.po_code', $po_code)
        ->first();
        // info(
          // $info = DB::getQueryLog();
          // info($info);
        
        if ($po_info) {
            $po_no = $po_info->po_no;
            $po_date = $po_info->po_date;
            $supplier_name=$po_info->name;
            $supplier_no=$po_info->supplier_no;
            // Items get from po_item table
            $po_items = DB::table('purchase_order_item')
                ->join('item_masters', 'purchase_order_item.item_no', '=', 'item_masters.id')
                ->select('purchase_order_item.*', 'item_masters.item_name')
                ->where('po_no', $po_no)
                ->get();
            
            return response()->json([
                'po_no' => $po_no,
                'po_date' => $po_date, // Include po_date in the response
                'po_items' => $po_items,
                'supplier_name'=>$supplier_name,
                'supplier_no'=> $supplier_no

                

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
    $data = EmployeeMaster::where('firstname','LIKE',$firstname.'%')->get();
 
    return $data;
}
  // autocomplete data for project master form clientnaster( company name)
  public function  getclientdata(){
      
    $company_name = $_GET['company_name'];
    $data = ClientMaster::where('company_name','LIKE',$company_name.'%')->get();
 
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
// sitemaster location for  material issue (location)
public function  getsitelocationdata(){

  $site_name = $_GET['site_name'];

  $data = SiteMaster::where('site_location','LIKE',$site_name.'%')->get();
  //info($data);

  return $data;
}
}
