<!-- STYLE INCLUDED IN LAYOUT PAGE -->
@extends('layouts.app', [
    'activeName' => 'PayRoll',
])
@section('title', 'Pay Roll')

@section('content_header')
@stop

@section('content')
    <!-- DATA table -->
    <div class="row">
        <div class="container-fluid">
            <div class="card shadow">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h4 class="font-weight-bold text-dark py">Pay Roll</h4>
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

                                    <th>Employee Name</th>
                                    <th>Designation</th>
                                    <th>Department</th>
                                    {{-- <th>Project Name</th> --}}
                                    <th data-orderable="false" class="action notexport">Show</th>
                                    <th data-orderable="false" class="action notexport">Edit</th>
                                    <th data-orderable="false" class="action notexport">Delete</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($payrolls as $payroll)
                                    <tr class="text-center">
                                        <td>{{ $payroll->firstname }}<div id="blur-background" class="blur-background">
                                            </div>
                                        </td>
                                        <td>{{ $payroll->depart }}</td>
                                        <td>{{ $payroll->project_name }}</td>
                                        <td>
                                            <a onclick="handleShowAndEdit('{{ $payroll->id }}','show')"
                                                class="btn btn-primary btn-circle btn-sm">
                                                <i class="fas fa-flag"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a onclick="handleShowAndEdit('{{ $payroll->id }}','edit')"
                                                class="btn btn-info btn-circle btn-sm mx-2">
                                                <i class="fas fa-check"></i>
                                            </a>
                                        </td>
                                        <td>

                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="handleDelete('{{ $payroll->id }}')">
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
            <dialog id="myDialog" style="width:1000px;">
                <div class="row">
                    <div class="col-md-12">
                        <a class="btn  btn-sm" onclick="handleClose()" style="float:right;padding: 10px 10px;">
                            <i class="fas fa-close"></i>
                        </a>
                        <h4 id='heading_name' style='color:white' align="center"><b>Update Payroll Details</b></h4>
                    </div>
                </div>

                <form class="form-row" enctype="multipart/form-data" style="display:block" id="form" onsubmit="handleSubmit()">
                    <input type="hidden" id="method" value="ADD" />
                    <input type="hidden" id="id" name="id" value="" /><br>

                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="employee_name" class="form-label fw-bold">Employee Name<a style="text-decoration: none;color:red">*</a></label>
                            <input type="text" id="firstname" name="firstname" value="{{ old('firstname') }}" Placeholder="Employee Name" class="form-control" autocomplete="off">
                            <input type="text" id="employee_id" name="employee_id" hidden value="{{ old('employee_id') }}" class="form-control employee_id" autocomplete="off">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="employee_no" class="form-label fw-bold">Employee No</label>
                            <input type="text" id="employee_no" name="employee_no" class="form-control employee_no" autocomplete="off" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="emp_designation" class="form-label fw-bold">Employee Designation</label>
                            <input type="text" id="desigination" readonly name="desigination" value="{{ old('desigination') }}" placeholder="Designation" class="form-control" autocomplete="off">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="emp_dpart" class="form-label fw-bold">Employee Department</label>
                            <input type="text" id="depart" name="depart" readonly value="{{ old('depart') }}" placeholder="Department" class="form-control" autocomplete="off">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="sponser" class="form-label fw-bold">Sponsor</label>
                            <input type="text" id="sponser" name="sponser" value="{{ old('sponser') }}" placeholder="sponsor" class="form-control sponser" autocomplete="off" readonly>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="month" class="form-label fw-bold">Month <a style="text-decoration: none;color:red">*</a></label>
                            <select id="month" name="month" class="form-control form-select" autocomplete="off">
                                <option value="">Select Option</option>
                                @foreach ($month as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="year" class="form-label fw-bold">Year <a style="text-decoration: none;color:red">*</a></label>
                            <input type="text" id="year" name="year" value="{{ old('year') }}" placeholder="Year" class="form-control year" autocomplete="off">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="project_name" class="form-label fw-bold">Project Name<a style="text-decoration: none;color:red">*</a></label>
                            <input type="text" id="project_name" name="project_name" value="{{ old('project_name') }}" placeholder="Project Name" class="form-control" autocomplete="off">
                            <input type="text" id="project_id" name="project_id" hidden value="{{ old('project_id') }}" class="form-control" autocomplete="off">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="lop_days" class="form-label fw-bold">LOP Days</label>
                            <input type="text" id="lop_days" name="lop_days" value="{{ old('lop_days') }}" placeholder="LOP days" class="form-control" autocomplete="off" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="worked_days" class="form-label fw-bold">Total Worked Days</label>
                            <input type="text" id="worked_days" name="worked_days" value="{{ old('worked_days') }}" placeholder="Total worked days" class="form-control" autocomplete="off" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="ot_hours" class="form-label fw-bold">OT Hours<a style="text-decoration: none;color:red">*</a></label>
                            <input type="text" id="ot_hours" name="ot_hours" value="{{ old('ot_hours') }}" placeholder="OT hours" class="form-control" autocomplete="off" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="wps" class="form-label fw-bold">WPS No</label>
                            <input type="text" id="wps" name="wps" value="{{ old('wps') }}" placeholder="WPS No" class="form-control wps" autocomplete="off" readonly>
                        </div>
                    </div>
                    <div class="container pt-4">
                        <div class="row">
                            <div class="col-md-6 earnings-column">
                                <div class="form-group ">
                                    <h4 class="text-primary text-center"><b>Earnings (AED)</b></h4>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="basic" class="form-label fw-bold">Basic</label>
                                            <input type="text" id="basic" name="basic" value="{{ old('basic') }}" placeholder="Basic" class="form-control" autocomplete="off" readonly>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="hra" class="form-label fw-bold">HRA</label>
                                            <input type="text" id="hra" name="hra" value="{{ old('hra') }}" placeholder="HRA" class="form-control" autocomplete="off" readonly>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="medical" class="form-label fw-bold">Medical Allowance<a style="text-decoration: none;color:red">*</a></label>
                                            <input type="number" id="medical" name="medical" value="{{ old('medical') }}" placeholder="Medical Allowance" class="form-control medical" autocomplete="off">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="special" class="form-label fw-bold">Special Allowance<a style="text-decoration: none;color:red">*</a></label>
                                            <input type="number" id="special" name="special" value="{{ old('special') }}" placeholder="Special Allowance" class="form-control special" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="conveyance" class="form-label fw-bold">Conveyance Allowance<a style="text-decoration: none;color:red">*</a></label>
                                            <input type="number" id="conveyance" name="conveyance" value="{{ old('conveyance') }}" placeholder="Conveyance Allowance" class="form-control conveyance" autocomplete="off">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="ot" class="form-label fw-bold">OT</label>
                                            <input type="text" id="ot" name="ot" value="{{ old('ot') }}" placeholder="OT" class="form-control" autocomplete="off" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="total_earning" class="form-label fw-bold">Total Earnings</label>
                                            <input type="text" id="total_earning" name="total_earning" value="{{ old('total_earning') }}" placeholder="Total Earnings" class="form-control" autocomplete="off" oninput="calculateNetPay()" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 deduction-column">
                                <h4 class="text-primary text-center"><b>Deduction (AED)</b></h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="">
                                        <thead>
                                            <tr>
                                                <th class="text-center">S.No</th>
                                                <th class="text-center" style="width: 30%;">Deduction</th>
                                                <th class="text-center" style="width: 45%;">Reason</th>
                                                <th class="text-center"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody"></tbody>
                                    </table>
                                </div>
                                <button class="btn btn-md btn-primary" id="addBtn" type="button">Add Row</button>
                                <div class="form-group col-md-6  mt-5">
                                    <label for="deduction" class="form-label fw-bold">Total Deduction</label>
                                    <input type="text" id="total_deduction" name="total_deduction" value="{{ old('total_deduction') }}" placeholder="Total Deduction" class="form-control" autocomplete="off" oninput="calculateNetPay()" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-md-2">
                            <label for="">Net Pay</label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="netpay" id="netpay" class="form-control mb-2" oninput="convertNumberToWords()" readonly>
                        </div>
                        <div class="col-md-2">
                            <label for="">Mode Of Payment</label>
                        </div>
                        <div class="col-md-4">
                            <select id="payment_mode" name="payment_mode" class="form-control form-select" autocomplete="off">
                                <option value="">Select Option</option>
                                @foreach ($payment_mode as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label for="">Amount in words</label>
                            <input type="text" name="amount_words" id="amount_words" class="form-control mb-2" readonly>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="form-group col-md-12">
                            <center>
                                <button id="submit" class="btn btn-primary mx-3 mt-3">Save</button>
                            </center>
                        </div>
                    </div>
                </form>
                <!-- SHOW DIALOG -->
                <div class="card" id="show" style="display:none">
                    <div class="card-body" style="background-color:white;width:100%;height:20%;">

                        <div class="row">
                            <div class="col-md-3">
                                <label>Employee Name</label>
                                <p id="show_firstname"></p>
                            </div>
                            <div class="col-md-3">
                                <label>Employee Id</label>
                                <p id="show_employee_no"></p>
                            </div>
                            <div class="col-md-3">
                                <label>Department</label>
                                <p id="show_depart"></p>
                            </div>
                            <div class="col-md-3">
                                <label>Designation</label>
                                <p id="show_desigination"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label>Sponsor</label>
                                <p id="show_sponser"></p>
                            </div>
                            <div class="col-md-3">
                                <label>Month</label>
                                <p id="show_month"></p>
                            </div>
                            <div class="col-md-3">
                                <label>Year</label>
                                <p id="show_year"></p>
                            </div>
                            <div class="col-md-3">
                                <label>LOP Days</label>
                                <p id="show_lop_days"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label>Total Worked Days</label>
                                <p id="show_worked_days"></p>
                            </div>
                            <div class="col-md-3">
                                <label>WPS No</label>
                                <p id="show_wps"></p>
                            </div>
                            <div class="col-md-3">
                                <label>OT hours</label>
                                <p id="show_ot_hours"></p>
                            </div>
                            <div class="col-md-3">
                                <label>Basic</label>
                                <p id="show_basic"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label>HRA</label>
                                <p id="show_hra"></p>
                            </div>
                            <div class="col-md-3">
                                <label>Conveyance Allowance</label>
                                <p id="show_conveyance"></p>
                            </div>
                            <div class="col-md-3">
                                <label>Medical Allowance</label>
                                <p id="show_medical"></p>
                            </div>
                            <div class="col-md-3">
                                <label>Special Allowance</label>
                                <p id="show_special"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label>OT</label>
                                <p id="show_ot"></p>
                            </div>
                            <div class="col-md-3">
                                <label>Net Pay</label>
                                <p id="show_netpay"></p>
                            </div>
                            <div class="col-md-3">
                                <label>Mode Of Payment</label>
                                <p id="show_payment_mode"></p>
                            </div>
                            <div class="col-md-6">
                                <label>Amount in words</label>
                                <p id="show_amount_words"></p>
                            </div>
                        </div>

                        <div id="item_details_show"></div>
                    </div>
                </div>
            </dialog>


            <!-- Script Start -->

<script type="text/javascript">

    $.ajaxSetup({
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Initialize the DataTable plugin on the element with id "myTable"
    $(function(){

        $("#myTable").DataTable();
    });
</script>

<script type="text/javascript">

     // jQuery button click event to add a row
     $('#addBtn').on('click', function()
    {
        add_text();
    });

    // delete row in dynamically created table
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
        rowIdx--;
    });

    // function to add row dynamically
    var rowIdx = 1;

    function add_text()
    {
        var html = '';
        html += '<tr id="row' + rowIdx + '" class="rowtr">';
        html += '<td>' + rowIdx + '</td>';
        html += '<td><div class="col-xs-12"><input type="text" id="deduction_' + rowIdx +
                '"  name="deduction[]" class="deduction form-control" placeholder="Deduction" oninput="calculateTotalDeduction(this)"></div></td>';
        html += '<td><div class="col-xs-12"><input type="textarea" name="reason[]" id="reason_' + rowIdx +
            '"  name="reason[]" class="reason form-control"></div></td>';

        if (rowIdx != 1)
        {
            html +='<td><button class="btn btn-danger remove" id="delete" type="button"><i class="fa fa-trash"></i></button></td>';
            html += '</tr>';
        }
        $("#tbody").append(html);
        rowIdx++;
    }

    // Create a separate function for the AJAX call

    function updatePayData()
    {
        $.ajax(
        {
            type: "GET",
            url: "{{ route('getpaydata') }}",
            dataType: "json",
            data:
            {
                'employee_id': $('#employee_id').val(),
                'month': $('#month').val(),
                'year': $('#year').val()
            },
            success: function(data)
            {
                if (data.data.length > 0 && data.data[0] !== null)
                {
                    console.log(data.data[0].basic);
                    console.log(data.data[0].hra);

                    var month = parseInt($('#month').val()); // Get the selected month
                    var year = parseInt($('#year').val()); // Get the selected year

                    var medicalAllowance = parseFloat($('#medical').val()) || 0;
                    var specialAllowance = parseFloat($('#special').val()) || 0;
                    var conveyanceAllowance = parseFloat($('#conveyance').val()) || 0;

                    var daysInMonth;
                    if (month === 2)
                    {
                        // February
                        if ((year % 4 === 0 && year % 100 !== 0) || year % 400 === 0)
                        {
                            // Leap year, February has 29 days
                            daysInMonth = 29;
                        }
                        else
                        {
                            // Non-leap year, February has 28 days
                            daysInMonth = 28;
                        }
                    }
                    else if ([4, 6, 9, 11].includes(month))
                    {
                         // April, June, September, November have 30 days
                        daysInMonth = 30;
                    }
                    else
                    {
                        // All other months have 31 days
                        daysInMonth = 31;
                    }

                    var basic = data.data[0].basic - (data.data1[0].leave * (data.data[0].basic / daysInMonth));
                    var hra = data.data[0].hra - (data.data1[0].leave * (data.data[0].hra / daysInMonth));
                    var ot_cal = data.data2[0].ot * 5; // Multiply OT hours by 5
                    var totalEarning = basic + hra + ot_cal + medicalAllowance + specialAllowance + conveyanceAllowance;

                    $('#worked_days').val(data.data[0].count);
                    $('#lop_days').val(data.data1[0].leave);
                    $('#ot_hours').val(data.data2[0].ot);
                    $('#basic').val(basic);
                    $('#hra').val(hra);
                    $('#ot').val(ot_cal);
                    $('#total_earning').val(totalEarning);
                    calculateNetPay(); // Calculate net pay
                }
                else
                {
                    // Clear the fields when there is no data
                    $('#worked_days').val('');
                    $('#lop_days').val('');
                    $('#ot_hours').val('');
                    $('#basic').val('');
                    $('#hra').val('');
                    $('#ot').val('');
                    $('#total_earning').val('');
                    calculateNetPay(); // Calculate net pay (with total_earning as 0)
                }
            },
            fail: function(xhr, textStatus, errorThrown)
            {
                alert(errorThrown);
            }
        });
    }

    // calculation for netpay
    function calculateNetPay()
    {
        var totalDeduction = document.getElementById('total_deduction').value;
        var totalEarning = document.getElementById('total_earning').value;

        // Check if totalDeduction is empty or not provided
        if (totalDeduction === '')
        {
            totalDeduction = 0;
        }

        // Check if totalEarning is empty or not provided
        if (totalEarning === '')
        {
            totalEarning = 0;
        }

        var netPay = parseFloat(totalEarning) - parseFloat(totalDeduction);
        document.getElementById('netpay').value = netPay.toFixed(2);

        // Convert the net pay value to words using the 'convertNumberToWords' function call
        var amountInWords = convertNumberToWords(netPay);
        document.getElementById('amount_words').value = amountInWords;
        //console.log(amountInWords);
    }

    // netpay amount number to word conversion
    function convertNumberToWords(number)
    {
        var units = [
            'zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine',
            'ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen',
            'eighteen', 'nineteen'
        ];
        var tens = [
            '', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'
        ];
        var scales = ['', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion'];

        if (number === 0)
        {
            return units[0];
        }

        var words = '';

        // Handle negative numbers
        if (number < 0) {
            words += 'negative ';
            number = Math.abs(number);
        }

        var wholePart = Math.floor(number);
        var decimalPart = Math.round((number - wholePart) * 100);

        // Convert the whole part
        var scaleIndex = 0;

        while (wholePart > 0)
        {
            var chunk = wholePart % 1000;
            if (chunk !== 0)
            {
                var chunkWords = '';

                var hundreds = Math.floor(chunk / 100);
                if (hundreds !== 0)
                {
                    chunkWords += units[hundreds] + ' hundred ';
                }

                var tensAndUnits = chunk % 100;
                if (tensAndUnits < 20)
                {
                    chunkWords += units[tensAndUnits] + ' ';
                }
                else
                {
                    var tensDigit = Math.floor(tensAndUnits / 10);
                    var unitsDigit = tensAndUnits % 10;
                    chunkWords += tens[tensDigit] + ' ' + units[unitsDigit] + ' ';
                }

                chunkWords += scales[scaleIndex] + ' ';
                words = chunkWords + words;
            }

            wholePart = Math.floor(wholePart / 1000);
            scaleIndex++;
        }

        // Convert the decimal part
        if (decimalPart > 0)
        {
            words += '.';
            if (decimalPart < 20)
            {
                words += units[decimalPart];
            }
            else
            {
                var tensDigit = Math.floor(decimalPart / 10);
                var unitsDigit = decimalPart % 10;
                words += tens[tensDigit];
                if (unitsDigit !== 0)
                {
                    words += ' ' + units[unitsDigit];
                }
            }
        }

        return words.trim();
    }

    //deduction calculation
    function calculateTotalDeduction(input)
    {
        var deductionFields = document.getElementsByName('deduction[]');
        var totalDeductionField = document.getElementById('total_deduction');

        var totalDeduction = 0;
        for (var i = 0; i < deductionFields.length; i++)
        {
            var deductionValue = parseFloat(deductionFields[i].value);
            if (!isNaN(deductionValue))
            {
                totalDeduction += deductionValue;
            }
        }

        // Check if totalDeduction is NaN or not provided
        if (isNaN(totalDeduction))
        {
            totalDeduction = 0;
        }

        totalDeductionField.value = totalDeduction.toFixed(2);
        calculateNetPay(); // Recalculate the net pay
    }


    // Bind the function to the change event of input fields
    $(document).on('input', '#employee_id, #month, #year, .medical, .special, .conveyance', function()
    {
        updatePayData();
    });

    // Bind the function to the change event of deduction fields
    $(document).on('input', 'input[name="deduction[]"]', function()
    {
        calculateTotalDeduction(this);
    });



    //ADD DIALOG
    function handleDialog()
    {
        document.getElementById("myDialog").open = true;
        add_text();
        $('#method').val("ADD");
        $('#submit').text("Save");
        $('#heading_name').text("Add Payroll Details").css('font-weight', 'bold');
        $('#show').css('display', 'none');
        $('#form').css('display', 'block');
        $('#blur-background').css('display', 'block');
    }

    // DELETE FUNCTION
    function handleDelete(id)
    {
        let url = '{{ route('payrollApi.delete', ':id') }}';
        url = url.replace(':id', id);
        if (confirm("Are you sure you want to delete this Payroll Details?"))
        {
            $.ajax(
            {
                url: url,
                type: 'DELETE',
                success: function(message)
                {
                    alert(message);
                    window.location.reload();
                },
            })
        }

    }

    // DIALOG CLOSE BUTTON
    function handleClose()
    {
        document.getElementById("myDialog").open = false;
        // Clear the form fields
        $('#form')[0].reset();
        // Hide any error messages
        $('.error-msg').removeClass('error-msg');
        $('.has-error').removeClass('has-error');
        // Hide any error messages
        $('error').html('');
        // Hide the dialog background
        $('#blur-background').css('display', 'none');
    }

    // DIALOG SUBMIT FOR ADD AND EDIT
    function handleSubmit()
    {
        event.preventDefault();
        var hiddenErrorElements = $('.error-msg:not(:hidden)').length;
        //  alert(hiddenErrorElements);
        if (hiddenErrorElements === 0)
        {
            // Disable the submit button
            $('#submit').prop('disabled', true);
            let form_data = new FormData(document.getElementById('form'));
            let method = $('#method').val();
            let url;
            let type;
            if (method == 'ADD')
            {
                url = '{{ route('payrollApi.store') }}';
                type = 'POST';

            }
            else
            {
                let id = $('#id').val();
                url = '{{ route('payrollApi.update', ':id') }}';
                url = url.replace(':id', id);
                type = 'POST';
            }
            $.ajax(
            {
                url: url,
                type: type,
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                success: function(message)
                {
                    alert(message);
                    window.location.reload();
                },
                error: function(message)
                {
                    var data = message.responseJSON;
                     $('#submit').prop('disabled', false);
                }
            })
        }
    }

    //DATA SHOW FOR EDIT AND SHOW

    function handleShowAndEdit(id, action)
    {

        let url = '{{ route('payrollApi.show', ':id') }}';
        url = url.replace(':id', id);
        let type = "GET"
        $.ajax({
            url: url,
            type: type,
            contentType: false,
            cache: false,
            processData: false,
            success: function(message)
            {
                console.log(message.payrolls);
                console.log(message.payroll_deduction);
                if (action == 'edit')
                {

                    $('#heading_name').text("Update Payroll Details").css('font-weight', 'bold');
                    $('#show').css('display', 'none');
                    $('#form').css('display', 'block');
                    $('#blur-background').css('display', 'block');

                    for (const [key, value] of Object.entries(message.payrolls[0]))
                    {
                        $(`#${key}`).val(value);

                    }
                    var rowid = 1;
                    for (const item of message.payroll_deduction)
                    {
                        add_text(); // add a new row to the table
                        console.log(item.deduction);
                        console.log(rowid);
                        $('#deduction_' + rowid).val(item.deduction);
                        $('#reason_' + rowid).val(item.reason);
                        rowid++;
                    }
                    $('#method').val('UPDATE');
                    $('#submit').text('UPDATE');
                }
                else
                {
                    for (const [key, value] of Object.entries(message.payrolls[0]))
                    {
                        $(`#show_${key}`).text(value);
                    }
                    console.log(message.payroll_deduction[0]);
                    let script =
                        '<table id="show_table" class="table table-striped"><thead style="text-align: center;"><tr><th>S.No</th><th>Deduction</th><th>Reason</th></tr></thead><tbody>';

                    if (message.payroll_deduction?.length)
                    {
                        message.payroll_deduction.forEach((item, index) =>
                        {
                            script += `<tr>
                            <td>${index + 1}</td>
                            <td style="text-align: center;">${item.deduction || ''}</td>
                            <td>${item.reason}</td>
                            </tr>`;
                        });
                    }
                    else
                    {
                        script += '<tr><td colspan="3" style="text-align: center;">No data found</td></tr>';
                    }
                    script += '</tbody></table>';

                    $('#show_table').remove();
                    $('#item_details_show').append(script);
                    $('#heading_name').text("View Payroll Details").css('font-weight', 'bold');
                    $('#show').css('display', 'block');
                    $('#form').css('display', 'none');
                    $('#blur-background').css('display', 'block');
                }
                document.getElementById("myDialog").open = true;

            },
        })
    }

    //project name autocomplete

    $("#project_name").autocomplete(
    {
        source: function(request, response)
        {
            $.ajax(
            {
                type: "GET",
                url: "{{ route('getlocdata') }}",
                dataType: "json",
                data:
                {
                    'projectname': $("#project_name").val()
                },
                success: function(data)
                {
                    result = [];
                    for (var i in data)
                    {
                        result.push(data[i]["project_name"]);
                    }
                    response(result);
                },
                fail: function(xhr, textStatus, errorThrown)
                {
                    alert(errorThrown);
                }
            });
        },
    });
    $("#project_name").on('change', function()
    {
        var code = $(this).val();

        $.ajax({
            type: "GET",
            url: "{{ route('getlocdata') }}",
            dataType: "json",
            data:
            {
                'projectname': $(this).val()
            },
            success: function(data)
            {
                result = [];
                for (var i in data)
                {
                    $('#project_id').val(data[i]["project_no"]);

                }
            },
            fail: function(xhr, textStatus, errorThrown)
            {
                alert(errorThrown);
            }
        });
    });

    // Employee details auto complete

    $("#firstname").autocomplete({

        source: function(request, response)
        {
            $.ajax({
                type: "GET",
                url: "{{ route('getemployeedata') }}",
                dataType: "json",
                data:
                {
                    'firstname': $("#firstname").val()
                },
                success: function(data)
                {
                    result = [];
                    for (var i in data)
                    {
                        result.push(data[i]["firstname"]);
                    }

                    response(result);
                },
                fail: function(xhr, textStatus, errorThrown)
                {
                    alert(errorThrown);
                }
            });
        },
    });

    $("#firstname").on('change', function()
    {
        var code = $(this).val();

        $.ajax({
            type: "GET",
            url: "{{ route('getemployeedata') }}",
            dataType: "json",
            data:
            {
                'firstname': $(this).val()
            },
            success: function(data)
            {
                result = [];
                for (var i in data)
                {
                    console.log(data);

                    $('.sponser').val(data[i]["sponser"]);
                    $('#employee_id').val(data[i]["id"]);
                    $('.employee_no').val(data[i]["employee_no"]);
                    $('#desigination').val(data[i]["desigination"]);
                    $('#depart').val(data[i]["depart"]);
                    $('#basic').val(data[i]["basic"]);
                    $('#hra').val(data[i]["hra"]);
                    $('#wps').val(data[i]["wps"]);

                }
            },
            fail: function(xhr, textStatus, errorThrown)
            {
                alert(errorThrown);
            }
        });
    });

    // Initialize form validation

    var project_name = @json($project_name);
    var employee = @json($employee);
    $.validator.addMethod("employeeNameCheck", function(value, element)
    {
        return employee.includes(value);
    });
    $.validator.addMethod("projectNameCheck", function(value, element)
    {
        return project_name.includes(value);
    });
    $.validator.addMethod("alphanumeric", function(value, element)
    {
        return this.optional(element) || /^[A-Za-z ]+$/i.test(value);
    });


    var formValidationConfig = {

        rules:
        {
            firstname:
            {
                required: true,
                employeeNameCheck: true
            },
            month: "required",
            year: "required",
            project_name:
            {
                required: true,
                projectNameCheck: true
            },
            conveyance: "required",
            medical: "required",
            special: "required",
            payment_mode: "required",
            total_payable: "required",
            "deduction[]":
            {
                digits:true
            }
        },
        messages:
        {
            firstname:
            {
                required: "Please enter the Employee Name",
                employeeNameCheck: "Please enter a valid Employee Name"
            },
            month: "Please enter the Month",
            year: "Please enter the year",
            project_name:
            {
                required: "Please enter the project name",
                projectNameCheck: "Please enter a valid Project Name "
            },
            conveyance: "Please enter the Convenance Allowance",
            medical: "Please enter the Medical Allowance",
            special: "Please enter the Special Allowance",
            payment_mode: "Please select payment mode",
            total_payable: "Please enter the Total Pay",
           "deduction[]":
            {"digits":"Please Enter only Numbers"}
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