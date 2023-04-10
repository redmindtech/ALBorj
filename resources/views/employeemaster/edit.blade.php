@foreach ($employes as $employe)
<div class="modal fade" id="edit_employee_{{$employe->id}}">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h4 class="modal-title" align="center"><b>Edit Employee</b></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>

        </div>
        <div class="modal-body">



              <form method="POST" class="form-row" action="{{ route('employeemaster.update',$employe->id) }}" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')
                  <div class="col-md-12 mt-3 text-primary">
                      <h4><center>Personal Details</center></h4>
                  </div>
                  <div class="form-group col-md-6" hidden>
                    <label for="firstname" class="form-label fw-bold ">Employee Id</label>
                    <input type="text" name="id" value="{{old("id",$employe->id)}}" placeholder="Employee Id" class="form-control emp_id">

                </div>
                  <div class="form-group col-md-6">
                      <label for="id" class="form-label fw-bold">Employee Id</label>
                      <input type="text"  value="{{old("id",$employe->id)}}" placeholder="Employee Id" class="form-control u_id" readonly>
                      <span id="u_id_val"></span>
                  </div>

                  <div class="form-group col-md-6">
                      <label for="firstname" class="form-label fw-bold">FirstName</label>
                      <input type="text" name="firstname" value="{{old("firstname",$employe->firstname)}}" placeholder="Employee FirstName" class="form-control u_firstname">
                      <span id="u_firstname_val"></span>
                  </div>


                  <div class="form-group col-md-6">
                      <label for="fullname" class="form-label fw-bold">Last Name<a style="text-decoration: none;color:red">*</a></label>
                      <input type="text" name="lastname" value="{{old("lastname",$employe->lastname)}}" placeholder="Last Name" class="form-control u_lastname" >
                      <span id="u_lastname_val"></span>
                    </div>

                  <div class="form-group col-md-6 ">
                      <label for="fullname" class="form-label fw-bold">Father Name<a style="text-decoration: none;color:red">*</a></label>
                      <input type="text" name="fathername" value="{{old("fathername",$employe->fathername)}}" placeholder="Father Name" class="form-control u_fathername">
                      <span id="u_fathername_val"></span>
                    </div>
                  <div class="form-group col-md-6 ">
                      <label for="fullname" class="form-label fw-bold">Mother Name<a style="text-decoration: none;color:red">*</a></label>
                      <input type="text" name="mothername" value="{{old("mothername",$employe->mothername)}}" placeholder="Mother Name" class="form-control u_mothername">
                      <span id="u_mothername_val"></span>
                    </div>
                  <div class="form-group col-md-6">
                      <label class="form-label fw-bold" for="join_date">Date of Joining<a style="text-decoration: none;color:red">*</a></label>
                      <input type="date" class="form-control u_join_date" value="{{old("join_date",$employe->join_date)}}"  placeholder="Date of Joining" name="join_date" id="join_date" >
                      <span id="u_join_date_val"></span>
                    </div>
                  <div class="form-group col-md-6">
                      <label class="form-label fw-bold" for="end_date">End Date</label>
                      <input type="date" class="form-control u_end_date" value="{{old("end_date",$employe->end_date)}}"  placeholder="End Date" name="end_date" >
                      <span id="u_end_date_val"></span>
                    </div>
                  <div class="form-group col-md-6">
                      <label class="form-label fw-bold" for="category">Category<a style="text-decoration: none;color:red">*</a></label>
                      <div class="form-label">
                          <select id="category" name="category"  class="form-control u_category" type="text" placeholder="Category">
                              @foreach(trans('category') as $value => $label)
                              <option @if(($employe->category ?? old('category')) == $value) selected @endif value="{{ $value }}">{{$label}}</option>
                             @endforeach
                         </select>
                      </div>
                      <span id="u_category_val"></span>
                    </div>
                  <div class="form-group col-md-4">
                      <label class="form-label fw-bold" for="sponser">Sponsor<a style="text-decoration: none;color:red">*</a></label>
                      <select id="sponser" name="sponser"  class="form-control u_sponser" type="text" placeholder="Sponsor">
                          @foreach(trans('sponsor') as $value => $label)
                          <option @if(($employe->sponser ?? old('sponser')) == $value) selected @endif value="{{ $value }}">{{$label}}</option>
                         @endforeach
                     </select>
                     <span id="u_sponser_val"></span>
                    </div>
                  <div class="form-group col-md-4">
                      <label class="form-label fw-bold" for="working_as">Working As<a style="text-decoration: none;color:red">*</a></label>
                      <input type="text" name="working_as" value="{{old("working_as",$employe->working_as)}}"  placeholder="working As" class="form-control u_working_as">
                      <span id="u_working_as_val"></span>
                    </div>

                  <div class="form-group col-md-4">
                      <label class="form-label fw-bold" for="depart">Department<a style="text-decoration: none;color:red">*</a></label>
                   <div class="form-label">
                      <select id="depart" name="depart"  class="form-control u_depart" type="text" placeholder="Department">
                          @foreach(trans('department') as $value => $label)
                          <option @if(($employe->depart ?? old('depart')) == $value) selected @endif value="{{ $value }}">{{$label}}</option>
                          @endforeach
                      </select>
                      </div>
                      <span id="u_depart_val"></span>
                    </div>
                  <div class="form-group col-md-4">
                      <label class="form-label fw-bold" for="status">Status<a style="text-decoration: none;color:red">*</a></label>
                   <div class="form-label">
                      <select id="status" name="status"  class="form-control u_status" type="text" placeholder="Department">
                          @foreach(trans('status') as $value => $label)
                          <option @if(($employe->status ?? old('status')) == $value) selected @endif value="{{ $value }}">{{$label}}</option>
                          @endforeach
                      </select>
                      </div>
                      <span id="u_status_val"></span>
                    </div>
                  <div class="form-group col-md-4">
                      <label class="form-label fw-bold" for="religion">Religion<a style="text-decoration: none;color:red">*</a></label>
                      <div class="form-label">
                          <select id="religion" name="religion"  class="form-control u_religion" type="text" placeholder="Religion">
                              @foreach(trans('religion') as $value => $label)
                              <option @if(($employe->religion ?? old('religion')) == $value) selected @endif value="{{ $value }}">{{$label}}</option>
                              @endforeach
                          </select>
                          </div>
                          <span id="u_status_val"></span>
                    </div>
                  <div class="form-group col-md-4">
                      <label class="form-label fw-bold" for="nationality">Nationality<a style="text-decoration: none;color:red">*</a></label>
                      <div class="form-label">
                      <select id="nationality" name="nationality"  class="form-control u_nationality" type="text" placeholder="Religion">
                          @foreach(trans('nationality') as $value => $label)
                          <option @if(old('nationality') == $value) selected @endif value="{{ $value }}">{{ $label }}</option>
                          @endforeach
                      </select>
                      </div>
                      <span id="u_nationality_val"></span>
                    </div>


                  <div class="form-group col-md-4">
                      <label class="form-label fw-bold" for="city">Current Location<a style="text-decoration: none;color:red">*</a></label>
                      <select id="city" name="city"  class="form-control u_city" type="text" placeholder="City">
                        @foreach(trans('current_location') as $value => $label)
                        <option @if(old('city') == $value) selected @endif value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                      <span id="u_city_val"></span>
                    </div>

                  <div class="form-group col-md-4">
                      <label class="form-label fw-bold" for="phone">Home Country Contact Number<a style="text-decoration: none;color:red">*</a></label>
                      <input type="text" class="form-control u_phone" value="{{old("phone",$employe->phone)}}"  placeholder="Phone" name="phone" >
                      <span id="u_phone_val"></span>
                    </div>
                  <div class="form-group col-md-4">
                      <label class="form-label fw-bold" for="UAE_mobile_number">UAE Mobile Number<a style="text-decoration: none;color:red">*</a></label>
                      <input type="text" class="form-control u_mobile" value="{{old("UAE_mobile_number",$employe->UAE_mobile_number)}}"  placeholder="UAE Mobile Number" name="UAE_mobile_number">
                      <span id="u_mobile_val"></span>
                    </div>

                  <div class="form-group col-md-4">
                      <label class="form-label fw-bold" for="pay_group">Pay Group<a style="text-decoration: none;color:red">*</a></label>
                      <input type="text" class="form-control u_pay" value="{{old("pay_group",$employe->pay_group)}}"  placeholder="PayGroup" name="pay_group">
                      <span id="u_pay_val"></span>
                    </div>

                    <div class="form-group col-md-4">
                        <label class="form-label fw-bold" for="accomodation">Accomodation<a style="text-decoration: none;color:red">*</a></label>
                        <!-- <input type="text" class="form-control" value="{{old("accomodation",$employe->accomodation)}}"  placeholder="Accomodation" name="accomodation"> -->
                        <div class="form-label">
                  <select id="accomodation" name="accomodation"  class="form-control u_accomodation" type="text" >
                    <option value=''>Select Any Option</option>
                      @foreach(trans('accomodation') as $value => $label)
                      <option @if($employe->accomodation ?? old('accomodation') == $value) selected @endif value="{{ $value }}">{{ $label }}</option>
                      @endforeach
                  </select>
                  </div>
                  <span id="u_accomodation_val"></span>
                      </div>

                     <div class="form-group col-md-4">
                      <label for="passport_no" class="form-label fw-bold">Passport Number<a style="text-decoration: none;color:red">*</a></label>
                      <input type="passport_no" name="passport_no" value="{{old("passport_no",$employe->passport_no)}}" placeholder="Passport Number" class="form-control u_passport"  >
                      <span id="u_passport_val"></span>
                    </div>
                  <div class="form-group col-md-4">
                      <label class="form-label fw-bold" for="passport_expiry_date"> Passport Expiry Date<a style="text-decoration: none;color:red">*</a></label>
                      <input type="date" class="form-control u_expirydate" value="{{old("passport_expiry_date",$employe->passport_expiry_date)}}"  placeholder="Passport Expiry Date" name="passport_expiry_date" id="passport_expiry_date" >
                      <span id="u_expirydate_val"></span>
                    </div>
                  <div class="form-group col-md-4">
                      <label for="emirates_id_no" class="form-label fw-bold">Emirates Id No<a style="text-decoration: none;color:red">*</a></label>
                      <input type="emirates_id_no" name="emirates_id_no" value="{{old("emirates_id_no",$employe->emirates_id_no)}}"  placeholder="Emirates Id No" class="form-control u_emirates_id_no" maxlength="7">
                      <span id="u_id_val"></span>
                    </div>
                  <div class="form-group col-md-4">
                      <label class="form-label fw-bold" for="emirates_id_from_date">Emirates Id From Date<a style="text-decoration: none;color:red">*</a></label>
                      <input type="date" class="form-control u_emifromdate" value="{{old("emirates_id_from_date",$employe->emirates_id_from_date)}}"  placeholder="Emirates Id From Date" name="emirates_id_from_date" id="emirates_id_from_date" >
                      <span id="u_emifromdate_val"></span>
                    </div>
                  <div class="form-group col-md-4">
                      <label class="form-label fw-bold" for="emirates_id_to_date">Emirates Id To Date<a style="text-decoration: none;color:red">*</a></label>
                      <input type="date" class="form-control u_emitodate" value="{{old("emirates_id_to_date",$employe->emirates_id_to_date)}}"  placeholder="Emirates Id To Date" name="emirates_id_to_date" id="emirates_id_to_date" >
                      <span id="u_emitodate_val"></span>

                    </div>

                  {{-- visa details --}}
                  <div class="col-md-12 mt-3 text-primary">
                      <h4><center>Visa Details</center></h4>
                  </div>
                    <div class="form-group col-md-4">
                      <label class="form-label fw-bold" for="expiry_date">Visa End Date<a style="text-decoration: none;color:red">*</a></label>
                      <input type="date" class="form-control u_visaexpirydate" value="{{old("expiry_date",$employe->expiry_date)}}"  placeholder="Visa End Date" name="expiry_date" id="expiry_date" required>
                      <span id="u_visaexpirydate_val"></span>
                  </div>

                    <div class="form-group col-md-4">
                        <label class="form-label fw-bold" for="visa_status">Visa Status<a style="text-decoration: none;color:red">*</a></label>
                        <div class="form-label">
                            <select id="visa_status" name="visa_status"  class="form-control u_visastatus" type="text" placeholder="Visa Status">
                                @foreach(trans('visastatus') as $value => $label)
                                <option @if(old('visa_status') == $value) selected @endif value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <span id="u_visastatus_val"></span>
                    </div>
                    <div class="form-group col-md-4">
                      <label class="form-label fw-bold" for="desigination">Visa Designation<a style="text-decoration: none;color:red">*</a></label>
                   <div class="form-label">
                      <select id="desigination" name="desigination"  class="form-control u_desigination" type="text" placeholder="Designation">
                          @foreach(trans('designation') as $value => $label)
                          <option @if(($employe->desigination ?? old('desigination')) == $value) selected @endif value="{{ $value }}">{{$label}}</option>
                          @endforeach
                      </select>
                      </div>
                      <span id="u_desigination_val"></span>
                    </div>
{{-- salary --}}
              <div class="col-md-12 mt-3 text-primary">
                  <h4><center>Salary Details</center></h4>
              </div>
          <div class="form-group col-md-6">
              <label for="fullname" class="form-label fw-bold">Total Salary<a style="text-decoration: none;color:red">*</a></label>
              <input type="text" name="total_salary" value="{{old("total_salary",$employe->total_salary)}}" placeholder="Total Salary" class="form-control u_salary" required>
              <span id="u_salary_val"></span>
          </div>
          <div class="form-group col-md-6">
              <label for="fullname" class="form-label fw-bold">HRA<a style="text-decoration: none;color:red">*</a></label>
              <input type="text" name="hra" value="{{old("hra",$employe->hra)}}" placeholder="HRA" class="form-control u_hra" required>
              <span id="u_hra_val"></span>
          </div>
          <div class="form-group row ">
              <div class="col-md-8">
                  <button type="submit" class="btn btn-primary edit_button" id="edit_button">
                      {{ __('Update') }}
                  </button>
              </div>
          </div>
      </div>
  </div>
</form>
</div>
</div>
</div>
</div>
@endforeach

{{-- <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script> --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script>
$(document).ready(function(){
  $(document).on("click",".edit", function(){
    alert ($(this).attr("id"));
   $.ajax({
    url: "{{ route('employee_data') }}",
    type: "GET", // or "GET", "PUT", etc.
    data: {
        'id':$(this).attr("id")
    },
    dataType: "json", // the type of data you're expecting in response
    success: function(data) {
        console.log(data);
        // $('.emp_id').val(data['employeemaster'][0].id);
       $('.u_id').val("EMP00"+data['employeemaster'][0].id);
    //    console.log(data['employeemaster'][0].firstname);
       $('.u_firstname').val(data['employeemaster'][0].firstname);

       $('.u_lastname').val(data['employeemaster'][0].lastname) ;
        $('.u_fathername').val(data['employeemaster'][0].fathername) ;
        $('.u_mothername').val(data['employeemaster'][0].mothername) ;
         $('.u_join_date').val(data['employeemaster'][0].join_date) ;
         $('.u_end_date').val(data['employeemaster'][0].end_date) ;
         $('.u_category').val(data['employeemaster'][0].category) ;
         $('.u_sponser').val(data['employeemaster'][0].sponser) ;
        $('.u_working_as').val(data['employeemaster'][0].working_as) ;
        $('.u_depart').val(data['employeemaster'][0].depart) ;
        $('.u_status').val(data['employeemaster'][0].status) ;
        $('.u_religion').val(data['employeemaster'][0].religion) ;
        $('.u_nationality').val(data['employeemaster'][0].nationality) ;
        $('.u_city').val(data['employeemaster'][0].city) ;
        $('.u_phone').val(data['employeemaster'][0].phone) ;
        $('.u_mobile').val(data['employeemaster'][0].UAE_mobile_number) ;
        $('.u_pay').val(data['employeemaster'][0].pay_group) ;
        $('.u_accomodation').val(data['employeemaster'][0].accomodation) ;
       $('.u_passport').val(data['employeemaster'][0].passport_no) ;
        $('.u_expirydate').val(data['employeemaster'][0].passport_expiry_date) ;
        $('.u_emirates_id_no').val(data['employeemaster'][0].emirates_id_no) ;
        $('.u_emifromdate').val(data['employeemaster'][0].emirates_id_from_date) ;
        $('.u_emitodate').val(data['employeemaster'][0].emirates_id_to_date) ;
        $('.u_visaexpirydate').val(data['visadetails'][0].expiry_date) ;
        $('.u_visastatus').val(data['visadetails'][0].visa_status) ;
        $('.u_designation').val(data['visadetails'][0].designation) ;
        $('.u_salary').val(data['salarydetails'][0].total_salary) ;
        $('.u_hra').val(data['salarydetails'][0].hra) ;



    },
    error: function(jqXHR, textStatus, errorThrown) {
        // handle error
    }
});

  });
});
</script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
    $(document).ready(function()
    {
        $('.edit_button').prop('disabled', true);

        $(".u_firstname").focusout(function()
        {
            var name_reg=/^[A-Z a-z]+$/;

            if($(this).val()== '')
            {
                document.getElementById("u_firstname_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('.edit_button').prop('disabled',true);
            }
            else if(name_reg.test($(this).val()) == true)
            {
                document.getElementById("u_firstname_val").innerHTML="";
                $('.edit_button').prop('disabled',false);
            }
            else if(name_reg.test($(this).val()) == false)
            {
                document.getElementById("u_firstname_val").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('.edit_button').prop('disabled',true);
            }
        });
        $(".u_lastname").focusout(function()
        {
            var name_reg=/^[A-Z a-z]+$/;

            if($(this).val()== '')
            {
                document.getElementById("u_lastname_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('.edit_button').prop('disabled',true);
            }
            else if(name_reg.test($(this).val()) == true)
            {
                document.getElementById("u_lastname_val").innerHTML="";
                $('.edit_button').prop('disabled',false);
            }
            else if(name_reg.test($(this).val()) == false)
            {
                document.getElementById("u_lastname_val").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('.edit_button').prop('disabled',true);
            }
        });
        $(".u_fathername").focusout(function()
        {
            var name_reg=/^[A-Z a-z]+$/;

            if($(this).val()== '')
            {
                document.getElementById("u_fathername_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('.edit_button').prop('disabled',true);
            }
            else if(name_reg.test($(this).val()) == true)
            {
                document.getElementById("u_fathername_val").innerHTML="";
                $('.edit_button').prop('disabled',false);
            }
            else if(name_reg.test($(this).val()) == false)
            {
                document.getElementById("u_fathername_val").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('.edit_button').prop('disabled',true);
            }
        });
        $(".u_mothername").focusout(function()
        {
            var name_reg=/^[A-Z a-z]+$/;

            if($(this).val()== '')
            {
                document.getElementById("u_mothername_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('.edit_button').prop('disabled',true);
            }
            else if(name_reg.test($(this).val()) == true)
            {
                document.getElementById("u_mothername_val").innerHTML="";
                $('.edit_button').prop('disabled',false);
            }
            else if(name_reg.test($(this).val()) == false)
            {
                document.getElementById("u_mothername_val").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('.edit_button').prop('disabled',true);
            }
        });

        $(".u_category").focusout(function(){
        if($(this).val()== ''){
        document.getElementById("u_category_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
        $('.edit_button').prop('disabled',true);
        }
        else  if($(this).val() != ''){
            document.getElementById("u_category_val").innerHTML="";
            $('.edit_button').prop('disabled',false);
        }
          });

        $(".u_sponser").focusout(function(){
                if($(this).val()== ''){
                document.getElementById("u_sponser_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('.edit_button').prop('disabled',true);
                }
                else  if($(this).val() != ''){
                    document.getElementById("u_sponser_val").innerHTML="";
                    $('.edit_button').prop('disabled',false);
                }
          });

          $(".u_workingas").focusout(function()
        {
            var name_reg=/^[A-Z a-z]+$/;

            if($(this).val()== '')
            {
                document.getElementById("u_workingas_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('.edit_button').prop('disabled',true);
            }
            else if(name_reg.test($(this).val()) == true)
            {
                document.getElementById("u_workingas_val").innerHTML="";
                $('.edit_button').prop('disabled',false);
            }
            else if(name_reg.test($(this).val()) == false)
            {
                document.getElementById("u_workingas_val").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('.edit_button').prop('disabled',true);
            }
        });

        $(".u_depart").focusout(function(){
                if($(this).val()== ''){
                document.getElementById("u_depart_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('.edit_button').prop('disabled',true);
                }
                else  if($(this).val() != ''){
                    document.getElementById("u_depart_val").innerHTML="";
                    $('.edit_button').prop('disabled',false);
                }
          });

          $(".u_status").focusout(function(){
                if($(this).val()== ''){
                document.getElementById("u_status_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('.edit_button').prop('disabled',true);
                }
                else  if($(this).val() != ''){
                    document.getElementById("u_status_val").innerHTML="";
                    $('.edit_button').prop('disabled',false);
                }
          });

          $(".u_religion").focusout(function(){
                if($(this).val()== ''){
                document.getElementById("u_religion_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('.edit_button').prop('disabled',true);
                }
                else  if($(this).val() != ''){
                    document.getElementById("u_religion_val").innerHTML="";
                    $('.edit_button').prop('disabled',false);
                }
          });

          $(".u_nationality").focusout(function(){
                if($(this).val()== ''){
                document.getElementById("u_nationality_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('.edit_button').prop('disabled',true);
                }
                else  if($(this).val() != ''){
                    document.getElementById("u_nationality_val").innerHTML="";
                    $('.edit_button').prop('disabled',false);
                }
          });
          $(".u_city").focusout(function()
        {
            var name_reg=/^[A-Z a-z]+$/;

            if($(this).val()== '')
            {
                document.getElementById("u_city_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('.edit_button').prop('disabled',true);
            }
            else if(name_reg.test($(this).val()) == true)
            {
                document.getElementById("u_city_val").innerHTML="";
                $('.edit_button').prop('disabled',false);
            }
            else if(name_reg.test($(this).val()) == false)
            {
                document.getElementById("u_city_val").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('.edit_button').prop('disabled',true);
            }
        });

        $(".u_phone").focusout(function()
        {
            var re=/^[6789][0-9]+$/;

            if($(this).val()== '')
            {
                document.getElementById("u_phone_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('.edit_button').prop('disabled',true);
            }
            else if(re.test($(this).val()) == true)
            {
                document.getElementById("u_phone_val").innerHTML="";
                $('.edit_button').prop('disabled',false);
            }
            else if(re.test($(this).val()) == false)
            {
                document.getElementById("u_phone_val").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('.edit_button').prop('disabled',true);
            }
        });
        $(".u_mobile").focusout(function()
        {
            var re=/^[6789][0-9]+$/;

            if($(this).val()== '')
            {
                document.getElementById("u_mobile_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('.edit_button').prop('disabled',true);
            }
            else if(re.test($(this).val()) == true)
            {
                document.getElementById("u_mobile_val").innerHTML="";
                $('.edit_button').prop('disabled',false);
            }
            else if(re.test($(this).val()) == false)
            {
                document.getElementById("u_mobile_val").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('.edit_button').prop('disabled',true);
            }
        });
        $(".u_pay").focusout(function(){
                if($(this).val()== ''){
                document.getElementById("u_pay_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('.edit_button').prop('disabled',true);
                }
                else  if($(this).val() != ''){
                    document.getElementById("u_pay_val").innerHTML="";
                    $('.edit_button').prop('disabled',false);
                }
          });
        $(".u_accomodation").focusout(function()
        {
            if($(this).val()== '')
            {
                document.getElementById("u_accomodation_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('.edit_button').prop('disabled',true);
            }
            else if($(this).val()== true)
            {
                document.getElementById("u_accomodation_val").innerHTML="";
                $('.edit_button').prop('disabled',false);
            }
        });

    });
    $(".u_passport").focusout(function()
        {
            var re=/^(?!0+(?:\.0+)?$)[0-9]+(?:\.[0-9]+)?$/;

            if($(this).val()== '')
            {
                document.getElementById("u_passport_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('.edit_button').prop('disabled',true);
            }
            else if(re.test($(this).val()) == true)
            {
                document.getElementById("u_passport_val").innerHTML="";
                $('.edit_button').prop('disabled',false);
            }
            else if(re.test($(this).val()) == false)
            {
                document.getElementById("u_passport_val").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('.edit_button').prop('disabled',true);
            }
        });
        $(".u_eid").focusout(function()
        {
            var re=/^(?!0+(?:\.0+)?$)[0-9]+(?:\.[0-9]+)?$/;

            if($(this).val()== '')
            {
                document.getElementById("u_eid_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('.edit_button').prop('disabled',true);
            }
            else if(re.test($(this).val()) == true)
            {
                document.getElementById("u_eid_val").innerHTML="";
                $('.edit_button').prop('disabled',false);
            }
            else if(re.test($(this).val()) == false)
            {
                document.getElementById("u_eid_val").innerHTML="<span class='text-danger m-2'>Please enter valid data</span>";
                $('.edit_button').prop('disabled',true);
            }
        });
        $(".u_visastatus").focusout(function(){
                if($(this).val()== ''){
                document.getElementById("u_visastatus_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('.edit_button').prop('disabled',true);
                }
                else  if($(this).val() != ''){
                    document.getElementById("u_visastatus_val").innerHTML="";
                    $('.edit_button').prop('disabled',false);
                }
          });
        $(".u_visadesignation").focusout(function(){
                if($(this).val()== ''){
                document.getElementById("u_visadesignation_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('.edit_button').prop('disabled',true);
                }
                else  if($(this).val() != ''){
                    document.getElementById("u_visadesignation_val").innerHTML="";
                    $('.edit_button').prop('disabled',false);
                }
          });
          $(".u_salary").focusout(function()
        {
            var re=/^(?!0+(?:\.0+)?$)[0-9]+(?:\.[0-9]+)?$/;

            if($(this).val()== '')
            {
                document.getElementById("u_salary_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('.edit_button').prop('disabled',true);
            }
            else if(re.test($(this).val()) == true)
            {
                document.getElementById("u_salary_val").innerHTML="";
                $('.edit_button').prop('disabled',false);
            }
            else if(re.test($(this).val()) == false)
            {
                document.getElementById("u_salary_val").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('.edit_button').prop('disabled',true);
            }
        });
        $(".u_hra").focusout(function()
        {
            var re=/^(?!0+(?:\.0+)?$)[0-9]+(?:\.[0-9]+)?$/;

            if($(this).val()== '')
            {
                document.getElementById("u_hra_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('.edit_button').prop('disabled',true);
            }
            else if(re.test($(this).val()) == true)
            {
                document.getElementById("u_hra_val").innerHTML="";
                $('.edit_button').prop('disabled',false);
            }
            else if(re.test($(this).val()) == false)
            {
                document.getElementById("u_hra_val").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('.edit_button').prop('disabled',true);
            }
        });


</script>
