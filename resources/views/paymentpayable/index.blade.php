<!-- STYLE INCLUDED IN LAYOUT PAGE -->
@extends('layouts.app', [
    'activeName' => 'Payment payable',
])
@section('title', 'Payment payable')

@section('content_header')
@stop

@section('content')
    <!-- DATA table -->
    <div class="row">
        <div class="container-fluid">
            <div class="card shadow">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h4 class="font-weight-bold text-dark py">Payment payable</h4>
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

                                    <th>AP Code</th>
                                    <th>Supplier Name</th>
                                    <th>Project Name</th>
                                    <th>Amount</th>
                                    {{-- <th>Payable Amount</th> --}}
                                    <th>Created At</th>
                                    <th data-orderable="false" class="action notexport">Show</th>
                                    <th data-orderable="false" class="action notexport">Edit</th>
                                    <th data-orderable="false" class="action notexport">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payment_payables as $payment_payable)
                                    <tr class="text-center">
                                        <td>{{ $payment_payable->ap_code }}<div id="blur-background"
                                                class="blur-background">
                                            </div>
                                        </td>
                                        <td>{{ $payment_payable->name }}</td>
                                        <td>{{ $payment_payable->project_name }}</td>
                                        <td>{{ $payment_payable->invoice_amount }}</td>
                                        {{-- <td>{{ $payment_payable->payable_amount }}</td> --}}
                                        <td>{{ $payment_payable->created_at }}</td>
                                        <td>
                                            <a onclick="handleShowAndEdit('{{ $payment_payable->ap_no }}','show')"
                                                class="btn btn-primary btn-circle btn-sm" id="method" value="SHOW">
                                                <i class="fas fa-flag"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a onclick="handleShowAndEdit('{{ $payment_payable->ap_no }}','edit')"
                                                class="btn btn-info btn-circle btn-sm mx-2">
                                                <i class="fas fa-check"></i>
                                            </a>
                                        </td>
                                        <td>

                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="handleDelete('{{ $payment_payable->ap_no }}')">
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


            <dialog id="myDialog" style="width:1000px;">
                <div class="row">
                    <div class="col-md-12">
                        <a class="btn btn-sm" onclick="handleClose()" style="float:right;padding: 10px 10px;"><i
                                class="fas fa-close"></i></a>
                        <h4 id='heading_name' style='color:white' align="center"><b>Update Payment Payable Details</b></h4>
                    </div>
                </div>

                <form class="form-row" enctype="multipart/form-data" style="display: block" id="form">
                    <input type="hidden" id="method" value="ADD" />
                    <input type="hidden" id="ap_no" name="ap_no" value="" /><br>

                    {!! csrf_field() !!}
                    <h4 class="text-primary text-center"><b>Pay Amount</b></h4>
                    <div class="row">

                        <div class="form-group col-md-6">
                            <label for="project_name" class="form-label fw-bold">Project Name<a
                                    style="text-decoration: none;color:red">*</a></label>
                            <input type="text" id="project_name" name="project_name" value="{{ old('project_name') }}"
                                placeholder="Project Name" class="form-control" autocomplete="off">
                            <input type="text" id="project_no" hidden name="project_no" value="{{ old('project_no') }}"
                                class="form-control" />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="name" class="form-label fw-bold">Supplier Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                placeholder="Supplier Name" class="form-control" autocomplete="off"
                                onchange="showQuantityField()" readonly>
                            <input type="text" hidden id="supplier_no" name="supplier_no" value="{{ old('supplier_no') }}"
                                placeholder="Supplier Id" class="form-control" autocomplete="off">
                        </div>
                    </div>

                    <div class="container pt-4">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="register">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th style="width:15%">Date</th>
                                        <th>Grn No</th>
                                        <th>Amount</th>
                                        {{-- <th>Payable Amount</th> --}}
                                        <th>Payment Type</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="tbody1">
                                </tbody>
                            </table>
                        </div>
                        <br>
                    </div>


                </form>

                <!-- SHOW DIALOG -->
                <div class="card" id="show" style="display:none">
                    <div class="card-body" style="background-color:white;width:100%;height:20%;">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Project Name</label>
                                <p id="show_project_name"></p>
                            </div>
                            <div class="col-md-4">
                                <label>Supplier Name</label>
                                <p id="show_name"></p>
                            </div>
                            <div class="col-md-4">
                                <label>grn date</label>
                                <p id="show_grn_date"></p>
                            </div>
                            <div class="col-md-4">
                                <label>AP Code</label>
                                <p id="show_ap_code"></p>
                            </div>
                            <div class="col-md-4">
                                <label>Grn Code</label>
                                <p id="show_grn_code"></p>
                            </div>
                            <div class="col-md-4">
                                <label>Invoice Amount</label>
                                <p id="show_invoice_amount"></p>
                            </div>

                            <div class="col-md-4">
                                <label>Payment Mode</label>
                                <p id="show_payment_mode"></p>
                            </div>
                            <div class="col-md-4">
                                <label>Cheque No</label>
                                <p id="show_cheque_no"></p>
                            </div>
                            <div class="col-md-4">
                                <label>Cheque Date</label>
                                <p id="show_cheque_date"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </dialog>

            <script>
                // Add dynamic row
                var rowIdx = 1;

                function add_text() {
                    var html = '';
                    html += '<tr id="row' + rowIdx + '" class="rowtr">';
                    html += '<td>' + rowIdx + '</td>';
                    html += '<td><div class="col-xs-12"><input type="text" id="grn_date_' + rowIdx +
                        '" name="grn_date[]" class="grn_date form-control" placeholder="Grn date"></div></td>';
                    html += '<td hidden><div class="col-xs-12"><input type="text" id="grn_no_' + rowIdx +
                        '" name="grn_no[]" class="grn_no form-control" required></div></td>';
                    html += '<td><div class="col-xs-12"><input type="text" id="grn_code_' + rowIdx +
                        '" name="grn_code[]" class="grn_code form-control"></div></td>';
                    html += '<td><div class="col-xs-12"><input type="text" id="invoice_amount_' + rowIdx +
                        '" name="invoice_amount[]" readonly class="invoice_amount form-control"></div></td>';
                    // html += '<td><div class="col-xs-12"><input type="text" id="payable_amount_' + rowIdx +
                    //     '" name="payable_amount[]"  class="payable_amount form-control"></div></td>';
                    html += '<td><div class="col-xs-12"><select id="payment_mode_' + rowIdx +
                        '" name="payment_mode[]" class="payment_mode form-control" onchange="toggleChequeFields(' + rowIdx +
                        ', this)"><option value="">Select Option</option><option value="cheque">Cheque</option><option value="cash">Cash</option></select></div></td>';
                    html += '<td><button id="submit' + rowIdx + '" class="btn btn-primary mx-3 mt-3 pay-button" onclick="handleSubmit(' + rowIdx + ')">Pay</button></td>';
                    html += '</tr>';

                    html += '<tr id="cheque_row_' + rowIdx + '" class="rowtr cheque-row" style="display: none;">';
                    html += '<td></td>';
                    html += '<td colspan="2"><div class="col-xs-12"><input type="text" id="cheque_no_' + rowIdx +
                        '" name="cheque_no[]" class="cheque_no form-control" placeholder="Cheque number"></div></td>';
                    html += '<td colspan="2"><div class="col-xs-12"><input type="date" id="cheque_date_' + rowIdx +
                        '" name="cheque_date[]" class="cheque_date form-control" placeholder="Cheque date"></div></td>';
                    html += '<td></td>';
                    html += '</tr>';

                    $("#tbody1").append(html);

                    rowIdx++;
                }


                function toggleChequeFields(rowIdx, selectElement) {
                    var chequeRow = document.getElementById('cheque_row_' + rowIdx);
                    if (selectElement.value === 'cheque') {
                        chequeRow.style.display = '';
                    } else {
                        chequeRow.style.display = 'none';
                    }
                }

                // dialog open
                function handleDialog() {
                    document.getElementById("myDialog").open = true;
                    window.scrollTo(0, 0);
                    $('#method').val("ADD");
                    $('#submit').text("Save");
                    $('#heading_name').text("Add Payment Payable Details").css('font-weight', 'bold');
                    $("#lable_ap_code").hide();
                    $("#ap_code").hide();
                    $('#show').css('display', 'none');
                    $('#form').css('display', 'block');
                    $('#blur-background').css('display', 'block');
                }

                // dialog close
                function handleClose() {
                    document.getElementById("myDialog").open = false;
                    $("#myDialog").load(location.href + " #myDialog > *");
                    rowIdx = 1;
                    // // Clear the form fields
                    $('#form')[0].reset();


                    // Hide any error messages
                    $('.error-msg').removeClass('error-msg');
                    $('.has-error').removeClass('has-error');
                    // Hide any error messages
                    $('error').html('');
                    // Hide the dialog background
                    $('#blur-background').css('display', 'none');
                    // Refresh the page if the method is 'ADD'
                    if ($('#method').val() === 'ADD') {
                        window.location.reload();
                    }
                    if ($('#method').val() === 'SHOW') {
                        location.reload(false);
                    }

               }


                // DELETE FUNCTION
                function handleDelete(id) {
                    let url = '{{ route('paymentpayableApi.delete', ':id') }}';
                    url = url.replace(':id', id);
                    if (confirm("Are you sure you want to delete this payment payable Details?")) {
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            success: function(message) {
                                alert(message);
                                window.location.reload();
                            },
                        })
                    }
                }
                // DIALOG SUBMIT FOR ADD AND EDIT
                function handleSubmit(rowIdx) {
                    event.preventDefault();

                    let form_data = new FormData();
                    let method = $('#method').val();
                    let url;
                    let type;

                    // Validate the form fields before submitting

                    // var payableAmount = $('#payable_amount_' + rowIdx).val();
                    var paymentMode = $('#payment_mode_' + rowIdx).val();
                    var chequeNo = $('#cheque_no_' + rowIdx).val();
                    var chequeDate = $('#cheque_date_' + rowIdx).val();



                    if (paymentMode === '') {
                        alert('Please select a payment mode in row ' + rowIdx);
                        return;
                    }

                    if (paymentMode === 'cheque') {
                        if (chequeNo === '') {
                            alert('Please enter a cheque number in row ' + rowIdx);
                            return;
                        }

                        if (chequeDate === '') {
                            alert('Please enter a cheque date in row ' + rowIdx);
                            return;
                        }
                    }

                    // Add the specific row data to the form_data
                    form_data.append('grn_date', $('#grn_date_' + rowIdx).val());
                    form_data.append('grn_no', $('#grn_no_' + rowIdx).val());
                    form_data.append('invoice_amount', $('#invoice_amount_' + rowIdx).val());
                    // form_data.append('payable_amount', $('#payable_amount_' + rowIdx).val());
                    form_data.append('payment_mode', $('#payment_mode_' + rowIdx).val());

                    // Check the payment mode to add additional data if necessary

                    if (paymentMode === 'cheque') {
                        form_data.append('cheque_no', $('#cheque_no_' + rowIdx).val());
                        form_data.append('cheque_date', $('#cheque_date_' + rowIdx).val());
                    }

                    // Add the project_no to the form_data
                    form_data.append('project_no', $('#project_no').val());
                    form_data.append('supplier_no', $('#supplier_no').val()); // Access project_no directly

                    if (method == 'ADD') {
                        url = '{{ route('paymentpayableApi.store') }}';
                        type = 'POST';
                    } else {
                        let id = $('#ap_no').val();
                        url = '{{ route('paymentpayableApi.update', ':id') }}';
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
                        success: function(message) {
                            alert(message);
                            // handleClose(); // Close the dialog
                            // window.location.reload();
                            var clickedButtonId = 'submit' + rowIdx;
                            $('#' + clickedButtonId).prop('disabled', true);


                        },

                        error: function(message) {
                            var data = message.responseJSON;
                        }
                    });
                }



                // DATA SHOW FOR EDIT AND SHOW
                function handleShowAndEdit(id, action) {
                    let url = "{{ route('paymentpayableApi.show', ':ap_no') }}";
                    url = url.replace(':ap_no', id);
                    let type = "GET";
                    console.log(id);
                    $.ajax({
                        url: url,
                        type: type,
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function(message) {
                            console.log(message.payment_payables);
                            if (action == 'edit') {
                                $('#show').css('display', 'none');
                                $('#form').css('display', 'block');
                                $('#blur-background').css('display', 'block');
                                add_text();

                                // Assuming you have retrieved the payment_mode value from somewhere
                                var paymentMode = message.payment_payables[0].payment_mode;
                                console.log(message.payment_payables[0].payment_mode);

                                // Check if payment_mode is 'cheque'
                                if (paymentMode === 'cheque') {
                                    // Enable the cheque_no and cheque_date fields
                                    $('#cheque_no_' + (rowIdx - 1)).prop('disabled', false).closest('.cheque-row')
                                        .show();
                                    $('#cheque_date_' + (rowIdx - 1)).prop('disabled', false).closest('.cheque-row')
                                        .show();
                                    // JavaScript code
                                    var chequeDate = message.payment_payables[0].cheque_date;
                                    var chequeDateObj = new Date(chequeDate);
                                    var chequeDay = chequeDateObj.getDate();
                                    var chequeMonth = chequeDateObj.getMonth() + 1;
                                    var chequeYear = chequeDateObj.getFullYear();
                                    var formattedChequeDate = chequeYear + '-' + ('0' + chequeMonth).slice(-2) + '-' + (
                                        '0' + chequeDay).slice(-2);
                                    console.log(formattedChequeDate);
                                    $('#cheque_date_' + (rowIdx - 1)).val(formattedChequeDate);

                                    // Retrieve and set the values for cheque_no and cheque_date fields
                                    $('#cheque_no_' + (rowIdx - 1)).val(message.payment_payables[0].cheque_no);


                                } else {
                                    // Disable the cheque_no and cheque_date fields
                                    $('#cheque_no_' + (rowIdx - 1)).prop('disabled', false).closest('.cheque-row')
                                        .hide();
                                    $('#cheque_date_' + (rowIdx - 1)).prop('disabled', false).closest('.cheque-row')
                                        .hide();
                                }

                                // Rest of your code...
                                for (const [key, value] of Object.entries(message.payment_payables[0])) {
                                    console.log(message.payment_payables[0]);
                                    console.log(`${key}: ${value}`);

                                    $(`#${key}`).val(value);
                                }
                                //

                                // Format the grn_date value
                                var grnDate = message.payment_payables[0].grn_date;
                                var grnDateObj = new Date(grnDate);
                                var grnDay = grnDateObj.getDate();
                                var grnMonth = grnDateObj.getMonth() + 1;
                                var grnYear = grnDateObj.getFullYear();
                                var formattedGrnDate = grnDay + '-' + grnMonth + '-' + grnYear;

                                // Set the formatted grn_date value
                                $('#grn_date_' + (rowIdx - 1)).val(formattedGrnDate);
                                $('#grn_no_' + (rowIdx - 1)).val(message.payment_payables[0].grn_no);
                                $('#grn_code_' + (rowIdx - 1)).val(message.payment_payables[0].grn_code);
                                $('#invoice_amount_' + (rowIdx - 1)).val(message.payment_payables[0].invoice_amount);
                                // $('#payable_amount_' + (rowIdx - 1)).val(message.payment_payables[0].payable_amount);
                                $('#payment_mode_' + (rowIdx - 1)).val(message.payment_payables[0].payment_mode);

                                $('#method').val('UPDATE');
                                $('#submit').text('UPDATE');
                            } else {
                                for (const [key, value] of Object.entries(message.payment_payables[0])) {
                                    if (key === "grn_date" || key === "date") {
                                        var dateObj = new Date(value);
                                        var day = dateObj.getDate();
                                        var month = dateObj.getMonth() + 1;
                                        var year = dateObj.getFullYear();
                                        datepr = day + '-' + month + '-' + year;
                                    }
                                    $(`#show_${key}`).text(value);
                                }
                                $('#show_table').remove();
                                $('#heading_name').text("View Payment Payable Details").css('font-weight', 'bold');
                                $('#show').css('display', 'block');
                                $('#form').css('display', 'none');
                                $('#blur-background').css('display', 'block');
                            }
                            document.getElementById("myDialog").open = true;
                            window.scrollTo(0, 0);
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                }

                jQuery($ => {
                    $(document).on('focus', '#project_name', function() {
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
                                        var result = [];
                                        for (var i in data) {
                                            var project = {
                                                label: data[i]["project_name"],
                                                value: data[i]["project_no"]
                                            };
                                            result.push(project);
                                        }
                                        response(result);
                                    },
                                    error: function(xhr, textStatus, errorThrown) {
                                        alert(errorThrown);
                                    }
                                });
                            },
                            select: function(event, ui) {
                                $("#project_name").val(ui.item.label);
                                $("#project_no").val(ui.item.value);
                                return false;
                            }
                        });


                        $("#project_name").on('change', function() {
                            var selectedProject = $(this).val();
                            if (selectedProject === '') {
                                $("#project_no").val('');
                                return;
                            }

                            $.ajax({
                                type: "GET",
                                url: "{{ route('get_grn_data') }}",
                                dataType: "json",
                                data: {
                                    'project_no': $('#project_no').val(),
                                },
                                success: function(data) {
                                    $('#supplier_no').val(data.data1[0].supplier_no);
                                    $('#name').val(data.data1[0].name);

                                    var create_id = 1;
                                    for (const item of data.data1) {
                                        add_text();
                                        console.log(data.data1);


                                        $('#grn_date_' + create_id).val(item.grn_date);
                                        $('#grn_code_' + create_id).val(item.grn_code);
                                        $('#grn_no_' + create_id).val(item.grn_no);
                                        $('#invoice_amount_' + create_id).val(item
                                        .total_amount);
                                        create_id++;
                                    }
                                    rowIdx = 1;
                                },
                                error: function(xhr, textStatus, errorThrown) {
                                    alert(errorThrown);
                                }
                            });
                        });
                    });
                });

                // Initialize form validation
                var project_name = @json($project_name);
                $.validator.addMethod("projectNameCheck", function(value, element) {

                    return project_name.includes(value);
                });
                var formValidationConfig = {
                    rules: {


                        payment_mode: "required",
                        project_name: {
                            required: true,
                            projectNameCheck: true
                        },

                    },
                    messages: {


                        payment_mode: "Please enter the year",
                        project_name: {
                            required: "Please enter the project name",
                            projectNameCheck: "Please enter a valid Project Name. "
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