<div id="myModal2" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content ">
            <div class="modal-header bg-primary">
                <h4 class="modal-title ">Add Project</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="card-body ">
                    <form method="POST" class="form-row" id="myform" action="{{ route('projectmaster.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group col-md-6">
                            <label for="site_name" class="form-label fw-bold">Site Name<a style="text-decoration: none;color:red">*</a></label>
                            <input type="text" name="site_name" id="site_name" value="{{old("site_name")}}" placeholder="Site Name" required class="form-control site_name">
                            <span id="val_site_name"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="site_no" class="form-label fw-bold">Site No</label>
                            <input type="text" name="site_no" id="site_no" value="{{old("site_no")}}" placeholder="Site Number" required class="form-control site_no" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="project_name" class="form-label fw-bold">Project Name<a style="text-decoration: none;color:red">*</a></label>
                            <input type="text" name="project_name" id="project_name" value="{{old("project_name")}}" placeholder="Project Name" required class="form-control" autocomplete="off">
                            <span id="val_project_name"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="project_type" class="form-label fw-bold">Project Type<a style="text-decoration: none;color:red">*</a></label>
                            <div class="form-label">
                            <select id="project_type" name="project_type"  class="form-control" type="text" placeholder="Religion">
                                <option value=''>Select option</option>
                                @foreach(trans('project_type') as $value => $label)
                                    <option @if(old('project_type') == $value) selected @endif value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            <span id="val_project_type"></span>
                        </div>
                    </div>
                        <div class="form-group col-md-6">
                            <label for="project_comments" class="form-label fw-bold">Comments<a style="text-decoration: none;color:red">*</a></label>
                            <input type="text" name="project_comments" id="project_comments"  value="{{old("project_comments")}}" placeholder="Comments" required class="form-control" autocomplete="off">
                            <span id="val_project_comments"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="manager_name" class="form-label fw-bold">Manager Name<a style="text-decoration: none;color:red">*</a></label>
                            <input type="text" name="manager_name" id="manager_name" value="{{old("manager_name")}}" placeholder="Manager Name" required class="form-control manager_name" autocomplete="off">
                            <span id="val_manager_name"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="manager_contact_number" class="form-label fw-bold">Manager Contact Number<a style="text-decoration: none;color:red">*</a></label>
                            <input type="text" name="manager_contact_number" readonly id="manager_contact_number" value="{{old("manager_contact_number")}}" maxlength="10" placeholder="Manager Contact Number" required class="form-control manager_contact_number" autocomplete="off">
                            <span id="val_manager_contact_number"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="" class="form-label fw-bold">Client / Company Name<a style="text-decoration: none;color:red">*</a></label>
                            <input type="text" name="company_name" id="company_name" value="{{old("company_name")}}" placeholder="Company Name" required class="form-control" autocomplete="off">
                            <span id="val_company_name"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="" class="form-label fw-bold">Client Contact Name<a style="text-decoration: none;color:red">*</a></label>
                            <input type="text" name="client_contact_name"  value="{{old("client_contact_name")}}" placeholder="Client Contact Name " required class="form-control" id="client_contact_name" autocomplete="off">
                            <span id="val_client_contact_name"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="" class="form-label fw-bold">Client Contact Number<a style="text-decoration: none;color:red">*</a></label>
                            <input type="text" name="client_contact_number" id="client_contact_number" value="{{old("client_contact_number")}}" maxlength="10" placeholder="Client Contact Number " required class="form-control" autocomplete="off">
                            <span id="val_client_contact_number"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="" class="form-label fw-bold">Consultant Name<a style="text-decoration: none;color:red">*</a></label>
                            <input type="text" name="consultant_name" id="consultant_name" value="{{old("consultant_name")}}" placeholder="Consultant Name" required class="form-control" autocomplete="off">
                            <span id="val_consultant_name"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="" class="form-label fw-bold">Start Date<a style="text-decoration: none;color:red">*</a></label>
                            <input type="date" name="start_date" id="start_date"  value="{{old("start_date")}}" required class="form-control" autocomplete="off">
                            <span id="val_start_date"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="" class="form-label fw-bold">Tentative End Date<a style="text-decoration: none;color:red">*</a></label>
                            <input type="date" name="end_date" id="end_date"  value="{{old("end_date")}}"  required class="form-control" autocomplete="off">
                            <span id="val_end_date"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="" class="form-label fw-bold">Actual Project End Date<a style="text-decoration: none;color:red">*</a></label>
                            <input type="date" name="actual_project_end_date" id="actual_project_end_date"  value="{{old("actual_project_end_date")}}" required class="form-control" autocomplete="off">
                            <span id="val_actual_project_end_date"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="" class="form-label fw-bold">Status<a style="text-decoration: none;color:red">*</a></label>
                            <select id="status" name="status"  class="form-control" type="text">
                                <option value=''>Select option</option>
                                @foreach(trans('project_status') as $value => $label)
                                    <option @if(old('status') == $value) selected @endif value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            <span id="val_status"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="" class="form-label fw-bold">Total Project Cost<a style="text-decoration: none;color:red">*</a></label>
                            <input type="text" name="total_price_cost" id="total_price_cost" value="{{old("total_price_cost")}}" placeholder="Total Price Cost" required class="form-control" autocomplete="off">
                            <span id="val_total_price_cost"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="" class="form-label fw-bold">Advance Amount<a style="text-decoration: none;color:red">*</a></label>
                            <input type="text" name="advanced_amount" id="advanced_amount"  value="{{old("advanced_amount")}}" placeholder="Advance Amount" required class="form-control " autocomplete="off">
                            <span id="val_advanced_amount"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="" class="form-label fw-bold">Retention<a style="text-decoration: none;color:red">*</a></label>
                            <input type="text" name="retention" id="retention" value="{{old("retention")}}" placeholder="Retention" required class="form-control" autocomplete="off">
                            <span id="val_retention"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="" class="form-label fw-bold">Balance Amount To Be Received<a style="text-decoration: none;color:red">*</a></label>
                            <input type="text" name="amount_to_be_received" id="amount_to_be_received" value="{{old("amount_to_be_received")}}" placeholder="Balance Amount To Be Received " required class="form-control" autocomplete="off">
                            <span id="val_amount_to_be_received"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="" class="form-label fw-bold">Amount Return<a style="text-decoration: none;color:red">*</a></label>
                            <input type="text" name="amount_return" id="amount_return" value="{{old("amount_return")}}" placeholder="Amount Return" required class="form-control" autocomplete="off">
                            <span id="val_amount_return"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="" class="form-label fw-bold">Amount Return Date<a style="text-decoration: none;color:red">*</a></label>
                            <input type="date" name="amount_return_date" id="amount_return_date"  value="{{old("amount_return_date")}}" required class="form-control">
                            <span id="val_amount_return_date"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="" class="form-label fw-bold">Amount Return Comments<a style="text-decoration: none;color:red">*</a></label>
                            <input type="text" name="amount_returns_comment" id="amount_returns_comment" value="{{old("amount_returns_comment")}}" placeholder="Amount Return Comments" required class="form-control">
                            <span id="val_amount_returns_comment"></span>
                        </div>
                            <div class="col-md-12">
                                <button type="submit" id="add_button" class="btn btn-primary">{{ __('Add') }}</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>



{{-- Site Name - site number autocomplete --}}

<script>
 $("#edit").hide();
     dlgc = $("#myModal2"); //modal
     supc = $("#site_name", dlgc); //

     $(".site_name").autocomplete(
      {

      source: function( request, response ) {
        $.ajax( {
        type:"GET",
          url: "{{ route('ProjectGetData') }}",
          dataType: "json",
          data:{
            'site_name':$("#site_name").val()
          },
          success: function( data ) {

            result = [];
            for(var i in data)
            {
              result.push(data[i]["site_name"]);
            }
// alert($("#supplier_name").val());
             response(result);

          },fail: function(xhr, textStatus, errorThrown){
       alert(errorThrown);
    }
        } );
      },
      minLength:1,

      appendTo: "#myModal2",
      open: function () {
        setTimeout(function () {
         $(this).css('zIndex', 2147483647);

    }, 0);
          autocomplete.zIndex(dlgc.zIndex()+1);
 	 }

    } );
    //autocomplete = $("#site_name").autocomplete("widget").insertAfter(dlgc.parent());

 $("#site_name").on('change',function(){
    var code= $(this).val();

    $.ajax( {
         type:"GET",
           url: "{{ route('ProjectGetData') }}",
           dataType: "json",
           data:{
             'site_name':$(this).val()
           },
           success: function( data ) {
             console.log(data);
             result = [];
             for(var i in data)
             {
               $('#site_no').val(data[i]["site_no"]);
             }
              console.log(result);
           },fail: function(xhr, textStatus, errorThrown){
        alert(errorThrown);
     }
         } );
 });


</script>


{{-- Manager - contact number autocomplete --}}

<script>
    $("#edit").hide();
        dlgc = $("#myModal2"); //modal
        supc = $("#manager_name", dlgc); //

        $(".manager_name").autocomplete(
         {

         source: function( request, response ) {
           $.ajax( {
           type:"GET",
             url: "{{ route('ProjectManagerData') }}",
             dataType: "json",
             data:{
               'manager_name':$("#manager_name").val()
             },
             success: function( data ) {

               result = [];
               for(var i in data)
               {
                 result.push(data[i]["firstname"]);
               }
   // alert($("#supplier_name").val());
                response(result);

             },fail: function(xhr, textStatus, errorThrown){
          alert(errorThrown);
       }
           } );
         },
         minLength:1,

         appendTo: "#myModal2",
         open: function () {
           setTimeout(function () {
            $(this).css('zIndex', 2147483647);

       }, 0);
             autocomplete.zIndex(dlgc.zIndex()+1);
         }

       } );
       //autocomplete = $("#manager_name").autocomplete("widget").insertAfter(dlgc.parent());

     $("#manager_name").on('change',function(){
        var code= $(this).val();

        $.ajax( {
             type:"GET",
               url: "{{ route('ProjectManagerData') }}",
               dataType: "json",
               data:{
                 'manager_name':$(this).val()
               },
               success: function( data ) {
                 console.log(data);
                 result = [];
                 for(var i in data)
                 {
                   $('#manager_contact_number').val(data[i]["phone"]);
                 }
                  console.log(result);
               },fail: function(xhr, textStatus, errorThrown){
            alert(errorThrown);
         }
             } );
     });


   </script>



<script>
    $(document).ready(function()
    {
        $('#add_button').prop('disabled', true);

        $("#site_name").focusout(function()
        {
            var name_reg=/^[A-Za-z ]+$/;

            if($(this).val()== '')
            {
                document.getElementById("val_site_name").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#add_button').prop('disabled',true);
            }
            else if(name_reg.test($(this).val()) == true)
            {
                document.getElementById("val_site_name").innerHTML="";
                $('#add_button').prop('disabled',false);
            }
            else if(name_reg.test($(this).val()) == false)
            {
                document.getElementById("val_site_name").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('#add_button').prop('disabled',true);
            }
        });
        $("#project_name").focusout(function()
        {
            if($(this).val()== '')
            {
                document.getElementById("val_project_name").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#add_button').prop('disabled',true);
            }
            else if(re.test($(this).val()) != '')
            {
                document.getElementById("val_project_name").innerHTML="";
                $('#add_button').prop('disabled',false);
            }
        });
        $("#contact_number").focusout(function()
        {
            var re=/^[6789]\d{9}$/;

            if($(this).val()== '')
            {
                document.getElementById("c3").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#add_button').prop('disabled',true);
            }
            else if(re.test($(this).val()) == true)
            {
                document.getElementById("c3").innerHTML="";
                $('#add_button').prop('disabled',false);
            }
            else if(re.test($(this).val()) == false)
            {
                document.getElementById("c3").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('#add_button').prop('disabled',true);
            }
        });
        $("#project_comments").focusout(function()
        {
            if($(this).val()== '')
            {
                document.getElementById("val_project_comments").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#add_button').prop('disabled',true);
            }
            else if(re.test($(this).val()) == true)
            {
                document.getElementById("val_project_comments").innerHTML="";
                $('#add_button').prop('disabled',false);
            }
        });

        $("#manager_name").focusout(function()
        {
            var name_reg=/^[A-Za-z ]+$/;

            if($(this).val()== '')
            {
                document.getElementById("val_manager_name").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#add_button').prop('disabled',true);
            }
            else if(name_reg.test($(this).val()) == true)
            {
                document.getElementById("val_manager_name").innerHTML="";
                $('#add_button').prop('disabled',false);
            }
            else if(name_reg.test($(this).val()) == false)
            {
                document.getElementById("val_manager_name").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('#add_button').prop('disabled',true);
            }
        });


        $("#manager_contact_number").focusout(function()
        {
            var re=/^[6789]\d{9}$/;

            if($(this).val()== '')
            {
                document.getElementById("val_manager_contact_number").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#add_button').prop('disabled',true);
            }
            else if(re.test($(this).val()) == true)
            {
                document.getElementById("val_manager_contact_number").innerHTML="";
                $('#add_button').prop('disabled',false);
            }
            else if(re.test($(this).val()) == false)
            {
                document.getElementById("val_manager_contact_number").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('#add_button').prop('disabled',true);
            }
        });

        $("#company_name").focusout(function()
        {
            var name_reg=/^[A-Za-z ]+$/;

            if($(this).val()== '')
            {
                document.getElementById("val_company_name").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#add_button').prop('disabled',true);
            }
            else if(name_reg.test($(this).val()) == true)
            {
                document.getElementById("val_company_name").innerHTML="";
                $('#add_button').prop('disabled',false);
            }
            else if(name_reg.test($(this).val()) == false)
            {
                document.getElementById("val_company_name").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('#add_button').prop('disabled',true);
            }
        });


        $("#client_contact_name").focusout(function()
        {
            var name_reg=/^[A-Za-z ]+$/;

            if($(this).val()== '')
            {
                document.getElementById("val_client_contact_name").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#add_button').prop('disabled',true);
            }
            else if(name_reg.test($(this).val()) == true)
            {
                document.getElementById("val_client_contact_name").innerHTML="";
                $('#add_button').prop('disabled',false);
            }
            else if(name_reg.test($(this).val()) == false)
            {
                document.getElementById("val_client_contact_name").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('#add_button').prop('disabled',true);
            }
        });

        $("#client_contact_number").focusout(function()
        {
            var re=/^[6789]\d{9}$/;

            if($(this).val()== '')
            {
                document.getElementById("val_client_contact_number").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#add_button').prop('disabled',true);
            }
            else if(re.test($(this).val()) == true)
            {
                document.getElementById("val_client_contact_number").innerHTML="";
                $('#add_button').prop('disabled',false);
            }
            else if(re.test($(this).val()) == false)
            {
                document.getElementById("val_client_contact_number").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('#add_button').prop('disabled',true);
            }
        });

        $("#consultant_name").focusout(function()
        {
            var name_reg=/^[A-Za-z ]+$/;

            if($(this).val()== '')
            {
                document.getElementById("val_consultant_name").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#add_button').prop('disabled',true);
            }
            else if(name_reg.test($(this).val()) == true)
            {
                document.getElementById("val_consultant_name").innerHTML="";
                $('#add_button').prop('disabled',false);
            }
            else if(name_reg.test($(this).val()) == false)
            {
                document.getElementById("val_consultant_name").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('#add_button').prop('disabled',true);
            }
        });

        $("#total_price_cost").focusout(function()
        {
            var re=/^[6789][0-9]+$/;

            if($(this).val()== '')
            {
                document.getElementById("val_total_price_cost").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#add_button').prop('disabled',true);
            }
            else if(re.test($(this).val()) == true)
            {
                document.getElementById("val_total_price_cost").innerHTML="";
                $('#add_button').prop('disabled',false);
            }
            else if(re.test($(this).val()) == false)
            {
                document.getElementById("val_total_price_cost").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('#add_button').prop('disabled',true);
            }
        });

        $("#advanced_amount").focusout(function()
        {
            var re=/^[6789][0-9]+$/;

            if($(this).val()== '')
            {
                document.getElementById("val_advanced_amount").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#add_button').prop('disabled',true);
            }
            else if(re.test($(this).val()) == true)
            {
                document.getElementById("val_advanced_amount").innerHTML="";
                $('#add_button').prop('disabled',false);
            }
            else if(re.test($(this).val()) == false)
            {
                document.getElementById("val_advanced_amount").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('#add_button').prop('disabled',true);
            }
        });


        $("#retention").focusout(function()
        {
            var re=/^[6789][0-9]+$/;

            if($(this).val()== '')
            {
                document.getElementById("val_retention").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#add_button').prop('disabled',true);
            }
            else if(re.test($(this).val()) == true)
            {
                document.getElementById("val_retention").innerHTML="";
                $('#add_button').prop('disabled',false);
            }
            else if(re.test($(this).val()) == false)
            {
                document.getElementById("val_retention").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('#add_button').prop('disabled',true);
            }
        });


        $("#amount_to_be_received").focusout(function()
        {
            var re=/^[6789][0-9]+$/;

            if($(this).val()== '')
            {
                document.getElementById("val_amount_to_be_received").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#add_button').prop('disabled',true);
            }
            else if(re.test($(this).val()) == true)
            {
                document.getElementById("val_amount_to_be_received").innerHTML="";
                $('#add_button').prop('disabled',false);
            }
            else if(re.test($(this).val()) == false)
            {
                document.getElementById("val_amount_to_be_received").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('#add_button').prop('disabled',true);
            }
        });


        $("#amount_return").focusout(function()
        {
            var re=/^[123456789][0-9]+$/;

            if($(this).val()== '')
            {
                document.getElementById("val_amount_return").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#add_button').prop('disabled',true);
            }
            else if(re.test($(this).val()) == true)
            {
                document.getElementById("val_amount_return").innerHTML="";
                $('#add_button').prop('disabled',false);
            }
            else if(re.test($(this).val()) == false)
            {
                document.getElementById("val_amount_return").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('#add_button').prop('disabled',true);
            }
        });

        $("#amount_returns_comment").focusout(function()
        {
            if($(this).val()== '')
            {
                document.getElementById("val_amount_returns_comment").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#add_button').prop('disabled',true);
            }
            else if(re.test($(this).val()) != '')
            {
                document.getElementById("val_amount_returns_comment").innerHTML="";
                $('#add_button').prop('disabled',false);
            }
        });

    });


    $("#project_type").focusout(function(){
                if($(this).val()== ''){
                document.getElementById("val_project_type").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#add_button').prop('disabled',true);
                }
                else  if($(this).val() != ''){
                    document.getElementById("val_project_type").innerHTML="";
                    $('#add_button').prop('disabled',false);
                }
          });
          $("#status").focusout(function(){
                if($(this).val()== ''){
                document.getElementById("val_status").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#add_button').prop('disabled',true);
                }
                else  if($(this).val() != ''){
                    document.getElementById("val_status").innerHTML="";
                    $('#add_button').prop('disabled',false);
                }
          });

</script>

