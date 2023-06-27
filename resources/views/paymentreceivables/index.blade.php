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
        <button type="button" class="btn btn-block btn-primary" onclick="handleDialog()">PCC</button>
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
                                            <th>Invoice No.</th>
                                            <th>Invoice date</th>
                                            <th>Project Name</th>
                                            <th>Invoice Type</th>
                                            <th>Invoice Amount</th>
                                            <th>Due Date</th>
                                            <th>Amount Received</th>
                                            <th data-orderable="false" class="action notexport">Show</th>
                                            <th data-orderable="false" class="action notexport">Edit</th>
                                            <th data-orderable="false" class="action notexport">Delete</th>
                                            <div id="blur-background" class="blur-background"></div>
                                        </tr>
                                    </thead>
                                   
                                </table>
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
            <input type="hidden" id="po_no" name="po_no" value=""/><br>
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
                    
                <div class="container pt-4">
                    <div class="table-responsive">
                        <center><table class="table table-bordered" >
                            <thead>
                                <tr>
                                    <th class="text-center">S.No</th>
                                    <th class="text-center" style="width:20%">Item Name</th>
                                    <th class="text-center" style="width:15%">Specification</th>                                  
                                    <th class="text-center" style="width:12%">Quantity</th>
                                    <th class="text-center" style="width:10%">Unit</th>
                                    <th class="text-center" style="width:10%">Used Qty</th>
                                    <th class="text-center" style="width:12%">Rate Per Quantity</th>                                 
                                    <th class="text-center" style="width:10%">Amount</th>
                                    
                                 
                                </tr>
                            </thead>
                            <tbody id="tbody">
                            </tbody>
                        </table></center>
                    </div>
                </div>
                <div style="text-align: right;">
                    <div style="margin-top: 8px; margin-right: 106px; display: inline-block;">
                        <button class="btn btn-md btn-primary" id="addBtn" type="button">Add Row</button>
                    </div>
                </div>
                <div class="row" style="margin-top:10px;">
  <div class="col-md-2">
    <label for="" class="float-end mt-2 text-end">Total Amount</label><br>
    <label for="" class="float-end mt-3 text-end">Project cost</label><br>
    <label for="" class="float-end my-2 text-end">Received Amount</label>
    <label for="" class="float-end my-3 text-end">Balance Amount</label>
  </div>
  <div class="col-md-4">
    <input type="text" readonly name="total_amount" id="total_amount" class="form-control mb-2" autocomplete="off">
    <input type="text" readonly name="project_cost" id="project_cost" class="form-control mb-2" autocomplete="off">
    <input type="text" readonly name="received_amt" id="received_amt" class="form-control mb-2" autocomplete="off">
    <input type="text" readonly name="balance_amount" id="balance_amount" class="form-control mb-2 total" autocomplete="off">
  </div>
</div>

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
                        <label>Po Code</label>
                        <p id="show_po_code"></p>
                    </div>
                    <div class="col-md-3">
                        <label>Purchase Type</label>
                        <p id="show_po_type"></p>
                    </div>
                    <div class="col-md-3">
                        <label>Date</label>
                        <p id="show_po_date"></p>
                    </div>
                    <div class="col-md-3">
                        <label>Supplier Name</label>
                        <p id="show_name"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label>Contact Person</label>
                        <p id="show_name"></p>
                    </div>
                    <div class="col-md-3">
                        <label>Mobile Number</label>
                        <p id="show_contact_number"></p>
                    </div>                  
                    <div class="col-md-3">
                        <label>Email</label>
                        <p id="show_mail_id"></p>
                    </div>
                    <div class="col-md-3">
                        <label>Website</label>
                        <p id="show_website"></p>
                    </div>                    
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label>Currency</label>
                        <p id="show_currency"></p>
                    </div>          
                    <div class="col-md-3">
                        <label>Quote Reference</label>
                        <p id="show_quote_ref"></p>
                    </div>
                    <div class="col-md-3">
                        <label>Quote Date</label>
                        <p id="show_quote_date"></p>
                    </div>
                    <div class="col-md-3">
                        <label>Credit period</label>
                        <p id="show_credit_period"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label>Payment Terms</label>
                        <p id="show_payment_terms"></p>
                    </div>
                    <div class="col-md-3">
                        <label>Delivery Location</label>
                        <p id="show_site_location"></p>
                    </div>                    
                    <div class="col-md-3">
                        <label>Delivery Terms</label>
                        <p id="show_delivery_terms"></p>
                    </div>
                    <div class="col-md-3">
                        <label>Prepared By</label>
                        <p id="show_firstname"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label>Pull Mr Code</label>
                        <p id="show_mr_reference_code"></p>
                    </div>
                    <div class="col-md-3">
                        <label>Total Amount</label>
                        <p id="show_total_amount"></p>
                    </div>
                    <div class="col-md-3">
                        <label>Misc Expenses</label>
                        <p id="show_misc_expenses"></p>
                    </div>
                    <div class="col-md-3">
                        <label>Freight</label>
                        <p id="show_freight"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label>Discount</label>
                        <p id="show_discount"></p>
                    </div>
                    <div class="col-md-3">
                        <label>Total Discount</label>
                        <p id="show_total_discount"></p>
                    </div>
                    <div class="col-md-3">
                        <label>VAT</label>
                        <p id="show_vat"></p>
                    </div>
                    <div class="col-md-3">
                        <label>VAT Amount</label>
                        <p id="show_total_vat"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label>Grand Total</label>
                        <p id="show_gross_amount"></p>
                    </div>
                    <div class="col-md-3">
                        <label>Attachments</label>
                        <p id="show_filename"></p>
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
              add_text();
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
                $('.toggle input[type="checkbox"]').parent().removeClass('on');
                //  $('.toggle').prop('checked', false);
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
          var rowIdx = 1;
    function add_text() 
    {
        var html = '';
        html += '<tr id="row' + rowIdx + '" class="rowtr">';
        html += '<td>' + rowIdx + '</td>';
        html += '<td><div class="col-xs-12"><input type="text" id="item_name_' + rowIdx +
        '"  name="item_name[]" class="item_name form-control" placeholder="Item name"><input type="text"  name="item_no[]" id="item_no_' +
        rowIdx + '" class="item_no_' + rowIdx + '" hidden  placeholder=" Item no"></div></td>';
        html += '<td><div class="col-xs-12"><input type="text" name="specification[]"  id="specification_' + rowIdx +
            '"name="specification[]" class="specification form-control"></div></td>';
        html += '<td><div class="col-xs-12"><input type="number" name="qty[]"  id="qty_' + rowIdx +
            '"name="qty[]" class="qty form-control"></div></td>';
            
        html += '<td><div class="col-xs-12"><input type="number" name="unit[]"  id="unit_' + rowIdx +
            '"name="unit[]" class="unit form-control"></div></td>';
            html += '<td><div class="col-xs-12"><input type="number" name="used_qty[]"  id="used_qty_' + rowIdx +
            '"name="qty[]" class="qty form-control"></div></td>';
        html += '<td><div class="col-xs-12"><input type="number" name="rate_per_qty[]" id="rate_per_qty_' + rowIdx +
            '"  name="rate_per_qty[]" class="rate_per_qty form-control"></div></td>';
        
        html += '<td><div class="col-xs-12"><input type="text" name="amount[]" id="amount_' + rowIdx +
            '"  name="amount[]" class="amount form-control" readonly></div></td>';
               
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
                    $(document).on('focus', 'input', "#company_name", function() {
                        $("#company_name").autocomplete({
                            source: function(request, response) {
                                $.ajax({
                                    type: "GET",
                                    url: "{{ route('getclientdata') }}",
                                    dataType: "json",
                                    data: {
                                        'company_name': $("#company_name").val()
                                    },
                                    success: function(data) {
                                        result = [];
                                        for (var i in data) {
                                            result.push(data[i]["company_name"]);
                                        }
                                        response(result);
                                    },
                                    fail: function(xhr, textStatus, errorThrown) {
                                        alert(errorThrown);
                                    }
                                });
                            },
                            select: function(event, ui) {
                                var selectedCompanyName = ui.item.value;
                                updateCompanyNameValue(selectedCompanyName);
                            }
                        });
                    });

                    $(document).on('input', '#company_name', function() {
                        updateCompanyNameValue($(this).val());
                    });

                    function updateCompanyNameValue(companyName) {
                        $.ajax({
                            type: "GET",
                            url: "{{ route('getclientdata') }}",
                            dataType: "json",
                            data: {
                                'company_name': companyName
                            },
                            success: function(data) {
                                for (var i in data) {
                                    $('#client_no').val(data[i]["client_no"]);
                                    $('#contact_number').val(data[i]["contact_number"]);
                                    $('#name').val(data[i]["name"]);
                                }
                            },
                            fail: function(xhr, textStatus, errorThrown) {
                                alert(errorThrown);
                            }
                        });
                    }
                });

</script>
@stop