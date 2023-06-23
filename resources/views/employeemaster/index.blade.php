<!-- STYLE INCLUDED IN LAYOUT PAGE -->
@extends('layouts.app', [
    'activeName' => 'Employee Master',
])
@section('title', 'Employee Master')

@section('content_header')
@stop

@section('content')
    <!-- DATA table -->
    <div class="row">
        <div class="container-fluid">
            <div class="card shadow">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h4 class="font-weight-bold text-dark py">EMPLOYEE MASTER</h4>
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
                                    <th>Employee Code</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Category</th>
                                    <th>Working As</th>
                                    <th>Department</th>
                                    <th>Date of Joining</th>
                                    <th>Sponsor</th>
                                    <th>UAE Mobile Number</th>
                                    <th>Accomodation</th>
                                    <th>Visa Status</th>
                                    <th>Total Salary</th>
                                    <th>Account Number</th>
                                    <th>Name of the Bank</th>
                                    <th>WPS</th>
                                    <th data-orderable="false" class="action notexport">Show</th>
                                    <th data-orderable="false"class="action notexport">Edit</th>
                                    <th data-orderable="false" class="action notexport">Delete</th>
                                    <div id="blur-background" class="blur-background"></div>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employes as $key => $employe)
                                    <tr class="text-center">
                                        <td>{{ $employe->employee_no }}</td>
                                        <td>{{ $employe->firstname }}</td>
                                        <td>{{ $employe->lastname }}</td>
                                        <td>{{ $employe->category }}</td>
                                        <td>{{ $employe->working_as }}</td>
                                        <td>{{ $employe->depart }}</td>
                                        <td>{{ date('d-m-Y', strtotime($employe->join_date)) }}</td>
                                        <td>{{ $employe->sponser }}</td>
                                        <td>{{ $employe->UAE_mobile_number }}</td>
                                        <td>{{ $employe->accomodation }}</td>
                                        <td>{{ $employe->visa_status }}</td>
                                        <td>{{ $employe->total_salary }}</td>
                                        <td>{{$employe->account_no}}</td>
                                        <td>{{$employe->bank_name}}</td>
                                        <td>{{$employe->wps}}</td>
                                        <td>
                                            <a onclick="handleShowAndEdit('{{ $employe->id }}','show')"
                                                class="btn btn-primary btn-circle btn-sm">
                                                <i class="fas fa-flag"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a onclick="handleShowAndEdit('{{ $employe->id }}','edit')"
                                                class="btn btn-info btn-circle btn-sm mx-2">
                                                <i class="fas fa-check"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="handleDelete('{{ $employe->id }}')">
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
                        <h4 id='heading_name' style='color:white' align="center"><b>Update Employee</b></h4>
                    </div>
                </div>
                <form class="form-row" enctype="multipart/form-data" style="display:block" id="form"
                    onsubmit="handleSubmit()">
                    <input type="hidden" id="method" value="ADD" />
                    <input type="hidden" id="id" name="id" value="" /><br>

                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="code" id="code_lable"class="form-label fw-bold">Employee Code</label>
                            <input type="text" id="employee_no" name="employee_no" readonly
                                value="{{ old('employee_no') }}" placeholder="Employee Code" class="form-control"
                                autocomplete="off">

                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="firstname" class="form-label fw-bold">First Name<a
                                    style="text-decoration: none;color:red">*</a></label>
                            <input type="text" id="firstname" name="firstname" value="{{ old('firstname') }}"
                                placeholder="First Name" class="form-control" autocomplete="off">

                        </div>

                        <div class="form-group col-md-6">
                            <label for="lastname" class="form-label fw-bold">Last Name<a
                                    style="text-decoration: none;color:red">*</a></label>
                            <input type="text" id="lastname" name="lastname" value="{{ old('lastname') }}"
                                placeholder="Last Name" class="form-control" autocomplete="off">

                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="fathername" class="form-label fw-bold">Father Name<a
                                    style="text-decoration: none;color:red">*</a></label>
                            <input type="text" id="fathername" name="fathername" value="{{ old('fathername') }}"
                                placeholder="Father Name" class="form-control" autocomplete="off">

                        </div>
                        <div class="form-group col-md-6">
                            <label for="mothername" class="form-label fw-bold">Mother Name<a
                                    style="text-decoration: none;color:red">*</a></label>
                            <input type="text" id="mothername" name="mothername" value="{{ old('mothername') }}"
                                placeholder="Mother Name" class="form-control" autocomplete="off">

                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="join_date" class="form-label fw-bold">Date of joining<a
                                    style="text-decoration: none;color:red">*</a></label>
                            <input type="date" id="join_date" name="join_date" value="{{ old('join_date') }}"
                                placeholder="join_date" class="form-control" autocomplete="off">

                        </div>
                        <div class="form-group col-md-6">
                            <label for="end_date" class="form-label fw-bold">End Date</label>
                            <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}"
                                placeholder="end_date" class="form-control" autocomplete="off">

                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="form-group col-md-6">
                            <label for="category" class="form-label fw-bold">Category<a
                                    style="text-decoration: none;color:red">*</a></label>
                            <select id="category" name="category" class="form-control form-select" autocomplete="off">
                                <option value="">Select Option</option>
                                @foreach ($category as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="form-group col-md-6">
                            <label for="sponser" class="form-label fw-bold">Sponsor<a
                                    style="text-decoration: none;color:red">*</a></label>
                            <select id="sponser" name="sponser" class="form-control form-select" autocomplete="off"
                                style="width:100%">
                                <option value="">Select Option</option>
                                @foreach ($sponsor as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                            <div id="sponser-error" class="error-msg" style="display: none;"></div>

                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="form-group col-md-6">
                            <label for="working_as" class="form-label fw-bold">Working As<a
                                    style="text-decoration: none;color:red">*</a></label>
                            <select id="working_as" name="working_as" class="form-control form-select"
                                autocomplete="off" style="width:100%">
                                <option value="">Select Option</option>
                                @foreach ($working_as as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                            <div id="working_as-error" class="error-msg" style="display: none;"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="depart" class="form-label fw-bold">Department<a
                                    style="text-decoration: none;color:red">*</a></label>
                            <select id="depart" name="depart" class="form-control form-select" autocomplete="off">
                                <option value="">Select Option</option>
                                @foreach ($department as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="status" class="form-label fw-bold">Status<a
                                    style="text-decoration: none;color:red">*</a></label>
                            <select id="status" name="status" class="form-control form-select" autocomplete="off">
                                <option value="">Select Option</option>
                                @foreach ($status as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="form-group col-md-6">
                            <label for="religion" class="form-label fw-bold">Religion<a
                                    style="text-decoration: none;color:red">*</a></label>
                            <select id="religion" name="religion" class="form-control form-select" autocomplete="off">
                                <option value="">Select Option</option>
                                @foreach ($religion as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="nationality" class="form-label fw-bold">Nationality<a
                                    style="text-decoration: none;color:red">*</a></label>
                            <!-- <input type="text" id="nationality" name="nationality"  value="{{ old('nationality') }}" placeholder=" nationality" class="form-control" autocomplete="off"> -->
                            <select id="nationality" name="nationality" class="form-control form-select"
                                autocomplete="off">
                                <option value="">Select Option</option>
                                @foreach ($nationality as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="form-group col-md-6">
                            <label for="city" class="form-label fw-bold">Current Location<a
                                    style="text-decoration: none;color:red">*</a></label>
                            <input type="text" id="city" name="city" value="{{ old('city') }}"
                                placeholder="Project Name" class="form-control" autocomplete="off">


                        </div>

                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="phone" class="form-label fw-bold">Home Country Contact Number<a
                                    style="text-decoration: none;color:red">*</a></label><br>
                            <!-- <input type="phone_number" name="phone" id="phone" value="{{ old('phone') }}" placeholder="Phone No" class="input form-control" autocomplete="off"> -->
                            <input type="hidden" id="country_code" name="country_code"
                                value="{{ old('country_code') }}" />
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                                class="input form-control" size="60">

                            <!-- <input type="tel" id="phone" name="phone"  value="{{ old('phone') }}" placeholder=" phone" class="form-control phone_number" autocomplete="off"> -->

                        </div>
                        <div class="form-group col-md-6">
                            <label for="UAE_mobile_number" class="form-label fw-bold">UAE Mobile Number<a
                                    style="text-decoration: none;color:red">*</a></label>
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">{{ +971 }}</span>
                                <!-- </div> -->
                                <input type="text" id="UAE_mobile_number" name="UAE_mobile_number"
                                    value="{{ old('UAE_mobile_number') }}" placeholder=" UAE_mobile_number"
                                    class="form-control" autocomplete="off">
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="pay_group" class="form-label fw-bold">Pay Group<a
                                    style="text-decoration: none;color:red">*</a></label>
                            <select id="pay_group" name="pay_group" class="form-control form-select" autocomplete="off">
                                <option value="">Select Option</option>
                                @foreach ($pay_group as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="form-group col-md-6">
                            <label for="accomodation" class="form-label fw-bold">Accomodation<a
                                    style="text-decoration: none;color:red">*</a></label>
                            <select id="accomodation" name="accomodation" class="form-control form-select"
                                autocomplete="off">
                                <option value="">Select Option</option>
                                @foreach ($accomodation as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="passport_no" class="form-label fw-bold">Passport Number<a
                                    style="text-decoration: none;color:red">*</a></label>
                            <input type="text" id="passport_no" name="passport_no" value="{{ old('passport_no') }}"
                                placeholder=" Passport no" class="form-control" autocomplete="off">

                        </div>
                        <div class="form-group col-md-6">
                            <label for="passport_expiry_date" class="form-label fw-bold">Passport Expiry Date<a
                                    style="text-decoration: none;color:red">*</a></label>
                            <input type="date" id="passport_expiry_date" name="passport_expiry_date"
                                value="{{ old('passport_expiry_date') }}" placeholder="passport_expiry_date"
                                class="form-control" autocomplete="off">

                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="emirates_id_no" class="form-label fw-bold">Emirates Id No<a
                                    style="text-decoration: none;color:red">*</a></label>
                            <input type="text" id="emirates_id_no" name="emirates_id_no"
                                value="{{ old('emirates_id_no') }}" placeholder="Emirates id no" class="form-control"
                                autocomplete="off">

                        </div>

                        <div class="form-group col-md-6">
                            <label for="emirates_id_from_date" class="form-label fw-bold">Emirates Id From Date<a
                                    style="text-decoration: none;color:red">*</a></label>
                            <input type="date" id="emirates_id_from_date" name="emirates_id_from_date"
                                value="{{ old('emirates_id_from_date') }}" placeholder=" emirates_id_from_date"
                                class="form-control" autocomplete="off">

                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="emirates_id_to_date" class="form-label fw-bold">Emirates Id To Date<a
                                    style="text-decoration: none;color:red">*</a></label>
                            <input type="date" id="emirates_id_to_date" name="emirates_id_to_date"
                                value="{{ old('emirates_id_to_date') }}" placeholder=" emirates_id_to_date"
                                class="form-control" autocomplete="off">

                        </div>


                        <div class="form-group col-md-6">
                            <label for="expiry_date" class="form-label fw-bold">Visa End Date<a
                                    style="text-decoration: none;color:red">*</a></label>
                            <input type="date" id="expiry_date" name="expiry_date" value="{{ old('expiry_date') }}"
                                placeholder=" expiry_date" class="form-control" autocomplete="off">

                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="form-group col-md-6">
                            <label for="visa_status" class="form-label fw-bold">Visa Status<a
                                    style="text-decoration: none;color:red">*</a></label>
                            <select id="visa_status" name="visa_status" class="form-control form-select"
                                autocomplete="off">
                                <option value="">Select Option</option>
                                @foreach ($visa_status as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="form-group col-md-6">
                            <label for="desigination" class="form-label fw-bold">Visa Designation<a
                                    style="text-decoration: none;color:red">*</a></label>
                            <select id="desigination" name="desigination" class="form-control select2"
                                autocomplete="off" style="width:100%">
                                <option value="">Select Option</option>
                                @foreach ($desigination as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                            <div id="desigination-error" class="error-msg" style="display: none;"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="basic" class="form-label fw-bold">Basic<a
                                    style="text-decoration: none;color:red">*</a></label>
                            <input type="number" id="basic" name="basic" value="{{ old('basic') }}"
                                placeholder="Basic" class="form-control" autocomplete="off">

                        </div>
                        <div class="form-group col-md-4">
                            <label for="total_salary" class="form-label fw-bold">Total Salary<a
                                    style="text-decoration: none;color:red">*</a></label>
                            <input type="number" id="total_salary" name="total_salary"
                                value="{{ old('total_salary') }}" placeholder="Total Salary" class="form-control"
                                autocomplete="off">

                        </div>
                        <div class="form-group col-md-4">
                            <label for="hra" class="form-label fw-bold">HRA<a
                                    style="text-decoration: none;color:red">*</a></label>
                            <input type="number" id="hra" name="hra" value="{{ old('hra') }}"
                                placeholder="HRA" class="form-control" autocomplete="off">

                        </div>
                    </div>
                    <div class="row">
                    <div class="form-group col-md-4">
                            <label for="account_np" class="form-label fw-bold">A/C No</label>
                            <input type="number" id="account_no" name="account_no" value="{{ old('account_no') }}"
                                placeholder="Account_No" class="form-control" autocomplete="off">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="bank_name" class="form-label fw-bold">Name of the Bank</label>
                            <input type="text" id="bank_name" name="bank_name" value="{{ old('bank_name') }}"
                                placeholder="Bank_Name" class="form-control" autocomplete="off">
                        </div>
    
                                       
                        <div class="form-group col-md-4">
                            <label for="wps" class="form-label fw-bold">WPS</label>
                            <input type="number" id="wps" name="wps" value="{{ old('wps') }}"
                                placeholder="WPS" class="form-control" autocomplete="off">
                        </div>
                    </div>
                    <div class="row">
                        <label>
                            Over Time:<br>
                            <input type="checkbox" id="over_time" name="over_time" value="1"
                                {{ old('over_time') ? 'checked' : '' }}>

                        </label>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-2">
                            <label for="">Attachments</label>
                        </div>
                        <div class="col-md-4">
                            <input type="file" name="attachments" class="form-control">
                            <span id="filename"></span>
                        </div>
                        <div class="col-md-6">
                            <button type="button" id="deleteButton" class="btn btn-danger">Delete</button>
                            <input type="hidden" name="delete_attachment" id="deleteAttachmentInput" value="0">
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <button type="submit" id="submit" class="btn btn-primary float-end ">ADD</button>
                    </div>
                </form>
                <!-- SHOW DIALOG -->
                <div class="card" id="show" style="display:none">
    <div class="card-body" style="background-color:white;">
        <table class="table">
            <tbody>
                <tr>
                    <td><label>Employee code</label></td>
                    <td><p id="show_employee_no"></p></td>
                    <td><label>First Name</label></td>
                    <td><p id="show_firstname"></p></td>
                    <td><label>Last Name</label></td>
                    <td><p id="show_lastname"></p></td>
                </tr>
                <tr>
                    <td><label>Father Name</label></td>
                    <td><p id="show_fathername"></p></td>
                    <td><label>Mother Name</label></td>
                    <td><p id="show_mothername"></p></td>
                    <td><label>Date of Joining</label></td>
                    <td><p id="show_join_date"></p></td>
                </tr>
                <tr>
                    <td><label>End Date</label></td>
                    <td><p id="show_end_date"></p></td>
                    <td><label>Category</label></td>
                    <td><p id="show_category"></p></td>
                    <td><label>Sponsor</label></td>
                    <td><p id="show_sponser"></p></td>
                </tr>
                <tr>
                    <td><label>Working As</label></td>
                    <td><p id="show_working_as"></p></td>
                    <td><label>Visa Designation</label></td>
                    <td><p id="show_desigination"></p></td>
                    <td><label>Department</label></td>
                    <td><p id="show_depart"></p></td>
                </tr>
                <tr>
                    <td><label>Status</label></td>
                    <td><p id="show_status"></p></td>
                    <td><label>Nationality</label></td>
                    <td><p id="show_nationality"></p></td>
                    <td><label>Location</label></td>
                    <td><p id="show_city"></p></td>
                </tr>
                <tr>
                    <td><label>Home Country Number</label></td>
                    <td><p id="show_phone"></p></td>
                    <td><label>UAE Mobile Number</label></td>
                    <td><p id="show_UAE_mobile_number"></p></td>
                    <td><label>Accomodation</label></td>
                    <td><p id="show_accomodation"></p></td>
                </tr>
                <tr>
                    <td><label>Passport Number</label></td>
                    <td><p id="show_passport_no"></p></td>
                    <td><label>Passport Expiry Date</label></td>
                    <td><p id="show_passport_expiry_date"></p></td>
                    <td><label>Emirates Id No</label></td>
                    <td><p id="show_emirates_id_no"></p></td>
                </tr>
                <tr>
                    <td><label>Emirates Id From Date</label></td>
                    <td><p id="show_emirates_id_from_date"></p></td>
                    <td><label>Emirates Id To Date</label></td>
                    <td><p id="show_emirates_id_to_date"></p></td>
                    <td><label>Visa End Date</label></td>
                    <td><p id="show_expiry_date"></p></td>
                </tr>
                <tr>
                    <td><label>Visa Status</label></td>
                    <td><p id="show_visa_status"></p></td>
                    <td><label>Basic</label></td>
                    <td><p id="show_basic"></p></td>
                    <td><label>Total Salary</label></td>
                    <td><p id="show_total_salary"></p></td>
                </tr>
                <tr>
               <td><label>Account Number</label></td>
               <td><p id="show_account_no"></p></td>             
                  <td><label>Name of the Bank</label></td>
               <td><p id="show_bank_name"></p></td>
                   <td><label>WPS</label></td>
                     <td><p id="show_wps"></p></td>
                    </tr>
                    <tr>
                    <td><label>HRA</label></td>
                    <td><p id="show_hra"></p></td>
                
                    <td><label>Attachments</label></td>
                    <td><p id="show_filename"></p></td>
                </tr>
            </tbody>
        </table>
        <br>
        <button type="button" id="print" class="btn btn-primary float-end">Print</button>
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
    // delete attachment
    document.getElementById("deleteButton").addEventListener("click", function() {
                     if (confirm("Are you sure you want to delete this attachment?")) {
                         document.getElementById("deleteAttachmentInput").value = "1";
                         document.querySelector("input[name='attachments']").value = "";
                         document.getElementById("filename").textContent = "";
                     }
                 });
</script>
            <script>
                $(function() {
                    $("#myTable").DataTable();
                });
            </script>


            <script type="text/javascript">
                // ADD DIALOG
                function handleDialog() {
                    window.scrollTo(0, 0)
                    document.getElementById("myDialog").open = true;
                    $('#method').val("ADD");
                    $('#submit').text("ADD");
                    $('#heading_name').text("Add Employee Details").css('font-weight', 'bold');
                    $('#employee_no').hide();
                    $('#code_lable').hide();
                    $('#show').css('display', 'none');
                    $('#form').css('display', 'block');
                    $('#blur-background').css('display', 'block');
                }
                // DELETE FUNCTION
                function handleDelete(id) {
                    let url = '{{ route('employeeApi.delete', ':id') }}';
                    url = url.replace(':id', id);
                    if (confirm("Are you sure want to delete this Employee Details?")) {
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
                    // Clear the form fields
                    $('#form')[0].reset();
                    // Reset Select2 dropdowns
                    $('#desigination, #sponser, #working_as').val(null).trigger('change');
                    $('.error-msg').removeClass('error-msg');
                    $('.has-error').removeClass('has-error');
                    // Hide any error messages
                    $('error').html('');
                    // Hide the dialog background
                    $('#blur-background').css('display', 'none');
                }
                // DIALOG SUBMIT FOR ADD AND EDIT
                function handleSubmit() {
                    event.preventDefault();
                    var hiddenErrorElements = $('.error-msg:not(:hidden)').length;
                    // alert(hiddenErrorElements);
                    if (hiddenErrorElements === 0) {
                        let form_data = new FormData(document.getElementById('form'));
                        let method = $('#method').val();
                        let url;
                        let type
                        // alert("submit");
                        if (method == 'ADD') {
                            // employee.store
                            // alert('{{ route('employeeApi.store') }}');
                            url = '{{ route('employeeApi.store') }}';
                            type = 'POST';
                        } else {
                            let id = $('#id').val();
                            url = '{{ route('employeeApi.update', ':id') }}';
                            url = url.replace(':id', id);
                            type = 'POST';
                            if ($('#over_time').is(':checked')) {
                                form_data.append('over_time', '1');
                            } else {
                                form_data.append('over_time', '0');
                            }
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
                                window.location.reload();
                            },
                            error: function(message) {
                                var data = message.responseJSON;
                            }
                        })
                    }
                }

                //DATA SHOW FOR EDIT AND SHOW
                var currentMobileNumber;

                function handleShowAndEdit(id, action) {
                    let url = '{{ route('employeeApi.show', ':id') }}';
                    url = url.replace(':id', id);
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
                                $('#heading_name').text("Update Employee Details").css('font-weight', 'bold');
                                $('#show').css('display', 'none');
                                $('#form').css('display', 'block');
                                $('#blur-background').css('display', 'block');
                                $('#filename').text(message[0].filename);
                                $('#over_time').prop('checked', true);
                                for (const [key, value] of Object.entries(message[0])) {
                                    console.log($(`#${key}`).val(value));
                                    $(`#${key}`).val(value);
                                    // console.log(message[0].country_code);
                                    if (message[0].over_time == '1') {
                                        $('#over_time').prop('checked', true);
                                    } else {
                                        $('#over_time').prop('checked', false);
                                    }
                                    iti.getSelectedCountryData().iso2 = message[0].country_code;
                                    $('#country_code').val(iti.getSelectedCountryData().iso2);
                                    iti.setCountry(message[0].country_code);
                                    // set default value to the first option
                                    $('#country').val(message[0].country_code);

                                    // $('#country_code').val(iti.getSelectedCountryData().iso2);
                                    // console.log(message[0].desigination); // Select the option with a value of '1'
                                    $('#desigination').val(message[0].desigination);
                                    $('#desigination').select2({
                                        tags: true
                                    }).next().find('.select2-selection').attr('aria-labelledby', 'desigination-label');
                                    $('#sponser').val(message[0].sponser);
                                    $('#sponser').select2({
                                        tags: true
                                    }).next().find('.select2-selection').attr('aria-labelledby', 'sponser-label');
                                    $('#working_as').val(message[0].working_as);
                                    $('#working_as').select2({
                                        tags: true
                                    }).next().find('.select2-selection').attr('aria-labelledby', 'working_as-label');
                                 }
                                currentMobileNumber = message[0].UAE_mobile_number;
                                console.log(message[0].filename);

                                $('#method').val('UPDATE');
                                $('#submit').text('UPDATE');
                            } else {
                                for (let [key, value] of Object.entries(message[0])) {
                                    if (key === "join_date" || key === "end_date" || key === "passport_expiry_date" ||
                                        key === "emirates_id_from_date" || key === "emirates_id_to_date" || key ===
                                        "expiry_date") {
                                            if( value == null)
                                            {
                                                value="";
                                            }
                                            else
                                            {
                                                var dateObj = new Date(value);
                                                var day = dateObj.getDate();
                                                var month = dateObj.getMonth() + 1;
                                                var year = dateObj.getFullYear();
                                                value= day + '-' + month + '-' + year
                                            }
                                    }
                                    $(`#show_${key}`).text(value);
                                }
                                $('#heading_name').text("Employee Details").css('font-weight', 'bold');
                                $('#show').css('display', 'block');
                                $('#form').css('display', 'none');
                                $('#blur-background').css('display', 'block');
                            }
                            document.getElementById("myDialog").open = true;
                            window.scrollTo(0, 0)
                        },
                    })
                }

                // phone number -->
                var input = $('#phone');
                var country = $('#country');
                var iti = intlTelInput(input.get(0))

                // Set the initial country code value
                $('#country_code').val(iti.getSelectedCountryData().iso2);

                // listen to the telephone input for changes
                input.on('countrychange', function(e) {
                    $('#country_code').val(iti.getSelectedCountryData().iso2);

                });
                // current location auto complete from projectmaster in project name
                jQuery($ => {
                    $(document).on('focus click', $("#city"), function() {
                        $("#city").autocomplete({
                            source: function(request, response) {
                                $.ajax({
                                    type: "GET",
                                    url: "{{ route('getlocdata') }}",
                                    dataType: "json",
                                    data: {
                                        'projectname': $("#city").val()
                                    },
                                    success: function(data) {
                                        result = [];
                                        for (var i in data) {
                                            result.push(data[i]["project_name"]);
                                        }
                                        console.log(result);
                                        response(result);
                                    },
                                    fail: function(xhr, textStatus, errorThrown) {
                                        alert(errorThrown);
                                    }
                                });
                            },
                        });
                    });
                });

                $("#city").on('change', function() {
                    var code = $(this).val();
                    $.ajax({
                        type: "GET",
                        url: "{{ route('getlocdata') }}",
                        dataType: "json",
                        data: {
                            'projectname': $(this).val()
                        },
                        success: function(data) {
                            result = [];
                            for (var i in data) {
                                $('#city').val(data[i]["project_name"]);
                            }
                        },
                        fail: function(xhr, textStatus, errorThrown) {
                            alert(errorThrown);
                        }
                    });
                });
                // Visa Desigination,Sponser,Working As Select2 TextBox
                $(document).ready(function() {
                    $('#desigination').select2({
                        tags: true
                    }).next().find('.select2-selection').attr('aria-labelledby', 'desigination-label');

                    $('#sponser').select2({
                        tags: true
                    }).next().find('.select2-selection').attr('aria-labelledby', 'sponser-label');

                    $('#working_as').select2({
                        tags: true
                    }).next().find('.select2-selection').attr('aria-labelledby', 'working_as-label');
                });

                document.getElementById("print").addEventListener("click", function() {
                    $('#heading_name').text("Employee Details").css('color', 'black').css('font-weight', 'bold');
                window.print();
                $('#heading_name').text("Employee Details").css('color', 'white').css('font-weight', 'bold');
                });
                // Initialize form validation
                var employee_uae = @json($employee_uae);
                var project_name = @json($project_name);

                $.validator.addMethod("uniqueContactNumber", function(value, element) {
                    if ($("#method").val() !== "ADD" && value === currentMobileNumber) {
                        return true;
                    }
                    return !employee_uae.includes(value);
                });
                $.validator.addMethod("alphanumeric", function(value, element) {
                    console.log(value);
                    return this.optional(element) || /^[A-Za-z ]+$/i.test(value);
                });
                $.validator.addMethod("alphanumeric_pass", function(value, element) {
                    console.log(value);
                    return this.optional(element) || /^[A-Za-z0-9 ]+$/i.test(value);
                });

                $.validator.addMethod("greaterThan", function(value, element, param) {
                    var startDate = $(param).val();
                    if (!value || !startDate) {
                        return true; // Skip validation if either date is missing
                    }

                    return new Date(value) > new Date(startDate);
                });
                $.validator.addMethod("alphanumeric_city", function(value, element) {
                    return this.optional(element) || /^[A-Za-z ]+$/i.test(value);
                });
                $.validator.addMethod("alphanumeric_hra", function(value, element) {
                    return this.optional(element) || /^\d+(\.\d+)?$/i.test(value);
                });
                //
                jQuery($ => {
                    $(document).on('focusout', '.select2-selection', function()
                    {
                        var value = $(this).text();
                        console.log(value);
                        console.log($(this).attr('aria-labelledby'));


                        if ($(this).attr('aria-labelledby') == 'working_as-label')
                        {
                            if (!/^[A-Za-z0-9\s\W]+$/i.test(value)) {
                                $("#working_as-error").text("Please enter the valid working.");
                                $("#working_as-error").show();
                            } else {
                                $("#working_as-error").hide();
                            }
                        }
                        if ($(this).attr('aria-labelledby') == 'desigination-label')
                        {
                            if (!/^[A-Za-z0-9\s\W]+$/i.test(value)) {
                                $("#desigination-error").text("Please enter the valid desigination.");
                                $("#desigination-error").show();
                            } else {
                                $("#desigination-error").hide();
                            }
                        }
                        if ($(this).attr('aria-labelledby') == 'sponser-label')
                        {
                            if (!/^[A-Za-z0-9\s\W]+$/i.test(value)) {
                                $("#sponser-error").text("Please enter the valid sponsor.");
                                $("#sponser-error").show();
                            } else {
                                $("#sponser-error").hide();
                            }
                        }
                    });
                });


                jQuery($ => {
                    $('#city').on('input', function() {
                        var cityName = $(this).val().trim();
                        if (cityName !== '') {
                            var isAlphanumeric = /^[A-Za-z ]+$/i.test(cityName);
                            if (!isAlphanumeric) {
                                $(this).addClass('error');
                            } else {
                                $(this).removeClass('error');
                            }
                        }
                    });
                });
                $.validator.addMethod("emirates_id", function(value, element) {
                    return this.optional(element) || /^[\d\-]{18}$/.test(value);
                });


                var formValidationConfig = {
                    rules: {
                        firstname: {
                            required: true,
                            alphanumeric: true
                        },
                        lastname: {
                            required: true,
                            alphanumeric: true
                        },
                        fathername: {
                            required: true,
                            alphanumeric: true
                        },
                        mothername: {
                            required: true,
                            alphanumeric: true
                        },
                        join_date: {
                            required: true,
                        },
                        end_date: {
                            date: true,
                            greaterThan: "#join_date"
                        },
                        category: "required",
                        sponser:
                        {   required:true,

                        },
                        working_as:{
                             required:true,

                        },
                        depart: "required",
                        status: "required",
                        religion: "required",
                        nationality: "required",
                        city: {
                            required: true,
                            alphanumeric_city: true
                        },
                        phone: {
                            required: true,
                            digits: true,
                            minlength: 10,
                            maxlength: 10,
                        },
                        UAE_mobile_number: {
                            required: true,
                            digits: true,
                            minlength: 9,
                            maxlength: 9,
                            uniqueContactNumber: true,
                        },
                        pay_group: "required",
                        accomodation: "required",
                        passport_no: {
                            required: true,
                            alphanumeric_pass: true

                        },
                        passport_expiry_date: "required",
                        emirates_id_no: {
                            required: true,
                            // digits: true,
                            // minlength: 7,
                            // maxlength: 7,
                            emirates_id:true,
                        },
                        emirates_id_from_date: "required",
                        emirates_id_to_date: {
                            required: true,
                            date: true,
                            greaterThan: "#emirates_id_from_date"
                        },
                        expiry_date: "required",
                        visa_status: "required",
                        desigination:{
                             required:true,

                        },
                        total_salary: {
                            required: true,
                            alphanumeric_hra: true
                        },
                        hra: {
                            required: true,
                            alphanumeric_hra: true
                        },
                        basic: {
                            required: true,
                            alphanumeric_hra: true,
                        },  wps: {
                            digits: true,
                            minlength: 14,
                            maxlength: 14,
                        },
                    },
                    messages: {
                        firstname: {
                            required: "Please enter the firstname",
                            alphanumeric: "The firstname allows only alphabets"
                        },
                        lastname: {
                            required: "Please enter the lastname",
                            alphanumeric: "The lastname allows only alphabets"
                        },
                        fathername: {
                            required: "Please enter the fathername",
                            alphanumeric: "The fathername allows only alphabets"
                        },
                        mothername: {
                            required: "Please enter the mothername",
                            alphanumeric: "The mothername allows only alphabets"
                        },
                        join_date: {
                            required: "Please enter the date of joining",
                        },
                        end_date: {
                            date: "Please enter a valid date",
                            greaterThan: "End date must be after the start date"
                        },
                        category: "Please select the category",
                        sponser:
                        {
                            required:"Please select the sponsor",

                        },
                        working_as:
                        {
                            required:"Please select the Working as",

                        },
                        depart: "Please select the department",
                        status: "Please select the status",
                        religion: "Please select the religion",
                        nationality: "Please select the nationality",
                        city: {
                            required: "Please enter the current location",
                            alphanumeric_city: "The current location allows only alphabets"
                        },
                        phone: {
                            required: "Please enter the home country contact number",
                            digits: "Please enter only numbers",
                            minlength: "Home country contact number must be exactly 10 numbers",
                            maxlength: "Home country contact number must be exactly 10 numbers"
                        },
                        UAE_mobile_number: {
                            required: "Please enter the UAE mobile number",
                            digits: "Please enter only numbers",
                            minlength: "UAE mobile number must be exactly 9 numbers",
                            maxlength: "UAE mobile number must be exactly 9 numbers",
                            uniqueContactNumber: "This UAE mobile number is already exists.Please enter new number"
                        },
                        pay_group: {
                            required: "Please select the pay group",
                        },
                        accomodation: {
                            required: "Please select the accommodation",
                        },
                        passport_no: {
                            required: "Please enter the passport number",
                            alphanumeric_pass: "The passport number does not allow special characters"

                        },
                        passport_expiry_date: "Please select the passport expiry date",
                        emirates_id_no: {
                            required: "Please enter the emirates id no",
                            // digits: "Please enter only numbers",
                            // minlength: "Emirates id no must be exactly 7 numbers",
                            // maxlength: "Emirates id no must be exactly 7 numbers",
                            emirates_id:"Please enter a valid Emirates Id in the format(xxx-xxxx-xxxxxxx-x)",

                        },
                        emirates_id_from_date: "Please select the emirates id from date",
                        emirates_id_to_date: {
                            required: "Please select the emirates id to date",
                            date: true,
                            greaterThan: "Emirates id to date must be after the emirates id from date"
                        },
                        expiry_date: "Please select the visa end date",
                        visa_status: "Please select the visa status",
                        desigination:  {
                            required:"Please select the visa desigination",

                        },
                        total_salary: {
                            required: "Please enter the total salary",
                            digits: "Please enter only numbers",
                        },
                        hra: {
                            required: "Please enter the hra",
                            digits: "Please enter only numbers",
                        },
                        basic: "Please enter the basic",
                      
                        wps: {
                            digits: "Please enter numerical value",
                            minlength: "WPS must be 14 digits",
                            maxlength: "WPS must be 14 digits"
                        }
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
                jQuery($ => {
                    //   $("#form").validate(formValidationConfig).valid();
                    var form = $("#form");
                    form.validate(formValidationConfig);

                });
            </script>
        @stop