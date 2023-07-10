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
                            <a class="btn  btn-sm" id="closeButton" onclick="handleClose()" style="float:right;padding: 10px 10px;"><i class="fas fa-close"></i></a>
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
                    <div id="cheque_no-error" class="error-msg" style="display: none; color: red;"></div>
                </div>
                <div class="form-group col-md-4"   id='cheque_date1' style="display: none;">
                    <label for="cheque_date" class="form-label fw-bold">Cheque Date<a style="text-decoration: none;color:red">*</a></label>
                    <input type="date" id="cheque_date"  name="cheque_date" value="{{ old('cheque_date') }}" placeholder="Cheque Date" class="form-control" autocomplete="off">
                    <div id="cheque_date-error" class="error-msg" style="display: none; color: red;"></div>
                </div>
            </div>
            <div class="row"> 
                <div class="form-group col-md-4">
                    <label for="source" class="form-label fw-bold">Opening Balance<a style="text-decoration: none;color:red">*</a></label>
                    <input type="text" readonly name="opening_bal" id="opening_bal" class="form-control mb-2" autocomplete="off">                 
                </div>
                <div class="form-group col-md-4">
                    <label for="item_amount" class="form-label fw-bold">Item Amount</label>
                    <input type="text" readonly name="item_amount" id="item_amount" class="form-control mb-2" autocomplete="off">                 
                </div>
                <div class="form-group col-md-4">
                    <label for="vat_amount" class="form-label fw-bold">VAT amount</label>
                    <input type="text" readonly name="vat_amount" id="vat_amount" class="form-control mb-2" autocomplete="off">                 
                </div>
              
            </div>
            <div class="row"> 
            <div class="form-group col-md-4">
                <label for="total_amount" class="form-label fw-bold">Total Amount</label>
                <input type="text" readonly name="total_amount" id="total_amount" class="form-control mb-2" autocomplete="off">
                </div>
                <div class="form-group col-md-4">
                <label for="project_cost" class="form-label fw-bold">Project cost</label>
                <input type="text"readonly  name="project_cost" id="project_cost" class="form-control mb-2" autocomplete="off">
                </div>
                <div class="form-group col-md-4">
                <label for="" class="form-label fw-bold">Received Amount</label>
                <input type="text" readonly name="received_amt" id="received_amt" class="form-control mb-2" autocomplete="off">
                </div>
      
            </div>
            <div class="row"> 
            <div class="form-group col-md-4">
                <label for="" class="form-label fw-bold">Balance Amount</label>
                <input type="text" readonly name="balance_amount" id="balance_amount" class="form-control mb-2 total" autocomplete="off">
                </div>
                <div class="form-group col-md-4">
                <label for="" class="form-label fw-bold">Closing Balance</label>
                <input type="text" readonly name="closing_bal" id="closing_bal" class="form-control mb-2" autocomplete="off">
                </div>
                <div class="form-group col-md-4">
                <label for="receivables_code" id="code_lable"class="form-label fw-bold">Receivables Code</label>
                <input type="text" id="receivables_code" name="receivables_code" readonly value="{{ old('Receivables Code') }}" placeholder="Client Code" class="form-control mb-2" autocomplete="off">
                </div>
            </div>             
            <div class="row mt-3">
                <div class="col-md-12 d-flex justify-content-center">
                    <button id="submit" class="btn btn-primary mx-3 mt-3">Submit</button>
                    <button type="button" id='ppc' class="btn btn-primary mx-3 mt-3"
                        onclick="addForm()">PPC</button>
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
                        <label>Opening Balanace</label>
                        <p id="show_opening_bal"></p>
                    </div>    
                    <div class="col-md-3">
                        <label>Item Amount</label>
                        <p id="show_item_amount"></p>
                    </div>
                    
                    
                </div>     
                <div class="row">
                <div class="col-md-3">
                        <label>VAT Amount</label>
                        <p id="show_vat_amount"></p>
                    </div>  
                <div class="col-md-3">
                        <label>Received Amt</label>
                        <p id="show_received_amt"></p>
                    </div>
                    <div class="col-md-3">
                        <label>Balanace Amount</label>
                        <p id="show_balance_amount"></p>
                    </div>
                    <div class="col-md-3">
                        <label>Closing Balanace</label>
                        <p id="show_closing_bal"></p>
                    </div>
                </div>  
                <div class="row">
                    <div class="col-md-3">
                        <label>Receivables Code</label>
                        <p id="show_receivables_code"></p>
                    </div>  
                </div> 
                
                
                <div id="item_details_show"></div>
            </div>
        </div>
    </dialog>

    {{-- pcc dialog --}}
    <dialog id="myDialog1" class="ppc_form">
        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-sm" id='closeButton' onclick="handleClose1()" style="float:right;padding: 10px 10px;">
                    <i class="fas fa-close"></i>
                </a>
                <img id="header_image" class="print-header-image" src="vendor/adminlte/dist/img/al borj.jpeg"
                    width="100%" height="120" />

                <h4 id="heading_name" style="color: white; background-color:#45A6F2;" align="center">
                    <b>Progress Payment Certificate</b>
                </h4>


            </div>
        </div>


        <div class="card-body" style="background-color: white; width: 100%; height: 20%;">
            <div class="row table-bordered">
                <div class="col-md-6 column-border">
                    <label>Subcontractor</label>
                    <p id="project_name1"></p>
                </div>
                <div class="col-md-6">
                    <label>Certificate No</label>
                    <p id="certify_no"></p>
                </div>
            </div>
            <div class="row table-bordered">
                <div class="col-md-6 column-border">
                    <label>BOQ No</label>
                    <p id="boq_no"></p>
                </div>
                <div class="col-md-6">
                    <label>Date</label>
                    <p id="date"></p>
                </div>
            </div>
            <div class="row table-bordered">
                <div class="col-md-6 column-border">
                    <label>BOQ Value Total (excl. tax)</label>
                    <p id="boq_value"></p>
                </div>
                <div class="col-md-6">
                    <label>Currency</label>
                    <p>AED</p>
                </div>
            </div>
        </div>

        <style>
            .column-border {
                border-right: 1px solid #beb8b8;
            }
        </style>


        <div class="container pt-4">
            <div class="table-responsive">
                <center>
                    <table class="table table-bordered">
                        <tr>
                            <td>
                                <label>Description</label>
                            </td>
                            <td>
                                <label>Work included in form of tender</label>
                            </td>
                            <td>
                                <label>Value of Extra Work
                                    Authorization</label>
                            </td>
                            <td>
                                <label>Total Value<br>
                                    (F.O.T. + E.W.A.) </label>
                            </td>

                        </tr>
                        <tr>
                        <tr>
                            <td class="text-bold">Value of work
                                completed to date </td>
                            <td>
                                <p id="received_amt1"></p>
                            </td>
                            <td>
                                <p id="variation"></p>
                            </td>
                            <td>
                                <p id="total_value"></p>
                            </td>
                        </tr>
                        </tr>
                        <tr>
                        <tr>
                            <td class="text-bold">Gross value of work completed to
                                date </td>
                            <center>
                                <td>
                                    <p id="gross_value"></p>
                                </td>
                            </center>

                        </tr>
                        </tr>
                    </table>
                </center>
            </div>
            <div class="container pt-4">
                <div class="row">
                    <div class="col-md-6">
                        <div>
                            <label>Rentention Rate</label>
                            <p id="rentention_rate"></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div>
                            <label>Net value of work completed to date</label>
                            <p id="net_value"></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div>
                            <label>Deduct previous payments</label>
                            <p id="pre_value"></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div>
                            <label>Amount due for payment (excl tax)</label>
                            <p id="due_amount"></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-3">
                <p>Certified that the amount stated above is now due to the subcontractor in accordance with the terms of
                    the contract.</p>
            </div>
            <div class="row table-bordered">
                <p>Accepted for Company</p>
            </div>
            <div class="row table-bordered">
                <div class="col-md-6 column-border">
                    <label>Subcontracts/Control Manager</label>
                    <p id="project_name1"></p>
                </div>
                <div class="col-md-6">
                    <label>Date</label>
                    <p id="item_amount1"></p>
                </div>
            </div>
            <div class="row table-bordered">
                <p></p>
            </div>
            <div class="row table-bordered">
                <div class="col-md-6 column-border">
                    <label>Project Construction Manager</label>
                    <p id="boq_no"></p>
                </div>
                <div class="col-md-6">
                    <label>Date</label>
                    <p id=""></p>
                </div>
            </div>
            <div class="row table-bordered">
                <p></p>
            </div> <!-- Empty Row -->
            <div class="row table-bordered">
                <div class="col-md-6 column-border">
                    <label>Accepted for Client</label>
                    <p id=""></p>
                </div>
                <div class="col-md-6">
                    <label>Date</label>
                    <p></p>
                </div>
            </div>
            <div class="row table-bordered">
                <p></p>
            </div><!-- Empty Row -->
            <div><img id="footer_image" class="print-footer-image" src="vendor/adminlte/dist/img/footer.png"
                    width="100%" height="100" /></div>

            <button type="button" id="print" class="btn btn-primary float-end">Print</button>
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
             $('#method').val("ADD");
             $('#submit').text("Save");
             $('#heading_name').text("Add Payment Receivables Details").css('font-weight', 'bold');
             $('#code_lable').hide();
             $('#receivables_code').hide();
             $('#show').css('display','none');
             $('#form').css('display','block');
             $('#blur-background').css('display','block');
             updatePPCButton();

          }
// update ppc button
function updatePPCButton() {
            var projectName = $('#project_name').val();
            var usedQty = $('.used_qty').val();

            if (projectName && usedQty) {
                // Enable PPC button
                $('#ppc').prop('disabled', false);
            } else {

                // Disable PPC button
                $('#ppc').prop('disabled', true);
            }
        }

        //pcc dialog
        $('#ppc').prop('disabled', true);

        function addForm() {

            var dialog = document.getElementById('myDialog1');
            window.scrollTo(0, 0);
            dialog.showModal();
            // Scroll to the top of the dialog
            dialog.scrollTop = 0;

            $('#project_name1').empty();
            $('#boq_no').empty();
            $('#boq_value').empty();
            $('#rentention_rate').empty();
            $('#certify_no').empty();
            $('#net_value').empty();
            $('#received_amt1').empty();
            $('#variation').empty();
            $('#total_value').empty();
            $('#pre_value').empty();
            $('#due_amount').empty();
            $('#date').empty();
            $('#gross_value').empty();

            var projectName = $('#project_name').val();
            $.ajax({
                type: "GET",
                url: "{{ route('get_project_boq') }}",
                dataType: "json",
                data: {
                    'projectname': projectName
                },
                success: function(data) {
                    console.log(data.project_name1[0]);
                    console.log(data.project_name1[0].received_amt_sum);
                    $('#project_name1').text(data.project_name1[0].project_name);
                    $('#boq_no').text(data.project_name1[0].project_code);
                    $('#boq_value').text(data.project_name1[0].total_price_cost);
                    $('#rentention_rate').text(data.project_name1[0].retention);
                    $('#certify_no').text(data.project_name1[0].receivables_code);
                    $('#pre_value').text(data.project_name1[0].received_amt_sum);
                    $('#received_amt1').text($("#received_amt").val());

                    // total_value, net_value,gross_value calculation.

                    var total_amount = data.project_name1[0]
                    .total_price_cost; // Replace with your actual total amount value
                    var balance_amount = data.project_name1[0]
                    .balance_amount; // Replace with your actual balance amount value

                    if (balance_amount > total_amount) {
                        $('#variation').text(balance_amount - total_amount);
                    } else {
                        $('#variation').text(0);
                    }
                    var received_amt = parseFloat($("#received_amt")
                .val()); // Parse the received_amt value as an integer
                    var variation = parseFloat($('#variation')
                .text()); // Parse the variation value as an integer

                    var sum = received_amt + variation;
                    $('#total_value').text(sum);
                    $('#net_value').text(sum);
                    $('#gross_value').text(sum);
                    //due amount
                    var boqValue = data.project_name1[0]
                    .total_price_cost; // Get the value from $('#boq_value') and parse it as a float
                    var totalValue = $('#total_value')
                .text(); // Get the value from $('#total_value') and parse it as a float
                    var dueAmount = boqValue - totalValue;

                    $('#due_amount').text(dueAmount);
                    // date format changes

                    var createdDate = new Date(data.project_name1[0].created_at);
                    var day = createdDate.getDate().toString().padStart(2, '0');
                    var month = (createdDate.getMonth() + 1).toString().padStart(2, '0');
                    var year = createdDate.getFullYear().toString();
                    var formattedDate = day + '-' + month + '-' + year;

                    $('#date').text(formattedDate);


                },
                error: function(xhr, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        }

        //print function
        document.getElementById("print").addEventListener("click", function() {
            $('#heading_name').css('color', 'black').css('font-weight', 'bold');
            $('.ppc_form').css('overflow', 'hidden'); // Hide scrollbars for your form

            var headerImage = document.getElementById("header_image");
            var footerImage = document.getElementById("footer_image");

            headerImage.classList.toggle('print-header-image'); // Hide the header image in print preview
            footerImage.classList.toggle('print-footer-image'); // Hide the footer image in print preview

            var originalHeadingText = $('#heading_name').text(); // Store the original heading text

            // Update the heading text for print preview
            $('#heading_name').text('Print Preview Heading');

            window.print();

            headerImage.classList.toggle('print-header-image'); // Restore the header image after printing
            footerImage.classList.toggle('print-footer-image'); // Restore the footer image after printing

            // Restore the original heading text
            $('#heading_name').text(originalHeadingText);

            $('.ppc_form').css('overflow', 'auto'); // Restore scrollbars for your form
            $('#heading_name').css('color', 'white').css('font-weight', 'bold');
        });



        function handleClose1() {
            var dialog = document.getElementById("myDialog1");
            dialog.close();
        }

// dialogclose
function handleClose(){
            document.getElementById("myDialog").open = false;
                // Clear the form fields
                $('#form')[0].reset();
                $('#cheque').hide();
                $('#cheque_date1').hide();
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
                 // Disable the submit button
                 $('#submit').prop('disabled', true);
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

                alert(response); 
                  if (method == 'ADD'){
                $('#heading_name').css('color', 'black').css('font-weight', 'bold');
                window.print();
                 $('#heading_name').css('color', 'white').css('font-weight', 'bold');
                 }
                window.location.reload();
                },
                error: function (xhr, status, error) {
                var errorMessage = xhr.responseText; // Get the error message from the response
                    // Disable the submit button
                    $('#submit').prop('disabled', false);                }
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
                                    console.log($(`#${key}`).val(value));
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
                                $('#ppc').hide(); // Hide the submit button in the update form
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
        html += '<td><div class="col-xs-12"><input type="text" name="used_qty[]"  id="used_qty_' + rowIdx +'" class="used_qty form-control"></div></td>';
        html += '<td><div class="col-xs-12"><input type="text" name="remaining_qty[]"  id="remaining_qty_' + rowIdx +'" class="remaining_qty form-control" readonly></div></td>';
        html += '<td><div class="col-xs-12"><input type="text" name="rate_per_qty[]" id="rate_per_qty_' + rowIdx +'" class="rate_per_qty_ form-control" readonly></div></td>';
        html += '<td><div class="col-xs-12"><input type="text" name="amount[]" id="amount_' + rowIdx +'" class="amount form-control" readonly></div></td>';
        html += '<td><button class="btn btn-danger remove btn-sm" id="delete" type="button"><i class="fa fa-trash"></i></button></td>';
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
                $('#cheque_date1').show();

            } else
            {
                $('#cheque').hide();
                $('#cheque_date1').hide();

            }

        });
    
  
  $('#tbody').on('input', 'input[id^="used_qty_"], input[id^="rate_per_qty_"]', function() {
  var row = $(this).closest('tr');
  var quantity = parseFloat(row.find('input[id^="pending_qty_"]').val()) || 0;
  var usedQuantity = parseFloat(row.find('input[id^="used_qty_"]').val()) || 0;
  var rate = parseFloat(row.find('input[id^="rate_per_qty_"]').val()) || 0;
  var itemAmount = usedQuantity * rate;
  var receivingQty = quantity - usedQuantity;

  row.find('input[id^="amount_"]').val(itemAmount);
  row.find('input[id^="remaining_qty_"]').val(receivingQty);

  calculateTotal();
  updateCalculation();
  updatePPCButton();
});

function calculateTotal() {
  var total = 0;
  $("input[name='amount[]']").each(function() {
    var val = parseFloat($(this).val());
    if (!isNaN(val)) {
      total += val;
    }
  });
  var vat = total * 0.05; // Calculate VAT amount (5% of the total)
    var totalWithVat = total + vat; 
  $("#item_amount").val(total.toFixed(2));
  $("#vat_amount").val(vat.toFixed(2));
  $("#total_amount").val(totalWithVat.toFixed(2));
  $("#received_amt").val(totalWithVat.toFixed(2));
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
                $(document).ready(function() {
            $("#source").on("focusout", function() {
                var source  = $(this).val().trim();
                
                if (source === "Cheque") {
                    if($("#cheque_no").val() == ""){
                        $("#cheque_no-error").text("Please enter the cheque number");
                        $("#cheque_no-error").show();
                    }
                    else {
                        $("#cheque_no-error").hide();                  
                    }

                if($("#cheque_date").val() == ""){
                    $("#cheque_date-error").text("Please select the cheque date");               
                        $("#cheque_date-error").show();
                }    
                else   {
                    $("#cheque_date-error").hide();
                }
            }
            });
            $("#cheque_no").on("focusout", function() {
                if($("#cheque_no").val() != ""){
                        $("#cheque_no-error").hide();                  
                    }
                });

                $("#cheque_date").on("focusout", function() {
                    console.log($("#cheque_date").val());
                    if($("#cheque_date").val() != "")
                    {
                    $("#cheque_date-error").hide();
                }
            
             });
           
             });
                $("#form").validate(formValidationConfig);
            

</script>
@stop