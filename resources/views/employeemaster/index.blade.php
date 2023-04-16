<!-- STYLE INCLUDED IN LAYOUT PAGE -->
@extends('layouts.app',[
    'activeName' => 'Employee Master'
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
                                            <!-- <th>S.No</th> -->
                                            <th>Employee id</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <!-- <th>Department</th> -->
                                            <th>Date of Joining</th>
                                            <th>Show</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($employes as $key => $employe)
                                            <tr class="text-center">
                                                <!-- <td>{{$key+=1}}</td> -->
                                                <td>{{$employe->id}}</td>
                                                <td>{{$employe->firstname}}</td>
                                                <td>{{$employe->lastname}}</td>
                                                <!-- <td>{{$employe->depart}}</td> -->
                                                <td>{{$employe->join_date}}</td>

                                                <td>
                                                    <a  onclick="handleShowAndEdit('{{$employe->id}}','show')"
                                                        class="btn btn-primary btn-circle btn-sm"   >
                                                        <i class="fas fa-flag"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a onclick="handleShowAndEdit('{{$employe->id}}','edit')"
                                                        class="btn btn-info btn-circle btn-sm mx-2" >
                                                        <i class="fas fa-check"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <button  type="submit" class="btn btn-sm btn-danger" onclick="handleDelete('{{$employe->id}}')">
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
                     <h4  id='heading_name' style='color:white' align="center"><b>Update Employee</b></h4>
                    </div>
            </div>
            

 
            <form  class="form-row"  enctype="multipart/form-data" style="display:block" id="form" onsubmit="handleSubmit()">
                <input type="hidden" id="method" value="ADD"/>
                <input type="hidden" id="id" name="id" value=""/><br>
               
{!! csrf_field() !!}
<div class="row">
<div class="form-group col-md-12">
        <label for="code" id="code_lable"class="form-label fw-bold">Employee Code<a style="text-decoration: none;color:red">*</a></label>
        <input type="text" id="employee_no" name="employee_no" readonly value="{{ old('employee_no') }}" placeholder="Employee Code" class="form-control" autocomplete="off">
        <p style="color: red" id="error_code"></p>
    </div>
</div>
<div class="row">
<div class="form-group col-md-6">
        <label for="firstname" class="form-label fw-bold">First Name<a style="text-decoration: none;color:red">*</a></label>
        <input type="text" id="firstname"  name="firstname" value="{{ old('firstname') }}" placeholder="First Name" class="form-control" autocomplete="off">
        <p style="color: red" id="error_firstname"></p>
    </div>

    <div class="form-group col-md-6">
        <label for="lastname" class="form-label fw-bold">Last Name<a style="text-decoration: none;color:red">*</a></label>
        <input type="text" id="lastname" name="lastname" value="{{ old('lastname') }}" placeholder="Last Name" class="form-control" autocomplete="off">
        <p style="color: red" id="error_lastname"></p>
    </div>
</div>
<div class="row">
    <div class="form-group col-md-6">
        <label for="fathername" class="form-label fw-bold">Father Name<a style="text-decoration: none;color:red">*</a></label>
        <input type="text" id="fathername" name="fathername" value="{{ old('fathername') }}" placeholder="Father Name" class="form-control" autocomplete="off">
        <p style="color: red" id="error_fathername"></p>
    </div>
    <div class="form-group col-md-6">
        <label for="mothername" class="form-label fw-bold">Mother Name<a style="text-decoration: none;color:red">*</a></label>
        <input type="text" id="mothername" name="mothername" value="{{ old('mothername') }}" placeholder="Mother Name" class="form-control" autocomplete="off">
        <p style="color: red" id="error_mothername"></p>
    </div>
</div>
<div class="row">
    <div class="form-group col-md-6">
        <label for="join_date" class="form-label fw-bold">Date of joining<a style="text-decoration: none;color:red">*</a></label>
        <input type="date" id="join_date" name="join_date" value="{{ old('join_date') }}" placeholder="join_date" class="form-control" autocomplete="off">
        <p style="color: red" id="error_join_date"></p>
    </div>
    <div class="form-group col-md-6">
        <label for="end_date" class="form-label fw-bold">End Date<a style="text-decoration: none;color:red">*</a></label>
        <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}" placeholder="end_date" class="form-control" autocomplete="off">
        <p style="color: red" id="error_end_date"></p>
    </div>
</div>
<div class="row">
    <div class="form-group col-md-6">
        <label for="category" class="form-label fw-bold">Category<a style="text-decoration: none;color:red">*</a></label>
        <!-- <input type="text" id="category" name="category" value="{{ old('category') }}" placeholder="category" class="form-control" autocomplete="off"> -->
        <select id="category" name="category" class="form-control" autocomplete="off">
        <option value="">Select Option</option>
            @foreach($category as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
        <p style="color: red" id="error_category"></p>
    </div>
    <div class="form-group col-md-6">
        <label for="sponser" class="form-label fw-bold">Sponser As<a style="text-decoration: none;color:red">*</a></label>
        <!-- <input type="text" id="sponser" name="sponser" value="{{ old('sponser') }}" placeholder="sponser" class="form-control" autocomplete="off"> -->
        <select id="sponser" name="sponser" class="form-control" autocomplete="off">
        <option value="">Select Option</option>
            @foreach($sponsor as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
        <p style="color: red" id="error_sponser"></p>
    </div>
</div>
<div class="row">
    <div class="form-group col-md-6">
        <label for="working_as" class="form-label fw-bold">Working As<a style="text-decoration: none;color:red">*</a></label>
        <input type="text" id="working_as" name="working_as" value="{{ old('working_as') }}" placeholder="WorkingAs" class="form-control" autocomplete="off">
        <p style="color: red" id="error_working_as"></p>
    </div>
    <div class="form-group col-md-6">
        <label for="depart" class="form-label fw-bold">Department<a style="text-decoration: none;color:red">*</a></label>
        <!-- <input type="text" id="depart" name="depart" value="{{ old('depart') }}" placeholder="Department" class="form-control" autocomplete="off"> -->
        <select id="depart" name="depart" class="form-control" autocomplete="off">
        <option value="">Select Option</option>
            @foreach($department as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
        <p style="color: red" id="error_depart"></p>
    </div>
</div>
<div class="row">
    <div class="form-group col-md-6">
        <label for="status" class="form-label fw-bold">Status<a style="text-decoration: none;color:red">*</a></label>
        <!-- <input type="text" id="status" name="status" value="{{ old('status') }}" placeholder="status" class="form-control" autocomplete="off"> -->
        <select id="status" name="status" class="form-control" autocomplete="off">
        <option value="">Select Option</option>
            @foreach($status as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
        <p style="color: red" id="error_status"></p>
    </div>
    <div class="form-group col-md-6">
        <label for="religion" class="form-label fw-bold">Religion<a style="text-decoration: none;color:red">*</a></label>
        <!-- <input type="text" id="religion" name="religion" value="{{ old('religion') }}" placeholder="Religion" class="form-control" autocomplete="off"> -->
        <select id="religion" name="religion" class="form-control" autocomplete="off">
        <option value="">Select Option</option>
            @foreach($religion as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
        <p style="color: red" id="error_religion"></p>
    </div>
</div>
<div class="row">
<div class="form-group col-md-6">
        <label for="nationality" class="form-label fw-bold">Nationality<a style="text-decoration: none;color:red">*</a></label>
        <!-- <input type="text" id="nationality" name="nationality"  value="{{ old('nationality') }}" placeholder=" nationality" class="form-control" autocomplete="off"> -->
        <select id="nationality" name="nationality" class="form-control" autocomplete="off">
        <option value="">Select Option</option>
            @foreach($nationality as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
        <p style="color: red" id="error_nationality"></p>
    </div>
    <div class="form-group col-md-6">
        <label for="city" class="form-label fw-bold">Current Location<a style="text-decoration: none;color:red">*</a></label>
        <!-- <input type="text" id="city" name="city"  value="{{ old('city') }}" placeholder=" city" class="form-control" autocomplete="off"> -->
        <select id="city" name="city" class="form-control" autocomplete="off">
        <option value="">Select Option</option>
            @foreach($location as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
        <p style="color: red" id="error_city"></p>
    </div>
</div>
<div class="row">
    <div class="form-group col-md-6">
        <label for="phone" class="form-label fw-bold">Home Country Contact Number<a style="text-decoration: none;color:red">*</a></label>
        <input type="tel" id="phone" name="phone"  value="{{ old('phone') }}" placeholder=" phone" class="form-control phone_number" autocomplete="off">
        <p style="color: red" id="error_phone"></p>
    </div>
    <div class="form-group col-md-6">
        <label for="UAE_mobile_number" class="form-label fw-bold">UAE Mobile Number<a style="text-decoration: none;color:red">*</a></label>
        <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">{{+971}}</span>
            <!-- </div> -->
        <input type="text" id="UAE_mobile_number" name="UAE_mobile_number"  value="{{old('UAE_mobile_number') }}" placeholder=" UAE_mobile_number" class="form-control" autocomplete="off"></div>
        <p style="color: red" id="error_UAE_mobile_number"></p>
    </div>
</div>
<div class="row">
    <div class="form-group col-md-6">
        <label for="pay_group" class="form-label fw-bold">Pay Group<a style="text-decoration: none;color:red">*</a></label>
        <!-- <input type="text" id="pay_group" name="pay_group"  value="{{ old('pay_group') }}" placeholder=" pay_group" class="form-control" autocomplete="off"> -->
        <select id="pay_group" name="pay_group" class="form-control" autocomplete="off">
        <option value="">Select Option</option>
            @foreach($pay_group as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
        <p style="color: red" id="error_pay_group"></p>
    </div>
    <div class="form-group col-md-6">
        <label for="accomodation" class="form-label fw-bold">Accomodation<a style="text-decoration: none;color:red">*</a></label>
        <!-- <input type="text" id="accomodation" name="accomodation"  value="{{ old('accomodation') }}" placeholder=" accomodation" class="form-control" autocomplete="off"> -->
        <select id="accomodation" name="accomodation" class="form-control" autocomplete="off">
        <option value="">Select Option</option>
            @foreach($accomodation as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
        <p style="color: red" id="error_accomodation"></p>
    </div>
</div>
<div class="row">
    <div class="form-group col-md-6">
        <label for="passport_no" class="form-label fw-bold">Passport Number<a style="text-decoration: none;color:red">*</a></label>
        <input type="text" id="passport_no" name="passport_no"  value="{{ old('passport_no') }}" placeholder=" passport_no" class="form-control" autocomplete="off">
        <p style="color: red" id="error_passport_no"></p>
    </div>
    <div class="form-group col-md-6">
        <label for="passport_expiry_date" class="form-label fw-bold">Passport Expiry Date<a style="text-decoration: none;color:red">*</a></label>
        <input type="date" id="passport_expiry_date" name="passport_expiry_date"  value="{{ old('passport_expiry_date') }}" placeholder=" passport_expiry_date" class="form-control" autocomplete="off">
        <p style="color: red" id="error_passport_expiry_date"></p>
    </div>
</div>
<div class="row">
    <div class="form-group col-md-6">
        <label for="emirates_id_no" class="form-label fw-bold">Emirates Id No<a style="text-decoration: none;color:red">*</a></label>
        <input type="text" id="emirates_id_no" name="emirates_id_no"  value="{{ old('emirates_id_no') }}" placeholder=" emirates_id_no" class="form-control" autocomplete="off">
        <p style="color: red" id="error_emirates_id_no"></p>
    </div>

     <div class="form-group col-md-6">
        <label for="emirates_id_from_date" class="form-label fw-bold">Emirates Id From Date<a style="text-decoration: none;color:red">*</a></label>
        <input type="date" id="emirates_id_from_date" name="emirates_id_from_date"  value="{{ old('emirates_id_from_date') }}" placeholder=" emirates_id_from_date" class="form-control" autocomplete="off">
        <p style="color: red" id="error_emirates_id_from_date"></p>
    </div>
</div>
<div class="row">
     <div class="form-group col-md-6">
        <label for="emirates_id_to_date" class="form-label fw-bold">Emirates Id To Date<a style="text-decoration: none;color:red">*</a></label>
        <input type="date" id="emirates_id_to_date" name="emirates_id_to_date"  value="{{ old('emirates_id_to_date') }}" placeholder=" emirates_id_to_date" class="form-control" autocomplete="off">
        <p style="color: red" id="error_emirates_id_to_date"></p>
    </div>


<div class="form-group col-md-6">
        <label for="expiry_date" class="form-label fw-bold">Visa End Date<a style="text-decoration: none;color:red">*</a></label>
        <input type="date" id="expiry_date" name="expiry_date"  value="{{ old('expiry_date') }}" placeholder=" expiry_date" class="form-control" autocomplete="off">
        <p style="color: red" id="error_expiry_date"></p>
    </div>
</div>
<div class="row">
    <div class="form-group col-md-6">
        <label for="visa_status" class="form-label fw-bold">Visa Status<a style="text-decoration: none;color:red">*</a></label>
        <!-- <input type="text" id="visa_status" name="visa_status"  value="{{ old('visa_status') }}" placeholder=" visa_status" class="form-control" autocomplete="off"> -->
        <select id="visa_status" name="visa_status" class="form-control" autocomplete="off">
        <option value="">Select Option</option>
            @foreach($visa_status as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
        <p style="color: red" id="error_visa_status"></p>
    </div>
    <div class="form-group col-md-6">
        <label for="desigination" class="form-label fw-bold">Visa Designation<a style="text-decoration: none;color:red">*</a></label>
        <!-- <input type="text" id="desigination" name="desigination"  value="{{ old('desigination') }}" placeholder=" desigination" class="form-control" autocomplete="off"> -->
        <select id="desigination" name="desigination" class="form-control select2" autocomplete="off" style="width:100%">
        <option value="">Select Option</option>
            @foreach($desigination as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
        <p style="color: red" id="error_desigination"></p>
    </div>
</div>
<div class="row">
     <div class="form-group col-md-6">
        <label for="total_salary" class="form-label fw-bold">Total Salary<a style="text-decoration: none;color:red">*</a></label>
        <input type="text" id="total_salary" name="total_salary"  value="{{ old('total_salary') }}" placeholder=" total_salary" class="form-control" autocomplete="off">
        <p style="color: red" id="error_total_salary"></p>
    </div>
<div class="form-group col-md-6">
        <label for="hra" class="form-label fw-bold">HRA<a style="text-decoration: none;color:red">*</a></label>
        <input type="text" id="hra" name="hra"  value="{{ old('hra') }}" placeholder=" hra" class="form-control" autocomplete="off">
        <p style="color: red" id="error_hra"></p>
    </div>
</div>

    <div class="form-group col-md-12">
        <button type="submit" id="submit"  class="btn btn-primary float-end ">ADD</button>
    </div>
</form>
<!-- SHOW DIALOG -->
<div class="card" id="show" style="display:none">
    <div class="card-body" style="background-color:white;width:100%;height:20%;" >
       
                        <div class="row">
                        <div class="col-md-3">
                            <label>Employee code</label>
                            <p id="show_employee_no"></p>
                        </div>
                        <div class="col-md-3">
                            <label>First Name</label>
                            <p id="show_firstname"></p>
                        </div>
                        <div class="col-md-3">
                            <label>Last Name</label>
                            <p id="show_lastname"></p>
                        </div>
                        <div>
                        <div class="row">
                          <div class="col-md-3">
                            <label>Father Name</label>
                            <p id="show_fathername"></p>
                        </div>
                        <div class="col-md-3">
                            <label>Mother Name</label>
                            <p id="show_mothername"></p>
                        </div>                    
                        <div class="col-md-3">
                            <label>Date of Joining</label>
                            <p id="show_join_date"></p>
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-md-3">
                            <label>End Date</label>
                            <p id="show_end_date"></p>
                        </div>            
                        <div class="col-md-3">
                            <label>Category</label>
                            <p id="show_category"></p>
                        </div>
                         <div class="col-md-3">
                            <label>Sponsor</label>
                            <p id="show_sponser"></p>
                        </div>
                        </div>
                        <div class="row">
                         <div class="col-md-3">
                            <label>Working As</label>
                            <p id="show_working_as"></p>
                        </div>
                         <div class="col-md-3">
                            <label>Visa Designation</label>
                            <p id="show_desigination"></p>
                        </div>                        
                        <div class="col-md-3">
                            <label>Department</label>
                            <p id="show_depart"></p>
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-md-3">
                            <label>Status</label>
                            <p id="show_status"></p>
                        </div>                    
                        <div class="col-md-3">
                            <label>Nationality</label>
                            <p id="show_nationality"></p>
                        </div>
                        <div class="col-md-3">
                            <label>Location</label>
                            <p id="show_city"></p>
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-md-3">
                            <label>Home Country Number</label>
                            <p id="show_phone"></p>
                        </div>
                         <div class="col-md-3">
                            <label>UAE Mobile Number</label>
                            <p id="show_UAE_mobile_number"></p>
                        </div>                   
                         <div class="col-md-3">
                            <label>Accomodation</label>
                            <p id="show_accomodation"></p>
                        </div>
                        </div>
                        <div class="row">
                         <div class="col-md-3">
                            <label>Passport Number</label>
                            <p id="show_passport_no"></p>
                        </div>                    
                         <div class="col-md-3">
                            <label>Passport Expiry Date</label>
                            <p id="show_passport_expiry_date"></p>
                        </div>
                        <div class="col-md-3">
                            <label>Emirates Id No</label>
                            <p id="show_emirates_id_no"></p>
                        </div>
                    </div>
                        <div class="row">
                        <div class="col-md-3">
                            <label>Emirates Id From Date</label>
                            <p id="show_emirates_id_from_date"></p>
                        </div>
                        <div class="col-md-3">
                            <label>Emirates Id To Date</label>
                            <p id="show_emirates_id_to_date"></p>
                        </div>               
                        <div class="col-md-3">
                            <label>Visa End Date</label>
                            <p id="show_expiry_date"></p>
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-md-3">
                            <label>Visa Status</label>
                            <p id="show_visa_status"></p>
                        </div>              
                        <div class="col-md-3">
                            <label>Total Salary</label>
                            <p id="show_total_salary"></p>
                        </div>
                        <div class="col-md-3">
                            <label>HRA</label>
                            <p id="show_hra"></p>
                        </div>
                    </div>
    
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
        $(function () {
            $("#myTable").DataTable();
        });
    </script>    
     <!--ADD DIALOG  -->
          <script type="text/javascript">
          function handleDialog(){
             document.getElementById("myDialog").open = true;
             $('#method').val("ADD");
             $('#submit').text("ADD");
             $('#heading_name').text("Add Employee").css('font-weight', 'bold');
             $('#employee_no').hide();
             $('#code_lable').hide();
             $('#show').css('display','none');
             $('#form').css('display','block');
          }
// DELETE FUNCTION
          function handleDelete(id){
             let url = '{{route('employeeApi.delete',":id")}}';
            url= url.replace(':id',id);
            if (confirm("Are you sure you want to delete this Employee Master?")) {
              $.ajax({
            url: url,
            type: 'DELETE',
            success: function (message) {
             alert(message);
             window.location.reload();
            },
        })}
        
          }
// DIALOG CLOSE BUTTON
          function handleClose(){
            document.getElementById("myDialog").open = false;
            window.location.reload();
          }
// DIALOG SUBMIT FOR ADD AND EDIT
          function handleSubmit(){
            event.preventDefault();
         let form_data = new FormData(document.getElementById('form'));
         let method = $('#method').val();
         let url;
         let type;
         if(method == 'ADD'){
            // employee.store
            // alert('{{route('employeeApi.store')}}');
             url = '{{route('employeeApi.store')}}';
             type  = 'POST';
            
         } else {
            let id = $('#id').val();
            url = '{{route('employeeApi.update',":id")}}';
            url= url.replace(':id',id);
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
            },error: function (message) {
                var data = message.responseJSON;
                $.each(data.errors, function (key, val) {
                    console.log(key,val);
                    $(`#error_${key}`).html(val[0]);
                })
            }
        })
          }

        //DATA SHOW FOR EDIT AND SHOW 
          function handleShowAndEdit(id,action){
            // alert('')
            let url = '{{route('employeeApi.show',":id")}}';
            url = url.replace(':id',id);
            let type= "GET"
            $.ajax({
            url: url,
            type: type,
             contentType: false,
            cache: false,
            processData: false,
            success: function (message) {
                console.log(message);
                if(action == 'edit'){
                    $('#show').css('display','none');
                     $('#form').css('display','block');
                for (const [key, value] of Object.entries(message[0])) {
//                console.log(`${key}: ${value}`);
                    $(`#${key}`).val(value);
                }
                $('#method').val('UPDATE');
                $('#submit').text('UPDATE');
            } else {
                for (const [key, value] of Object.entries(message[0])) {
                    $(`#show_${key}`).text(value);
                }
                $('#heading_name').text("View Employee").css('font-weight', 'bold');
                $('#show').css('display','block');
                $('#form').css('display','none');
            }
            document.getElementById("myDialog").open = true;
                    
            },
        })
          }

//select2
    
    // $('.select2').select2({
    // //   theme: 'bootstrap4',
    //   tags:true
    // });


    // country code with phone number
    var phone_number = window.intlTelInput(document.querySelector(".phone_number"), {
  separateDialCode: true,
//   preferredCountries:["in"],
//   hiddenInput: "full",
   utilsScript: "//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.js"
});

$("form").submit(function() {
  var full_number = phone_number.getNumber(intlTelInputUtils.numberFormat.E164);
$("input[name='phone']").val(full_number);
//   alert(full_number);
});
        </script>
    
    

@stop