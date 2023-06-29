<!-- STYLE INCLUDED IN LAYOUT PAGE -->
@extends('layouts.app',[
    'activeName' => 'Supplier Master'
])
@section('title', 'Supplier Master')

@section('content_header')
@stop

@section('content')


<!-- DATA table -->
     <div class="row">
                <div class="container-fluid">
                    <div class="card shadow">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h4 class="font-weight-bold text-dark py">SUPPLIER MASTER</h4>
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
                                            <th>Supplier Code</th>
                                            <th>Supplier Name</th>
                                            <th>Company Name</th>                                          
                                            <th>Contact No</th>
                                            <th>Address</th>
                                            <th>Website</th>
                                            <th>Email Id</th>
                                            <th>Date</th>
                                            <th data-orderable="false" class="action notexport">Show</th>
                                            <th data-orderable="false" class="action notexport">Edit</th>
                                            <th data-orderable="false" class="action notexport">Delete</th>
                                            <div id="blur-background" class="blur-background"></div>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($suppliers as $key => $supplier)
                                            <tr class="text-center">
                                                <td>{{$supplier->code}}</td>
                                                <td>{{$supplier->name}}</td>
                                                <td>{{$supplier->company_name}}</td>
                                                <td>{{$supplier->contact_number}}</td>
                                                <td>{{$supplier->address}}</td>
                                                <td>{{$supplier->website}}</td>
                                                <td>{{$supplier->mail_id}}</td>
                                                <td>{{ date('d-m-Y', strtotime($supplier->created_at)) }}</td>
                                                <td>
                                                    <a  onclick="handleShowAndEdit('{{$supplier->supplier_no}}','show')"
                                                        class="btn btn-primary btn-circle btn-sm"   >
                                                        <i class="fas fa-flag"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a onclick="handleShowAndEdit('{{$supplier->supplier_no}}','edit')"
                                                        class="btn btn-info btn-circle btn-sm mx-2" >
                                                        <i class="fas fa-check"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <button  type="submit" class="btn btn-sm btn-danger" onclick="handleDelete('{{$supplier->supplier_no}}')">
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
               
                     <a class="btn  btn-sm" id="closeButton" onclick="handleClose()" style="float:right;padding: 10px 10px;"><i class="fas fa-close"></i></a>
                     <h4  id='heading_name' style='color:white' align="center"><b>Update Supplier </b></h4>
                </div>
            </div>
            

 
            <form  class="form-row"  enctype="multipart/form-data" style="display:block" id="form" onsubmit="handleSubmit()">
                <input type="hidden" id="method" value="ADD"/>
                <input type="hidden" id="supplier_no" name="supplier_no" value=""/><br>
               
{!! csrf_field() !!}
<div class="row">
  <div class="form-group col-md-6">
        <label for="name" class="form-label fw-bold">Supplier Name<a style="text-decoration: none;color:red">*</a></label>
        <input type="text" id="name"  name="name" value="{{ old('name') }}" placeholder="Supplier Name" class="form-control" autocomplete="off">
        
    </div>

    <div class="form-group col-md-6">
        <label for="company_name" class="form-label fw-bold">Company Name<a style="text-decoration: none;color:red">*</a></label>
        <input type="text" id="company_name" name="company_name" value="{{ old('company_name') }}" placeholder="Company Name" class="form-control" autocomplete="off">
        
    </div>
</div>
<div class="row">
    <div class="form-group col-md-6">
        <label for="website" class="form-label fw-bold">Website</label>
        <input type="website" id="website" name="website" value="{{ old('website') }}" placeholder="Website" class="form-control" autocomplete="off">
        
    </div>
    <div class="form-group col-md-6">
        <label for="address" class="form-label fw-bold">Address<a style="text-decoration: none;color:red">*</a></label>
        <input type="text" id="address" name="address" value="{{ old('address') }}" placeholder="Address" class="form-control" autocomplete="off">
        
    </div>
</div>
<div class="row">
<div class="form-group col-md-6">
        <label for="contact_number" class="form-label fw-bold">Contact Number<a style="text-decoration: none;color:red">*</a></label>
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">{{+971}}</span>
         
            <input type="text" id="contact_number" name="contact_number" value="{{ old('contact_number') }}" maxlength="10" placeholder="Contact Number" class="form-control" autocomplete="off">
        </div>
        
    </div>
    <div class="form-group col-md-6">
        <label for="mail_id" class="form-label fw-bold">Email Id<a style="text-decoration: none;color:red">*</a></label>
        <input type="text" id="mail_id" name="mail_id" value="{{ old('mail_id') }}" placeholder="Email Id" class="form-control" autocomplete="off">
        
    </div>
</div>
<div class="row">

<div class="form-group col-md-6">
    <label for="trn_number" class="form-label fw-bold">TRN Number</label>
    <input type="text" id="trn_number" name="trn_number" value="{{ old('trn_number') }}" placeholder="TRN Number" class="form-control " autocomplete="off" >
</div>  
<div class="form-group col-md-6">
        <label for="code" id="code_lable"class="form-label fw-bold">Supplier Code<a style="text-decoration: none;color:red">*</a></label>
        <input type="text" id="code" name="code" readonly value="{{ old('code') }}" placeholder="Supplier Code" class="form-control" autocomplete="off">
        
    </div>
</div>
    <div class="form-group col-md-12">
        <button type="submit" id="submit"  class="btn btn-primary float-end ">ADD</button>
    </div>
</form>
<!-- SHOW DIALOG -->


<div class="card" id="show" style="display:none">
    <div class="card-body" style="background-color:white;width:100%;height:20%;">
        <table class="table">
            <tbody>
                <tr>
                    <td><label>Supplier Name</label></td>
                    <td><p id="show_name"></p></td>
                
                    <td><label>Company Name</label></td>
                    <td><p id="show_company_name"></p></td>
              
                    <td><label>Supplier Code</label></td>
                    <td><p id="show_code"></p></td>
                </tr>
                <tr>
                    <td><label>Address</label></td>
                    <td><p id="show_address"></p></td>
             
                    <td><label>Contact Number</label></td>
                    <td><p id="show_contact_number"></p></td>
                
                    <td><label>Email Id</label></td>
                    <td><p id="show_mail_id"></p></td>
                </tr>
                <tr>
                    <td><label>TRN Number</label></td>
                    <td><p id="show_trn_number"></p></td>
                </tr>
            </tbody>
        </table>
        <br>
        <button type="button" id="print" class="btn btn-primary float-end">Print</button>
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
        $(function () 
        {
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
            $('#heading_name').text("Add Supplier Details").css('font-weight', 'bold');
            $('#code').hide();
            $('#code_lable').hide();
            $('#show').css('display','none');
            $('#form').css('display','block');
            $('#blur-background').css('display','block');

        }
    // DELETE FUNCTION
        function handleDelete(id)
        {
            let url = '{{route('supplierApi.delete',":id")}}';
            url= url.replace(':id',id);
            if (confirm("Are you sure want to delete this Supplier Details?"))
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
            // Hide any error messages
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
            event.preventDefault();
            var hiddenErrorElements = $('.error-msg:not(:hidden)').length;
           
            if(hiddenErrorElements === 0)
            {
                let form_data = new FormData(document.getElementById('form'));
                let method = $('#method').val();
                let url;
                let type;
                if(method == 'ADD')
                {
                    url = '{{route('supplierApi.store')}}';
                    type  = 'POST';
                } 
                else 
                {
                    let id = $('#supplier_no').val();
                    url = '{{route('supplierApi.update',":id")}}';
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
                        },
                        error: function (message) 
                        {
                            var data = message.responseJSON;
                        }
                    })
                }
            }
            

        //DATA SHOW FOR EDIT AND SHOW 
        var current_contact_number;
        function handleShowAndEdit(id,action)
        {
            let url = '{{route('supplierApi.show',":id")}}';
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
                    if(action == 'edit')
                    {
                        $('#heading_name').text("Update Supplier Details").css('font-weight', 'bold');
                        $('#show').css('display','none');
                        $('#form').css('display','block');
                        for (const [key, value] of Object.entries(message)) 
                        {
                             $(`#${key}`).val(value);
                        }
                        $('#method').val('UPDATE');
                        $('#submit').text('UPDATE');
                        $('#blur-background').css('display','block');
                        current_contact_number=message.contact_number;
                    } 
                    else 
                    {
                        for (const [key, value] of Object.entries(message))
                        {
                            $(`#show_${key}`).text(value);
                        }
                        $('#heading_name').text("Supplier Details").css('font-weight', 'bold');
                        $('#show').css('display','block');
                        $('#form').css('display','none');
                        $('#blur-background').css('display','block');

                    }
                    document.getElementById("myDialog").open = true;
                    window.scrollTo(0, 0);
                    
                },
            })
        }
        
    document.getElementById("print").addEventListener("click", function() {
        $('#heading_name').css('color', 'black').css('font-weight', 'bold');
        window.print();
        $('#heading_name').css('color', 'white').css('font-weight', 'bold');
    });
      // validation

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

$.validator.addMethod("email", function(value, element) {
  return this.optional(element) || /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/i.test(value);
});
$.validator.addMethod("alphanumeric_website", function(value, element) {
  return this.optional(element) || /((?:https?|http?\:\/\/|www?\.)(?:[-a-z0-9]+\.)*[-a-z0-9]+.*)/i.test(value);
});
$.validator.addMethod("alphanumeric_trn", function(value, element) {
                   
                    return this.optional(element) || /^[A-Za-z0-9 ]+$/i.test(value);
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
        alphanumeric_website: true
      },
      mail_id:
      {
        required:true,
        email:true,

      },
      trn_number: {
        alphanumeric_trn: true

     },

    },
    messages: {
        name: {
    required: "Please enter the supplier name",
     alphanumeric: "Supplier name allows only alphabets",
     
  },
       company_name: "Please enter the company name",
      contact_number: {
        required: "Please enter the contact number",
        digits: "Please enter only numbers",
        minlength: "Contact number must be exactly 9 numbers",
        maxlength: "Contact number must be exactly 9 numbers",
        uniqueContactNumber:"This Contact Number is already exists.Please enter new number"
      },
      address: "Please enter the address",
      website:{ 
        alphanumeric_website:"Please enter a valid website",
      },
      mail_id:
      {
        required:"Please enter the email id",
        email:"Please enter a valid email id",

      },
      trn_number: {
            alphanumeric_trn: "The TRN number does not allow special characters"
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
        
      },
     
  };
  $("#form").validate(formValidationConfig);
</script>
@stop