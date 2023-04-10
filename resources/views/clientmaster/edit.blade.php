@foreach ($clients as $client)
<div class="modal fade" id="edit_clientmaster">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title" align="center"><b>Edit client</b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form method="POST" id="edit-form" class="form-row" action="{{ route('clientmaster.update',$client->client_no) }}"enctype="multipar/form-data">
                            @csrf
                            @method('PUT')
                             <div class="form-group col-md-6">
                                <label for="id" class="form-label fw-bold">Client NO</label>
                                <input type="number" name="client_no" value="{{old("client_no",$client->client_no)}}" id="uid"  required class="form-control lname" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="name" class="form-label fw-bold">Name</label>
                                <input type="text" name="name" value="{{old("name",$client->name)}}" id="cname" placeholder="Name" required class="form-control lname">
                                <span class='text-danger m-2' id="cl1"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="company_name" class="form-label fw-bold">Company Name</label>
                                <input type="text" name="company_name" value="{{old("company_name",$client->company_name)}}" id="companyname" required  placeholder="Company Name" class="form-control lcompany">
                                <span class='text-danger m-2' id="cl2"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="contact_number" class="form-label fw-bold">Contact Number</label>
                                <input type="text" name="contact_number" maxlength="10" pattern="[789][0-9]{9}" value="{{old("contact_number",$client->contact_number)}}" id="contactnumber" required placeholder="Contact Number" class="form-control lcontact">
                                <span class='text-danger m-2' id="cl3"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="address" class="form-label fw-bold">Address</label>
                                <input type="text" name="address" value="{{old("address",$client->address)}}"placeholder="Address" required id="caddress" class="form-control laddress">
                                <span class='text-danger m-2' id="cl4"></span>
                            </div>
                                <div class="col-md-12">
                                    <button type="submit" id="edit_button" class="btn btn-primary edit ">
                                        {{ __('Update') }}
                                    </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endforeach
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script>
    $(document).ready(function()
    {

        $(document).on("click",".edit", function()
        {
            $.ajax                                                   //    alert ($(this).attr("id"));
            ({
                url: "{{ route('client_data') }}",
                type: "GET",                                        // or "GET", "PUT", etc.
                data:
                {
                 'id':$(this).attr("id")
                },
                dataType: "json",                                   // the type of data you're expecting in response
                success: function(data)                             // the data argument contains the response from the server
                {
                    console.log(data[0].client_no);
                    console.log(data[0].name);
                    console.log(data[0].company_name);
                    console.log(data[0].contact_number);
                    console.log(data[0].address);

                   $('#id').val("CM0"+data[0].client_no);
                   $('#uid').val(data[0].client_no);
                    $('#cname').val(data[0].name);
                    $('#companyname').val(data[0].company_name) ;
                    $('#contactname').val(data[0].contact_number) ;
                    $('#caddress').val(data[0].address);
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                   // handle error
                }
            });
        });


        $('#edit_button').prop('disabled', true);
       $("#cname").focusout(function()
        {

            var name_reg=/^[a-zA-Z ]+$/;
            if($(this).val()== '')
            {
                 document.getElementById("cl1").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#edit_button').prop('disabled',true);
            }
            else if(name_reg.test($(this).val()) == true)
            {
                document.getElementById("cl1").innerHTML="";
                $('#edit_button').prop('disabled',false);
            }
            else if(name_reg.test($(this).val()) == false)
            {
                document.getElementById("cl1").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('#edit_button').prop('disabled',true);
            }

        });
        $("#companyname").focusout(function()
        {
            var re=/^[a-zA-Z ]+$/;
            if($(this).val()== '')
            {
                document.getElementById("cl2").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#edit_button').prop('disabled',true);
            }
            else if(re.test($(this).val()) == true)
            {
                document.getElementById("cl2").innerHTML="";
                $('#edit_button').prop('disabled',false);
            }
            else if(re.test($(this).val())==false)
            {
                document.getElementById("cl2").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('#edit_button').prop('disabled',true);
            }
        });
        $("#contactnumber").focusout(function()
        {
            var reg=/^[6789]\d{9}$/;
            if($(this).val()== '')
            {
                document.getElementById("cl3").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                 $('#edit_button').prop('disabled',true);
            }
            else if(reg.test($(this).val()) == true)
            {
                document.getElementById("cl3").innerHTML="";
                $('#edit_button').prop('disabled',false);
            }
            else if(reg.test($(this).val())==false)
            {
                document.getElementById("cl3").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('#edit_button').prop('disabled',true);
            }

        });

        $("#caddress").focusout(function()
        {
            if($(this).val()== '')
            {
                document.getElementById("cl4").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#edit_button').prop('disabled',true);
            }
            else if($(this).val() != '')
            {
                document.getElementById("cl4").innerHTML="";
                $('#edit_button').prop('disabled',false);
            }

        });

    });
</script>
