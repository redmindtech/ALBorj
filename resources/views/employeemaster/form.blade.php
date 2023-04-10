<form method="POST" class="form-group row" action="{{ route('employeemaster.store') }}" enctype="multipart/form-data">
    @csrf

                        <div class="col-md-12 mt-3 text-primary">
                            <h4><center>Personal Details</center></h4>
                        </div>
                      <div class="form-group col-md-6">
                          <label for="fullname" class="form-label fw-bold">First Name<a style="text-decoration: none;color:red">*</a></label>
                          <input type="text" name="firstname" value="{{old("firstname")}}"
placeholder="First Name" class="form-control " id="firstname" required>
                         <span id="firstname_val"></span>
                        </div>
                      <div class="form-group col-md-6">
                          <label for="fullname" class="form-label fw-bold">Last Name<a style="text-decoration: none;color:red">*</a></label>
                          <input type="text" name="lastname" value="{{old("lastname")}}" placeholder="Last Name" class="form-control"  id="lastname" required>
                          <span id="lastname_val"></span>
                        </div>

                      <div class="form-group col-md-6 ">
                          <label for="fullname" class="form-label fw-bold">Father Name<a style="text-decoration: none;color:red">*</a></label>
                          <input type="text" name="fathername" value="{{old("fathername")}}" placeholder="Father Name" class="form-control" id="fathername" required>
                          <span id="fathername_val"></span>
                        </div>
                      <div class="form-group col-md-6 ">
                          <label for="fullname" class="form-label fw-bold">Mother Name<a style="text-decoration: none;color:red">*</a></label>
                          <input type="text" name="mothername" value="{{old("mothername")}}" placeholder="Mother Name" class="form-control" id="mothername" required>
                          <span id="mothername_val"></span>
                        </div>
                      <div class="form-group col-md-6">
                          <label class="form-label fw-bold" for="join_date">Date of Joining<a style="text-decoration: none;color:red">*</a></label>
                          <input type="date" class="form-control" value="{{old("join_date")}}"  placeholder="Date of Joining" name="join_date" id="joindate" required>
                          <span id="joindate_val"></span>

                        </div>
                      <div class="form-group col-md-6">
                          <label class="form-label fw-bold" for="end_date">End Date</label>
                          <input type="date" class="form-control" value="{{old("end_date")}}"  placeholder="End Date" name="end_date" id="enddate"required >
                          <span id="enddate_val"></span>
                        </div>
                      <div class="form-group col-md-4">
                          <label class="form-label fw-bold" for="category">Category<a style="text-decoration: none;color:red">*</a></label>
                          <div class="form-label">
                              <select id="category" name="category"  class="form-control" type="text" placeholder="Category" required>
                                <option value=''>Select option</option>
                                  @foreach(trans('category') as $value => $label)
                                  <option @if(old('category') == $value) selected @endif value="{{ $value }}">{{ $label }}</option>
                                  @endforeach
                              </select>
                          </div>
                          <span id="category_val"></span>
                        </div>
                      <div class="form-group col-md-4">
                          <label class="form-label fw-bold" for="sponser">Sponsor<a style="text-decoration: none;color:red">*</a></label>
                          <select id="sponser" name="sponser"  class="form-control" type="text" placeholder="Sponsor" required>
                            <option value=''>Select option</option>
                            @foreach(trans('sponsor') as $value => $label)
                            <option @if(old('sponser') == $value) selected @endif value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        <span id="sponser_val"></span>
                        </div>
                      <div class="form-group col-md-4">
                          <label class="form-label fw-bold" for="working_as">Working As<a style="text-decoration: none;color:red">*</a></label>
                          <input type="text" name="working_as" value="{{old("working_as")}}"  placeholder="working As" class="form-control" id="workingas">
                          <span id="workingas_val"></span>
                        </div>

                      <div class="form-group col-md-4">
                          <label class="form-label fw-bold" for="depart">Department<a style="text-decoration: none;color:red">*</a></label>
                       <div class="form-label">
                          <select id="depart" name="depart"  class="form-control" type="text" placeholder="Department" required>
                            <option value=''>Select option</option>
                              @foreach(trans('department') as $value => $label)
                              <option @if(old('department') == $value) selected @endif value="{{ $value }}">{{ $label }}</option>
                              @endforeach
                          </select>
                          </div>
                          <span id="depart_val"></span>
                        </div>
                      <div class="form-group col-md-4">
                          <label class="form-label fw-bold" for="status">Status<a style="text-decoration: none;color:red">*</a></label>
                       <div class="form-label">
                          <select id="status" name="status"  class="form-control" type="text" placeholder="Department"required>
                            <option value=''>Select option</option>
                              @foreach(trans('status') as $value => $label)
                              <option @if(old('status') == $value) selected @endif value="{{ $value }}">{{ $label }}</option>
                              @endforeach
                          </select>
                          </div>
                          <span id="status_val"></span>
                        </div>
                      <div class="form-group col-md-4">
                          <label class="form-label fw-bold" for="religion">Religion<a style="text-decoration: none;color:red">*</a></label>
                          <div class="form-label">
                              <select id="religion" name="religion"  class="form-control" type="text" placeholder="Religion" required>
                                <option value=''>Select option</option>
                                  @foreach(trans('religion') as $value => $label)
                                  <option @if(old('religion') == $value) selected @endif value="{{ $value }}">{{ $label }}</option>
                                  @endforeach
                              </select>
                              </div>
                              <span id="religion_val"></span>
                        </div>
                      <div class="form-group col-md-4">
                          <label class="form-label fw-bold" for="nationality">Nationality<a style="text-decoration: none;color:red">*</a></label>
                          <div class="form-label">
                          <select id="nationality" name="nationality"  class="form-control" type="text" placeholder="Nationality" required>
                            <option value=''>Select option</option>
                              @foreach(trans('nationality') as $value => $label)
                              <option @if(old('nationality') == $value) selected @endif value="{{ $value }}">{{ $label }}</option>
                              @endforeach
                          </select>
                          </div>
                          <span id="nationality_val"></span>
                        </div>


                      <div class="form-group col-md-4">
                          <label class="form-label fw-bold" for="city">Current Location<a style="text-decoration: none;color:red">*</a></label>
                          <select id="city" name="city"  class="form-control" type="text" >
                            <option value=''>Select Any Option</option>
                              @foreach(trans('current_location') as $value => $label)
                              <option @if(old('city') == $value) selected @endif value="{{ $value }}">{{ $label }}</option>
                              @endforeach
                          </select>
                          <span id="city_val"></span>
                        </div>

                      <div class="form-group col-md-4">
                          <label class="form-label fw-bold" for="phone">Home Country Contact Number<a style="text-decoration: none;color:red">*</a></label>
                          <input type="text" class="form-control" value="{{old("phone")}}"  placeholder="Phone" name="phone" id="phone" required  maxlength="10">
                          <span id="phone_val"></span>
                        </div>
                      <div class="form-group col-md-4">
                          <label class="form-label fw-bold" for="UAE_mobile_number">UAE Mobile Number<a style="text-decoration: none;color:red">*</a></label>
                          <input type="text" class="form-control" value="{{old("UAE_mobile_number")}}"  placeholder="UAE Mobile Number" name="UAE_mobile_number" id="mobile" maxlength="10" >
                          <span id="mobile_val"></span>
                        </div>

                      <div class="form-group col-md-4">
                          <label class="form-label fw-bold" for="pay_group">Pay Group<a style="text-decoration: none;color:red">*</a></label>
                          <select id="pay" name="pay_group"  class="form-control" type="text" placeholder="Pay Group" required>
                            <option value=''>Select option</option>
                              @foreach(trans('paygroup') as $value => $label)
                              <option @if(old('pay_group') == $value) selected @endif value="{{ $value }}">{{ $label }}</option>
                              @endforeach
                          </select>
                          <span id="pay_val"></span>
                        </div>

                        <div class="form-group col-md-4">
                            <label class="form-label fw-bold" for="accomodation">Accomodation<a style="text-decoration: none;color:red">*</a></label>
                            <!-- <input type="text" class="form-control" value="{{old("accomodation")}}"  placeholder="Accomodation" name="accomodation"> -->
                            <div class="form-label">
                            <select id="accomodation" name="accomodation"  class="form-control " type="text" >
                              <option value=''>Select Any Option</option>
                                @foreach(trans('accomodation') as $value => $label)
                                <option @if(old('accomodation') == $value) selected @endif value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            </div>
                            <span id="accomodation_val"></span>
                          </div>
                         <div class="form-group col-md-4">
                          <label for="passport_no" class="form-label fw-bold">Passport Number<a style="text-decoration: none;color:red">*</a></label>
                          <input type="passport_no" name="passport_no" value="{{old("passport_no")}}" placeholder="Passport Number" class="form-control" id="passport" required >
                          <span id="passport_val"></span>
                        </div>
                      <div class="form-group col-md-4">
                          <label class="form-label fw-bold" for="passport_expiry_date"> Passport Expiry Date<a style="text-decoration: none;color:red">*</a></label>
                          <input type="date" class="form-control" value="{{old("passport_expiry_date")}}"  placeholder="Passport Expiry Date" name="passport_expiry_date" id="expirydate" required>
                          <span id="expirydate_val"></span>
                        </div>
                      <div class="form-group col-md-4">
                          <label for="emirates_id_no" class="form-label fw-bold">Emirates Id No<a style="text-decoration: none;color:red">*</a></label>
                          <input type="emirates_id_no" name="emirates_id_no" value="{{old("emirates_id_no")}}"  placeholder="Emirates Id No" class="form-control" id="eid" maxlength="7" required>
                          <span id="eid_val"></span>
                        </div>
                      <div class="form-group col-md-4">
                          <label class="form-label fw-bold" for="emirates_id_from_date">Emirates Id From Date<a style="text-decoration: none;color:red">*</a></label>
                          <input type="date" class="form-control" value="{{old("emirates_id_from_date")}}"  placeholder="Emirates Id From Date" name="emirates_id_from_date" id="emirates_id_from_date" required >
                          <span id="efid_val"></span>
                        </div>
                      <div class="form-group col-md-4">
                          <label class="form-label fw-bold" for="emirates_id_to_date">Emirates Id To Date<a style="text-decoration: none;color:red">*</a></label>
                          <input type="date" class="form-control" value="{{old("emirates_id_to_date")}}"  placeholder="Emirates Id To Date" name="emirates_id_to_date" id="emirates_id_to_date" required>
                          <span id="etid_val"></span>
                        </div>

                        {{-- Visa --}}
                        <div class="col-md-12 mt-3 text-primary">
                            <h4><center>Visa Details</center></h4>
                          </div>

                        <div class="form-group col-md-4">
                            <label class="form-label fw-bold" for="expiry_date">Visa End Date<a style="text-decoration: none;color:red">*</a></label>
                            <input type="date" class="form-control" value="{{old("expiry_date")}}"  placeholder="Visa End Date" name="expiry_date" id="vexpiry_date" required>
                            <span id="vexpiry_date_val"></span>
                        </div>

                          <div class="form-group col-md-4">
                              <label class="form-label fw-bold" for="visa_status">Visa Status<a style="text-decoration: none;color:red">*</a></label>
                              <div class="form-label">
                                  <select id="visastatus" name="visa_status"  class="form-control" type="text" placeholder="Visa Status" required>
                                    <option value=''>Select option</option>
                                      @foreach(trans('visastatus') as $value => $label)
                                      <option @if(old('visa_status') == $value) selected @endif value="{{ $value }}">{{ $label }}</option>
                                      @endforeach
                                  </select>
                                  <span id="visastatus_val"></span>
                              </div>
                          </div>
                          <div class="form-group col-md-4">
                            <label class="form-label fw-bold" for="desigination">Visa Designation<a style="text-decoration: none;color:red">*</a></label>
                         <div class="form-label">
                            <select id="visadesignation" name="desigination"  class="form-control" type="text" placeholder="Designation" required>
                                <option value=''>Select option</option>
                                @foreach(trans('designation') as $value => $label)
                                <option @if(old('designation') == $value) selected @endif value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            </div>
                            <span id="visadesignation_val"></span>
                          </div>


                        {{-- salary --}}
                        <div class="col-md-12 mt-3 text-primary">
                            <h4><center>Salary Details</center></h4>
                          </div>

                        <div class="form-group col-md-6">
                            <label for="fullname" class="form-label fw-bold">Total Salary<a style="text-decoration: none;color:red">*</a></label>
                            <input type="text" name="total_salary" value="{{old("total_salary")}}" placeholder="Total Salary" class="form-control" required id="salary">
                            <span id="salary_val"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="fullname" class="form-label fw-bold">HRA<a style="text-decoration: none;color:red">*</a></label>
                            <input type="text" name="hra" value="{{old("hra")}}" placeholder="HRA" class="form-control" required id="hra">
                            <span id="hra_val"></span>
                        </div>

                        <div class="form-group ">
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-primary " id="add_button">
                                    {{ __('Add') }}
                                </button>
                            </div>
                        </div>
              </div>
            </div>

</form>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
    $(document).ready(function()
    {

        $('#add_button').prop('disabled', true);

        $("#firstname").focusout(function()
        {
            var name_reg=/^[A-Z a-z]+$/;

            if($(this).val()== '')
            {
                document.getElementById("firstname_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#add_button').prop('disabled',true);
            }
            else if(name_reg.test($(this).val()) == true)
            {
                document.getElementById("firstname_val").innerHTML="";
                $('#add_button').prop('disabled',false);
            }
            else if(name_reg.test($(this).val()) == false)
            {
                document.getElementById("firstname_val").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('#add_button').prop('disabled',true);
            }
        });
        $("#lastname").focusout(function()
        {
            var name_reg=/^[A-Z a-z]+$/;

            if($(this).val()== '')
            {
                document.getElementById("lastname_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#add_button').prop('disabled',true);
            }
            else if(name_reg.test($(this).val()) == true)
            {
                document.getElementById("lastname_val").innerHTML="";
                $('#add_button').prop('disabled',false);
            }
            else if(name_reg.test($(this).val()) == false)
            {
                document.getElementById("lastname_val").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('#add_button').prop('disabled',true);
            }
        });
        $("#fathername").focusout(function()
        {
            var name_reg=/^[A-Z a-z]+$/;

            if($(this).val()== '')
            {
                document.getElementById("fathername_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#add_button').prop('disabled',true);
            }
            else if(name_reg.test($(this).val()) == true)
            {
                document.getElementById("fathername_val").innerHTML="";
                $('#add_button').prop('disabled',false);
            }
            else if(name_reg.test($(this).val()) == false)
            {
                document.getElementById("fathername_val").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('#add_button').prop('disabled',true);
            }
        });
        $("#mothername").focusout(function()
        {
            var name_reg=/^[A-Z a-z]+$/;

            if($(this).val()== '')
            {
                document.getElementById("mothername_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#add_button').prop('disabled',true);
            }
            else if(name_reg.test($(this).val()) == true)
            {
                document.getElementById("mothername_val").innerHTML="";
                $('#add_button').prop('disabled',false);
            }
            else if(name_reg.test($(this).val()) == false)
            {
                document.getElementById("mothername_val").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('#add_button').prop('disabled',true);
            }
        });

        $("#category").focusout(function(){
        if($(this).val()== ''){
        document.getElementById("category_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
        $('#add_button').prop('disabled',true);
        }
        else  if($(this).val() != ''){
            document.getElementById("category_val").innerHTML="";
            $('#add_button').prop('disabled',false);
        }
          });

        $("#sponser").focusout(function(){
                if($(this).val()== ''){
                document.getElementById("sponser_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#add_button').prop('disabled',true);
                }
                else  if($(this).val() != ''){
                    document.getElementById("sponser_val").innerHTML="";
                    $('#add_button').prop('disabled',false);
                }
          });

          $("#workingas").focusout(function()
        {
            var name_reg=/^[A-Z a-z]+$/;

            if($(this).val()== '')
            {
                document.getElementById("workingas_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#add_button').prop('disabled',true);
            }
            else if(name_reg.test($(this).val()) == true)
            {
                document.getElementById("workingas_val").innerHTML="";
                $('#add_button').prop('disabled',false);
            }
            else if(name_reg.test($(this).val()) == false)
            {
                document.getElementById("workingas_val").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('#add_button').prop('disabled',true);
            }
        });

        $("#depart").focusout(function(){
                if($(this).val()== ''){
                document.getElementById("depart_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#add_button').prop('disabled',true);
                }
                else  if($(this).val() != ''){
                    document.getElementById("depart_val").innerHTML="";
                    $('#add_button').prop('disabled',false);
                }
          });

          $("#status").focusout(function(){
                if($(this).val()== ''){
                document.getElementById("status_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#add_button').prop('disabled',true);
                }
                else  if($(this).val() != ''){
                    document.getElementById("status_val").innerHTML="";
                    $('#add_button').prop('disabled',false);
                }
          });

          $("#religion").focusout(function(){
                if($(this).val()== ''){
                document.getElementById("religion_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#add_button').prop('disabled',true);
                }
                else  if($(this).val() != ''){
                    document.getElementById("religion_val").innerHTML="";
                    $('#add_button').prop('disabled',false);
                }
          });

          $("#nationality").focusout(function(){
                if($(this).val()== ''){
                document.getElementById("nationality_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#add_button').prop('disabled',true);
                }
                else  if($(this).val() != ''){
                    document.getElementById("nationality_val").innerHTML="";
                    $('#add_button').prop('disabled',false);
                }
          });
          $("#city").focusout(function()
        {
            var name_reg=/^[A-Z a-z]+$/;

            if($(this).val()== '')
            {
                document.getElementById("city_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#add_button').prop('disabled',true);
            }
            else if(name_reg.test($(this).val()) == true)
            {
                document.getElementById("city_val").innerHTML="";
                $('#add_button').prop('disabled',false);
            }
            else if(name_reg.test($(this).val()) == false)
            {
                document.getElementById("city_val").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('#add_button').prop('disabled',true);
            }
        });

        $("#phone").focusout(function()
        {
            var re=/^[6789][0-9]+$/;

            if($(this).val()== '')
            {
                document.getElementById("phone_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#add_button').prop('disabled',true);
            }
            else if(re.test($(this).val()) == true)
            {
                document.getElementById("phone_val").innerHTML="";
                $('#add_button').prop('disabled',false);
            }
            else if(re.test($(this).val()) == false)
            {
                document.getElementById("phone_val").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('#add_button').prop('disabled',true);
            }
        });
        $("#mobile").focusout(function()
        {
            var re=/^[6789][0-9]+$/;

            if($(this).val()== '')
            {
                document.getElementById("mobile_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#add_button').prop('disabled',true);
            }
            else if(re.test($(this).val()) == true)
            {
                document.getElementById("mobile_val").innerHTML="";
                $('#add_button').prop('disabled',false);
            }
            else if(re.test($(this).val()) == false)
            {
                document.getElementById("mobile_val").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('#add_button').prop('disabled',true);
            }
        });
        $("#pay").focusout(function(){
                if($(this).val()== ''){
                document.getElementById("pay_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#add_button').prop('disabled',true);
                }
                else  if($(this).val() != ''){
                    document.getElementById("pay_val").innerHTML="";
                    $('#add_button').prop('disabled',false);
                }
          });
        $("#accomodation").focusout(function()
        {
            if($(this).val()== '')
            {
                document.getElementById("accomodation_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#add_button').prop('disabled',true);
            }
            else if($(this).val()!= '')
            {
                document.getElementById("accomodation_val").innerHTML="";
                $('#add_button').prop('disabled',false);
            }
        });

    });
    $("#passport").focusout(function()
        {
            var re=/^(?!0+(?:\.0+)?$)[0-9]+(?:\.[0-9]+)?$/;

            if($(this).val()== '')
            {
                document.getElementById("passport_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#add_button').prop('disabled',true);
            }
            else if(re.test($(this).val()) == true)
            {
                document.getElementById("passport_val").innerHTML="";
                $('#add_button').prop('disabled',false);
            }
            else if(re.test($(this).val()) == false)
            {
                document.getElementById("passport_val").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('#add_button').prop('disabled',true);
            }
        });
        $("#eid").focusout(function()
        {
            var re=/^(?!0+(?:\.0+)?$)[0-9]+(?:\.[0-9]+)?$/;

            if($(this).val()== '')
            {
                document.getElementById("eid_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#add_button').prop('disabled',true);
            }
            else if(re.test($(this).val()) == true)
            {
                document.getElementById("eid_val").innerHTML="";
                $('#add_button').prop('disabled',false);
            }
            else if(re.test($(this).val()) == false)
            {
                document.getElementById("eid_val").innerHTML="<span class='text-danger m-2'>Please enter valid data</span>";
                $('#add_button').prop('disabled',true);
            }
        });
        $("#visastatus").focusout(function(){
                if($(this).val()== ''){
                document.getElementById("visastatus_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#add_button').prop('disabled',true);
                }
                else  if($(this).val() != ''){
                    document.getElementById("visastatus_val").innerHTML="";
                    $('#add_button').prop('disabled',false);
                }
          });
        $("#visadesignation").focusout(function(){
                if($(this).val()== ''){
                document.getElementById("visadesignation_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#add_button').prop('disabled',true);
                }
                else  if($(this).val() != ''){
                    document.getElementById("visadesignation_val").innerHTML="";
                    $('#add_button').prop('disabled',false);
                }
          });
          $("#salary").focusout(function()
        {
            var re=/^(?!0+(?:\.0+)?$)[0-9]+(?:\.[0-9]+)?$/;

            if($(this).val()== '')
            {
                document.getElementById("salary_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#add_button').prop('disabled',true);
            }
            else if(re.test($(this).val()) == true)
            {
                document.getElementById("salary_val").innerHTML="";
                $('#add_button').prop('disabled',false);
            }
            else if(re.test($(this).val()) == false)
            {
                document.getElementById("salary_val").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('#add_button').prop('disabled',true);
            }
        });
        $("#hra").focusout(function()
        {
            var re=/^(?!0+(?:\.0+)?$)[0-9]+(?:\.[0-9]+)?$/;

            if($(this).val()== '')
            {
                document.getElementById("hra_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#add_button').prop('disabled',true);
            }
            else if(re.test($(this).val()) == true)
            {
                document.getElementById("hra_val").innerHTML="";
                $('#add_button').prop('disabled',false);
            }
            else if(re.test($(this).val()) == false)
            {
                document.getElementById("hra_val").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('#add_button').prop('disabled',true);
            }
        });


</script>
