@extends('layouts.app',[
    'activeName' => 'purchase'
])
@section('title', 'Purchase Order')

@section('content_header')
@stop

@section('content')
<div class="row">
                <div class="container-fluid">
                    <div class="card shadow">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h4 class="font-weight-bold text-dark py">PURCHASE RETURN</h4>
                                <div style="width:120px">
                                    <button type="button" class="btn btn-block btn-primary" onclick="handleDialog()">Add</button>
                                </div>
                            </div>
                        </div>
                            <div class="card">
                            <div class="card-body">
                                <table id="myTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="text-center">
                                            <!-- <th>S.NO</th> -->
                                            <th>GRN Code</th>
                                            <th>Project Name</th>
                                            <th>Supplier Name</th>
                                            <th>Purchase Type</th>
                                            <th data-orderable="false" class="action notexport" >Show</th>
                                            <th data-orderable="false" class="action notexport">Edit</th>
                                            <th data-orderable="false" class="action notexport">Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       
                                </table>
                            </div>
                        </div>
                    </div>
                    <dialog id="myDialog"  style="width:1000px;">
            <div class="row">

                <div class="col-md-12">

                     <a class="btn  btn-sm" onclick="handleClose()" style="float:right;padding: 10px 10px;"><i class="fas fa-close"></i></a>
                     <h4  id='heading_name' style='color:white' align="center"><b>Update Goods Receiving Note </b></h4>
                    </div>
            </div>



            <form  class="form-row"  enctype="multipart/form-data" style="display:block" id="form" onsubmit="handleSubmit()">
                <input type="hidden" id="method" value="ADD"/>
                <input type="hidden" id="grn_no" name="grn_no" value=""/><br>

{!! csrf_field() !!}
<div class="row g-3">
<div class="form-group col-md-4">
         <label for="name" class="form-label fw-bold">Supplier Name<a style="text-decoration: none;color:red">*</a></label>
        <input type="text" id="name" name="name" readonly value="{{ old('name') }}" placeholder="Supplier Name" class="form-control" autocomplete="off">
        <input type="text" id="supplier_no" hidden name="supplier_no"  value="{{ old('supplier_no') }}"  class="form-control" autocomplete="off">
        <p style="color: red" id="error_name"></p>
    </div>
    <div class="form-group col-md-4" >
        <label for="code" class="form-label fw-bold">Supplier Code</label>
        <input type="code" id="code" name="code"  value="{{ old('code') }}" placeholder="Supplier Code" class="form-control" autocomplete="off" >
    </div>
    <div class="form-group col-md-4">
        <label for="currency" class="form-label fw-bold">Currency</label>
        {{-- <input type="text" id="currency" name="currency" value="{{ old('currency') }}" placeholder="Currency" class="form-control" autocomplete="off"> --}}
        <select id="currency" name="currency" class="form-control" autocomplete="off">
            {{-- <option value="">Select Option</option> --}}
            @foreach ($currency as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
        <p style="color: red" id="error_currency"></p>
    </div>
 
    <div class="form-group col-md-4">
    <label for="invoice_no" class="form-label fw-bold">Invoice No<a style="text-decoration: none;color:red">*</a></label>
        <input type="text" id="invoice_no" name="invoice_no"  value="{{ old('invoice_no') }}" placeholder="Invoice No" class="form-control" autocomplete="off">
        <input type="text" id="invoice_no" name="invoice_no"  hidden value="{{ old('invoice_no') }}"  class="form-control" autocomplete="off">
        <p style="color: red" id="error_invoice_no"></p>
 
    </div>
    <div class="form-group col-md-4">
        <label for="pr_purchase_type" class="form-label fw-bold">Purchase type<a style="text-decoration: none;color:red">*</a></label>
        <select id="pr_purchase_type" name="pr_purchase_type" class="form-control" autocomplete="off">
                                    <option value="">Select Option</option>
                                    @foreach($purchase_type as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                <p style="color: red" id="error_pr_purchase_type"></p>
        
    </div>

    <div class="form-group col-md-4">
        <label for="project_code" class="form-label fw-bold">Project Code<a style="text-decoration: none;color:red">*</a></label>
        <input type="text" id="project_code" name="project_code" value="{{ old('project_code') }}" readonly placeholder="Project Code" class="form-control" autocomplete="off">
        
    </div>
  
   
    
    <div class="form-group col-md-4" >
        <label for="due_Date" class="form-label fw-bold">Due date</label>
        <input type="date" id="due_Date" name="due_Date"  value="{{ old('due_Date') }}" placeholder="REF LPO date" class="form-control" autocomplete="off" >
        
    </div>    
    <div class="form-group col-md-4">
        <label for="grn_code" id="grn_code_lable"class="form-label fw-bold">GRN Invoice #</label>
        <input type="text" id="grn_code" name="grn_code"  value="{{ old('grn_code ') }}" readonly placeholder="GRN Invoice #" class="form-control" autocomplete="off">       
    </div>
  
   
</div>
    <div class="container pt-4">
        <div class="table-responsive">
        <table class="table table-bordered" id="register">
            <thead>
            <tr>
                <th>S.No</th>               
                <th>Item Name</th>
                <th hidden>item_id</th>
                <th>Pack Specification</th>
                <th>Quantity</th>
                <th>Pending Qty</th>
                <th>Receiving Qty</th>
                <th>Rate per Qty</th>
                <th>Total</th>
                <th hidden>Delete</th>
            </tr>
            </thead>
            <tbody id="tbody1">
</tbody>
    </table>
        </div>
        <!-- <div style="margin-top:8px">
        <button class="btn btn-md btn-primary"
        id="addBtn" type="button">
            Add Row
        </button>
 </div> -->
    </div>
    <div class="row" style="margin-top:8px">
    <div class="form-group col-md-2">
        <label for="invoice_amount" class="form-label fw-bold">Invoice Amt</label>
        <input type="text" id="invoice_amount" name="invoice_amount" value="{{ old('invoice_amount')}}" placeholder="Invoice Amt" class="form-control" autocomplete="off">      
    </div>
    <div class="form-group col-md-2">
        <label for="misc_expenses" class="form-label fw-bold">Misc Expenses</label>
        <input type="text" id="misc_expenses" name="misc_expenses" value="{{ old('misc_expenses')}}" placeholder="Misc Expenses" class="form-control" autocomplete="off">      
    </div>
    <div class="form-group col-md-2">
        <label for="discount" class="form-label fw-bold">Discount</label>
        <input type="text" id="discount_amount" name="discount_amount" value="{{ old('discount_amount')}}" placeholder="Discount" class="form-control" autocomplete="off">      
    </div>
    <div class="form-group col-md-2">
        <label for="freight" class="form-label fw-bold">Freight</label>
        <input type="text" id="freight" name="freight" value="{{ old('freight')}}" placeholder="Freight" class="form-control" autocomplete="off">      
    </div>
    <div class="form-group col-md-3">
        <label for="vat" class="form-label fw-bold">VAT</label>
        <div class="input-group">
            <input type="text" id="vat" name="vat" value="{{ old('vat')}}"  placeholder="VAT" class="form-control" autocomplete="off">      
        <div class="toggle focus">   
              
            <input type="checkbox" class="st" name="vat_type" id="vat_type" value="1" {{ old('vat_type') ? 'checked' : '' }}>
                <span class="slider focus"></span>
                <span class="label">₹</span>  </div>
    </div>  
    </div>
 </div>
    <div class="row" style="margin-top:8px">
    <div class="col-md-2">
        <label for="">Remarks</label>
    </div>
    <div class="col-md-4">
        <textarea name="remarks" id="remarks" cols="30" rows="5" class="form-control"></textarea>
    </div>
    <div class="col-md-2">
    <label for="" id="total" class="float-end mt-2">Item Amount </label><br>
    <label for="" class="float-end mt-3"> Discount Amount</label><br>
        <label for="" class="float-end mt-2">Total Amount</label><br>
        
        <label for="" class="float-end my-3">VAT Amount</label>
        <label for="" class="float-end my-3">Grand Total</label>
    </div>
    <div class="col-md-4">
        <input type="text" name="total_item_amount"  id="total_item_amount" readonly class="form-control mb-2">
        <input type="text" name="discount" id="discount" readonly class="form-control mb-2">
        <input type="text" name="total_amount" id="total_amount"readonly class="form-control mb-2">
        <input type="text" name="vat" id="vat1" readonly class="form-control mb-2">
        <input type="text" name="gross_amount" id="gross_amount"readonly class="form-control mb-2">
    </div>
    
    <div class="col-md-2">
        <label for="">Attachments</label>
    </div>
    <div class="col-md-4">
        <input type="file" name="attachments" class="form-control">
        <span id="filename"></span>
    </div>
    <div class="col-md-2">
    <button type="button" id="deleteButton" class="btn btn-danger">Delete</button>
</div>
<input type="hidden" name="delete_attachment" id="deleteAttachmentInput" value="0">
</div>
    <div class="row mt-3">
        <div class="form-group col-md-12">
            <center><button id="submit" class="btn btn-primary mx-3 mt-3">Save</button>
                {{-- <button type="submit"  class="btn btn-primary mx-3">Print</button>
                <button type="submit" class="btn btn-primary mx-3">Clear</button> --}}
            </center>
        </div>
    </div>
</form>
<!-- SHOW DIALOG -->
<div class="card" id="show" style="display:none">
    <div class="card-body" style="background-color:white;width:100%;height:20%;" >

                          <div class="row">
                          <div class="col-md-3">
                            <label>GRN Code</label>
                            <p id="show_grn_code"></p>  
                        </div>         
                        <div class="col-md-3">
                            <label>Supplier Name</label>
                            <p id="show_name"></p> 
                        </div>                                              
                          <div class="col-md-3">
                            <label>Project Name</label>
                            <p id="show_project_name"></p>
                        </div>
                        <div class="col-md-3">
                            <label>GRN Invoice/Receive date</label>
                            <p id="show_grn_date"></p>
                        </div>
                        </div>
                        <div class="row">
                          <div class="col-md-3">
                            <label>Project Code</label>
                            <p id="show_project_code"></p>
                        </div>
                        <div class="col-md-3">
                            <label>Purchase Type</label>
                            <p id="show_grn_purchase_type"></p>
                        </div>                   
                          <div class="col-md-3">
                            <label>REF LPO</label>
                            <p id="show_po_code"></p>
                        </div>
                          <div class="col-md-3">
                            <label>REF LPO date</label>
                            <p id="show_po_date"></p>
                        </div>
                        </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label>Due date</label>
                            <p id="show_due_Date"></p>
                        </div>                
                          <div class="col-md-3">
                            <label>Invoice Amount</label>
                            <p id="show_invoice_amount"></p>
                        </div>
                          <div class="col-md-3">
                            <label>Misc Expenses</label>
                            <p id="show_misc_expenses"></p>
                        </div>
                        <div class="col-md-3">
                            <label>Discount</label>
                            <p id="show_discount_amount"></p>
                        </div>
                </div>
                <div class="row">
                        <div class="col-md-3">
                            <label>Freight</label>
                            <p id="show_freight"></p>
                        </div>                
                       
                          <div class="col-md-3">
                            <label>VAT</label>
                            <p id="show_vat"></p>
                        </div>
                        <div class="col-md-3">
                            <label>Total Amount</label>
                            <p id="show_total_amount"></p>
                        </div>
                        <div class="col-md-3">
                            <label>Grand Total</label>
                            <p id="show_gross_amount"></p>
                        </div>
                </div>
                <div class="row">
                                        
                          <div class="col-md-3">
                            <label>Attachments</label>
                            <p id="show_filename"></p>
                        </div>
                          <div class="col-md-3">
                            <label>Remarks</label>
                            <p id="show_remarks"></p>
                        </div>
                </div>
                <div id="item_details_show"></div>
                                       
    </div>
</div>
          </dialog>

@stop