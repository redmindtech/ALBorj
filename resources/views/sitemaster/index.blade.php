<!-- STYLE INCLUDED IN LAYOUT PAGE -->
@extends('layouts.app',[
    'activeName' => 'Site Master'
])
@section('title', 'Site Master')

@section('content_header')
@stop

@section('content')
<!-- DATA table -->
     <div class="row">
                <div class="container-fluid">
                    <div class="card shadow">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h4 class="font-weight-bold text-dark py">SITE MASTER</h4>
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
                                            <th>Site Code</th>
                                            <th>Site Name</th>                                            
                                            <th>Site location</th>                                          
                                            <th>Site Manager</th>  
                                            <th>Status</th>  
                                            <th>Site Address</th>                                            
                                            <th data-orderable="false" class="action notexport">Show</th>
                                            <th data-orderable="false" class="action notexport">Edit</th>
                                            <th data-orderable="false" clclass="action notexport">Delete</th>
                                            <div id="blur-background" class="blur-background"></div>
                                        </tr>
                                    </thead>
                                  
                                    <tbody>
                                        @foreach ($sitemasters as $key => $sitemaster)
                                            <tr class="text-center">
                                                <td>{{$sitemaster->site_code}}</td>
                                                <td>{{$sitemaster->site_name}}</td>                                        
                                                <td>{{$sitemaster->site_location}}</td>
                                                <td>{{$sitemaster->firstname}}</td>
                                                <td>{{$sitemaster->site_status}}</td>
                                                <td>{{$sitemaster->site_address}}</td>
                                                <td>
                                                    <a  onclick="handleShowAndEdit('{{$sitemaster->site_no}}','show')"
                                                        class="btn btn-primary btn-circle btn-sm"   >
                                                        <i class="fas fa-flag"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a onclick="handleShowAndEdit('{{$sitemaster->site_no}}','edit')"
                                                        class="btn btn-info btn-circle btn-sm mx-2" >
                                                        <i class="fas fa-check"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <button  type="submit" class="btn btn-sm btn-danger" onclick="handleDelete('{{$sitemaster->site_no}}')">
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
                     <h4  id='heading_name' style='color:white' align="center"><b>Update Site Details </b></h4>
                </div>
            </div>
            

 
            <form  class="form-row"  enctype="multipart/form-data" style="display:block" id="form" onsubmit="handleSubmit()">
                <input type="hidden" id="method" value="ADD"/>
                <input type="hidden" id="site_no" name="site_no" value=""/><br>
               
{!! csrf_field() !!}
<div class="row">
  <div class="form-group col-md-6">
        <label for="site_name" class="form-label fw-bold">Site Name<a style="text-decoration: none;color:red">*</a></label>
        <input type="text" id="site_name"  name="site_name" value="{{ old('site_name') }}" placeholder="Site Name" class="form-control" autocomplete="off">
       
    </div>

    <div class="form-group col-md-6">
        <label for="site_location" class="form-label fw-bold">Location<a style="text-decoration: none;color:red">*</a></label>
        <select id="site_location" name="site_location" class="form-control form-select" autocomplete="off">
            <option value="">Select Option</option>
                @foreach($site_location as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
        
    </div>
</div>
<div class="row">
    <div class="form-group col-md-6">
        <label for="site_building" class="form-label fw-bold">Site Building<a style="text-decoration: none;color:red">*</a></label>
        <input type="text" id="site_building" name="site_building" value="{{ old('site_building') }}" placeholder="Site Building" class="form-control" autocomplete="off">
       
    </div>
    <div class="form-group col-md-6">
        <label for="site_floor" class="form-label fw-bold">Site Floor<a style="text-decoration: none;color:red">*</a></label>
        <input type="text" id="site_floor" name="site_floor" value="{{ old('site_floor') }}" placeholder="Site Floor" class="form-control" autocomplete="off">
       
    </div>
</div>
<div class="row">
    <div class="form-group col-md-6">
        <label for="room_number" class="form-label fw-bold">Room Number<a style="text-decoration: none;color:red">*</a></label>
        <input type="text" id="room_number" name="room_number" value="{{ old('room_number') }}"  placeholder="Room Number" class="form-control" autocomplete="off">
        
    </div>
    <div class="form-group col-md-6">
        <label for="site_address" class="form-label fw-bold">Site Address<a style="text-decoration: none;color:red">*</a></label>
        <input type="text" id="site_address" name="site_address" value="{{ old('site_address') }}" placeholder="Site Address" class="form-control" autocomplete="off">
       
    </div>
</div>
<div class="row">

    <div class="form-group col-md-6">
        <label for="site_manager" class="form-label fw-bold">Site Manager<a style="text-decoration: none;color:red">*</a></label>
        <input type="text" id="firstname" name="firstname" value="{{ old('firstname') }}" placeholder="Site Manager" class="form-control" autocomplete="off">
        <input type="text" id="site_manager" hidden  name="site_manager" value="{{ old('site_manager') }}"  class="form-control" autocomplete="off">
      
    </div> 
    <div class="form-group col-md-6">
        
        <label for="site_status" class="form-label fw-bold">Site Status<a style="text-decoration: none;color:red">*</a></label>
        <select id="site_status" name="site_status" class="form-control form-select" autocomplete="off">
        <option value="">Select Option</option>
            @foreach($site_status as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
        
    </div>
  
</div>
<div class="row">
<div class="form-group col-md-12">
        <label for="description" class="form-label fw-bold">Description</label>
        <textarea id="description" name="description" value="{{ old('description') }}" placeholder="Description" class="form-control" autocomplete="off"></textarea>
       
    </div>
    <div class="form-group col-md-">
        <label for="site_code" id="code_lable" class="form-label fw-bold">Site Code</label>
        <input type="text" id="site_code" name="site_code" value="{{ old('site_code') }}" readonly placeholder="Site Code" class="form-control" autocomplete="off">
        
    </div>
</div>
    <div class="row">  
    <div class="form-group col-md-12">
        <button type="submit" id="submit"  class="btn btn-primary float-end ">ADD</button>
    </div>
</div>
</form>
<!-- SHOW DIALOG -->
<div class="card" id="show" style="display:none">
    <div class="card-body" style="background-color:white;">
        <table class="table">
            <tbody>
                <tr>
                    <td><label>Site Name</label></td>
                    <td><p id="show_site_name"></p></td>
                
                    <td><label>Location</label></td>
                    <td><p id="show_site_location"></p></td>
                </tr>
                <tr>
                    <td><label>Site Building</label></td>
                    <td><p id="show_site_building"></p></td>
                
                    <td><label>Site Floor</label></td>
                    <td><p id="show_site_floor"></p></td>
                </tr>
                <tr>
                    <td><label>Room Number</label></td>
                    <td><p id="show_room_number"></p></td>
                
                    <td><label>Site Address</label></td>
                    <td><p id="show_site_address"></p></td>
                </tr>
                <tr>
                    <td><label>Site Status</label></td>
                    <td><p id="show_site_status"></p></td>
                
                    <td><label>Site Manager</label></td>
                    <td><p id="show_firstname"></p></td>
                </tr>
                <tr>
                    <td><label>Description</label></td>
                    <td><p id="show_description"></p></td>
                
                    <td><label>Site Code</label></td>
                    <td><p id="show_site_code"></p></td>
                </tr>
            </tbody>
        </table>
        <br>
        <button type="button" id="print" class="btn btn-primary float-end">Print</button>
        
    </div>
</div>
        </dialog>
   
<script type="text/javascript">
    $.ajaxSetup(
    {
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

    <!-- ADD DIALOG  -->
<script type="text/javascript">

        function handleDialog()
        {
             document.getElementById("myDialog").open = true;
             window.scrollTo(0, 0);
             $('#method').val("ADD");
             $('#submit').text("ADD");
             $('#heading_name').text("Add Site Details").css('font-weight', 'bold');
             $('#site_code').hide();
             $('#code_lable').hide();
             $('#show').css('display','none');
             $('#form').css('display','block');
             $('#blur-background').css('display','block');

        }
    // DELETE FUNCTION
        function handleDelete(id)
        {
            let url = '{{route('siteApi.delete',":site_no")}}';
            url= url.replace(':site_no',id);
            if (confirm("Are you sure want to delete this Site Details?")) 
            {
                $.ajax(
                {
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
            event.preventDefault();
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
                    url = '{{route('siteApi.store')}}';
                    type  = 'POST';
                    
                } 
                else 
                {
                    let id = $('#site_no').val();
                    url = '{{route('siteApi.update',":site_no")}}';
                    url= url.replace(':site_no',id);
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
    var current_SiteName; 
        function handleShowAndEdit(id,action)
        {
            let url = '{{route('siteApi.show',":site_no")}}';
            url = url.replace(':site_no',id);
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
                        $('#heading_name').text("Update Site Details").css('font-weight', 'bold');
                        $('#show').css('display','none');
                        $('#form').css('display','block');
                        $('#blur-background').css('display','block');
                        for (const [key, value] of Object.entries(message[0])) 
                        {
                            $(`#${key}`).val(value);
                            console.log( $(`#${key}`).val(value));
                        }
                        $('#method').val('UPDATE');
                        $('#submit').text('UPDATE');
                        current_SiteName = message[0].site_name.toLowerCase().replace(/ /g, '');
                    } 
                    else 
                    {
                        for (const [key, value] of Object.entries(message[0])) 
                        {
                            $(`#show_${key}`).text(value);
                        }
                            $('#heading_name').text("Site Details").css('font-weight', 'bold');
                            $('#show').css('display','block');
                            $('#form').css('display','none');
                            $('#blur-background').css('display','block');

                    }
                    document.getElementById("myDialog").open = true;
                    window.scrollTo(0, 0);          
                },
            })
        }
  
     // auto complete from employeemaster
     jQuery($ => {
    $(document).on('focus', 'input',"#firstname", function() {
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
                $('#site_manager').val(null);
                var selectedFirstName = ui.item.value;
                updateSiteManagerValue(selectedFirstName);
            }
        });
    });

    // EMPLOYEE CODE
    $("#firstname").on('input', function() {
        $('#site_manager').val(null);
        var selectedFirstName = $(this).val();
        updateSiteManagerValue(selectedFirstName);
    });

    function updateSiteManagerValue(firstName) {
        $.ajax({
            type: "GET",
            url: "{{ route('getemployeedata') }}",
            dataType: "json",
            data: {
                'firstname': firstName
            },
            success: function(data) {
                console.log(data);
                for (var i in data) {
                    $('#site_manager').val(data[i]["id"]);
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

        // validation
        var Site_Names_check = @json($siteNames);
            var employee_name=@json($employee_name);
         
            $.validator.addMethod("uniqueSiteName", function(value, element) {
         
                var lowercaseValue = value.toLowerCase().replace(/\s/g, '');
                 
  if ($("#method").val() != "ADD" && lowercaseValue == current_SiteName) {
    return true;
  }
  
    var lowercaseValu = value.toLowerCase().replace(/\s/g, '');
  return !Site_Names_check.includes(lowercaseValu);
  
});

$.validator.addMethod("employeeNameCheck", function(value, element) {
  return employee_name.includes(value);
});



  // Initialize form validation
  var formValidationConfig = {
    rules: {
        site_name: {
                required: true,
                uniqueSiteName:true
            },
            site_location: "required",

            site_building:"required",

            site_floor: "required",

            room_number:"required",

            site_address:"required",

            site_status:"required",

            firstname:{
                required:true,

                employeeNameCheck:true,
                }
            },
    messages: {
        site_name: {

            required:"The site name is required ",

            uniqueSiteName:"This site name is already exists. Please enter a different site name."

            },
            site_location: "Please select location",
            site_building:"The site building is required",
            site_floor: "The site floor is required",
            room_number: "The room number is required",
            site_address:"The site address is required",
            site_status:"The site address is required",
            firstname:
            {
                required:"The site manager is required",
                employeeNameCheck:"Please enter valid site manager"
            
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

  $("#form").validate(formValidationConfig);
</script>
@stop