<!-- STYLE INCLUDED IN LAYOUT PAGE -->
@extends('layouts.app',[
    'activeName' => 'Client Master'
])
@section('title', 'Client Master')

@section('content_header')
@stop

@section('content')
<!-- DATA table -->
     <div class="row">
                <div class="container-fluid">
                    <div class="card shadow">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h4 class="font-weight-bold text-dark py">CLIENT MASTER</h4>
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
                                            <!-- <th>Client No</th> -->
                                            <th>Client Code</th>
                                            <th>Client Name</th>
                                            <th>Company Name</th>
                                            <th>Contact Number</th>
                                            <th>Address</th>
                                            <th>Website</th>
                                            <th data-orderable="false" class="action notexport">Show</th>
                                            <th data-orderable="false" class="action notexport">Edit</th>
                                            <th data-orderable="false" class="action notexport">Delete</th>
                                            <div id="blur-background" class="blur-background"></div>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($clients as $key => $client)
                                            <tr class="text-center">
                                                <!-- <td>{{$client->client_no}}</td> -->
                                                <td>{{$client->client_code}}</td>
                                                <td>{{$client->name}}</td>
                                                <td>{{$client->company_name}}</td>
                                                <td>{{$client->contact_number}}</td>
                                                <td>{{$client->address}}</td>
                                                <td>{{$client->website}}</td>
                                                <td>
                                                    <a  onclick="handleShowAndEdit('{{$client->client_no}}','show')"
                                                        class="btn btn-primary btn-circle btn-sm"   >
                                                        <i class="fas fa-flag"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a onclick="handleShowAndEdit('{{$client->client_no}}','edit')"
                                                        class="btn btn-info btn-circle btn-sm mx-2" >
                                                        <i class="fas fa-check"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <button  type="submit" class="btn btn-sm btn-danger" onclick="handleDelete('{{$client->client_no}}')">
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
                                <a class="btn  btn-sm" onclick="handleClose()" style="float:right;padding: 10px 10px;"><i class="fas fa-close"></i></a>
                                <h4  id='heading_name' style='color:white' align="center"><b>Update Client </b></h4>
                            </div>
                        </div>

                        <form  class="form-row"  enctype="multipart/form-data" style="display:block" id="form" onsubmit="handleSubmit()">
                            <input type="hidden" id="method" value="ADD"/>
                            <input type="hidden" id="client_no" name="client_no" value=""/><br>
                            {!! csrf_field() !!}
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="name" class="form-label fw-bold">Client Name<a style="text-decoration: none;color:red">*</a></label>
                                    <input type="text" id="name"  name="name" value="{{ old('name') }}" placeholder="Client Name" class="form-control" autocomplete="off">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="company_name" class="form-label fw-bold">Company Name<a style="text-decoration: none;color:red">*</a></label>
                                    <input type="text" id="company_name" name="company_name" value="{{ old('company_name') }}" placeholder="Company Name" class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="row">
                            <div class="form-group col-md-6">
                                    <label for="contact_number" class="form-label fw-bold">Contact Number<a style="text-decoration: none;color:red">*</a></label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">{{+971}}</span>
                                        <!-- </div> -->
                                        <input type="number" id="contact_number" name="contact_number" value="{{ old('contact_number') }}" placeholder="Contact Number" class="form-control" autocomplete="off">
                                    </div>
                                </div>                                <div class="form-group col-md-6">
                                    <label for="address" class="form-label fw-bold">Address<a style="text-decoration: none;color:red">*</a></label>
                                    <input type="text" id="address" name="address" value="{{ old('address') }}" placeholder="Address" class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="website" class="form-label fw-bold">Website</label>
                                    <input type="url" id="website" name="website" value="{{ old('website') }}" placeholder="Website" class="form-control" autocomplete="off">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="client_code" id="code_lable"class="form-label fw-bold">Client Code</label>
                                    <input type="text" id="client_code" name="client_code" readonly value="{{ old('client_code') }}" placeholder="Client Code" class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <button type="submit" id="submit"  class="btn btn-primary float-end ">ADD</button>
                            </div>
                        </form>
                        <!-- SHOW DIALOG -->
                        <div class="card" id="show" style="display:none">
                            <div class="card-body" style="background-color:white;width:100%;height:20%;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Clients Name</label>
                                        <p id="show_name"></p>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Company Name</label>
                                        <p id="show_company_name"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Contact Number</label>
                                        <p id="show_contact_number"></p>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Address</label>
                                        <p id="show_address"></p>
                                    </div>
                                </div>
                                <div class="row">
                                        <div class="col-md-6">
                                          <label>Client Code</label>
                                          <p id="show_client_code"></p>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </dialog>

<script type="text/javascript">
    $.ajaxSetup
    ({
        headers:
        {
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
        function handleDialog()
        {
            document.getElementById("myDialog").open = true;
            window.scrollTo(0, 0);
            $('#method').val("ADD");
            $('#submit').text("ADD");
            $('#heading_name').text("Add Client Details").css('font-weight', 'bold');
            $('#client_code').hide();
            $('#code_lable').hide();
            $('#show').css('display','none');
            $('#form').css('display','block');
            $('#blur-background').css('display','block');

        }
// DELETE FUNCTION
        function handleDelete(id)
        {
            let url = '{{route('clientApi.delete',":id")}}';
            url= url.replace(':id',id);
            if (confirm("Are you sure want to delete this Client Details?"))
            {
                $.ajax
                ({
                    url: url,
                    type: 'DELETE',
                    success: function (message)
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
             $('.error-msg').removeClass('error-msg');
             $('.has-error').removeClass('has-error');       
             // Hide any error messages
             $('error').html('');
             // Hide the dialog background
             $('#blur-background').css('display','none');
        }
// DIALOG SUBMIT FOR ADD AND EDIT
        function handleSubmit()
        {
            var hiddenErrorElements = $('.error-msg:not(:hidden)').length;
            // alert(hiddenErrorElements);
            if(hiddenErrorElements === 0)
            {
                let form_data = new FormData(document.getElementById('form'));
                let method = $('#method').val();
                let url;
                let type;
                if(method == 'ADD')
                {
                    //
                    url = '{{route('clientApi.store')}}';
                    type  = 'POST';

                }
                else
                {
                    let id = $('#client_no').val();
                    url = '{{route('clientApi.update',":id")}}';
                    url= url.replace(':id',id);
                    type = 'POST';
                }
                $.ajax
                ({
                    url: url,
                    type: type,
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (message)
                    {
                        alert(message);
                        window.location.reload();
                    },error: function (message)
                    {
                        var data = message.responseJSON;
                    }
                })
            }
            else
            {
                event.preventDefault();
            }
        }
//DATA SHOW FOR EDIT AND SHOW
var currentClientName;
var current_contact_number;
        function handleShowAndEdit(id,action)
        {
            
            let url = '{{route('clientApi.show',":id")}}';
            url = url.replace(':id',id);
            let type= "GET"
            $.ajax
            ({
                url: url,
                type: type,
                contentType: false,
                cache: false,
                processData: false,
                success: function (message)
                {
                    console.log(message);
                    if(action == 'edit')
                    {
                        $('#heading_name').text("Update Client Details").css('font-weight', 'bold');
                        $('#show').css('display','none');
                        $('#form').css('display','block');
                        $('#blur-background').css('display','block');
                        for (const [key, value] of Object.entries(message))
                        {
                            console.log(`${key}: ${value}`);
                            $(`#${key}`).val(value);
                        }
                        $('#method').val('UPDATE');
                        $('#submit').text('UPDATE');
                        var currentClientName = message.name.toLowerCase().replace(/ /g, '');

                        current_contact_number=message.contact_number;
                    }
                    else
                    {

                        for (const [key, value] of Object.entries(message))
                        {
                            $(`#show_${key}`).text(value);
                        }
                        $('#heading_name').text("View Client Details").css('font-weight', 'bold');
                        $('#show').css('display','block');
                        $('#form').css('display','none');
                        $('#blur-background').css('display','block');
                    }
                    document.getElementById("myDialog").open = true;
                    window.scrollTo(0, 0);

                },
            })
        }

        // inline validation
        var clientNames = @json($clientNames);
       var contact_number=@json($contact_number);

$.validator.addMethod("uniqueContactNumber", function(value, element) {
  if ($("#method").val() !== "ADD" && value === current_contact_number) {
    return true;
  }
  return !contact_number.includes(value);
});

$.validator.addMethod("alphanumeric", function(value, element) {
  return this.optional(element) || /^[A-Za-z ]+$/i.test(value);
});
  // Initialize form validation
  var formValidationConfig = {
    rules: {
        name: {
    required: true,
     alphanumeric:true,

  },
     company_name: "required",
      contact_number: {
        required: true,
        digits: true,
        minlength: 9,
        maxlength: 9,
        uniqueContactNumber:true
      },
      address: "required",
      website: {
        url: true
      }
    },
    messages: {
        name: {
    required: "Please enter the client name",
     alphanumeric: "Client name allows only alphabets",
      },
       company_name: "Please enter the company name",
      contact_number: {
        required: "Please enter the contact number",
        digits: "Please enter only numbers",
        minlength: "Contact number must be exactly 9 numbers",
        maxlength: "Contact number must be exactly 9 numbers",
        uniqueContactNumber:"This Contact Number is already exist.Please enter new number"
      },
      address: "Please enter the address",
      website: "Please enter a valid URL"
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