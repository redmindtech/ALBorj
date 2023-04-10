@foreach ($projects as $project)
<div class="modal fade" id="edit_projectmaster">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title" align="center"><b>Edit Project</b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form method="POST" id="edit-form" class="form-row" action="{{ route('projectmaster.update',$project->project_no) }}"enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group col-md-6" hidden>
                                <label for="project_no" class="form-label fw-bold">Project No</label>
                                <input type="number" name="project_no" id="project_no" value="{{old("project_no",$project->project_no)}}" placeholder="Project Number" required class="form-control project_no">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="site_name" class="form-label fw-bold">Site Name<a style="text-decoration: none;color:red">*</a></label>
                                <input type="text" name="site_name" id="u_site_name" value="{{old("site_name",$project->site_name)}}" placeholder="Site Name" required class="form-control site_name">
                                <span id="u_val_site_name"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="site_no" class="form-label fw-bold">Site No</label>
                                <input type="number" name="site_no" id="site_no" readonly value="{{old("site_no",$project->site_no)}}" placeholder="Site Number" required class="form-control site_no site_number">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="project_name" class="form-label fw-bold">Project Name<a style="text-decoration: none;color:red">*</a></label>
                                <input type="text" name="project_name" id="u_project_name" value="{{old("project_name",$project->project_name)}}" placeholder="Project Name" required class="form-control project_name">
                                <span id="u_val_project_name"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="project_type" class="form-label fw-bold">Project Type<a style="text-decoration: none;color:red">*</a></label>
                                <div class="form-label">
                                <select id="ptype" name="project_type" id="project_type" class="form-control project_type" type="text">
                                    <option value="">Select option</option>
                                    @foreach(trans('project_type') as $value => $label)
                                        <option @if(old('project_type',$project->project_type) == $value) selected @endif value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                                <span id="val_project_type"></span>
                            </div>
                        </div>
                            <div class="form-group col-md-6">
                                <label for="project_comments" class="form-label fw-bold">Comments</label>
                                <input type="text" name="project_comments" id="u_project_comments"  value="{{old("project_comments",$project->project_comments)}}" placeholder="Comments" required class="form-control project_comments">
                                <span id="u_val_project_comments"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="manager_name" class="form-label fw-bold">Manager Name<a style="text-decoration: none;color:red">*</a></label>
                                <input type="text" name="manager_name" id="u_manager_name" value="{{old("manager_name",$project->manager_name)}}" placeholder="Manager Name" required class="form-control manager_name">
                                <span id="u_val_manager_name"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="manager_contact_number" class="form-label fw-bold">Manager Contact Number<a style="text-decoration: none;color:red">*</a></label>
                                <input type="text" name="manager_contact_number"id="u_manager_contact_number" maxlength="10" value="{{old("manager_contact_number",$project->manager_contact_number)}}" placeholder="Manager Contact Number " required class="form-control manager_contact_number" readonly>
                                <span id="u_val_manager_contact_number"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="" class="form-label fw-bold">Client / Company Name<a style="text-decoration: none;color:red">*</a></label>
                                <input type="text" name="company_name" id="u_company_name" value="{{old("company_name",$project->company_name)}}" placeholder="Company Name " required class="form-control company_name">
                                <span id="u_val_company_name"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="" class="form-label fw-bold">Client Contact Name<a style="text-decoration: none;color:red">*</a></label>
                                <input type="text" name="client_contact_name" id="u_client_contact_name"  value="{{old("client_contact_name",$project->client_contact_name)}}" placeholder="Client Contact Name " required class="form-control client_contact_name">
                                <span id="u_val_client_contact_name"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="" class="form-label fw-bold">Client Contact Number<a style="text-decoration: none;color:red">*</a></label>
                                <input type="text" name="client_contact_number" id="u_client_contact_number" value="{{old("client_contact_number",$project->client_contact_number)}}" placeholder="Client Contact Number" maxlength="10" required class="form-control client_contact_number">
                                <span id="u_val_client_contact_number"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="" class="form-label fw-bold">Consultant Name<a style="text-decoration: none;color:red">*</a></label>
                                <input type="text" name="consultant_name" id="u_consultant_name" value="{{old("consultant_name",$project->consultant_name)}}" placeholder="Consultant Name " required class="form-control consultant_name">
                                <span id="u_val_consultant_name"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="" class="form-label fw-bold">Start Date<a style="text-decoration: none;color:red">*</a></label>
                                <input type="date" name="start_date" id="start_date" value="{{old("start_date",$project->start_date)}}" required class="form-control start_date">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="" class="form-label fw-bold">Tentative End Date<a style="text-decoration: none;color:red">*</a></label>
                                <input type="date" name="end_date" id="end_date"  value="{{old("end_date",$project->end_date)}}" required class="form-control end_date">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="" class="form-label fw-bold">Actual Project End Date<a style="text-decoration: none;color:red">*</a></label>
                                <input type="date" name="actual_project_end_date" id="actual_project_end_date"  value="{{old("actual_project_end_date",$project->actual_project_end_date)}}" required class="form-control actual_project_end_date">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="" class="form-label fw-bold">Status<a style="text-decoration: none;color:red">*</a></label>
                                <select name="status" id="status"  class="form-control status" type="text" placeholder="Religion">

                                    @foreach(trans('project_status') as $value => $label)
                                    <option @if(($project->status ?? old('status')) == $value) selected @endif value="{{ $value }}">{{$label}}</option>
                                    @endforeach
                                </select>
                                <span id="val_status"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="" class="form-label fw-bold">Total Project Cost<a style="text-decoration: none;color:red">*</a></label>
                                <input type="text" name="total_price_cost" id="u_total_price_cost" value="{{old("total_price_cost",$project->total_price_cost)}}" placeholder="Total Price Cost " required class="form-control total_price_cost">
                                <span id="u_val_total_price_cost"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="" class="form-label fw-bold">Advance Amount<a style="text-decoration: none;color:red">*</a></label>
                                <input type="text" name="advanced_amount" id="u_advanced_amount"  value="{{old("advanced_amount",$project->advanced_amount)}}" placeholder="Advace Amount " required class="form-control advanced_amount">
                                <span id="u_val_advanced_amount"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="" class="form-label fw-bold">Rentation<a style="text-decoration: none;color:red">*</a></label>
                                <input type="text" name="retention" id="u_retention" value="{{old("retention",$project->retention)}}" placeholder="Retention " required class="form-control retention">
                                <span id="u_val_retention"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="" class="form-label fw-bold">Balance Amount To Be Received<a style="text-decoration: none;color:red">*</a></label>
                                <input type="text" name="amount_to_be_received" id="u_amount_to_be_received" value="{{old("amount_to_be_received",$project->amount_to_be_received)}}" placeholder="Amount To Be Received" required class="form-control amount_to_be_received">
                                <span id="u_val_amount_to_be_received"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="" class="form-label fw-bold">Amount Return<a style="text-decoration: none;color:red">*</a></label>
                                <input type="text" name="amount_return" id="amount_return" value="{{old("amount_return",$project->amount_return)}}" placeholder="Amount Return " required class="form-control amount_return">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="" class="form-label fw-bold">Amount Return Date<a style="text-decoration: none;color:red">*</a></label>
                                <input type="date" name="amount_return_date" id="amount_return_date"  value="{{old("amount_return_date",$project->amount_return_date)}}"  required class="form-control amount_return_date">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="" class="form-label fw-bold">Amount Return Comments<a style="text-decoration: none;color:red">*</a></label>
                                <input type="text" name="amount_returns_comment" id="u_amount_returns_comment" value="{{old("amount_returns_comment",$project->amount_returns_comment)}}" placeholder="Amount Return Comments" required class="form-control amount_returns_comment">
                                <span id="u_val_amount_returns_comment"></span>
                            </div>
                            <div class="form-group row ">
                                <div class="col-md-8">
                                    <button type="submit" id="edit" class="btn btn-primary edit ">
                                        {{ __('Update') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach



<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script>
    $(document).ready(function()
    {
        //alert('hi');
        $(document).on("click",".edit", function()
        {
           alert($(this).attr("id"));


            $.ajax                                                   //    alert ($(this).attr("id"));
            ({
                url: "{{ route('project_data') }}",
                type: "GET",                                        // or "GET", "PUT", etc.
                data:
                {
                 'project_no':$(this).attr("id")
                },
                dataType: "json",                                   // the type of data you're expecting in response
                success: function(data)                             // the data argument contains the response from the server
                {
                      console.log(data[0].site_name);
                      $('.project_no').val(data[0].project_no);
                   $('.site_no').val(data[0].site_no);
                    $('.site_name').val(data[0].site_name);
                    $('.project_name').val(data[0].project_name) ;
                    $('.project_type').val(data[0].project_type) ;
                    $('.project_comments').val(data[0].project_comments);

                    $('.manager_name').val(data[0].manager_name);
                    $('.manager_contact_number').val(data[0].manager_contact_number);
                    $('.company_name').val(data[0].company_name);
                    $('.client_contact_name').val(data[0].client_contact_name);
                    $('.client_contact_number').val(data[0].client_contact_number);
                    $('.consultant_name').val(data[0].consultant_name);
                    $('.start_date').val(data[0].start_date);
                    $('.end_date').val(data[0].end_date);
                    $('.actual_project_end_date').val(data[0].actual_project_end_date);
                    $('.status').val(data[0].status);
                    $('.total_price_cost').val(data[0].total_price_cost);
                    $('.advanced_amount').val(data[0].advanced_amount);
                    $('.retention').val(data[0].retention);

                    $('.amount_to_be_received').val(data[0].amount_to_be_received);
                    $('.amount_return').val(data[0].amount_return);
                    $('.amount_return_date').val(data[0].amount_return_date);
                    $('.amount_returns_comment').val(data[0].amount_returns_comment);
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                   // handle error
                }
            });
        });


        $('#edit_button').prop('disabled', false);
    });
</script>


<script>
    $(document).ready(function()
    {
        $('#edit_button').prop('disabled', true);

        $("#u_site_name").focusout(function()
        {
            var name_reg=/^[A-Za-z ]+$/;

            if($(this).val()== '')
            {
                document.getElementById("u_val_site_name").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#edit_button').prop('disabled',true);
            }
            else if(name_reg.test($(this).val()) == true)
            {
                document.getElementById("u_val_site_name").innerHTML="";
                $('#edit_button').prop('disabled',false);
            }
            else if(name_reg.test($(this).val()) == false)
            {
                document.getElementById("u_val_site_name").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('#edit_button').prop('disabled',true);
            }
        });
        $("#u_project_name").focusout(function()
        {
            if($(this).val()== '')
            {
                document.getElementById("u_val_project_name").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#edit_button').prop('disabled',true);
            }
            else if(re.test($(this).val()) != '')
            {
                document.getElementById("u_val_project_name").innerHTML="";
                $('#edit_button').prop('disabled',false);
            }
        });
        $("#u_contact_number").focusout(function()
        {
            var re=/^[6789]\d{9}$/;

            if($(this).val()== '')
            {
                document.getElementById("u_val_contact_number").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#edit_button').prop('disabled',true);
            }
            else if(re.test($(this).val()) == true)
            {
                document.getElementById("u_val_contact_number").innerHTML="";
                $('#edit_button').prop('disabled',false);
            }
            else if(re.test($(this).val()) == false)
            {
                document.getElementById("u_val_contact_number").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('#edit_button').prop('disabled',true);
            }
        });
        $("#u_project_comments").focusout(function()
        {
            if($(this).val()== '')
            {
                document.getElementById("u_val_project_comments").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#edit_button').prop('disabled',true);
            }
            else if(re.test($(this).val()) != '')
            {
                document.getElementById("u_val_project_comments").innerHTML="";
                $('#edit_button').prop('disabled',false);
            }
        });

        $("#u_manager_name").focusout(function()
        {
            var name_reg=/^[A-Za-z ]+$/;

            if($(this).val()== '')
            {
                document.getElementById("u_val_manager_name").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#edit_button').prop('disabled',true);
            }
            else if(name_reg.test($(this).val()) == true)
            {
                document.getElementById("u_val_manager_name").innerHTML="";
                $('#edit_button').prop('disabled',false);
            }
            else if(name_reg.test($(this).val()) == false)
            {
                document.getElementById("u_val_manager_name").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('#edit_button').prop('disabled',true);
            }
        });


        $("#u_manager_contact_number").focusout(function()
        {
            var re=/^[6789]\d{9}$/;

            if($(this).val()== '')
            {
                document.getElementById("u_val_manager_contact_number").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#edit_button').prop('disabled',true);
            }
            else if(re.test($(this).val()) == true)
            {
                document.getElementById("u_val_manager_contact_number").innerHTML="";
                $('#edit_button').prop('disabled',false);
            }
            else if(re.test($(this).val()) == false)
            {
                document.getElementById("u_val_manager_contact_number").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('#edit_button').prop('disabled',true);
            }
        });

        $("#u_company_name").focusout(function()
        {
            var name_reg=/^[A-Za-z ]+$/;

            if($(this).val()== '')
            {
                document.getElementById("u_val_company_name").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#edit_button').prop('disabled',true);
            }
            else if(name_reg.test($(this).val()) == true)
            {
                document.getElementById("u_val_company_name").innerHTML="";
                $('#edit_button').prop('disabled',false);
            }
            else if(name_reg.test($(this).val()) == false)
            {
                document.getElementById("u_val_company_name").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('#edit_button').prop('disabled',true);
            }
        });


        $("#u_client_contact_name").focusout(function()
        {
            var name_reg=/^[A-Za-z ]+$/;

            if($(this).val()== '')
            {
                document.getElementById("u_val_client_contact_name").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#edit_button').prop('disabled',true);
            }
            else if(name_reg.test($(this).val()) == true)
            {
                document.getElementById("u_val_client_contact_name").innerHTML="";
                $('#edit_button').prop('disabled',false);
            }
            else if(name_reg.test($(this).val()) == false)
            {
                document.getElementById("u_val_client_contact_name").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('#edit_button').prop('disabled',true);
            }
        });

        $("#u_client_contact_number").focusout(function()
        {
            var re=/^[6789]\d{9}$/;

            if($(this).val()== '')
            {
                document.getElementById("u_val_client_contact_number").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#edit_button').prop('disabled',true);
            }
            else if(re.test($(this).val()) == true)
            {
                document.getElementById("u_val_client_contact_number").innerHTML="";
                $('#edit_button').prop('disabled',false);
            }
            else if(re.test($(this).val()) == false)
            {
                document.getElementById("u_val_client_contact_number").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('#edit_button').prop('disabled',true);
            }
        });

        $("#u_consultant_name").focusout(function()
        {
            var name_reg=/^[A-Za-z ]+$/;

            if($(this).val()== '')
            {
                document.getElementById("u_val_consultant_name").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#edit_button').prop('disabled',true);
            }
            else if(name_reg.test($(this).val()) == true)
            {
                document.getElementById("u_val_consultant_name").innerHTML="";
                $('#edit_button').prop('disabled',false);
            }
            else if(name_reg.test($(this).val()) == false)
            {
                document.getElementById("u_val_consultant_name").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('#edit_button').prop('disabled',true);
            }
        });

        $("#u_total_price_cost").focusout(function()
        {
            var re=/^[123456789]\d{9}$/;

            if($(this).val()== '')
            {
                document.getElementById("u_val_total_price_cost").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#edit_button').prop('disabled',true);
            }
            else if(re.test($(this).val()) == true)
            {
                document.getElementById("u_val_total_price_cost").innerHTML="";
                $('#edit_button').prop('disabled',false);
            }
            else if(re.test($(this).val()) == false)
            {
                document.getElementById("u_val_total_price_cost").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('#edit_button').prop('disabled',true);
            }
        });

        $("#u_advanced_amount").focusout(function()
        {
            var re=/^[123456789]\d{9}$/;

            if($(this).val()== '')
            {
                document.getElementById("u_val_advanced_amount").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#edit_button').prop('disabled',true);
            }
            else if(re.test($(this).val()) == true)
            {
                document.getElementById("u_val_advanced_amount").innerHTML="";
                $('#edit_button').prop('disabled',false);
            }
            else if(re.test($(this).val()) == false)
            {
                document.getElementById("u_val_advanced_amount").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('#edit_button').prop('disabled',true);
            }
        });


        $("#u_retention").focusout(function()
        {
            var re=/^[123456789]\d{9}$/;

            if($(this).val()== '')
            {
                document.getElementById("u_val_retention").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#edit_button').prop('disabled',true);
            }
            else if(re.test($(this).val()) == true)
            {
                document.getElementById("u_val_retention").innerHTML="";
                $('#edit_button').prop('disabled',false);
            }
            else if(re.test($(this).val()) == false)
            {
                document.getElementById("u_val_retention").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('#edit_button').prop('disabled',true);
            }
        });


        $("#u_amount_to_be_received").focusout(function()
        {
            var re=/^[123456789]\d{9}$/;

            if($(this).val()== '')
            {
                document.getElementById("u_val_amount_to_be_received").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#edit_button').prop('disabled',true);
            }
            else if(re.test($(this).val()) == true)
            {
                document.getElementById("u_val_amount_to_be_received").innerHTML="";
                $('#edit_button').prop('disabled',false);
            }
            else if(re.test($(this).val()) == false)
            {
                document.getElementById("u_val_amount_to_be_received").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('#edit_button').prop('disabled',true);
            }
        });


        $("#u_amount_return").focusout(function()
        {
            var re=/^[123456789][0-9]+$/;

            if($(this).val()== '')
            {
                document.getElementById("u_val_amount_return").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#edit_button').prop('disabled',true);
            }
            else if(re.test($(this).val()) == true)
            {
                document.getElementById("u_val_amount_return").innerHTML="";
                $('#edit_button').prop('disabled',false);
            }
            else if(re.test($(this).val()) == false)
            {
                document.getElementById("u_val_amount_return").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('#edit_button').prop('disabled',true);
            }
        });

        $("#u_amount_returns_comment").focusout(function()
        {
            if($(this).val()== '')
            {
                document.getElementById("u_val_amount_returns_comment").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#edit_button').prop('disabled',true);
            }
            else if(re.test($(this).val()) == true)
            {
                document.getElementById("u_val_amount_returns_comment").innerHTML="";
                $('#edit_button').prop('disabled',false);
            }
        });

    });



</script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<script>
    $("#myModal2").hide();
        dlgc = $("#edit_projectmaster"); //modal
        supc = $("#u_site_name", dlgc); //

        $(".site_name").autocomplete(
         {

         source: function( request, response ) {
           $.ajax( {
           type:"GET",
             url: "{{ route('ProjectGetData') }}",
             dataType: "json",
             data:{
               'site_name':$("#u_site_name").val()
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

         appendTo: "#edit_projectmaster",
         open: function () {
           setTimeout(function () {
            $(this).css('zIndex', 2147483647);

       }, 0);
             autocomplete.zIndex(dlgc.zIndex()+1);
         }

       } );
       //autocomplete = $("#site_name").autocomplete("widget").insertAfter(dlgc.parent());

    $("#u_site_name").on('change',function(){
       var code= $(this).val();

       $.ajax( {
            type:"GET",
              url: "{{ route('ProjectGetData') }}",
              dataType: "json",
              data:{
                'site_name':$(this).val()
              },
              success: function( data ) {

                result = [];
                for(var i in data)
                {
                  $('.site_number').val(data[i]["site_no"]);
                }
                 console.log(result);
              },fail: function(xhr, textStatus, errorThrown){
           alert(errorThrown);
        }
            } );
    });


   </script>




<script>
    $("#myModal2").hide();
        dlgc = $("#edit_projectmaster"); //modal
        supc = $("#u_manager_name", dlgc); //

        $(".manager_name").autocomplete(
         {

         source: function( request, response ) {
           $.ajax( {
           type:"GET",
             url: "{{ route('ProjectManagerData') }}",
             dataType: "json",
             data:{
               'manager_name':$("#u_manager_name").val()
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

         appendTo: "#edit_projectmaster",
         open: function () {
           setTimeout(function () {
            $(this).css('zIndex', 2147483647);

       }, 0);
             autocomplete.zIndex(dlgc.zIndex()+1);
         }

       } );
       autocomplete = $("#u_manager_name").autocomplete("widget").insertAfter(dlgc.parent());

     $("#u_manager_name").on('change',function(){
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
                   $('#u_manager_contact_number').val(data[i]["phone"]);
                 }
                  console.log(result);
               },fail: function(xhr, textStatus, errorThrown){
            alert(errorThrown);
         }
             } );
     });



    $("#project_type").focusout(function(){
                if($(this).val()== ''){
                document.getElementById("val_project_type").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#edit_button').prop('disabled',true);
                }
                else  if($(this).val() != ''){
                    document.getElementById("val_project_type").innerHTML="";
                    $('#edit_button').prop('disabled',false);
                }
          });
          $("#status").focusout(function(){
                if($(this).val()== ''){
                document.getElementById("val_status").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#edit_button').prop('disabled',true);
                }
                else  if($(this).val() != ''){
                    document.getElementById("val_status").innerHTML="";
                    $('#edit_button').prop('disabled',false);
                }
          });

   </script>

