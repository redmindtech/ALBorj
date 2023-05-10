 <!-- STYLE INCLUDED IN LAYOUT PAGE -->
 @extends('layouts.app',[
    'activeName' => 'purchase'
])
@section('title', 'Purchase Order')

@section('content_header')
@stop

@section('content')
<!-- DATA table -->
     <div class="row">
                <div class="container-fluid">
                    <div class="card shadow">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h4 class="font-weight-bold text-dark py">GOODS REVECEIVING NOTES</h4>
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
                                           
                                            <th data-orderable="false" >Show</th>
                                            <th data-orderable="false">Edit</th>
                                            <th data-orderable="false">Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($grns as $key => $grn)
                                            <tr class="text-center">
                                                <!-- <td>{{$key+=1}}</td> -->
                                                <td>{{$grn->grn_code}}</td>
                                                <td>{{$grn->project_name}}</td>                                        
                                                <td>{{$grn->name}}</td>  
                                                <td>{{$grn->grn_purchase_type}}</td>                                               
                                                <td>
                                                    <a  onclick="handleShowAndEdit('{{$grn->grn_no}}','show')"
                                                        class="btn btn-primary btn-circle btn-sm"   >
                                                        <i class="fas fa-flag"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a onclick="handleShowAndEdit('{{$grn->grn_no}}','edit')"
                                                        class="btn btn-info btn-circle btn-sm mx-2" >
                                                        <i class="fas fa-check"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    {{-- <form id="{{$grn->grn_no}}" action="{{route("goodsreceivingnote.destroy",$grn->grn_no)}}" method="post">
                                                        @csrf
                                                        @method("DELETE")
                                                    </form> --}}
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
        <input type="text" id="name" name="name"  value="{{ old('name') }}" placeholder="Supplier Name" class="form-control" autocomplete="off">
        <input type="text" id="supplier_no" hidden name="supplier_no"  value="{{ old('supplier_no') }}"  class="form-control" autocomplete="off">
        <p style="color: red" id="error_name"></p>
    </div>  

   <div class="form-group col-md-4" >
        <label for="grn_date" class="form-label fw-bold">GRN Invoice / Receive date<a style="text-decoration: none;color:red">*</a></label>
        <input type="date" id="grn_date" name="grn_date"  value="{{ old('grn_date') }}" placeholder="GRN Invoice / Receive date" class="form-control" autocomplete="off" >
        <p style="color: red" id="error_grn_date"></p>
    </div>
    <div class="form-group col-md-4">
    <label for="project_name" class="form-label fw-bold">Project Name<a style="text-decoration: none;color:red">*</a></label>
        <input type="text" id="project_name" name="project_name"  value="{{ old('project_name') }}" placeholder="Project Name" class="form-control" autocomplete="off">
        <input type="text" id="project_no" name="project_no"  hidden value="{{ old('project_no') }}"  class="form-control" autocomplete="off">
        <p style="color: red" id="error_project_name"></p>
 
    </div>

    <div class="form-group col-md-4">
        <label for="project_code" class="form-label fw-bold">Project Code<a style="text-decoration: none;color:red">*</a></label>
        <input type="text" id="project_code" name="project_code" value="{{ old('project_code') }}" readonly placeholder="Project Code" class="form-control" autocomplete="off">
        
    </div>
    <div class="form-group col-md-4">
        <label for="grn_purchase_type" class="form-label fw-bold">Purchase type<a style="text-decoration: none;color:red">*</a></label>
        <select id="grn_purchase_type" name="grn_purchase_type" class="form-control" autocomplete="off">
                                    <option value="">Select Option</option>
                                    @foreach($purchase_type as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                <p style="color: red" id="error_grn_purchase_type"></p>
        
    </div>
    <div class="form-group col-md-4">
        <label for="po_no" class="form-label fw-bold">REF LPO</label>
        <input type="text" id="po_code" name="po_code" value="{{ old('po_code') }}" class="form-control" autocomplete="off">
        <input type="text"  hidden id="po_no" name="po_no" value="{{ old('po_no') }}" class="form-control" autocomplete="off">
        <p style="color: red" id="error_po_no"></p>
    </div>
    <div class="form-group col-md-4" >
        <label for="po_date" class="form-label fw-bold">REF LPO date</label>
        <input type="date" id="po_date" name="po_date"  value="{{ old('po_date') }}" placeholder="REF LPO date" class="form-control" autocomplete="off" >
        <p style="color: red" id="error_grn_date"></p>
    </div>
    <div class="form-group col-md-4" >
        <label for="due_Date" class="form-label fw-bold">Due date<a style="text-decoration: none;color:red">*</a></label>
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
                <th>Receiving Qty</th>
                <th>Rate per Qty</th>
                <th>Total</th>
                <th>Delete</th>
              
            </tr>
            </thead>
            <tbody id="tbody1">
            
  
</tbody>
    </table>
        </div>
        <div style="margin-top:8px">
        <button class="btn btn-md btn-primary"
        id="addBtn" type="button">
            Add Row
        </button>
 </div>
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
    <div class="form-group col-md-2">
        <label for="purchase" class="form-label fw-bold">Purchase</label>
        <input type="text" id="purchase" name="purchase" value="{{ old('purchase')}}" placeholder="Purchase" class="form-control" autocomplete="off">      
    </div>
    <div class="form-group col-md-2">
        <label for="vat" class="form-label fw-bold">VAT</label>
        <input type="text" id="vat" name="vat" value="{{ old('vat')}}"  placeholder="VAT" class="form-control" autocomplete="off">      
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
        <label for="" class="float-end mt-2">Total Amount</label><br>
        <label for="" class="float-end mt-3"> Discount Amount</label><br>
        <label for="" class="float-end my-3">VAT Amount</label>
        <label for="" class="float-end my-3">Grand Total</label>
    </div>
    <div class="col-md-4">
        <input type="text" name="total_item_amount"  id="total_item_amount" readonly class="form-control mb-2">
        <input type="text" name="total_amount" id="total_amount"readonly class="form-control mb-2">
        <input type="text" name="discount" id="discount" readonly class="form-control mb-2">
        <input type="text" name="vat" id="vat1" readonly class="form-control mb-2">
        <input type="text" name="gross_amount" id="gross_amount"readonly class="form-control mb-2">
    </div>
    
    <div class="col-md-2">
        <label for="">Attachments</label>
    </div>
    <div class="col-md-4">
        <input type="file" name="attachments" class="form-control">
    </div>
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
                            <label>Purchase</label>
                            <p id="show_purchase"></p>
                        </div>
                          <div class="col-md-3">
                            <label>VAT</label>
                            <p id="show_vat"></p>
                        </div>
                        <div class="col-md-3">
                            <label>Total Amount</label>
                            <p id="show_total_amount"></p>
                        </div>
                </div>
                <div class="row">
                        <div class="col-md-3">
                            <label>Grand Total</label>
                            <p id="show_gross_amount"></p>
                        </div>                
                          <div class="col-md-3">
                            <label>Attachments</label>
                            <p id="show_attachments"></p>
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
   

// vat text box
   var textbox1 = document.getElementById("vat");
    var textbox2 = document.getElementById("vat1");
    textbox1.addEventListener("input", function() {
        textbox2.value = textbox1.value;
    });// vat end

    // discount_text
    var textbox3 = document.getElementById("discount_amount");
    var textbox4 = document.getElementById("discount"); 
    textbox3.addEventListener("input", function() {
        textbox4.value = textbox3.value;
    });// discount end

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
    $('input[name="invoice_amount"], input[name="misc_expenses"],  input[name="freight"],input[name="discount_amount"],input[name="vat"], input[name="purchase"],#total_item_amount').on('input', function() {
        // Get the values of the input fields
        var invoiceAmount = parseFloat($('input[name="invoice_amount"]').val() || 0);
        var miscExpenses = parseFloat($('input[name="misc_expenses"]').val() || 0);        
        var freight = parseFloat($('input[name="freight"]').val() || 0);
        var purchase = parseFloat($('input[name="purchase"]').val() || 0);
        calculateTotal();
        // Calculate the total amount
        var totalAmount = invoiceAmount + miscExpenses + freight + purchase + (parseFloat($('#total_item_amount').val()) || 0);
        // Set the value of the total_amount input field
        $('#total_amount').val(totalAmount.toFixed(2));
        var discount=parseFloat($('input[name="discount_amount"]').val() || 0);
        var vat=parseFloat($('input[name="vat"]').val() || 0);
         var gross_amount =totalAmount+vat-discount;
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
    var invoiceAmount = parseFloat($('input[name="invoice_amount"]').val() || 0);
    var miscExpenses = parseFloat($('input[name="misc_expenses"]').val() || 0);        
    var freight = parseFloat($('input[name="freight"]').val() || 0);
    var purchase = parseFloat($('input[name="purchase"]').val() || 0);
    var discount=parseFloat($('input[name="discount_amount"]').val() || 0);
    var vat=parseFloat($('input[name="vat"]').val() || 0);
    var totalAmount = invoiceAmount + miscExpenses + freight + purchase + (parseFloat($('#total_item_amount').val()) || 0);
    $('#total_amount').val(totalAmount.toFixed(2));
    var gross_amount =totalAmount+vat-discount;
    $('#gross_amount').val(gross_amount.toFixed(2));    
       
    }       
    
    // dynamic table creation
   var rowIdx =1;
function add_text()
{
            var html = '';
		html +='<tr id="row'+rowIdx+'">';
        html += '<td>'+rowIdx+'</td>';
		html += '<td><div class="col-xs-12"><input type="text" id="item_name_'
        +rowIdx+'"  name="item_name[]" class="item_name" placeholder="Start Typing Item name..."></div></td>';
        html += '<td hidden ><div class="col-xs-12"><input type="text"  id="item_no_'+rowIdx+'"  name="item_no[]" class="item_no_'+rowIdx+'"></div></td>';
        html += '<td><div class="col-xs-12"><input type="text" id="pack_specification_'+rowIdx+'"  name="pack_specification[]" class="pack_specification"></div></td>';
        html += '<td><div class="col-xs-12"><input type="text" id="quantity_'+rowIdx+'"  name="quantity[]" class="quantity"></div></td>';
        html += '<td><div class="col-xs-12"><input type="text" id="receiving_qty_'+rowIdx+'" name="receiving_qty[]" class="receiving_qty"></div></td>';
        html += '<td><div class="col-xs-12"><input type="text" id="rate_per_qty_'+rowIdx+'"  name="rate_per_qty[]"class="rate_per_qty"></div></td>';       
        html += '<td><div class="col-xs-12"><input type="text"  id="item_amount_'+rowIdx+'"name="item_amount[]" class="item_amount"></div></td>';
        html +='<td><button class="btn btn-danger remove" id="delete" type="button"><i class="fa fa-trash"></i></button></td>';     
        html+='</tr>';
        
        $("#tbody1").append(html);        
        rowIdx++;     
  
}
// auto complete function for item name and item no
jQuery($ => {
  
$(document).on('focus', '.item_name', function() {
        
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

// supplier autocomplete
          $("#name").autocomplete(
    {

        source: function( request, response )
        {
            $.ajax
            ({
                type:"GET",
                url: "{{ route('getempdata') }}",
                dataType: "json",
                data:
                {
                    'suppliername':$("#name").val()
                },
                success: function( data )
                {

                    result = [];
                    for(var i in data)
                    {
                        result.push(data[i]["name"]);
                    }
                    response(result);
                },fail: function(xhr, textStatus, errorThrown)
                {
                    alert(errorThrown);
                }
            });
        },
    });

    $("#name").on('change',function()
    {
        var code= $(this).val();

        $.ajax
        ({
            type:"GET",
            url: "{{ route('getempdata') }}",
            dataType: "json",
            data:
            {
                'suppliername':$(this).val()
            },
            success: function( data )
            {
                result = [];
                for(var i in data)
                {
                    $('#supplier_no').val(data[i]["supplier_no"]);
                    // $('#code').val(data[i]["code"]);
                }
            },fail: function(xhr, textStatus, errorThrown){
            alert(errorThrown);
            }
        });
    });
    // project name auto complete
    $("#project_name").autocomplete(
      {
      source: function( request, response ) {
        $.ajax( {
            type:"GET",
            url: "{{ route('getlocdata') }}",
            dataType: "json",
            data:{
            'projectname':$("#project_name").val()
             },
             success: function( data ) {
             result = [];
             for(var i in data)
            {
              result.push(data[i]["project_name"]);
            }
             response(result);
           },fail: function(xhr, textStatus, errorThrown){
        alert(errorThrown);
      }
      });
      },
      
      });
      $("#project_name").on('change',function()
    {
        var code= $(this).val();

        $.ajax
        ({
            type:"GET",
            url: "{{ route('getlocdata') }}",
            dataType: "json",
            data:
            {
                'projectname':$(this).val()
            },
            success: function( data )
            {
                result = [];
                for(var i in data)
                { 
                    $('#project_no').val(data[i]["project_no"]);
                    $('#project_code').val(data[i]['project_code'])
                }
            },fail: function(xhr, textStatus, errorThrown){
            alert(errorThrown);
            }
        });
    });

// table create with data for ref lpo number
    $("#po_code").on('change',function()
    {        
        $.ajax
        ({
        type:"GET",
        url: "{{ route('get_po_details') }}",
        dataType: "json",
        data:
        {
            'project_code':$('#po_code').val()
        },
        success: function( data )
        {   var len= data.po_items.length;
            var create_id=1;
            $(po_no).val(data.po_no);
        if(len == 1)
        {   
            for (const item of data.po_items) {         
            $('#item_name_' + create_id).val(item.item_name);
            $('#item_no_' + create_id).val(item.item_no);              
            $('#quantity_'+ create_id).val(item.quantity);               
            $('#rate_per_qty_'+ create_id).val(item.rate_per_qty);              
             }
        }
        else{
            for (const item of data.po_items) {                
            add_text();
            $('#item_name_' + create_id).val(item.item_name);
            $('#item_no_' + create_id).val(item.item_no);              
            $('#quantity_'+ create_id).val(item.quantity);               
            $('#rate_per_qty_'+ create_id).val(item.rate_per_qty);              
            create_id++;
            }  
        }

    },fail: function(xhr, textStatus, errorThrown){
    alert(errorThrown);
    }
});
    });
    // dialog open
    function handleDialog(){
             document.getElementById("myDialog").open = true;
             add_text();
             $('#method').val("ADD");
             $('#submit').text("Save");
             $('#heading_name').text("Add Goods Receiving Note").css('font-weight', 'bold');
              $('#grn_code').hide();
             $('#grn_code_lable').hide();
             $('#show').css('display','none');
             $('#form').css('display','block');
          }
// dialogclose
          function handleClose(){
            document.getElementById("myDialog").open = false;
            window.location.reload();
          }

          // DELETE FUNCTION
    function handleDelete(id)
    {
        let url = '{{route('gdelete',":id")}}';
        url= url.replace(':id',id);
        if (confirm("Are you sure you want to delete this item?"))
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
    function handleSubmit()
    {
        event.preventDefault();
        let form_data = new FormData(document.getElementById('form'));
        let method = $('#method').val();
        let url;
        let type;
        if(method == 'ADD')
        {          
            url = '{{route('grnApi.store')}}';
            type  = 'POST';
        }
        else
        {           
            let id = $('#grn_no').val();
            url = '{{route('grnApi.update',":id")}}';
            url= url.replace(':id',id);
            type = 'POST';
        }
        $.ajax
        ({
            url: url,
            type: type,
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            success: function (message)
            {
                alert(message);
                window.location.reload();
            },error: function (message)
            {
                var data = message.responseJSON;
                $.each(data.errors, function (key, val)
                {               
                    $(`#error_${key}`).html(val[0]);
                })
            }
        })
    }
    
//DATA SHOW FOR EDIT AND SHOW
function handleShowAndEdit(id,action)
    { var totalAmount=0;
         
        let url = '{{route('grnApi.show',":id")}}';
        url = url.replace(':id',id);
        let type= "GET"
        $.ajax
        ({
            url: url,
            type: type,
            contentType: false,
            cache: false,
            processData: false,
            success: function (message)
            {
                if(action == 'edit')
                {               
                    $('#show').css('display','none');
                    $('#form').css('display','block');
                    for (const [key, value] of Object.entries(message.grn[0]))
                    {
                        $(`#${key}`).val(value);
                    }
               var rowid=1;
               for (const item of message.grn_item) {
                add_text(); // add a new row to the table
                $('#item_name_' + rowid).val(item.item_name);
                $('#item_no_' + rowid).val(item.item_no);
                $('#pack_specification_'+ rowid).val(item.pack_specification);
                $('#quantity_'+ rowid).val(item.quantity);
                $('#receiving_qty_'+ rowid).val(item.receiving_qty);
                $('#rate_per_qty_'+ rowid).val(item.rate_per_qty);
                $('#item_amount_'+ rowid).val(item.item_amount);
               totalAmount += parseFloat(item.item_amount);             
                rowid++;
            }
                    $('#total_item_amount').val(totalAmount);
                    $('#vat1').val(message.grn[0].vat);
                    $('#discount').val(message.grn[0].discount_amount);
                    $('#method').val('UPDATE');
                    $('#submit').text('UPDATE');
                }
                else
                {
                    for (let [key, value] of Object.entries(message.grn[0])) {
                        // date formate
                      if (key === "grn_date" || key === "po_date") {
                    var dateObj = new Date(value);
                    var day = dateObj.getDate();
                    var month = dateObj.getMonth() + 1;
                    var year = dateObj.getFullYear();
                    value= day + '-' + month + '-' + year
                    }
                    $(`#show_${key}`).text(value);
                    }                   
                    let script = '<table id="show_table" class="table table-striped"><thead><tr><th>Item Name</th><th>Pack Specification</th><th>Quantity</th><th>Receiving Quantity</th><th>Rate per Qty</th><th>Total Amount</th></tr></thead><tbody>';
                    for (const item of message.grn_item) {
                   script += '<tr>';
                   script += '<td>' + item.item_name + '</td>';
                   script += '<td>' + item.pack_specification + '</td>';
                   script += '<td>' + item.quantity+ '</td>';
                   script += '<td>' + item.receiving_qty + '</td>';
                   script += '<td>' + item.rate_per_qty + '</td>';
                   script += '<td>' + item.item_amount + '</td>';
                   script += '</tr>';
                }
               script+= '</tbody></table>';
               $('show_table').remove();
               $('#item_details_show').append(script); 
                    $('#heading_name').text("View Goods Receiving Note").css('font-weight', 'bold');
                    $('#show').css('display','block');
                    $('#form').css('display','none');
                }
                document.getElementById("myDialog").open = true;
            },
        })
    }   
    </script>        


@stop