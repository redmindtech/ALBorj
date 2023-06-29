<style>
    .toggle{
  display: flex; /* Use flexbox to align the checkbox and slider */
  align-items: center; /* Align vertically centered */
}
</style>
<!-- STYLE INCLUDED IN LAYOUT PAGE -->
@extends('layouts.app', [
    'activeName' => 'Project Master',
])
@section('title', 'Project Master')

@section('content_header')
@stop

@section('content')
    <!-- DATA table -->
    <div class="row">
        <div class="container-fluid">
            <div class="card shadow">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h4 class="font-weight-bold text-dark py">PROJECT MASTER</h4>
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
                                    <th>Project Code</th>
                                    <th>Project Name</th>
                                    <th>Client Name</th>
                                    <th>Status</th>
                                    <th>Project Cost</th>
                                    <th>Advance Amount</th>
                                    <th>Balance Amount</th>
                                    <th>Project Type</th>
                                    <th>Site Name</th>
                                    <th>Manager Name</th>
                                    <th>Actual Start Date</th>
                                    <th>Actual End Date</th>
                                    <th>Retention</th>
                                    <th>Amount Return</th>
                                    <th>Approved Variation Cost </th>
                                    <th>Advance Variation Amount</th>
                                    <th>Retention Variation Amount</th>
                                    <th>Date</th>
                                    <th data-orderable="false" class="action notexport">Show</th>
                                    <th data-orderable="false" class="action notexport">Edit</th>
                                    <th data-orderable="false" class="action notexport">Delete</th>
                                    <div id="blur-background" class="blur-background"></div>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($projectmasters as $key => $projectmaster)
                                    <tr class="text-center">
                                        <td>{{ $projectmaster->project_code }}</td>
                                        <td>{{ $projectmaster->project_name }}</td>
                                        <td>{{ $projectmaster->name }}</td>
                                        <td>{{ $projectmaster->status }}</td>
                                        <td>{{ $projectmaster->total_price_cost }}</td>
                                        <td>{{ $projectmaster->advanced_amount }}</td>
                                        <td>{{ $projectmaster->amount_to_be_received }}</td>
                                        <td>{{ $projectmaster->project_type }}</td>
                                        <td>{{ $projectmaster->site_name }}</td>
                                        <td>{{ $projectmaster->firstname }}</td>
                                        <td>{{ date('d-m-Y', strtotime($projectmaster->start_date)) }}</td>
                                        <td>{{ date('d-m-Y', strtotime($projectmaster->actual_project_end_date)) }}</td>
                                        <td>{{ $projectmaster->retention }}</td>
                                        <td>{{ $projectmaster->amount_return }}</td>
                                        <td>{{$projectmaster->Approved_Variation_Cost}} </td>
                                        <td>{{$projectmaster->Advance_Variation_Amount}}</td>
                                        <td>{{$projectmaster->Retention_Variation_Amount}}</td>
                                        <td>{{ date('d-m-Y', strtotime($projectmaster->created_at)) }}</td>

                                        <td>
                                            <a onclick="handleShowAndEdit('{{ $projectmaster->project_no }}','show')"
                                                class="btn btn-primary btn-circle btn-sm">
                                                <i class="fas fa-flag"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a onclick="handleShowAndEdit('{{ $projectmaster->project_no }}','edit')"
                                                class="btn btn-info btn-circle btn-sm mx-2">
                                                <i class="fas fa-check"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="handleDelete('{{ $projectmaster->project_no }}')">
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
                        <a class="btn  btn-sm" id="closeButton" onclick="handleClose()" style="float:right;padding: 10px 10px;"><i
                                class="fas fa-close"></i></a>
                        <h4 id='heading_name' style='color:white' align="center"><b>Update Project Details</b></h4>
                    </div>
                </div>



                <form class="form-row" enctype="multipart/form-data" style="display:block" id="form"
                    onsubmit="handleSubmit()">
                    <input type="hidden" id="method" value="ADD" />
                    <input type="hidden" id="project_no" name="project_no" value="" /><br>

                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="site_name" class="form-label fw-bold">Site Name<a
                                    style="text-decoration: none;color:red">*</a></label>
                          
                                <select id="site_name" name="site_name" class="form-control form-select" autocomplete="off" style="width:100%">
                                    <option value="">Select Option</option>
                                    @foreach ($site_name as $key => $value)
                                    <option value="{{ $value->site_name  }}">{{ $value->site_name }}</option>
                                    @endforeach
                                </select>
                                <input type="text" id="site_no" hidden  name="site_no" value="{{ old('site_no') }}"  class="form-control" autocomplete="off"> 
                            </div>

                        <div class="form-group col-md-4">
                            <label for="site_code" class="form-label fw-bold">Site No</label>
                            <input type="text" id="site_code" name="site_code" value="{{ old('site_code') }}" readonly
                                placeholder="Site Code" class="form-control" autocomplete="off">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="consultant_name" class="form-label fw-bold">Consultant Name</label>
                            <input type="text" id="consultant_name" name="consultant_name"
                                value="{{ old('consultant_name') }}" placeholder="Consultant Name" class="form-control"
                                autocomplete="off">

                        </div>

                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="project_name" class="form-label fw-bold">Project Name<a
                                    style="text-decoration: none;color:red">*</a></label>
                            <input type="text" id="project_name" name="project_name"
                                value="{{ old('project_name') }}" placeholder="Project Name" class="form-control"
                                autocomplete="off">

                        </div>
                        <div class="form-group col-md-4">
                            <label for="project_type" class="form-label fw-bold">Project Type<a
                                    style="text-decoration: none;color:red">*</a></label>
                            <select id="project_type" name="project_type" class="form-control form-select"
                                autocomplete="off">
                                <option value="">Select Option</option>
                                @foreach ($project_type as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="form-group col-md-4">
                            <label for="project_comments" class="form-label fw-bold">Comments</label>
                            <input type="text" id="project_comments" name="project_comments"
                                value="{{ old('project_comments') }}" placeholder="Comments" class="form-control"
                                autocomplete="off">

                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="status" class="form-label fw-bold">Project Status<a
                                    style="text-decoration: none;color:red">*</a></label>
                            <select id="status" name="status" class="form-control form-select" autocomplete="off">
                                <option value="">Select Option</option>
                                @foreach ($project_status as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="form-group col-md-4">
                            <label for="manager_name" class="form-label fw-bold">Manager Name<a
                                    style="text-decoration: none;color:red">*</a></label>
                            <input type="text" id="firstname" name="firstname" value="{{ old('firstname') }}"
                                placeholder="Manager Name" class="form-control" autocomplete="off">
                            <input type="text" id="employee_no" name="employee_no" hidden
                                value="{{ old('employee_no') }}" class="form-control" autocomplete="off">

                        </div>
                        <div class="form-group col-md-4">
                            <label for="UAE_mobile_number" class="form-label fw-bold">Manager Contact Number</label>
                            <input type="text" id="UAE_mobile_number" name="UAE_mobile_number" readonly
                                value="{{ old('UAE_mobile_number') }}" placeholder="Contact Number" class="form-control"
                                autocomplete="off">

                        </div>

                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="company_name" class="form-label fw-bold">Client / Company Name<a
                                    style="text-decoration: none;color:red">*</a></label>
                            <input type="text" id="company_name" name="company_name"
                                value="{{ old('company_name') }}" placeholder="Client / Company Name"
                                class="form-control" autocomplete="off">
                            <input type="text" id="client_no" hidden name="client_no" value="{{ old('client_no') }}"
                                class="form-control" autocomplete="off">

                        </div>
                        <div class="form-group col-md-4">
                            <label for="name" class="form-label fw-bold">Client Contact Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" readonly
                                placeholder="Client Contact Name" class="form-control" autocomplete="off">

                        </div>
                        <div class="form-group col-md-4">
                            <label for="contact_number" class="form-label fw-bold">Client Contact Number</label>
                            <input type="text" id="contact_number" name="contact_number" readonly
                                value="{{ old('contact_number') }}" placeholder="Client Contact Number"
                                class="form-control" autocomplete="off">

                        </div>
                    </div>
                    <div class="row">

                        <div class="form-group col-md-4">
                            <label for="start_date" class="form-label fw-bold">Project Start Date<a
                                    style="text-decoration: none;color:red">*</a></label>
                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}"
                                class="form-control" autocomplete="off">

                        </div>
                        <div class="form-group col-md-4">
                            <label for="end_date" class="form-label fw-bold">Tentative Project End Date<a
                                    style="text-decoration: none;color:red">*</a></label>
                            <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}"
                                class="form-control" autocomplete="off">

                        </div>
                        <div class="form-group col-md-4">
                            <label for="actual_project_end_date" class="form-label fw-bold">Actual Project End Date<a
                                    style="text-decoration: none;color:red">*</a></label>
                            <input type="date" name="actual_project_end_date" id="actual_project_end_date"
                                value="{{ old('actual_project_end_date') }}" class="form-control" autocomplete="off">

                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="form-group col-md-4">
                            <label for="total_price_cost" class="form-label fw-bold">Total Project Cost<a
                                    style="text-decoration: none;color:red">*</a></label>
                            <div class="input-group-prepend">
                                <input type="number" readonly style="width: 175px;"id="total_price_cost" name="total_price_cost"
                                    value="{{ old('total_price_cost') }}" placeholder="Total Project Cost"
                                    class="form-control" autocomplete="off">   
                                <div class="input-group-append">                              
                                        <select class="form-select input-group" id="currency" name="currency">                                   
                                        @foreach ($currency as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    <a onclick="boq()"
                                                class="btn btn-primary btn-circle btn-sm ">
                                                BOQ
                                            </a>  
                                 </div>                              
                            </div>                          
                        </div>


                        <div class="form-group col-md-3 mr-5">
                            <label for="advanced_amount" class="form-label fw-bold">Advance Amount<a
                                    style="text-decoration: none;color:red">*</a></label>
                            <div class="input-group-prepend">
                                <input type="number" id="advanced_amount" name="advanced_amount"
                                    value="{{ old('advanced_amount') }}" placeholder="Advance Amount"
                                    class="form-control" autocomplete="off" onchange="calculateAmount()">
                                <div class="input-group-append">
                                    <div class="toggle focus" style="margin-top:33% !important;">
                                        <input type="checkbox" class="st amount" name="amount_type" id="amount_type"
                                            value="1" {{ old('amount_type') ? 'checked' : '' }}>
                                        <span class="slider"></span>
                                        <span class="label">AED</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="form-group col-md-3 mr-5">
                            <label for="retention" class="form-label fw-bold">Retention</label>
                            <div class="input-group-prepend">
                                <input type="number" id="retention" name="retention" value="{{ old('retention') }}"
                                    placeholder="Retention" class="form-control" autocomplete="off">
                                <div class="input-group-append">
                                    <div class="toggle-retention focus" style="margin-top:33% !important;">
                                        <input type="checkbox" class="st retention" name="retention_type"
                                            id="retention_type" value="1"
                                            {{ old('retention_type') ? 'checked' : '' }}>
                                        <span class="slider"></span>
                                        <span class="label">AED</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                <div class="form-group col-md-4">
                        <label for="Approved_Variation_Cost" class="form-label fw-bold">Approved Variation Cost</label>
                        <input type="number" id="Approved_Variation_Cost" name="Approved_Variation_Cost" value="{{ old('Approved_Variation_Cost') }}" placeholder="Approved Variation Cost" class="form-control" autocomplete="off">    
                    </div>
                    <div class="form-group col-md-4">
                        <label for="Advance_Variation_Amount" class="form-label fw-bold">Advance Variation Amount</label>
                        <input type="number" id="Advance_Variation_Amount" name="Advance_Variation_Amount" value="{{ old('Advance_Variation_Amount') }}" placeholder="Advance Variation Amount" class="form-control" autocomplete="off">
                        
                    </div>
                    <div class="form-group col-md-4">
                        <label for="Retention_Variation_Amount" class="form-label fw-bold">Retention Variation Amount</label>
                        <input type="number" name="Retention_Variation_Amount" id="Retention_Variation_Amount"  value="{{old('Retention_Variation_Amount')}}" placeholder="Retention Variation Amount"   class="form-control" autocomplete="off">   
                    </div>
                </div>
                    <div class="row">

                        <div class="form-group col-md-4">
                            <label for="amount_to_be_received" class="form-label fw-bold">Balance Amount To Be
                                Received</label>
                            <input type="number" id="amount_to_be_received" name="amount_to_be_received"
                                value="{{ old('amount_to_be_received') }}" placeholder="Balance Amount To Be Received"
                                class="form-control" autocomplete="off" readonly>

                        </div>
                        <div class="form-group col-md-4">
                            <label for="amount_return" class="form-label fw-bold">Amount Return</label>
                            <input type="number" id="amount_return" name="amount_return"
                                value="{{ old('amount_return') }}" placeholder="Amount Return" class="form-control"
                                autocomplete="off">

                        </div>
                        <div class="form-group col-md-4">
                            <label for="amount_return_date" class="form-label fw-bold">Amount Return Date</label>
                            <input type="date" name="amount_return_date" id="amount_return_date"
                                value="{{ old('amount_return_date') }}" class="form-control" autocomplete="off">

                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="amount_returns_comment" class="form-label fw-bold">Amount Return Comments</label>
                            <input type="text" id="amount_returns_comment" name="amount_returns_comment"
                                value="{{ old('amount_returns_comment') }}" placeholder="Amount Return Comments"
                                class="form-control" autocomplete="off">

                        </div>
                        <div class="form-group col-md-4">
                            <label for="project_code " id='code_lable' class="form-label fw-bold">Project Code</label>
                            <input type="text" id="project_code" name="project_code" readonly
                                value="{{ old('project_code ') }}" class="form-control" autocomplete="off">

                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <button type="submit" id="submit" class="btn btn-primary float-end ">ADD</button>
                        </div>
                    </div>
                </form>
                <script>
                    $(document).ready(function() {
                        // Calculate the amount based on the initial values
                        calculateAmount();
                        $('.toggle-retention input[type="checkbox"]').click(function() {

                            $(this).parent().toggleClass('on');
                            if ($(this).parent().hasClass('on')) {
                                $('#retention_type').val('0');
                                $(this).parent().children('.label').text('%');
                            } else {
                                $('#retention_type').val('1');
                                $(this).parent().children('.label').text('AED');
                            }
                        });


                        $('.toggle input[type="checkbox"]').click(function() {
                            $(this).parent().toggleClass('on');

                            if ($(this).parent().hasClass('on')) {
                                $('#amount_type').val('0');
                                calculateAmount();
                                $(this).parent().children('.label').text('%');
                            } else {
                                $('#amount_type').val('1');
                                calculateAmount();
                                $(this).parent().children('.label').text('AED');
                            }
                        });

                        // Trigger calculation when the input values change
                        $('#total_price_cost, #advanced_amount').on('input', calculateAmount);
                    });

                    function calculateAmount() {
                        if ($('#amount_type').val() == '0') {
                            // Percentage calculation
                            var totalCost = parseFloat($('#total_price_cost').val()) || 0;
                            var vatPercentage = parseFloat($('#advanced_amount').val()) || 0;
                            var advanced_amount = (vatPercentage / 100) * totalCost;
                            var balance_amount = totalCost - advanced_amount;
                            $('#amount_to_be_received').val(balance_amount.toFixed(2));

                            // Calculate the amount to be received in AED
                            var amountToBeReceivedInAED = balance_amount * 3.6735;
                            $('#amount_to_be_received_in_aed').val(amountToBeReceivedInAED.toFixed(2));
                        } else {
                            // AED calculation
                            var totalCost = parseFloat($('#total_price_cost').val()) || 0;
                            var vatPercentage = parseFloat($('#advanced_amount').val()) || 0;

                            var balance_amount = totalCost - vatPercentage;
                            $('#amount_to_be_received').val(balance_amount.toFixed(2));

                            // Clear the amount to be received in AED field
                            $('#amount_to_be_received_in_aed').val('');
                        }
                    }
                </script>
                <!-- SHOW DIALOG -->
                <div class="card" id="show" style="display:none">
    <div class="card-body" style="background-color:white;">
        <table class="table">
            <tbody>
                <tr>
                    <td><label>Site Name</label></td>
                    <td><p id="show_site_name"></p></td>
                    <td><label>Site No</label></td>
                    <td><p id="show_site_code"></p></td>
                    <td><label>Project code</label></td>
                    <td><p id="show_project_code"></p></td>
                </tr>
                <tr>
                    <td><label>Project Name</label></td>
                    <td><p id="show_project_name"></p></td>
                    <td><label>Project Type</label></td>
                    <td><p id="show_project_type"></p></td>
                    <td><label>Comments</label></td>
                    <td><p id="show_project_comments"></p></td>
                </tr>
                <tr>
                    <td><label>Manager Name</label></td>
                    <td><p id="show_firstname"></p></td>
                    <td><label>Manager Contact Number</label></td>
                    <td><p id="show_UAE_mobile_number"></p></td>
                    <td><label>Client / Company Name</label></td>
                    <td><p id="show_company_name"></p></td>
                </tr>
                <tr>
                    <td><label>Client Contact Number</label></td>
                    <td><p id="show_contact_number"></p></td>
                    <td><label>Consultant Name</label></td>
                    <td><p id="show_consultant_name"></p></td>
                    <td><label>Project Start Date</label></td>
                    <td><p id="show_start_date"></p></td>
                </tr>
                <tr>
                    <td><label>Tentative Project End Date</label></td>
                    <td><p id="show_end_date"></p></td>
                    <td><label>Actual Project End Date</label></td>
                    <td><p id="show_actual_project_end_date"></p></td>
                    <td><label>Project Status</label></td>
                    <td><p id="show_status"></p></td>
                </tr>
                <tr>
                    <td><label>Total Project Cost</label></td>
                    <td><p id="show_total_price_cost"></p></td>
                    <td><label>Advance Amount</label></td>
                    <td><p id="show_advanced_amount"></p></td>
                    <td><label>Retention</label></td>
                    <td><p id="show_retention"></p></td>
                </tr>
                <tr>
                    <td><label>Balance Amount to be Received</label></td>
                    <td><p id="show_amount_to_be_received"></p></td>
                    <td><label>Amount Return</label></td>
                    <td><p id="show_amount_return"></p></td>
                    <td><label>Amount Return Date</label></td>
                    <td><p id="show_amount_return_date"></p></td>
                </tr>
                <tr>
                    <td><label>Amount Return Comments</label></td>
                    <td><p id="show_amount_returns_comment"></p></td>
                    <td><label>Approved Variation Cost</label></td>
                    <td> <p id="show_Approved_Variation_Cost"></p></td>
                    <td> <label>Advance Variation Amount</label></td>
                    <td> <p id="show_Advance_Variation_Amount"></p></td>
                </tr>
                <tr><td> <label>Retention_Variation_Amount</label></td>
                      <td> <p id="show_Retention_Variation_Amount"></p></td>
                </tr>
            </tbody>
        </table>
        <div id="item_details_show"></div>
        <br>
        <button type="button" id="print" class="btn btn-primary float-end">Print</button>
    
    </div>
</div>
</dialog>
<!-- BOQ popup -->
<dialog id="dialog1">              
    <div class="card" id="show1" style="display:none">
        <div class="col-md-12" >
            <a class="btn  btn-sm" onclick="handleClose1()" style="float:right;padding: 10px 10px;">
                <i class="fas fa-close"></i>
            </a>
            <h4 id="heading_name" style="color: white; background-color:#45A6F2;" align="center">
                <b>BOQ</b>
            </h4>
        </div>
        <div class="container pt-4">
            <form  enctype="multipart/form-data" id="form1">
                <div class="table-responsive">
                    <center>
                        <table class="table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center">S.No</th>
                                    <th class="text-center" style="width:35%">Item Name</th>
                                    <th class="text-center" style="width:25%">Specification</th>
                                    <th class="text-center" style="width:10%">Quantity</th>
                                    <th class="text-center" style="width:10%">Unit</th>
                                    <th class="text-center" style="width:10%">Rate Per Quantity</th>                           
                                    <th class="text-center" style="width:10%">Amount</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                <!-- Table rows go here -->
                            </tbody>
                        </table>
                    </center>
                </div>
                <div style="text-align: right;">
                    <div style="margin-top: 8px; margin-right: 106px; display: inline-block;">
                        <button class="btn btn-md btn-primary" id="addBtn" type="button">Add Row</button>
                    </div>
                </div>
                
                <div style="text-align: center;">
                    <button class="btn btn-md btn-primary" id="submitButton" onclick="handlesubmit1()" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</dialog>   


            <script type="text/javascript">
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            </script>

            <script>
                $(function() {
                    $("#myTable").DataTable();
                });
            </script>
            <!--ADD DIALOG  -->
            <script type="text/javascript">
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
        html += '<td><div class="col-xs-12"><input type="number" name="rate_per_qty[]" id="rate_per_qty_' + rowIdx +
            '"  name="rate_per_qty[]" class="rate_per_qty form-control"></div></td>';
        
        html += '<td><div class="col-xs-12"><input type="text" name="amount[]" id="amount_' + rowIdx +
            '"  name="amount[]" class="amount form-control" readonly></div></td>';
      
  
        if(rowIdx !=1){
        html +=
            '<td><button class="btn btn-danger remove btn-sm" id="delete" type="button"><i class="fa fa-trash"></i></button></td>';
        html += '</tr>';
        }

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
        calculateTotal();
    });
    $('#tbody').on('input', 'input[id^="qty_"], input[id^="rate_per_qty_"]', function() {
      var row = $(this).closest('tr');
      var quantity = parseFloat(row.find('input[id^="qty_"]').val()) || 0;
      var rate = parseFloat(row.find('input[id^="rate_per_qty_"]').val()) || 0;
      var itemAmount = quantity * rate;
      row.find('input[id^="amount_"]').val(itemAmount);
      calculateTotal();
    
    });
// calculation
    function calculateTotal() {
      var total = 0;
      $("input[name='amount[]']").each(function() {
        var val = parseFloat($(this).val());
        if (!isNaN(val)) {
          total += val;
        }
      });
      $("#total_price_cost").val(total.toFixed(2));
    }
    jQuery($ => {
    $(document).on('focus click', $("#tbody"), function() {
        
        $('#tbody').find('.item_name').autocomplete({
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
                function handleDialog() {
                    document.getElementById("myDialog").open = true;
                    window.scrollTo(0, 0);
                    $('#method').val("ADD");
                    $('#submit').text("ADD");
                    $('#heading_name').text("Add Project Details").css('font-weight', 'bold');
                    $('#project_code').hide();
                    $('#code_lable').hide();
                    $('#show').css('display', 'none');
                    $('#form').css('display', 'block');
                    $('#blur-background').css('display', 'block');

                }
                function boq(){
                   
                    if($('#method').val() == 'ADD'){
                        document.getElementById("dialog1").open = true;
                        var tbody = document.getElementById("tbody");
                        if (tbody && tbody.childElementCount === 0) {
                        document.getElementById("dialog1").open = true;
                        add_text();
                        }

                    }
                    else{
                        document.getElementById("dialog1").open = true; 
                    }
                    window.scrollTo(0, 0);                    
                    $('#show').css('display', 'none');                 
                    $('#show1').css('display', 'block');
                    $('#blur-background').css('display', 'block');  
                }
                // DELETE FUNCTION
                function handleDelete(id) {
                    let url = '{{ route('projectApi.delete', ':project_no') }}';
                    url = url.replace(':project_no', id);
                    if (confirm("Are you sure want to delete this Project Details?")) {
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
                // DIALOG CLOSE BUTTON
                function handleClose() {
                    document.getElementById("myDialog").open = false;
                    document.getElementById("dialog1").open = false;
                    var tbody = document.getElementById("tbody");
                        if (tbody) {
                            while (tbody.firstChild) {
                            tbody.firstChild.remove();
                            }
                        }                        
                        rowIdx = 1;
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
                function handleClose1() {
                // Close the dialog
                if($('#method').val() == 'ADD'){
                    var tbody = document.getElementById("tbody");
                        if (tbody) {
                            while (tbody.firstChild) {
                            tbody.firstChild.remove();
                            }
                        }
                        rowIdx = 1;
                        $('#total_price_cost').val("");
                     document.getElementById("dialog1").open = false;
                }
                else{
                document.getElementById("dialog1").open = false;
                
                }
                }
// In this code, after closing the dialog, we locate the tbody element using getElementById. Then, we retrieve all the rows with the class name "rowtr" using getElement
                function handlesubmit1()
                { 
                    event.preventDefault();
                     var hasError = false;
                     var itemNames = [];
                   $('.rowtr').each(function() {
                    // Get the row index
                    var rowIdx = $(this).attr('id').replace('row', '');
                    // Get the item name value for the current row
                    var itemName = $('#item_name_' + rowIdx).val(); // Assuming it's an input field
                    var qty=$('#qty_' + rowIdx).val();
                    var rate_per_qty=$('#rate_per_qty_' + rowIdx).val();    
                    // Check if item name is null or empty
                    if (itemName === '') {
                        alert('Please enter an item name in row ' + rowIdx);
                        document.getElementById("dialog1").open = true;
                        hasError = true;
                        return false; // Exit the loop
                    }

                    if (itemNames.includes(itemName)) {
                        alert('Item name "' + itemName + '" already exists in another row.');
                        document.getElementById("dialog1").open = true;
                        hasError = true;
                        return false; // Exit the loop
                    }

                    itemNames.push(itemName);
                    if (qty === '') {
                        alert('Please enter quantity in row ' + rowIdx);
                        document.getElementById("dialog1").open = true;
                        hasError = true;
                        return false; // Exit the loop
                    }
                    if (!/^\d+(\.\d+)?$/.test(qty)) {
                            alert('Quantity must be a valid number in row ' + rowIdx);
                            document.getElementById("dialog1").open = true;
                            hasError = true;
                            return false; // Exit the loop
                        }
                    if (rate_per_qty === '') {
                        alert('Please enter rate per qty in row ' + rowIdx);
                        document.getElementById("dialog1").open = true;
                        hasError = true;
                        return false; // Exit the loop
                    }
                    if (!/^\d+(\.\d+)?$/.test(rate_per_qty)) {
                            alert('Rate Per Qty must be a valid number in row ' + rowIdx);
                            document.getElementById("dialog1").open = true;
                            hasError = true;
                            return false; // Exit the loop
                        }
                });
                    if(!hasError) {
                        document.getElementById("dialog1").open = false;
                                }
                 }

                // DIALOG SUBMIT FOR ADD AND EDIT
                function handleSubmit() {
                    event.preventDefault();
                    var hasError = false;
                    $('.rowtr').each(function() {
                    // Get the row index
                    var rowIdx = $(this).attr('id').replace('row', '');
                    // Get the item name value for the current row
                    var itemName = $('#item_name_' + rowIdx).val(); // Assuming it's an input field
                    var qty=$('#qty_' + rowIdx).val();
                    var rate_per_qty=$('#rate_per_qty_' + rowIdx).val();    
                    // Check if item name is null or empty
                    if (itemName === '') {
                        alert('Please enter an item name in row ' + rowIdx);
                        document.getElementById("dialog1").open = true;
                        hasError = true;
                        return false; // Exit the loop
                    }
                    if (qty === '') {
                        alert('Please enter quantity in row ' + rowIdx);
                        document.getElementById("dialog1").open = true;
                        hasError = true;
                        return false; // Exit the loop
                    }
                    if (rate_per_qty === '') {
                        alert('Please enter rate per qty in row ' + rowIdx);
                        document.getElementById("dialog1").open = true;
                        hasError = true;
                        return false; // Exit the loop
                    }
                });
                    if(!hasError) {
                    var hiddenErrorElements = $('.error-msg:not(:hidden)').length;
                    if (hiddenErrorElements === 0) {
                        document.getElementById("dialog1").open = false;
                        event.preventDefault();
                        let form_data = new FormData(document.getElementById('form'));
                        let form_data1 = new FormData(document.getElementById('form1'));
                        // Combine form data from both forms
                        let combined_form_data = new FormData();
                        for (var pair of form_data.entries()) {
                            combined_form_data.append(pair[0], pair[1]);
                        }
                        for (var pair of form_data1.entries()) {
                            combined_form_data.append(pair[0], pair[1]);
                        }
                        let method = $('#method').val();
                        let url;
                        let type;
                        if (method == 'ADD') {
                            url = '{{ route('projectApi.store') }}';
                            type = 'POST';
                        } else {
                            let id = $('#project_no').val();
                            url = '{{ route('projectApi.update', ':project_no') }}';
                            url = url.replace(':project_no', id);
                            type = 'POST';
                        }

                        $.ajax({
                            url: url,
                            type: type,
                            data: combined_form_data,
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function (message) {
                                alert(message);
                                window.location.reload();
                            },
                            error: function (message) {
                                var data = message.responseJSON;
                                // Handle error
                            }
                        });
                    }
                }
                }

                //DATA SHOW FOR EDIT AND SHOW
                var currentProjectName;

                function handleShowAndEdit(id, action) {
                    let url = '{{ route('projectApi.show', ':project_no') }}';
                    url = url.replace(':project_no', id);
                    let type = "GET"
                    $.ajax({
                        url: url,
                        type: type,
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function(message) {
                                if (action == 'edit') {
                                $('#heading_name').text("Update Project Details").css('font-weight', 'bold');
                                $('#show').css('display', 'none');
                                $('#form').css('display', 'block');
                                $('#blur-background').css('display', 'block');

                                for (const [key, value] of Object.entries(message.data[0])) {
                                    $(`#${key}`).val(value);
                                }
                                $('#amount_type').prop('checked', true);
                              
                                if (message.data[0].amount_type == '0') {
                                    $('#amount_type').val('0');
                                    $('#amount_type').prop('checked', false);
                                    $('.toggle').addClass('on').addClass('checked');
                                    $('.toggle .label').text('%');
                                } else if (message.data[0].amount_type == '1') {
                                    $('#amount_type').val('1');
                                    $('#amount_type').prop('checked', true);
                                    $('.toggle').removeClass('on').removeClass('checked');
                                    $('.toggle .label').text('AED');
                                }
                                //rentention
                                $('#retention_type').prop('checked', true);
                               
                                if (message.data[0].retention_type == '0') {
                                    $('#retention_type').val('0');
                                    $('#retention_type').prop('checked', false);
                                    $('.toggle-retention').addClass('on').addClass('checked');
                                    $('.toggle-retention .label').text('%');
                                } else if (message.data[0].retention_type == '1') {
                                    $('#retention_type').val('1');
                                    $('#retention_type').prop('checked', true);
                                    $('.toggle-retention').removeClass('on').removeClass('checked');
                                    $('.toggle-retention .label').text('AED');
                                }
                                currentProjectName = message.data[0].project_name.toLowerCase().replace(/ /g, '');
                               
                               var rowid=1;
                    for (const item of message.project_item_details) 
                    {
                        
                        add_text(); // add a new row to the table
                        $('#item_name_' + rowid).val(item.item_name);
                        $('#item_no_' + rowid).val(item.item_no);
                        $('#specification_'+ rowid).text(item.specification);
                        $('#qty_'+ rowid).val(item.qty);
                        $('#unit_'+ rowid).val(item.unit);
                        $('#rate_per_qty_'+ rowid).val(item.rate_per_qty);
                        $('#amount_'+ rowid).val(item.amount);

                        rowid++;
                    }
                                $('#method').val('UPDATE');
                                $('#submit').text('UPDATE');
                            } else {
                                for (let [key, value] of Object.entries(message.data[0])) {
                                    if (key === "start_date" || key === "end_date" || key ===
                                        "actual_project_end_date" || key === "amount_return_date") {
                                        if (value == null) {
                                            value = "";
                                        } else if (key === "amount_return_date" && isNaN(new Date(value))) {
                                            value = "";
                                        } else {
                                            var dateObj = new Date(value);
                                            var day = dateObj.getDate();
                                            var month = dateObj.getMonth() + 1;
                                            var year = dateObj.getFullYear();
                                            value = day + '-' + month + '-' + year;
                                        }
                                    }
                                    $(`#show_${key}`).text(value);
                                    
                                }
                                        let script = '<table id="show_table" class="table table-striped"><thead><tr><th>Item Name</th><th>Specification</th><th>Quantity</th><th>Unit</th><th>Rate per Quantity</th><th>Amount</th></tr></thead><tbody>';
                                        for (const item of message.project_item_details) {
                                    script += '<tr>';
                                    script += '<td>' + item.item_name + '</td>';
                                    if(item.pack_specification == null){
                                        item.pack_specification ='';}
                                        
                                    script += '<td>' + item.specification + '</td>';
                                    script += '<td>' + item.qty+ '</td>';
                                    script += '<td>' + item.unit+ '</td>';
                                    script += '<td>' + item.rate_per_qty + '</td>';
                                    script += '<td>' + item.amount + '</td>';
                                    script += '</tr>';
                                    }
                                script+= '</tbody></table>';
                                $('show_table').remove();
                                $('#item_details_show').append(script);
                                $('#heading_name').text("Project Details").css('font-weight', 'bold');
                                $('#show').css('display', 'block');
                                $('#form').css('display', 'none');
                                $('#blur-background').css('display', 'block');
                            }
                            document.getElementById("myDialog").open = true;
                            window.scrollTo(0, 0);
                        },
                    })
                }

                

                // auto complete for managername from employeemasters
                jQuery($ => {
                    $(document).on('focus', 'input', '#firstname', function() {
                        $("#firstname").autocomplete({
                            source: function(request, response) {
                                $.ajax({
                                    type: "GET",
                                    url: "{{ route('getemployeedata') }}",
                                    dataType: "json",
                                    data: {
                                        'firstname': $("#firstname").val()
                                    },
                                    success: function(data) {
                                        result = [];
                                        for (var i in data) {
                                            result.push(data[i]["firstname"]);
                                        }
                                        response(result);
                                    },
                                    fail: function(xhr, textStatus, errorThrown) {
                                        alert(errorThrown);
                                    }
                                });
                            },
                            select: function(event, ui) {
                                var selectedFirstName = ui.item.value;
                                updateFirstNameValue(selectedFirstName);
                            }
                        });
                    });

                    // Employee code
                    $(document).on('input', '#firstname', function() {
                        updateFirstNameValue($(this).val());
                    });

                    function updateFirstNameValue(firstName) {
                        $.ajax({
                            type: "GET",
                            url: "{{ route('getemployeedata') }}",
                            dataType: "json",
                            data: {
                                'firstname': firstName
                            },
                            success: function(data) {
                                for (var i in data) {
                                    $('#employee_no').val(data[i]["id"]);
                                    $('#UAE_mobile_number').val(data[i]["UAE_mobile_number"]);
                                }
                            },
                            fail: function(xhr, textStatus, errorThrown) {
                                alert(errorThrown);
                            }
                        });
                    }
                });


                
                    // Site code
                    $(document).on('input', '#site_name', function() {
                        var selectedSiteName = $(this).val();
                        updateSiteManagerValue(selectedSiteName);
                    });

                    function updateSiteManagerValue(siteName) {
                        $.ajax({
                            type: "GET",
                            url: "{{ route('getsitedata') }}",
                            dataType: "json",
                            data: {
                                'site_name': siteName
                            },
                            success: function(data) {
                                
                                for (var i in data) {
                                    $('#site_no').val(data[0]["site_no"]);
                                    $('#site_code').val(data[0]["site_code"]);
                                }
                            },
                            fail: function(xhr, textStatus, errorThrown) {
                                alert(errorThrown);
                            }
                        });
                    }
                

                // auto complete for client from clientmaster
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

                document.getElementById("print").addEventListener("click", function() {
                    $('#heading_name').css('color', 'black').css('font-weight', 'bold');
                   window.print();
                     $('#heading_name').css('color', 'white').css('font-weight', 'bold');
                });
                // / Initialize form validation

                var project_Name = @json($projectName);
                var sitename = @json($siteNames);
                var employee_name = @json($employee_name);
                var client_company = @json($client_company);

                $.validator.addMethod("uniqueProjectName", function(value, element) {

                    var lowercaseValue = value.toLowerCase().replace(/\s/g, '');

                    if ($("#method").val() !== "ADD" && lowercaseValue === currentProjectName) {
                        return true;
                    }
                    var lowercaseValu = value.toLowerCase().replace(/\s/g, '');
                    return !project_Name.includes(lowercaseValu);
                });

                $.validator.addMethod("siteNameCheck", function(value, element) {
                    return sitename.includes(value);
                });

                $.validator.addMethod("employeeNameCheck", function(value, element) {
                    return employee_name.includes(value);
                });
                $.validator.addMethod("clientcompanyNameCheck", function(value, element) {
                    return client_company.includes(value);
                });
                $.validator.addMethod("greaterThan", function(value, element, param) {
                    var startDate = $(param).val();
                    if (!value || !startDate) {
                        return true; // Skip validation if either date is missing
                    }

                    return new Date(value) > new Date(startDate);
                }, "Invalid date");
                $.validator.addMethod("alphanumeric", function(value, element) {
                    
                    return this.optional(element) || /^[A-Za-z ]+$/i.test(value);
                });
                var formValidationConfig = {
                    rules: {
                        project_name: {
                            required: true,
                            uniqueProjectName: true
                        },
                        site_name: {
                            required: true,
                            siteNameCheck: true
                        },
                        project_type: "required",
                        firstname: {
                            required: true,
                            employeeNameCheck: true
                        },
                        company_name: {
                            clientcompanyNameCheck: true,
                            required: true
                        },
                        consultant_name: {
                            alphanumeric: true
                        },

                        start_date: "required",
                        end_date: {
                            required: true,
                            date: true,
                            greaterThan: "#start_date"
                        },

                        actual_project_end_date: {
                            required: true,
                            date: true,
                            greaterThan: "#start_date"
                        },
                        status: "required",
                        total_price_cost: {
                            required: true,
                            number: true
                        },
                        advanced_amount: {
                            required: true,
                            number: true
                        },
                        retention: {

                            number: true
                        },
                        amount_return: {

                            number: true
                        }, 
                        "item_name[]":
                        {
                            required: true,
                            
                        }
                    },
                    messages: {
                        project_name: {
                            required: "Please enter the project name",
                            uniqueProjectName: "This project name already exists. Please enter a different project name."
                        },
                        site_name: {
                            required: "Please enter the site name",
                            siteNameCheck: "Please enter a valid site name."
                        },
                        project_type: "Please select the project type",
                        firstname: {
                            required: "Please enter the Manager Name",
                            employeeNameCheck: "Please enter a valid Manager Name."
                        },
                        company_name: {
                            clientcompanyNameCheck: "Please enter a valid client/company Name",
                            required: "Please enter the client/company Name"
                        },
                        consultant_name: {
                            alphanumeric: "The consultant name allows only alphabets."
                        },
                        start_date: "Please select the project start date",
                        end_date: {
                            required: "Please select the tentative project end date",
                            date: "Please enter a valid date",
                            greaterThan: "The tentative project end date must be after the start date."
                        },
                        actual_project_end_date: {
                            required: "Please enter the actual project end date",
                            date: "Please enter a valid date",
                            greaterThan: "The actual project end date must be after the start date."
                        },
                        status: "Please select the project status",
                        total_price_cost: {
                            required: "Please enter the BOQ details",
                            number: "The total project cost must be a number."
                        },
                        advanced_amount: {
                            required: "Please enter the advanced amount",
                            number: "The advanced amount must be a number."
                        },
                        retention: {
                            number: "The retention must be a number."
                        },
                        amount_return: {
                            number: "The amount return must be a number."
                        }, 
                        "item_name[]":
{
    required: "Please enter the item name",
  
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