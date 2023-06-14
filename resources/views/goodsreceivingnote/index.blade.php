<!-- STYLE INCLUDED IN LAYOUT PAGE -->
@extends('layouts.app',[
    'activeName' => 'GOODS RECEIVING NOTES'
])
@section('title', 'GOODS RECEIVING NOTES')

@section('content_header')
@stop

@section('content')
<style>
    .toggle {
  display: flex; /* Use flexbox to align the checkbox and slider */
  align-items: center; /* Align vertically centered */
}</style>
<!-- DATA table -->
     <div class="row">
                <div class="container-fluid">
                    <div class="card shadow">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h4 class="font-weight-bold text-dark py">GOODS RECEIVING NOTES</h4>
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
                                            <th>GRN Date</th>
                                            <th>Project Name</th>
                                            <th>Discount</th>
                                            <th>Vat</th>
                                            <th>Purchase Amount</th>
                                            <!-- <th>Supplier Name</th> -->
                                            <th>Purchase Type</th>
                                            <th data-orderable="false" class="action notexport" >Show</th>
                                            <th data-orderable="false" class="action notexport">Edit</th>
                                            <th data-orderable="false" class="action notexport">Delete</th>
                                            <div id="blur-background" class="blur-background"></div>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($grns as $key => $grn)
                                            <tr class="text-center">
                                                <!-- <td>{{$key+=1}}</td> -->
                                                <td>{{$grn->grn_code}}</td>
                                                <td>{{date('d-m-Y',  strtotime($grn->grn_date))}}</td>                                               
                                                <td>{{$grn->project_name}}</td>   
                                                <td>{{$grn->discount_amount}}</td>  
                                                <td>{{$grn->vat}}</td>    
                                                <td>{{$grn->gross_amount}}</td>                                                                                    
                                                <!-- <td>{{$grn->name}}</td>   -->
                                                <td>{{$grn->grn_purchase_type}}</td>                                                                                           
                                                <td>
                                                    <a  onclick="handleShowAndEdit('{{$grn->grn_no}}','{{$grn->po_no}}','show')"
                                                        class="btn btn-primary btn-circle btn-sm"   >
                                                        <i class="fas fa-flag"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a onclick="handleShowAndEdit('{{$grn->grn_no}}','{{$grn->po_no}}','edit')"
                                                        class="btn btn-info btn-circle btn-sm mx-2" >
                                                        <i class="fas fa-check"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <button  type="submit" class="btn btn-sm btn-danger" onclick="handleDelete('{{$grn->grn_no}}')">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- ADD AND EDIT FORM -->
                    <dialog id="myDialog">
            <div class="row">

                <div class="col-md-12">

                     <a class="btn  btn-sm" onclick="handleClose()" style="float:right;padding: 10px 10px;"><i class="fas fa-close"></i></a>
                     <h4  id='heading_name' style='color:white' align="center"><b>Update Goods Receiving Note Details</b></h4>
                    </div>
            </div>



            <form  class="form-row"  enctype="multipart/form-data" style="display:block" id="form" onsubmit="handleSubmit()">
                <input type="hidden" id="method" value="ADD"/>
                <input type="hidden" id="grn_no" name="grn_no" value=""/><br>

{!! csrf_field() !!}
<div class="row g-3">
    <div class="form-group col-md-4">
    <label for="po_no" class="form-label fw-bold">REF LPO<a style="text-decoration: none;color:red">*</a></label>
        <input type="text" id="po_code" name="po_code" value="{{ old('po_code') }}"  placeholder="REF LPO"class="form-control" autocomplete="off">
        <input type="text"  hidden id="po_no" name="po_no" value="{{ old('po_no') }}" class="form-control" autocomplete="off">
        <p style="color: red" id="error_po_no"></p>
     
    </div>  
    <div class="form-group col-md-4" >
        <label for="po_date" class="form-label fw-bold">REF LPO Date</label>
        <input type="date" id="po_date" name="po_date" readonly  value="{{ old('po_date') }}" placeholder="REF LPO date" class="form-control" autocomplete="off" >
    </div>
    <div class="form-group col-md-4" >
        <label for="grn_date" class="form-label fw-bold">GRN Invoice / Receive date<a style="text-decoration: none;color:red">*</a></label>
        <input type="date" id="grn_date" name="grn_date"  value="{{ old('grn_date') }}" placeholder="GRN Invoice / Receive date" class="form-control" autocomplete="off" >
        <p style="color: red" id="error_grn_date"></p>
    </div>
    <div class="form-group col-md-4">
         <label for="name" class="form-label fw-bold">Supplier Name</label>
        <input type="text" id="name" name="name" readonly value="{{ old('name') }}" placeholder="Supplier Name" class="form-control" autocomplete="off">
        <input type="text" id="supplier_no" hidden name="supplier_no"  value="{{ old('supplier_no') }}"  class="form-control" autocomplete="off">
        
    </div>
    <div class="form-group col-md-4">
    <label for="project_name" class="form-label fw-bold">Project Name<a style="text-decoration: none;color:red">*</a></label>
        <input type="text" id="project_name" name="project_name"  value="{{ old('project_name') }}" placeholder="Project Name" class="form-control" autocomplete="off">
        <input type="text" id="project_no" name="project_no"  hidden value="{{ old('project_no') }}"  class="form-control" autocomplete="off">
        <p style="color: red" id="error_project_name"></p>
 
    </div>

    <div class="form-group col-md-4">
        <label for="project_code" class="form-label fw-bold">Project Code</label>
        <input type="text" id="project_code" name="project_code" value="{{ old('project_code') }}" readonly placeholder="Project Code" class="form-control" autocomplete="off">
        
    </div>
  
   
    <div class="form-group col-md-4">
        <label for="grn_purchase_type" class="form-label fw-bold">Purchase type<a style="text-decoration: none;color:red">*</a></label>
        <select id="grn_purchase_type" name="grn_purchase_type" class="form-control form-select" autocomplete="off">
                                    <option value="">Select Option</option>
                                    @foreach($purchase_type as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                <p style="color: red" id="error_grn_purchase_type"></p>
        
    </div>
    <div class="form-group col-md-4" >
        <label for="due_Date" class="form-label fw-bold">Due date</label>
        <input type="date" id="due_Date" name="due_Date"  value="{{ old('due_Date') }}" placeholder="REF LPO date" class="form-control" autocomplete="off" >
        
    </div>  
    <div class="form-group col-md-4">
        <label for="grn_invoice_no" class="form-label fw-bold">GRN Invoice No<a style="text-decoration: none;color:red">*</a></label>
        <input type="text" id="grn_invoice_no" name="grn_invoice_no"  value="{{ old('grn_invoice_no') }}"  placeholder="GRN Invoice No" class="form-control" autocomplete="off">       
    </div>  
    <div class="form-group col-md-4">
        <label for="grn_code" id="grn_code_lable"class="form-label fw-bold">GRN Code</label>
        <input type="text" id="grn_code" name="grn_code"  value="{{ old('grn_code ') }}" readonly placeholder="GRN Invoice #" class="form-control" autocomplete="off">       
    </div>
  
   
</div>
    <div class="container pt-4">
        <div class="table-responsive">
        <table class="table table-bordered" id="register">
            <thead>
            <tr>
                <th style="width:1%">S.No</th>               
                <th style="width:5%">Item Name</th>
                <th hidden>item_id</th>
                <th style="width:4%">Pack Spec.</th>
                <th style="width:1%">Qty</th>
                <th style="width:1%">Pending Qty</th>
                <th style="width:1%">Rec.Qty</th>
                <th style="width:1%">Rate per Qty</th>
                <th style="width:2%">Total</th>
                <th style="width:0.5%">Delete</th>
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
    <!-- <div class="form-group col-md-2">
        <label for="discount" class="form-label fw-bold">Discount</label>
        <input type="text" id="discount_amount" name="discount_amount" value="{{ old('discount_amount')}}" placeholder="Discount" class="form-control" autocomplete="off">      
    </div> -->
    <div class="form-group col-md-2">
        <label for="freight" class="form-label fw-bold">Freight</label>
        <input type="text" id="freight" name="freight" value="{{ old('freight')}}" placeholder="Freight" class="form-control" autocomplete="off">      
    </div>
    <div class="form-group col-md-3">
  <label for="discount" class="form-label fw-bold">Discount</label>
  <div class="input-group">
    <input type="text" id="discount_amount" name="discount_amount" value="{{ old('discount_amount')}}" placeholder="Discount" class="form-control" autocomplete="off">
    <div class="toggle focus" style="margin-top:6% !important;"> <!-- Add margin to create space between the input and the toggle button -->
      <input type="checkbox" class="st" name="dis_type" id="dis_type" value="1" {{ old('dis_type') ? 'checked' : '' }}>
      <span class="slider focus"></span>
      <span class="label">AED</span>
    </div>
  </div>
</div>

    <div class="form-group col-md-2 offset-md-1">
    <label class="form-label fw-bold">VAT</label>
    <div class="input-group">
        <div class="form-check form-check-inline">
            <input type="radio" id="vat-included" name="vat" value="0" class="form-check-input"{{ old('vat') == 'included' ? ' checked' : '' }}>
            <label for="vat-included" class="form-check-label">0%</label>
        </div>
        <div class="form-check form-check-inline">
            <input type="radio" id="vat-excluded" name="vat" value="5" class="form-check-input"{{ old('vat') == 'excluded' ? ' checked' : '' }}>
            <label for="vat-excluded" class="form-check-label">5%</label>
        </div>
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
        <input type="text" name="vat_amount" id="vat_amount" readonly class="form-control mb-2">
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
                            <label>Purchase Amount</label>
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
     
       <!--script starts  -->
<script> 
   $(document).ready(function(){
    $(this).parent().toggleClass('on');
        $('.toggle input[type="checkbox"]').click(function(){
            $(this).parent().toggleClass('on');      

            if ($(this).parent().hasClass('on')) {
                console.log('on');
                var miscExpenses = parseFloat($('input[name="misc_expenses"]').val() || 0);        
            var freight = parseFloat($('input[name="freight"]').val() || 0);
            var totalAmount =  parseFloat($('#total_item_amount').val()) || 0;
               $('#dis_type').val('1');
               var disPercentage = parseFloat($('input[name="discount_amount"]').val() || 0);
            //    discount cALCULATION
                dis = (disPercentage / 100) * totalAmount;
                $('#discount').val(dis.toFixed(2));
                // ITEM TOTAL CAL
                var total_amount =totalAmount-dis;
                var total_ex_f= total_amount+miscExpenses+freight;
                $('#total_amount').val(total_ex_f.toFixed(2));
                // VAT CALCULATION
                var selectedValue = $('input[name="vat"]:checked').val() || 0;
                var total_vat =((selectedValue/100)*total) || 0;
                $('#vat_amount').val(total_vat.toFixed(2));
                // GROSS AMT
               var gross_amount =parseFloat(total_ex_f)+parseFloat(total_vat);
               $('#gross_amount').val(gross_amount.toFixed(2));

                $(this).parent().children('.label').text('%')

            } else {
                console.log('off');
           var miscExpenses = parseFloat($('input[name="misc_expenses"]').val() || 0);        
            var freight = parseFloat($('input[name="freight"]').val() || 0);
            var totalAmount =  parseFloat($('#total_item_amount').val()) || 0;
                $('#dis_type').val('0');
               var disPercentage = parseFloat($('input[name="discount_amount"]').val() || 0);
               $('#discount').val(disPercentage.toFixed(2));
               var total_amount =totalAmount-disPercentage;

                var total_ex_f= total_amount+miscExpenses+freight;
                $('#total_amount').val(total_ex_f.toFixed(2));
                // VAT CALCULATION
                var selectedValue = $('input[name="vat"]:checked').val() || 0;
                var total_vat =((selectedValue/100)*total) || 0;
                $('#vat_amount').val(total_vat.toFixed(2));
                // GROSS AMT
               var gross_amount =parseFloat(total_ex_f)+parseFloat(total_vat);
               $('#gross_amount').val(gross_amount.toFixed(2));
                $(this).parent().children('.label').text('AED')
            }
        });           
    });  
    // delete attachment
        document.getElementById("deleteButton").addEventListener("click", function() {
            if (confirm("Are you sure you want to delete this attachment?"))
            {
            document.getElementById("deleteAttachmentInput").value = "1";
        document.querySelector("input[name='attachments']").value = "";
        document.getElementById("filename").textContent = "";
            }
        });

        // jQuery button click event to add a row
        $('#addBtn').on('click', function () {               
           var row=rowIdx-1;
                        if ($('#item_name_'+row).val() == '') {
                    alert("Please enter item name.");
                } else if (!/^[a-zA-Z]+$/.test($('#item_name_'+row).val())) {
                    alert("Item name should only contain alphabets.");
                } else if ($('#receiving_qty_'+row).val() == '') {
                    alert("Please enter receiving quantity.");
                } else if (!/^\d+(\.\d+)?$/.test($('#receiving_qty_'+row).val())) {
                    alert("Receiving quantity should only contain numbers.");
                } else if ($('#rate_per_qty_'+row).val() == '') {
                    alert("Please enter rate per quantity.");
                } else if (!/^\d+(\.\d+)?$/.test($('#rate_per_qty_'+row).val())) {
                    alert("Rate per quantity should only contain numbers.");
                } else{            

           add_text();
                 }                               
                 
            });
            // delete row in dynamically created table
            $('#tbody1').on('click', '.remove', function() {
                                 // Getting all the rows next to the row containing the clicked button
                                 var child = $(this).closest('tr').nextAll();

                                 // Iterating across all the rows obtained to change the index
                                 child.each(function() {
                                     // Getting <tr> id.
                                     var id = $(this).attr('id');

                                     // Getting the <p> inside the .row-index class.
                                     var idx = $(this).children('.row-index').children('p');

                                     // Gets the row number from <tr> id.
                                     var dig = parseInt(id.substring(1));

                                     // Modifying row index.
                                     idx.html(`<input type='text'>`);

                                     // Modifying row id.
                                     $(this).attr('id', `R${dig - 1}`);
                                 });

                                 // Removing the current row.
                                 $(this).closest('tr').remove();

                                 // Decreasing total number of rows by 1.
                                 rowIdx--;
                             });
   


            // table textbox multiple receiving_qty and rate_per_qty
            $('#tbody1').on('input', 'input[id^="receiving_qty"], input[id^="rate_per_qty_"]', function() {
                var row = $(this).closest('tr');
                var quantity = parseFloat(row.find('input[id^="receiving_qty"]').val()) || 0;
                var rate = parseFloat(row.find('input[id^="rate_per_qty_"]').val()) || 0;
                var itemAmount = quantity * rate;
                row.find('input[id^="item_amount_"]').val(itemAmount);
                calculateTotal();
                updateGrossAmount();
            });//end

    // calculation for total amount
    $(' input[name="misc_expenses"],  input[name="freight"],input[name="discount_amount"],input[name="vat"], input[name="purchase"],#total_item_amount').on('input', function() {
        var miscExpenses = parseFloat($('input[name="misc_expenses"]').val() || 0);        
        var freight = parseFloat($('input[name="freight"]').val() || 0);
        calculateTotal();
        var totalAmount =  parseFloat($('#total_item_amount').val()) || 0;
         var dis = 0;
    if ($('.toggle input[type="checkbox"]').parent().hasClass('on')) {
        // VAT input is set to percentagediscount_amount
        var disPercentage = parseFloat($('input[name="discount_amount"]').val() || 0);
        dis = (disPercentage / 100) * totalAmount;

    } else {
        // VAT input is set to rupee amount
        dis = parseFloat($('input[name="discount_amount"]').val() || 0);
    }
    $('#discount').val(dis.toFixed(2));
    var total_1 = totalAmount-dis;
    var total = total_1+miscExpenses+freight;
    $('#total_amount').val(total.toFixed(2));
    console.log(total);
    var selectedValue = $('input[name="vat"]:checked').val() || 0;
        var total_vat =(selectedValue/100)*total ;
    $('#vat_amount').val(total_vat.toFixed(2));
     var gross_amount =total+total_vat;
         $('#gross_amount').val(gross_amount.toFixed(2));
    });

// Calculate and display the total item amount
        function calculateTotal() {
        var total = 0;
        $("input[name='item_amount[]']").each(function() {
            var val = parseFloat($(this).val());
            if (!isNaN(val)) {
            total += val;
            }
        });
        $("#total_item_amount").val(total.toFixed(2));
        }

// after calculation if they add new row
    function updateGrossAmount() {
    var miscExpenses = parseFloat($('input[name="misc_expenses"]').val() || 0);        
    var freight = parseFloat($('input[name="freight"]').val() || 0);
    var total =parseFloat($('#total_item_amount').val()) || 0;
    var dis = 0;
    if ($('.toggle input[type="checkbox"]').parent().hasClass('on')) {
        // VAT input is set to percentage
        var disPercentage = parseFloat($('input[name="discount_amount"]').val() || 0);
        dis = (disPercentage / 100) * total;
    } else {
        // VAT input is set to rupee amount
        dis = parseFloat($('input[name="discount_amount"]').val() || 0);
    }

    $('#discount').val(dis.toFixed(2));
    var total1=total-dis;
    var totalAmount=total1+miscExpenses+freight;
    $('#total_amount').val(totalAmount.toFixed(2));
    var selectedValue = $('input[name="vat"]:checked').val() || 0;
    var total_vat =(selectedValue/100)*totalAmount;
    $('#vat_amount').val(total_vat.toFixed(2));   
    var gross_amount =totalAmount+total_vat;
    $('#gross_amount').val(gross_amount.toFixed(2));    
       
    }              
    
    // dynamic table creation
var rowIdx =1;
function add_text()
{    var html = '';
		html +='<tr id="row'+rowIdx+'" class="rowtr">';
        html += '<td>'+rowIdx+'</td>';
		html += '<td><div class="col-xs-12"><input type="text" id="item_name_'
        +rowIdx+'"  name="item_name[]" class="item_name form-control" placeholder="Start Typing Item name..."></div></td>';
        html += '<td hidden ><div class="col-xs-12"><input type="text"  id="item_no_'+rowIdx+'"  name="item_no[]" class="item_no_'+rowIdx+'"></div></td>';
        html += '<td><div class="col-xs-12"><input type="text" id="pack_specification_'+rowIdx+'"  name="pack_specification[]" class="pack_specification form-control"></div></td>';
        html += '<td><center><div class="col-xs-12" name="quantity[]" id="quantity1_'+ rowIdx + '" ></div></center>';
        html += '<div class="col-xs-12"><input hidden type="text" id="quantity_'+rowIdx+'" name="quantity[]" class="quantity"></td>';
        html += '<td><center><div class="col-xs-12 pending_qty1"name="pending_qty[]" id="pending_qty1_'+ rowIdx + '" ></div></center>';
        html += '<div class="col-xs-12"><input type="text" hidden id="pending_qty_'+rowIdx+'" name="pending_qty[]" class="pending_qty"></td>';
        html += '<td><div class="col-xs-12"><input type="text" id="receiving_qty_'+rowIdx+'" name="receiving_qty[]" class="receiving_qty form-control"></div></td>';
        html += '<td><div class="col-xs-12"><input type="text" id="rate_per_qty_'+rowIdx+'"  name="rate_per_qty[]"class="rate_per_qty form-control"></div></td>';       
        html += '<td><center><div class="col-xs-12"><center><input type="text"  id="item_amount_'+rowIdx+'"name="item_amount[]" class="item_amount form-control"></div></center></td>';
        html +=
            '<td><button class="btn btn-danger remove btn-sm" id="delete" type="button"><i class="fa fa-trash"></i></button></td>';
        html += '</tr>';
        $("#tbody1").append(html);        
        rowIdx++;     
 }
// auto complete function for item name and item no
jQuery($ => {

$(document).on('focus click', $("#tbody1"), function() {
        
    $('#tbody1').find('.item_name').autocomplete({
            source: function( request, response )
        {
            $.ajax
            ({
                type:"GET",
                url: "{{ route('getitemnamedata') }}",
                dataType: "json",
                data:
                {
                    'itemname':request.term
                },
                success: function( data )
                {
                    result = [];
                    for(var i in data)
                    {
                        result.push(data[i]["item_name"]);
                    }
                    response(result);
                },fail: function(xhr, textStatus, errorThrown)
                {
                    alert(errorThrown);
                }
            });
        },
        minLength: 1
    });

    });
    
});
    $(document).on('change', '.item_name', function() 
    {     
    var id=rowIdx-1;
        $.ajax
        ({
            type:"GET",
            url: "{{ route('getitemnamedata') }}",
            dataType: "json",
            data:
            {
                'itemname':$(this).val()
            },
            success: function( data )
            { 
                result = [];
                for(var i in data)
                {                    
                    $('#item_no_'+id).val(data[0]["id"]);
                    
                }
            },fail: function(xhr, textStatus, errorThrown){
            alert(errorThrown);
            }
        });
    });
        
    // project name auto complete
    jQuery($ => {
  $(document).on('focus', 'input',  "#project_name", function() {
    $("#project_name").autocomplete({
      source: function(request, response) {
        $.ajax({
          type: "GET",
          url: "{{ route('getlocdata') }}",
          dataType: "json",
          data: {
            'projectname': $("#project_name").val()
          },
          success: function(data) {
            result = [];
            for (var i in data) {
              result.push(data[i]["project_name"]);
            }
            response(result);
          },
          fail: function(xhr, textStatus, errorThrown) {
            alert(errorThrown);
          }
        });
      },
      select: function(event, ui) {
        var selectedproName = ui.item.value;
        updateProjectNameValue(selectedproName);
      }
    });
  });

  $(document).on('input', '#project_name', function() {
    updateProjectNameValue($(this).val());
  });

  function updateProjectNameValue(proName) {
    $.ajax({
      type: "GET",
      url: "{{ route('getlocdata') }}",
      dataType: "json",
      data: {
        'projectname': proName
      },
      success: function(data) {
        for (var i in data) {
          $('#project_no').val(data[i]["project_no"]);
          $('#project_code').val(data[i]['project_code']);
        }
      },
      fail: function(xhr, textStatus, errorThrown) {
        alert(errorThrown);
      }
    });
  }
});

// table create with data for ref lpo number
$(document).on('input', '#po_code',function()
    {   
        $('.rowtr').remove();   
       
        $.ajax
        ({
        type:"GET",
        url: "{{ route('get_po_details') }}",
        dataType: "json",
        data:
        {
            'po_code':$('#po_code').val()
        },
        success: function( data )
        {   
            console.log(data);
            $('#po_no').val(data.po_no);
            $('#po_date').val(data.po_date.split(' ')[0]);
            $('#name').val(data.supplier_name);
            $('#supplier_no').val(data.supplier_no);
            $('#grn_purchase_type').val(data.purchase_type);
            console.log(data.purchase_type);
            var create_id=1;   
            for (const item of data.po_items) { 
            add_text();
            $('#item_name_' + create_id).val(item.item_name);
            $('#item_no_' + create_id).val(item.item_no);              
            $('#quantity1_'+ create_id).text(item.qty); 
            $('#quantity_'+ create_id).val(item.qty); 
                                 
            $('#pending_qty1_'+ create_id).text(item.pending_qty); 
            $('#pending_qty_'+ create_id).val(item.pending_qty); 
         
            $('#item_name_' + create_id).val(item.item_name);   
            $('#rate_per_qty_'+ create_id).val(item.rate_per_qty);              
            create_id++;
            }  
            rowIdx=1;      

    },fail: function(xhr, textStatus, errorThrown){
    alert(errorThrown);
    }
});
    });

    // dialog open
    function handleDialog(){
             document.getElementById("myDialog").open = true;
             window.scrollTo(0, 0);
            //  add_text();
            $('#vat-included').prop('checked', true);
             $('#method').val("ADD");
             $('#submit').text("Save");
             $('#heading_name').text("Add Goods Receiving Note Details").css('font-weight', 'bold');
              $('#grn_code').hide();
             $('#grn_code_lable').hide();
             $('#show').css('display','none');
             $('#form').css('display','block');
             $('#blur-background').css('display','block');

          }
// dialogclose
function handleClose(){
            document.getElementById("myDialog").open = false;
                // Clear the form fields
                $('#form')[0].reset();
                // $('#dis_type').prop('checked', true).trigger('click');
                $("#tbody1").empty();
                // show_table
                $("#item_details_show").empty();
                rowIdx=1;
                $('.error-msg').removeClass('error-msg');
                $('.has-error').removeClass('has-error');
                // Hide any error messages
                $('error').html('');
                $('#blur-background').css('display','none');
                // window.location.reload();
          } 
        //   }



          // DELETE FUNCTION
    function handleDelete(id)
    {
        let url = '{{route('gdelete',":id")}}';
        url= url.replace(':id',id);
        if (confirm("Are you sure you want to delete this  Goods Receiving Note Details?"))
        {
            $.ajax
            ({
                url: url,
                type: 'GET',
                success: function (message)
                {
                    alert(message);
                    window.location.reload();
                },
            })
        }

    }
    // DIALOG SUBMIT FOR ADD AND EDIT     
    function handleSubmit() {
        event.preventDefault();
    var hasError = false;
    // check receiving qty
    $('.rowtr').each(function() {
        // Get the row index
        var rowIdx = $(this).attr('id').replace('row', '');

        // Get the receiving quantity value for the current row
        var receivingQty = parseFloat($('#receiving_qty_' + rowIdx).val());

        // Get the pending quantity value for the current row
        var pendingQty = parseFloat($('#pending_qty1_' + rowIdx).text());


if (isNaN(receivingQty) ) {
    alert('Please enter a valid Receiving quantity in row ' + rowIdx);
    hasError = true;
    return false; // Exit the loop
}
        // Check if receiving quantity is greater than pending quantity
        if (receivingQty > pendingQty) {
            // Display an error message or handle the condition as needed
            alert('Receiving quantity cannot be greater than pending quantity for row ' + rowIdx);
            hasError = true;
            return false; // Exit the loop
        }

    });
         if(!hasError) {
            var hiddenErrorElements = $('.error-msg:not(:hidden)').length;
            // alert(hiddenErrorElements);
            if(hiddenErrorElements === 0)
            {
            let form_data = new FormData(document.getElementById('form'));
            let method = $('#method').val();
            let url;
            let type;
            if (method == 'ADD') {
                url = '{{ route('grnApi.store') }}';
                type = 'POST';
            } else {
                let id = $('#grn_no').val();
                url = '{{ route('grnApi.update', ":id") }}';
                url = url.replace(':id', id);
                type = 'POST';
            }
            $.ajax({
                url: url,
                type: type,
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                success: function (message) {
                    alert(message);
                    window.location.reload();
                },
                error: function (message) {
                    var data = message.responseJSON;

                }
            });
        }
    }

}
//DATA SHOW FOR EDIT AND SHOW
function handleShowAndEdit(id,po_no,action)
    { 
        var totalAmount=0;
        let url = '{{ route('grnApi.show', [":grnid", ":po_no"]) }}';
        url = url.replace(':grnid', id);
        url = url.replace(':po_no', po_no);
        let type= "GET"
        $.ajax
        ({
            url: url,
            type: type,
            contentType: false,
            cache: false,
            processData: false,
            success: function (message)
            { console.log(message);
                 if(action == 'edit')
                {   
                    $('#show').css('display','none');
                    $('#form').css('display','block');
                    $('#blur-background').css('display','block');
                    $('#grn_code').show();
                     $('#grn_code_lable').show();
                     $('#heading_name').text("Update Goods Receiving Note Details").css('font-weight', 'bold');
                    for (const [key, value] of Object.entries(message.grn))
                    {
                        $(`#${key}`).val(value);
                    }                    
             if (message.grn.dis_type == '1') {          
                $('#dis_type').prop('checked', true).trigger('click');
             }

             if (message.grn.vat == '5') {
                  $('#vat-excluded').prop('checked', true);
            }else{
                $('#vat-included').prop('checked', true);
            }
                let fileName = message.grn.filename;
                $('#filename').text(fileName);
               var rowid=1;
               for (const item of message.grn_item) {
                add_text(); // add a new row to the table
                $('#item_name_' + rowid).val(item.item_name);
                $('#item_no_' + rowid).val(item.item_no);
                $('#pack_specification_'+ rowid).val(item.pack_specification);

                $('#quantity_'+ rowid).val(item.quantity);
                $('#quantity1_'+ rowid).text(item.quantity);
                $('#pending_qty1_'+ rowid).text(item.pending_qty); 
                $('#pending_qty_'+ rowid).val(item.pending_qty); 
                $('#receiving_qty_'+ rowid).val(item.receiving_qty);
                $('#rate_per_qty_'+ rowid).val(item.rate_per_qty);
                 $('#item_amount_'+ rowid).val(item.item_amount);
               totalAmount += parseFloat(item.item_amount);             
                rowid++;
            }
                     $('#total_item_amount').val(totalAmount);
                    $('#total_amount').val(message.grn.total_amount);
                     $('#discount').val(message.grn.discount);
                     $('#gross_amount').val(message.grn.gross_amount);
                     $('#vat_amount').val(message.grn.vat_amount);


                    $('#method').val('UPDATE');
                    $('#submit').text('UPDATE');
                }
                else
                {
                    for (let [key, value] of Object.entries(message.grn)) {
                        // date formate
                    
                      if (key === "grn_date" || key === "po_date" || key === "due_Date") {
                        if(value == ''){
                            value='';
                        }else{
                    var dateObj = new Date(value);
                    var day = dateObj.getDate();
                    var month = dateObj.getMonth() + 1;
                    var year = dateObj.getFullYear();
                    value= day + '-' + month + '-' + year
                        }
                    }
                    $(`#show_${key}`).text(value);

                    }                   
                    let script = '<table id="show_table" class="table table-striped"><thead><tr><th>Item Name</th><th>Pack Specification</th><th>Quantity</th><th>Pendind Quantity</th><th>Rate per Quantity</th><th>Total</th></tr></thead><tbody>';
                    for (const item of message.grn_item) {
                   script += '<tr>';
                   script += '<td>' + item.item_name + '</td>';
                   if(item.pack_specification == null){
                    item.pack_specification ='';}
                    
                   script += '<td>' + item.pack_specification + '</td>';
                   script += '<td>' + item.quantity+ '</td>';
                   script += '<td>' + item.pending_qty+ '</td>';
                   script += '<td>' + item.rate_per_qty + '</td>';
                   script += '<td>' + item.item_amount + '</td>';
                   script += '</tr>';
                }
               script+= '</tbody></table>';
               $('show_table').remove();
               $('#item_details_show').append(script); 
                    $('#heading_name').text("View Goods Receiving Note Details").css('font-weight', 'bold');
                    $('#show').css('display','block');
                    $('#form').css('display','none');
                    $('#blur-background').css('display','block');

                }
                document.getElementById("myDialog").open = true;
                window.scrollTo(0, 0);
            },
        })
    }   
    // Initialize form validation
    var item_name = @json($item_name);

$.validator.addMethod("ItemName", function(value, element)
{
    return item_name.includes(value.trim());
});
var project_name=@json($project_name);
$.validator.addMethod("projectNameCheck", function(value, element)
{
    return project_name.includes(value);
});
var purchase_order=@json($purchase_order);
$.validator.addMethod("pruchaseNameCheck", function(value, element)
{
    return purchase_order.includes(value);
});
$.validator.addMethod("alphanumeric_invoice", function(value, element) {
    return this.optional(element) || /^\d+(\.\d+)?$/i.test(value);
});

$.validator.addMethod("lessThanQty", function(value, element){
    console.log(value);
    var rowId = $(element).closest('.rowtr').attr('id');
    var Quantity = $('#' + rowId + ' .pending_qty1').text().trim();

    return parseFloat(value) <= parseFloat(Quantity);
    });

var formValidationConfig = {
rules:
{
grn_purchase_type: "required",

project_name:
{
    required:true,
    projectNameCheck:true
},
grn_date:
{
    required: true,
},
po_code:
{
    required: true
},
invoice_amount:
{
    alphanumeric_invoice:true
},
misc_expenses:
{
    alphanumeric_invoice:true
},
discount_amount:
{
    alphanumeric_invoice:true
},
freight:
{
    alphanumeric_invoice:true
},
vat:
{
    alphanumeric_invoice:true
},
grn_invoice_no:{
    required: true, 
},
"item_name[]":
{
    required: true,
    ItemName: true
},
"rate_per_qty[]":
{
    required: true,
    
},
"receiving_qty[]":
{
    required: true,
    digits: true,
    lessThanQty:true

},
},
messages:
{

grn_purchase_type: "Please select the purchase type ",

project_name:
{
    required:"Please enter the project Name",
    projectNameCheck:"Please enter valid project Name"
},
grn_date:
{
    required: "Please enter the grn date",
},
po_code:
{
    required:"Please enter the purchaseorder Number",
},
invoice_amount:
{
    alphanumeric_invoice: "Please enter only numbers"
},
misc_expenses:
{
    alphanumeric_invoice: "Please enter only numbers"
},
discount_amount:
{
    alphanumeric_invoice: "Please enter only numbers"
},
freight:
{
    alphanumeric_invoice:"Please enter only numbers"
},
vat:
{
    alphanumeric_invoice:"Please enter only numbers"
},
 "item_name[]":
{
    required: "Please enter the item name",
    ItemName: "Please enter a valid item name"
},
grn_invoice_no:{
    required: "Please enter the invoice number", 
},

"rate_per_qty[]":
{
    required: "Please enter the rate per quantity",
    
},
"receiving_qty[]":
{
    required: "Please enter the receiving quantity",
    digits: "Please enter an integer value",
    lessThanQty: "Receiving qty should be less than or equal to p.qty."

},
},
errorElement: "error",
errorClass: "error-msg",
highlight: function(element, errorClass, validClass)
{
    $(element).addClass(errorClass).removeClass(validClass);
    $(element).closest('.form-group').addClass('has-error');
},
unhighlight: function(element, errorClass, validClass)
{
    $(element).removeClass(errorClass).addClass(validClass);
    $(element).closest('.form-group').removeClass('has-error');
}
};

$("#form").validate(formValidationConfig);
    </script>        
@stop