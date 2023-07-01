@extends('layouts.app',[
    'activeName' => 'Payment Receivables'
])
@section('title', 'PaymentReceivablesController')

@section('content_header')
@stop

@section('content')
<div class="row">
    <div class="container-fluid">
        <div class="card shadow">
                <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <h4 class="font-weight-bold text-dark py">PAYMENT RECEIVABLES</h4>
                          
                                    <div class="row">
                                            <div class="col">
                                                <button type="button" class="btn btn-block btn-primary">PCC</button>
                                            </div>
                                            <div class="col">
                                                <button type="button" class="btn btn-block btn-primary" onclick="handleDialog()">COLLECT</button>
                                            </div>
                                    </div>
                                </div>
                </div>                    
                <div class="card">
                    <div class="card-body">
                          <table id="myTable" class="table table-bordered table-striped">
                                <thead>
                                        <tr class="text-center">
                                            <!-- <th>Client No</th> -->
                                            <th>Project Name</th>
                                            <th>Project Cost</th>
                                            <th>Received Amt</th>
                                            <th>Balance Amt</th>
                                           
                                            <th>Date</th>
                                            <!-- <th>Due Date</th>
                                            <th>Amount Received</th> -->
                                            <th data-orderable="false" class="action notexport">Show</th>
                                            <th data-orderable="false" class="action notexport">Edit</th>
                                            <th data-orderable="false" class="action notexport">Delete</th>
                                            <div id="blur-background" class="blur-background"></div>
                                         </tr>
                                </thead>
                                <tbody>
                                        @foreach ($payment_recs as $key => $payment_rec)
                                            <tr class="text-center">
                                                <td>{{$payment_rec->project_name}}</td>
                                                <td>{{$payment_rec->project_cost}}</td>                                        
                                                <td>{{$payment_rec->received_amt}}</td>
                                                <td>{{$payment_rec->balance_amount}}</td>
                                                
                                                <td>{{ date('d-m-Y', strtotime($payment_rec->created_at)) }}</td>
                                                <td>
                                                    <a  onclick="handleShowAndEdit('{{$payment_rec->id}}','show')"
                                                        class="btn btn-primary btn-circle btn-sm"   >
                                                        <i class="fas fa-flag"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a onclick="handleShowAndEdit('{{$payment_rec->id}}','edit')"
                                                        class="btn btn-info btn-circle btn-sm mx-2" >
                                                        <i class="fas fa-check"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <button  type="submit" class="btn btn-sm btn-danger" onclick="handleDelete('{{$payment_rec->id}}')">
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
    </div>
</div>
<dialog id="myDialog">
                    <div class="row">
                        <div class="col-md-12">
                            <a class="btn  btn-sm" onclick="handleClose()" style="float:right;padding: 10px 10px;"><i class="fas fa-close"></i></a>
                            <h4  id='heading_name' style='color:white' align="center"><b>Update purchaseOrder Details</b></h4>
                        </div>
                    </div>
        <form  class="form-row"  enctype="multipart/form-data" style="display:block" id="form" onsubmit="handleSubmit()">
            <input type="hidden" id="method" value="ADD"/>
            <input type="hidden" id="id" name="id" value=""/><br>
            {!! csrf_field() !!}
                <div class="row g-3">                   
                    <div class="form-group col-md-4">
                        <label for="project_name" class="form-label fw-bold">Project Name<a
                                style="text-decoration: none;color:red">*</a></label>
                        <input type="text" id="project_name" name="project_name" value="{{ old('name') }}"
                            placeholder="Project Name" class="form-control supplier_name" autocomplete="off">
                        <input type="text" id="project_no" hidden name="project_no"
                            value="{{ old('project_no') }}" class="form-control project_no" autocomplete="off">
                    </div>
                </div>   
                <div class="container pt-4">
                    <div class="table-responsive">
                        <center><table class="table table-bordered"  >
                            <thead>
                                <tr>
                                    <th class="text-center">S.No</th>
                                    <th class="text-center" style="width:18%">Item Name</th>
                                    <th class="text-center" style="width:15%">Specification</th>
                                    <th class="text-center" style="width:10%">Qty</th>
                                    <th class="text-center" style="width:10%">Unit</th>  
                                    <th class="text-center" style="width:8%">Pending Qty</th>                                      
                                    <th class="text-center" style="width:10%">Used Qty</th>
                                    <th class="text-center" style="width:10%">Rem.Qty</th>
                                    <th class="text-center" style="width:12%">Rate Per Qty</th>                                 
                                    <th class="text-center" style="width:11%">Amount</th>
                                   </tr>
                            </thead>
                            <tbody id="tbody">
                            </tbody>
                        </table></center>
                    </div>
                    
                </div>
                <div class="row"> 
                <div class="form-group col-md-4">
                    <label for="source" class="form-label fw-bold">Source<a style="text-decoration: none;color:red">*</a></label>
                    <select id="source" name="source" class="form-control form-select" autocomplete="off" >
                        <option value="">Select Option</option>
                        @foreach($source as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-4" id='cheque' style="display: none;">
                    <label for="cheque_no" class="form-label fw-bold">Cheque No<a style="text-decoration: none;color:red">*</a></label>
                    <input type="text" id="cheque_no"  name="cheque_no" value="{{ old('cheque_no') }}" placeholder="Cheque No" class="form-control" autocomplete="off">
                </div>
                <div class="form-group col-md-4"   id='cheque_date' style="display: none;">
                    <label for="cheque_date" class="form-label fw-bold">Cheque Date<a style="text-decoration: none;color:red">*</a></label>
                    <input type="date" id="cheque_date"  name="cheque_date" value="{{ old('cheque_date') }}" placeholder="Cheque Date" class="form-control" autocomplete="off">
                </div>
            </div>
            <div class="row"> 
                <div class="form-group col-md-4">
                    <label for="source" class="form-label fw-bold">Opening Balance<a style="text-decoration: none;color:red">*</a></label>
                    <input type="text" readonly name="opening_bal" id="opening_bal" class="form-control mb-2" autocomplete="off">                 
                </div>
                <div class="form-group col-md-4">
                <label for="total_amount" class="form-label fw-bold">Total Amount</label>
                <input type="text" readonly name="total_amount" id="total_amount" class="form-control mb-2" autocomplete="off">
                </div>
                <div class="form-group col-md-4">
                <label for="project_cost" class="form-label fw-bold">Project cost</label>
                <input type="text"readonly  name="project_cost" id="project_cost" class="form-control mb-2" autocomplete="off">
                </div>
            </div>
            <div class="row"> 
                <div class="form-group col-md-4">
                <label for="" class="form-label fw-bold">Received Amount</label>
                <input type="text" readonly name="received_amt" id="received_amt" class="form-control mb-2" autocomplete="off">
                </div>
                <div class="form-group col-md-4">
                <label for="" class="form-label fw-bold">Balance Amount</label>
                <input type="text" readonly name="balance_amount" id="balance_amount" class="form-control mb-2 total" autocomplete="off">
                </div>
                <div class="form-group col-md-4">
                <label for="" class="form-label fw-bold">Closing Balance</label>
                <input type="text" readonly name="closing_bal" id="closing_bal" class="form-control mb-2" autocomplete="off">
                </div>
            </div>

                <!-- <div class="row" style="margin-top:10px;">
               <br>
                <div class="col-md-2">  
                    <label for="" class="float-end mt-4 text-end">Opening Balance</label><br>             
                    <label for="" class="float-end mt-3 text-end">Total Amount</label><br>
                    <label for="" class="float-end mt-3 text-end">Project cost</label><br>
                    <label for="" class="float-end my-3 text-end">Received Amount</label>
                    <label for="" class="float-end my-1 text-end">Balance Amount</label>
                    <label for="" class="float-end my-2 text-end">Closing Balance</label><br>   
                </div>
                <div class="col-md-4">            
                    <br>
                    <input type="text" readonly name="opening_bal" id="opening_bal" class="form-control mb-2" autocomplete="off">
                    <input type="text" readonly name="total_amount" id="total_amount" class="form-control mb-2" autocomplete="off">
                    <input type="text"readonly  name="project_cost" id="project_cost" class="form-control mb-2" autocomplete="off">
                   
                    
                   
                </div> -->
                <!-- </div> -->
                <div class="row mt-3">
                    <div class="form-group col-md-12">
                        <center><button id="submit" class="btn btn-primary mx-3 mt-3">Collect</button></center>
                    </div>
                </div>
        </form>

        <!-- SHOW DIALOG -->
        <div class="card" id="show" style="display:none">
            <div class="card-body" style="background-color:white;width:100%;height:20%;">
                <div class="row">
                    <div class="col-md-3">
                        <label>Project Name</label>
                        <p id="show_project_name"></p>
                    </div>
                    <div class="col-md-3">
                        <label>Project Cost</label>
                        <p id="show_project_cost"></p>
                    </div>
                 
                                            
                    <div class="col-md-3">
                        <label>Received Amt</label>
                        <p id="show_received_amt"></p>
                    </div>
                    <div class="col-md-3">
                        <label>Balanace Amount</label>
                        <p id="show_balance_amount"></p>
                    </div>
                </div>        
                
                
                <div id="item_details_show"></div>
            </div>
        </div>
    </dialog>



<script type="text/javascript">

    $.ajaxSetup(
    {
        headers: 
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(function () 
    {
        $("#myTable").DataTable();
    });
    function handleDialog(){
             document.getElementById("myDialog").open = true;
             window.scrollTo(0, 0);
            
            //   add_text();
            // $('#dis_type').prop('checked', true);
          
             $('#method').val("ADD");
             $('#submit').text("Save");
             $('#heading_name').text("Add Payment Receivables Details").css('font-weight', 'bold');
            
             $('#show').css('display','none');
             $('#form').css('display','block');
             $('#blur-background').css('display','block');

          }
// dialogclose
function handleClose(){
            document.getElementById("myDialog").open = false;
                // Clear the form fields
                $('#form')[0].reset();
                $('#cheque').hide();
                $('#cheque_date').hide();
               
                $("#tbody").empty();
                // show_table
                $("#item_details_show").empty();
                rowIdx=1;
                $('.error-msg').removeClass('error-msg');
                $('.has-error').removeClass('has-error');
                // Hide any error messages
                $('error').html('');
                $('#blur-background').css('display','none');
             
          } 
   // DELETE FUNCTION
   function handleDelete(id)
    {
        let url = '{{route('payrecApi.delete',":id")}}';
        url= url.replace(':id',id);
        if (confirm("Are you sure you want to delete this  Payment Receivables Details?"))
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
          function handleSubmit() 
          {
            event.preventDefault();
            $('.rowtr').each(function() {
        // Get the row index
        var rowIdx = $(this).attr('id').replace('row', '');

        // Get the receiving quantity value for the current row
        var used_Qty = parseFloat($('#used_qty_' + rowIdx).val());

        // Get the pending quantity value for the current row
        var pendingQty = parseFloat($('#pending_qty_' + rowIdx).val());


        if (isNaN(used_Qty) ) {
            alert('Please enter a valid Receiving quantity in row ' + rowIdx);
            hasError = true;
            return false; // Exit the loop
        }
                // Check if receiving quantity is greater than pending quantity
                if (used_Qty > pendingQty) {
                    // Display an error message or handle the condition as needed
                    alert('Used quantity cannot be greater than pending quantity for row ' + rowIdx);
                    hasError = true;
                    return false; // Exit the loop
                }

            });
    
            var hiddenErrorElements = $('.error-msg:not(:hidden)').length;
            // alert(hiddenErrorElements);
            if(hiddenErrorElements === 0)
            {
            let form_data = new FormData(document.getElementById('form'));
            let method = $('#method').val();
            let url;
            let type;

            if (method == 'ADD') {
                url = '{{ route('payrecApi.store') }}';
                type = 'POST';
            } else {
                let id = $('#id').val();
                url = '{{ route('payrecApi.update', ":id") }}';
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
                success: function (response) {
                alert(response); // Show the response message
                window.location.reload();
                },
                error: function (xhr, status, error) {
                var errorMessage = xhr.responseText; // Get the error message from the response
                alert(errorMessage);
                }
            });
        }
            }
            function handleShowAndEdit(id, action) {
                    let url = '{{ route('payrecApi.show', ':project_no') }}';
                    url = url.replace(':project_no', id);
                    let type = "GET"
                    $.ajax({
                        url: url,
                        type: type,
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function(message) {
                            console.log(message);
                            if (action == 'edit') {
                                $('#heading_name').text("Update Payment Receivables Details").css('font-weight', 'bold');
                                $('#show').css('display', 'none');
                                $('#form').css('display', 'block');
                                $('#blur-background').css('display', 'block');

                                for (const [key, value] of Object.entries(message.payment_recs)) {
                                    $(`#${key}`).val(value);
                                }
                              var rowid =1;   
                             
                    for (const item of message.payment_item) 
                    {
                        console.log(item.total_quantity);
                        add_text(); // add a new row to the table
                        $('#item_name_' + rowid).val(item.item_name);
                        $('#item_no_' + rowid).val(item.item_no);
                        $('#specification_'+ rowid).text(item.specification);
                        $('#used_qty_'+ rowid).val(item.used_qty);
                        $('#remaining_qty_'+ rowid).val(item.remaining_qty);
                        $('#qty_'+ rowid).val(item.qty);
                        $('#pending_qty_'+ rowid).val(item.pending_qty);
                        $('#unit_'+ rowid).val(item.item_unit);
                        $('#rate_per_qty_'+ rowid).val(item.rate_per_qty);
                        $('#amount_'+ rowid).val(item.amount);
                        rowid++;
                    }
                                $('#method').val('UPDATE');
                                $('#submit').text('UPDATE');
                            } else {
                                console.log('c');
                                for (let [key, value] of Object.entries(message.payment_recs)) {
                                    console.log(  $(`#show_${key}`).text(value));
                                    $(`#show_${key}`).text(value);
                                    
                                }
                                        let script = '<table id="show_table" class="table table-striped"><thead><tr><th>Item Name</th><th>Unit</th><th>Specification</th><th>Quantity</th><th>Used Qty</th><th>Remaining Qty</th><th>Rate per Quantity</th><th>Amount</th></tr></thead><tbody>';
                                        for (const item of message.payment_item) {
                                    script += '<tr>';
                                    script += '<td>' + item.item_name + '</td>';
                                    script += '<td>' + item.item_unit+ '</td>';
                                    if(item.specification == null){
                                        item.specification ='';}  
                                    script += '<td>' + item.specification + '</td>';
                                    script += '<td>' + item.qty+ '</td>';
                                    script += '<td>' + item.used_qty+ '</td>';
                                    script += '<td>' + item.remaining_qty+ '</td>'; 
                                    script += '<td>' + item.rate_per_qty + '</td>';
                                    script += '<td>' + item.amount + '</td>';
                                    script += '</tr>';
                                    }
                                script+= '</tbody></table>';
                                $('show_table').remove();
                                $('#item_details_show').append(script);
                                $('#heading_name').text("Payment Receivables Details").css('font-weight', 'bold');
                                $('#show').css('display', 'block');
                                $('#form').css('display', 'none');
                                $('#blur-background').css('display', 'block');
                            }
                            document.getElementById("myDialog").open = true;
                            window.scrollTo(0, 0);
                        },
                    })
                }

    
          var rowIdx = 1;
    function add_text() 
    {
        var html = '';
        html += '<tr id="row' + rowIdx + '" class="rowtr">';
        html += '<td>' + rowIdx + '</td>';
        html += '<td><div class="col-xs-12"><input type="text" id="item_name_' + rowIdx +'"name="item_name[]" class="item_name form-control" placeholder="Item name" readonly><input type="text"  name="item_no[]" id="item_no_' +
        rowIdx + '" class="item_no_' + rowIdx + '" hidden  placeholder=" Item no"></div></td>';        
        html += '<td><div class="col-xs-12"><input type="text"  id="specification_' + rowIdx +'" name="specification[]" class="specification form-control"></div></td>';         html += '<td><div class="col-xs-12"><input type="text" name="qty[]"  id="qty_' + rowIdx +'" class="qty form-control" readonly ></div></td>';  
        html += '<td><div class="col-xs-12"><input type="text" name="unit[]"  id="unit_' + rowIdx +'" class="unit form-control" readonly ></div></td>';
        html += '<td><div class="col-xs-12"><input type="text" name="pending_qty[]"  id="pending_qty_' + rowIdx +'" class="pending_qty form-control" readonly ></div></td>';  
        html += '<td><div class="col-xs-12"><input type="number" name="used_qty[]"  id="used_qty_' + rowIdx +'" class="used_qty form-control"></div></td>';
          
        html += '<td><div class="col-xs-12"><input type="text" name="remaining_qty[]"  id="remaining_qty_' + rowIdx +'" class="remaining_qty form-control" readonly></div></td>';
        html += '<td><div class="col-xs-12"><input type="number" name="rate_per_qty[]" id="rate_per_qty_' + rowIdx +'" class="rate_per_qty_ form-control" readonly></div></td>';
        
        
        html += '<td><div class="col-xs-12"><input type="text" name="amount[]" id="amount_' + rowIdx +'" class="amount form-control" readonly></div></td>';
               
        html +=
            '<td><button class="btn btn-danger remove btn-sm" id="delete" type="button"><i class="fa fa-trash"></i></button></td>';
        html += '</tr>';
        

        $("#tbody").append(html);
        rowIdx++;
    }
    // add row
    $('#addBtn').on('click', function() 
    { add_text();
    });
// delete row
    $('#tbody').on('click', '.remove', function() 
    {
        // Getting all the rows next to the row containing the clicked button
        var child = $(this).closest('tr').nextAll();
        
        // Iterating across all the rows obtained to change the index
        child.each(function() 
        {
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
        // rowIdx--;
        
    });
    jQuery($ => {
  $(document).on('focus', 'input',  "#project_name", function() {
    $("#project_name").autocomplete({
      source: function(request, response) {
        $.ajax({
          type: "GET",
          url: "{{ route('get_project_boq') }}",
          dataType: "json",
          data: {
            'projectname': $("#project_name").val()
          },
          success: function(data) {
            result = [];
            for (var i in data.project_name) {
              result.push(data.project_name[i]["project_name"]);
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
});
  $(document).on('input', '#project_name', function() {
    updateProjectNameValue($(this).val());
  });

  function updateProjectNameValue(proName) {
    $.ajax({
      type: "GET",
      url: "{{ route('get_project_boq') }}",
      dataType: "json",
      data: {
        'projectname': proName
      },
      success: function(data) {
        console.log(data.project_name);
        console.log(data.project_master_item);
        console.log(data.opening_bal);
          $('#project_no').val(data.project_no);
          $('#opening_bal').val(data.opening_bal);
          for (var i in data.project_name){
            $('#project_cost').val( data.project_name[i]["total_price_cost"]);
      }   
      
          var create_id=1;  
    
            for (const item of data.project_master_item) { 
            add_text();
            $('#item_name_' + create_id).val(item.item_name);
            $('#item_no_' + create_id).val(item.item_no);              
            $('#specification_'+ create_id).text(item.qty); 
            $('#qty_'+ create_id).val(item.qty); 
            $('#pending_qty_'+ create_id).val(item.pending_qty); 
            $('#unit_'+ create_id).val(item.item_unit);           
            $('#rate_per_qty_'+ create_id).val(item.rate_per_qty);              
            create_id++;
            }  
      },
      fail: function(xhr, textStatus, errorThrown) {
        alert(errorThrown);
      }
    });
  }
  $('#source').change(function()
        {
            var selectedOption = $('#source').val();
            if (selectedOption === 'Cheque')
            {
                $('#cheque').show();
                $('#cheque_date').show();

            } else
            {
                $('#cheque').hide();
                $('#cheque_date').hide();

            }

        });
    
  
  $('#tbody').on('input', 'input[id^="used_qty_"], input[id^="rate_per_qty_"]', function() {
  var row = $(this).closest('tr');
  var quantity = parseFloat(row.find('input[id^="qty_"]').val()) || 0;
  var usedQuantity = parseFloat(row.find('input[id^="used_qty_"]').val()) || 0;
  var rate = parseFloat(row.find('input[id^="rate_per_qty_"]').val()) || 0;
  var itemAmount = usedQuantity * rate;
  var receivingQty = quantity - usedQuantity;

  row.find('input[id^="amount_"]').val(itemAmount);
  row.find('input[id^="remaining_qty_"]').val(receivingQty);

  calculateTotal();
  updateCalculation();
});

function calculateTotal() {
  var total = 0;
  $("input[name='amount[]']").each(function() {
    var val = parseFloat($(this).val());
    if (!isNaN(val)) {
      total += val;
    }
  });

  $("#total_amount").val(total.toFixed(2));
  $("#received_amt").val(total.toFixed(2));
  updateCalculation();
}

function updateCalculation() {
  var opening_bal = parseFloat($("#opening_bal").val()) || 0;
  var receivedAmt = parseFloat($("#received_amt").val()) || 0;
  var balanceAmount = opening_bal - receivedAmt;
  $("#balance_amount").val(balanceAmount.toFixed(2));
  
  $("#closing_bal").val(balanceAmount.toFixed(2));
}
// VALIDATION
                var project_Name = @json($projectName);


                $.validator.addMethod("uniqueProjectName", function(value, element) {
                    var lowercaseValue = value.toLowerCase().replace(/\s/g, '');

                    return project_Name.includes(lowercaseValue);
                });
                $.validator.addMethod("checkUsedQty", function(value, element) {
                    var rowIdx = $(element).closest('tr').attr('id').substring(3);
                    var pendingQty = parseFloat($("#pending_qty_" + rowIdx).val());
                    var usedQty = parseFloat(value);

                    return usedQty <= pendingQty;
                });

                var formValidationConfig = {
                    rules: {
                        project_name: {
                            required: true,
                            uniqueProjectName: true
                        },
                        
                        source: {

                            required: true,
                        }, 
                        cheque_no: {
                             required: {
                             depends: function(element) {
                            return $('#source').val() === 'Cheque';
                              }
                            }
                        },
                        cheque_date: {
                            required: {
                                depends: function(element) {
                                    return $('#source').val() === 'Cheque';
                                }
                            }
                        },
                        "used_qty[]":
                        {
                            required: true,
                            checkUsedQty: true
                            
                        }
                    },
                    messages: {
                        project_name: {
                            required: "Please enter the project name",
                            uniqueProjectName: "Please enter valid project name"
                        },
                        source: {
                            required: "Please select source"
                            },
                             cheque_no: {
                                required: "Please enter the cheque number"
                            },
                            cheque_date: {
                                required: "Please select the cheque date"
                            },                       
                       
                       "used_qty[]":
                        {
                            required: "Please enter the used qty",
                            checkUsedQty: "Used quantity cannot be greater than pending quantity"
                        },
                    },
                    errorElement: "error",
                    errorClass: "error-msg",
                    highlight: function(element, errorClass, validClass) {
                        $(element).addClass(errorClass).removeClass(validClass);
                        $(element).closest('.form-group').addClass('has-error');

                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).removeClass(errorClass).addClass(validClass);
                        $(element).closest('.form-group').removeClass('has-error');

                    }
                };

                $("#form").validate(formValidationConfig);
            

</script>
@stop