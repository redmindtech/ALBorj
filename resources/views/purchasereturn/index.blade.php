@extends('layouts.app',[
    'activeName' => 'Purchase Return'
])
@section('title', 'Purchase Return')

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
                                            <th>Purchase Return Code</th>
                                            <th>Supplier Name</th>
                                            <th>Project Name</th>
                                            <th>Purchase Type</th>
                                            <th data-orderable="false" class="action notexport" >Show</th>
                                            <th data-orderable="false" class="action notexport">Edit</th>
                                            <th data-orderable="false" class="action notexport">Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                @foreach ($prs as $key => $pr)
                                    <tr class="text-center">
                                        <!-- <td>{{$key+=1}}</td> -->
                                        <td>{{$pr->pr_code}}<div id="blur-background" class="blur-background"></div></td>
                                        <td>{{$pr->name}}</td>
                                        <td>{{$pr->project_name}}</td>
                                        <td>{{$pr->pr_purchase_type}}</td>

                                        <td>
                                            <a  onclick="handleShowAndEdit('{{$pr->pr_no}}','show')"
                                                class="btn btn-primary btn-circle btn-sm"   >
                                                <i class="fas fa-flag"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a onclick="handleShowAndEdit('{{$pr->pr_no}}','edit')"
                                                        class="btn btn-info btn-circle btn-sm mx-2" >
                                                        <i class="fas fa-check"></i>
                                                    </a>
                                                </td>
                                                <td>
                                        <button  type="submit" class="btn btn-sm btn-danger" onclick="handleDelete('{{$pr->pr_no}}')">
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
                    <dialog id="myDialog"  style="width:1000px;">
            <div class="row">

                <div class="col-md-12">

                     <a class="btn  btn-sm" onclick="handleClose()" style="float:right;padding: 10px 10px;"><i class="fas fa-close"></i></a>
                     <h4  id='heading_name' style='color:white' align="center"><b>Update Purchase Return </b></h4>
                    </div>
            </div>



            <form  class="form-row"  enctype="multipart/form-data" style="display:block" id="form" onsubmit="handleSubmit()">
                <input type="hidden" id="method" value="ADD"/>
                <input type="hidden" id="pr_no" name="pr_no" value=""/><br>

{!! csrf_field() !!}
<div class="row g-3">
<div class="form-group col-md-4">
         <label for="name" class="form-label fw-bold">Supplier Name<a style="text-decoration: none;color:red">*</a></label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Supplier Name" class="form-control" autocomplete="off">
        <input type="text" id="supplier_no" hidden  name="supplier_no"  value="{{ old('supplier_no') }}"  class="form-control" autocomplete="off">
        <p style="color: red" id="error_supplier_no"></p>
    </div>
    <div class="form-group col-md-4" >
        <label for="code" class="form-label fw-bold">Supplier Code</label>
        <input type="code" id="code" name="code" readonly  value="{{ old('code') }}" placeholder="Supplier Code" class="form-control" autocomplete="off" >
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
    <label for="invoice_no" class="form-label fw-bold">Invoice No</label>
        <input type="text" id="invoice_no" name="invoice_no"  value="{{ old('invoice_no') }}" placeholder="Invoice No" class="form-control" autocomplete="off">
       
       
 
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
    <label for="project_name" class="form-label fw-bold">Project Name<a style="text-decoration: none;color:red">*</a></label>
        <input type="text" id="project_name" name="project_name"  value="{{ old('project_name') }}" placeholder="Project Name" class="form-control" autocomplete="off">
        <input type="text" id="project_no" name="project_no"  hidden value="{{ old('project_no') }}"  class="form-control" autocomplete="off">
        <p style="color: red" id="error_project_no"></p>
 
    </div>

    <div class="form-group col-md-4">
        <label for="project_code" class="form-label fw-bold">Project Code</label>
        <input type="text" id="project_code" readonly  name="project_code" value="{{ old('project_code') }}" readonly placeholder="Project Code" class="form-control" autocomplete="off">
    </div>
    <div class="form-group col-md-4">
        <label for="pr_code" id="lable_pr_code" class="form-label fw-bold">Purchase Return Code</label>
        <input type="text" id="pr_code" readonly  name="pr_code" value="{{ old('pr_code') }}" readonly  class="form-control" autocomplete="off">
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
                <th >stock Quantity</th>
                <th>Return Quantity</th>                
                <th>Rate Per Quantity</th>
                <th>VAT(%)</th>
                <th hidden>vat_per_qty</th>
                <th>Total</th>
                <th>Delete</th>
            </tr>
            </thead>
            <tbody id="tbody1">
</tbody>
    </table>
        </div>
        <br>
        <div style="margin-top:8px">
        <button class="btn btn-md btn-primary"
        id="addBtn" type="button">
            Add Row
        </button>
 </div>
    </div>
   <br>
    <div class="row g-3">
    <div class="form-group col-md-6">
    <label for="vat" class="form-label fw-bold">VAT Amount</label>
        <input type="text" id="vat_amount" name="vat_amount"  readonly value="{{ old('vat_amount') }}" placeholder="VAT Amount" class="form-control" autocomplete="off">
        </div>

    <div class="form-group col-md-6">
        <label for="return_amount" class="form-label fw-bold">Total Return Amount</label>
        <input type="text" id="return_amount" readonly  name="return_amount" value="{{ old('return_amount') }}" readonly placeholder="Total Return Amount" class="form-control" autocomplete="off">
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
                          <div class="col-md-4">
                            <label>Purchase Return Code</label>
                            <p id="show_pr_code"></p>  
                        </div>         
                        <div class="col-md-4">
                            <label>Supplier Name</label>
                            <p id="show_name"></p> 
                        </div>                                              
                          <div class="col-md-4">
                            <label>Currency</label>
                            <p id="show_currency"></p>
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-md-4">
                            <label>Invoice No</label>
                            <p id="show_invoice_no"></p>
                        </div>
                          <div class="col-md-4">
                            <label>Purchase type</label>
                            <p id="show_pr_purchase_type"></p>
                        </div>
                        <div class="col-md-4">
                            <label>Project Name</label>
                            <p id="show_project_name"></p>
                        </div> 
                </div>
                <div class="row">                  
                          <div class="col-md-4">
                            <label>Project Code</label>
                            <p id="show_project_code"></p>
                        </div>
                          <div class="col-md-4">
                            <label>Vat Amount</label>
                            <p id="show_vat_amount"></p>
                        </div>
                        <div class="col-md-4">
                            <label>Total Return Amount</label>
                            <p id="show_return_amount"></p>
                        </div>                
                          
                </div>
                
                
                <div id="item_detail_show"></div>
                                       
    </div>
</div>
          </dialog>
          
<script>
     $('#addBtn').on('click', function () {               
                     add_text();
               });
            // delete row in dynamically created table
            $('#tbody1').on('click', '.remove', function() {

                                var row = $(this).closest('tr');

                            // Get the row index
                            var rowIndex = row.index();

                            // Calculate the item_return_quantity, rate_per_qty, and vat values
                            var quantity = parseFloat(row.find('input[id^="item_return_quantity_"]').val()) || 0;
                            var rate = parseFloat(row.find('input[id^="rate_per_qty_"]').val()) || 0;
                            var vat = parseFloat(row.find('input[id^="vat_"]').val()) || 0;

                            // Calculate vat_per_qty and item_return_total for the current row
                            var itemAmount = quantity * rate;
                            var vatAmount = itemAmount * (vat / 100);
                            itemAmount += vatAmount;

                            // Subtract the itemAmount and vatAmount from the total amounts
                            var totalItemAmount = parseFloat($("#return_amount").val()) || 0;
                            var totalVatAmount = parseFloat($("#vat_amount").val()) || 0;
                            totalItemAmount -= itemAmount;
                            totalVatAmount -= vatAmount;

                            // Set the updated total amounts
                            $("#return_amount").val(totalItemAmount.toFixed(2));
                            $("#vat_amount").val(totalVatAmount.toFixed(2));

                            // Removing the current row
                            row.remove();
                             });
    // add dynamic row
    var rowIdx = 1;

function add_text() {
    var html = '';
    html += '<tr id="row' + rowIdx + '" class="rowtr">';
    html += '<td>' + rowIdx + '</td>';
    html += '<td><div class="col-xs-12"><input type="text" id="item_name_' + rowIdx + '"  name="item_name[]" class="item_name" placeholder="Start Typing Item name..."></div></td>';
    html += '<td hidden><div class="col-xs-12"><input type="text"  id="item_no_' + rowIdx + '"  name="item_no[]" class="item_no_' + rowIdx + '"></div></td>';
    html += '<td><div class="col-xs-12 stock_qty" id="stock_qty_' + rowIdx + '"></div></td>';
    html += '<td><div class="col-xs-12"><input type="text" id="item_return_quantity_' + rowIdx + '"  name="item_return_quantity[]" class="item_return_quantity"></div></td>';
    html += '<td><div class="col-xs-12"><input type="text" id="rate_per_qty_' + rowIdx + '"  name="rate_per_qty[]"class="rate_per_qty"></div></td>';
    html += '<td><div class="col-xs-12"><input type="text"  id="vat_' + rowIdx + '"name="vat[]" class="vat"></div></td>';
    html += '<td hidden><div class="col-xs-12"><input type="text"  id="vat_per_qty_' + rowIdx + '"name="vat_per_qty[]" class="vat_per_qty"></div></td>';
    html += '<td><div class="col-xs-12"><input type="text"  id="item_return_total_' + rowIdx + '"name="item_return_total[]" class="item_return_total"></div></td>';
    html += '<td><button class="btn btn-danger remove" id="delete" type="button"><i class="fa fa-trash"></i></button></td>';
    html += '</tr>';
    $("#tbody1").append(html);


   
    document.getElementById('item_return_total_' + rowIdx).readonly = true;

    rowIdx++;
}


 // table textbox multiple receiving_qty and rate_per_qty
 $('#tbody1').on('input', 'input[id^="item_return_quantity_"], input[id^="rate_per_qty_"], input[id^="vat_"]', function() {
    var row = $(this).closest('tr');
    var quantity = parseFloat(row.find('input[id^="item_return_quantity_"]').val()) || 0;
    var rate = parseFloat(row.find('input[id^="rate_per_qty_"]').val()) || 0;
    var vat = parseFloat(row.find('input[id^="vat_"]').val()) || 0;
    
    var itemAmount = quantity * rate;
    var vatAmount = itemAmount * (vat / 100); // Calculate VAT amount based on item amount and VAT percentage
    itemAmount += vatAmount;
    row.find('input[id^="item_return_total_"]').val(itemAmount.toFixed(2));
    row.find('input[id^="vat_per_qty_"]').val(vatAmount.toFixed(2));
    
    calculateTotal();
    
});

// Calculate and display the total item amount and total VAT amount
function calculateTotal() {
    var totalItemAmount = 0;
    var totalVatAmount = 0;
    
    $("input[name='item_return_total[]']").each(function() {
        var val = parseFloat($(this).val());
        if (!isNaN(val)) {
            totalItemAmount += val;
        }
    });
    
    $("input[name='vat_per_qty[]']").each(function() {
        var val = parseFloat($(this).val());
        if (!isNaN(val)) {
            totalVatAmount += val;
        }
    });
    
    $("#return_amount").val(totalItemAmount.toFixed(2));
    $("#vat_amount").val(totalVatAmount.toFixed(2));
}


//  auto complete for supplier name
jQuery($ => {

$(document).on('focus click', $("#city"), function() {
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
});
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
                    $('#code').val(data[i]["code"]);
                }
            },fail: function(xhr, textStatus, errorThrown){
            alert(errorThrown);
            }
        });
    });
    // project name auto complete
jQuery($ => {

$(document).on('focus click', $("#city"), function() {
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
    });
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
// auto complete function for item name and item no
jQuery($ => {

$(document).on('focus click', $("#city"), function() {
          
      $('#tbody1').find('.item_name').autocomplete({
              source: function( request, response )
          {
              $.ajax
              ({
                  type:"GET",
                  url: "{{ route('purchase_return_data') }}",
                  dataType: "json",
                  data:
                  {
                      'itemname':request.term,
                      'supplier_id':$('#supplier_no').val()
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
              url: "{{ route('purchase_return_data') }}",
              dataType: "json",
              data:
              {
                  'itemname':$(this).val(),
                  'supplier_id':$('#supplier_no').val()
              },
              success: function( data )
              { 
                  result = [];
                  for(var i in data)
                  {                    
                      $('#item_no_'+id).val(data[0]["id"]);
                      $('#rate_per_qty_'+id).val(data[0]["price_per_qty"]);
                      $('#stock_qty_'+id).text(data[0]["total_quantity"]);
                      
                      
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
             $('#heading_name').text("Add Purchase Return").css('font-weight', 'bold');
              $("#lable_pr_code").hide();
              $("#pr_code").hide();

             $('#show').css('display','none');
             $('#form').css('display','block');
             $('#blur-background').css('display','block');
          }
// dialogclose
function handleClose(){
                     document.getElementById("myDialog").open = false;
                    $("#myDialog").load(" #myDialog > *");
                    rowIdx=1;
                    $('#blur-background').css('display','none');
                    // window.location.reload();
                }

          // DELETE FUNCTION
    function handleDelete(id)
    {
        let url = '{{route('prApi.delete',":id")}}';
        url= url.replace(':id',id);
        if (confirm("Are you sure you want to delete this purchase Return?"))
        {
            $.ajax
            ({
                url: url,
                type: 'DELETE',
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
    let isValid = true;
    let itemNames = []; // Array to store encountered item names

    // Loop through each row
    $('.rowtr').each(function () {
        let rowId = $(this).attr('id');
        let itemReturnQuantity = $('#' + rowId + ' .item_return_quantity').val();
        let vat = $('#' + rowId + ' .vat').val();
        let itemName = $('#' + rowId + ' .item_name').val();
        let stockQuantity = $('#' + rowId + ' .stock_qty').text().trim();

        if (itemName === '') {
            alert('Please enter an item name in ' + rowId);
            isValid = false;
            return false; // Exit the loop
        }

        if (itemNames.includes(itemName)) {
            alert('Item name "' + itemName + '" is repeated. Please enter a unique item name in ' + rowId);
            isValid = false;
            return false; // Exit the loop
        }

        itemNames.push(itemName); // Add item name to the array

        if (itemReturnQuantity === '' || isNaN(itemReturnQuantity)) {
            alert('Please enter a valid item return quantity in ' + rowId);
            isValid = false;
            return false; // Exit the loop
        }

        if (vat === '' || isNaN(vat)) {
            alert('Please enter a valid VAT value in ' + rowId);
            isValid = false;
            return false; // Exit the loop
        }

        if (parseFloat(itemReturnQuantity) > parseFloat(stockQuantity)) {
            alert('Item return quantity in ' + rowId + ' should be less than or equal to stock quantity.');
            isValid = false;
            return false; // Exit the loop
        }
    });

    if (isValid) {
    
    

    let form_data = new FormData(document.getElementById('form'));
    let method = $('#method').val();
    let url;
    let type;
    if (method == 'ADD') {
        url = '{{ route('prApi.store') }}';
        type = 'POST';
    } else {
        let id = $('#pr_no').val();
        url = '{{ route('prApi.update', ":id") }}';
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
            $('p[id ^= "error_"]').html("");
            $.each(data.errors, function (key, val) {
                $(`#error_${key}`).html(val[0]);
            });
        }
    });
}
}


//DATA SHOW FOR EDIT AND SHOW
        function handleShowAndEdit(id,action){
        let url = "{{ route('prApi.show', ':pr_no') }}";
        url = url.replace(':pr_no',id);
        let type= "GET"
        console.log(id);
        $.ajax({
            url: url,
            type: type,
            contentType: false,
            cache: false,
            processData: false,
            success: function(message) {
                console.log(message.pr);
                  console.log(message.pr_item);
                if (action == 'edit') {
                    $('#show').css('display', 'none');
                    $('#form').css('display', 'block');
                    $('#blur-background').css('display','block');
                    for (const [key, value] of Object.entries(message.pr[0])) {
                        //   console.log(`${key}: ${value}`);
                        $(`#${key}`).val(value);
                    }
                  
                    var len= message.pr_item.length;
            var create_id=1;
           
        if(len == 1)
        {
            for (const item of message.pr_item)
            { add_text();
                $('#item_name_' + create_id).val(item.item_name);
                $('#item_no_' + create_id).val(item.item_no);
                $('#stock_qty_'+ create_id).text(item.total_quantity);
                $('#item_return_quantity_'+ create_id).val(item.item_return_quantity);
                $('#rate_per_qty_'+ create_id).val(item.rate_per_qty);
                $('#vat_'+ create_id).val(item.vat);
                 $('#item_return_total_'+ create_id).val(item.item_return_total);
                 var quantity = parseFloat(item.item_return_quantity) || 0;
                        var vat = parseFloat(item.vat) || 0;
                        var vatPerQty = (vat / 100) * quantity;
                        $('#vat_per_qty_' + create_id).val(vatPerQty.toFixed(2));
            }
        }
        else{
            for (const item of message.pr_item)
            {
            add_text();
            $('#item_name_' + create_id).val(item.item_name);
                $('#item_no_' + create_id).val(item.item_no);
                $('#stock_qty_'+ create_id).text(item.total_quantity);
                $('#item_return_quantity_'+ create_id).val(item.item_return_quantity);
                $('#rate_per_qty_'+ create_id).val(item.rate_per_qty);
                $('#vat_'+ create_id).val(item.vat);
                 $('#item_return_total_'+ create_id).val(item.item_return_total);
                 var quantity = parseFloat(item.item_return_quantity) || 0;
                        var vat = parseFloat(item.vat) || 0;
                        var vatPerQty = (vat / 100) * quantity;
                        $('#vat_per_qty_' + create_id).val(vatPerQty.toFixed(2));
            create_id++;
            }
          
        }
        $('#method').val('UPDATE');
             $('#submit').text('UPDATE');
                  
    }
    
     else {

                    for (const [key, value] of Object.entries(message.pr[0])) {
                        console.log(`${key}: ${value}`);
                        $(`#show_${key}`).text(value);

                    }
                    let script =
                        '<table id="show_table" class="table table-striped"><thead><tr><th>Item Name</th><th>Stock Quantity</th><th>Return Quantity</th><th>Rate Per Quantity</th><th>VAT</th><th>Total</th></tr></thead><tbody>';
                    for (const item of message.pr_item) {
                        script += '<tr>';
                        script += '<td>' + item.item_name + '</td>';
                        script += '<td>' + item.total_quantity + '</td>';
                        script += '<td>' + item.item_return_quantity + '</td>';
                        script += '<td>' + item.rate_per_qty + '</td>';
                        script += '<td>' + item.vat + '</td>';
                        script += '<td >' + item.item_return_total + '</td>';
                        
                        script += '</tr>';
                    }
                     script += '</tbody></table>';
                    $('show_table').remove();
                     $('#item_detail_show').append(script);
                    $('#heading_name').text("View Purchase Return").css('font-weight', 'bold');
                    $('#show').css('display', 'block');
                    $('#form').css('display', 'none');
                    $('#blur-background').css('display','block');
                }
                 document.getElementById("myDialog").open = true;
            },
        })
    }
</script>
@stop