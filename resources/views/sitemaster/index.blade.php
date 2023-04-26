<!-- STYLE INCLUDED IN LAYOUT PAGE -->
@extends('layouts.app',[
    'activeName' => 'supplier'
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
                                            <!-- <th>S.No</th> -->
                                            <th>Site Code</th>
                                            <th>Site Name</th>                                            
                                            <th>Site location</th>
                                            <th>Site Manager</th>                                            
                                            <th data-orderable="false" class="action">Show</th>
                                            <th data-orderable="false" class="action">Edit</th>
                                            <th data-orderable="false" class="action">Delete</th>
                                        </tr>
                                    </thead>
                                  
                                    <tbody>
                                        @foreach ($sitemasters as $key => $sitemaster)
                                            <tr class="text-center">
                                                <!-- <td>{{$key+=1}}</td> -->
                                                <td>{{$sitemaster->site_code}}</td>
                                                <td>{{$sitemaster->site_name}}</td>                                        
                                                <td>{{$sitemaster->site_location}}</td>
                                                <td>{{$sitemaster->firstname}}</td>
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
                                                    {{-- <form id="{{$sitemaster->site_no}}" action="{{route("sitemaster.destroy",$sitemaster->site_no)}}" method="post">
                                                        @csrf
                                                        @method("DELETE")
                                                    </form> --}}
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
          <dialog id="myDialog"  style="width:1000px;">
            <div class="row">

                <div class="col-md-12">
               
                     <a class="btn  btn-sm" onclick="handleClose()" style="float:right;padding: 10px 10px;"><i class="fas fa-close"></i></a>
                     <h4  id='heading_name' style='color:white' align="center"><b>Update SiteMaster </b></h4>
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
        <p style="color: red" id="error_site_name"></p>
    </div>

    <div class="form-group col-md-6">
        <label for="site_location" class="form-label fw-bold">Location<a style="text-decoration: none;color:red">*</a></label>
        <input type="text" id="site_location" name="site_location" value="{{ old('site_location') }}" placeholder="Location" class="form-control" autocomplete="off">
        <p style="color: red" id="error_site_location"></p>
    </div>
</div>
<div class="row">
    <div class="form-group col-md-6">
        <label for="site_building" class="form-label fw-bold">Site Building<a style="text-decoration: none;color:red">*</a></label>
        <input type="text" id="site_building" name="site_building" value="{{ old('site_building') }}" placeholder="Site Building" class="form-control" autocomplete="off">
        <p style="color: red" id="error_site_building"></p>
    </div>
    <div class="form-group col-md-6">
        <label for="site_floor" class="form-label fw-bold">Site Floor<a style="text-decoration: none;color:red">*</a></label>
        <input type="text" id="site_floor" name="site_floor" value="{{ old('site_floor') }}" placeholder="Site Floor" class="form-control" autocomplete="off">
        <p style="color: red" id="error_site_floor"></p>
    </div>
</div>
<div class="row">
    <div class="form-group col-md-6">
        <label for="room_number" class="form-label fw-bold">Room Number<a style="text-decoration: none;color:red">*</a></label>
        <input type="text" id="room_number" name="room_number" value="{{ old('room_number') }}"  placeholder="Room Number" class="form-control" autocomplete="off">
        <p style="color: red" id="error_room_number"></p>
    </div>
    <div class="form-group col-md-6">
        <label for="site_address" class="form-label fw-bold">Site Address<a style="text-decoration: none;color:red">*</a></label>
        <input type="text" id="site_address" name="site_address" value="{{ old('site_address') }}" placeholder="Site Address" class="form-control" autocomplete="off">
        <p style="color: red" id="error_site_address"></p>
    </div>
</div>
<div class="row">

    <div class="form-group col-md-6">
        <label for="site_manager" class="form-label fw-bold">Site Manager<a style="text-decoration: none;color:red">*</a></label>
        <input type="text" id="firstname" name="emp_id" value="{{ old('firstname') }}" placeholder="Site Manager" class="form-control" autocomplete="off">
        <input type="text" id="site_manager"  hidden name="site_manager" value="{{ old('site_manager') }}"  class="form-control" autocomplete="off">
        <p style="color: red" id="error_site_manager"></p>
    </div> 
    <div class="form-group col-md-6">
        
        <label for="site_status" class="form-label fw-bold">Site Status</label>
        <select id="site_status" name="site_status" class="form-control" autocomplete="off">
        <option value="">Select Option</option>
            @foreach($site_status as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
        <p style="color: red" id="error_site_status"></p>
    </div>
  
</div>
<div class="row">
<div class="form-group col-md-12">
        <label for="description" class="form-label fw-bold">Description</label>
        <textarea id="description" name="description" value="{{ old('description') }}" placeholder="Description" class="form-control" autocomplete="off"></textarea>
        <p style="color: red" id="error_description"></p>
    </div>
    <div class="form-group col-md-">
        <label for="site_code" id="code_lable" class="form-label fw-bold">Site Code</label>
        <input type="text" id="site_code" name="site_code" value="{{ old('site_code') }}" readonly placeholder="Site Code" class="form-control" autocomplete="off">
        <p style="color: red" id="error_site_code"></p>
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
    <div class="card-body" style="background-color:white;width:100%;height:20%;" >
       
                          <div class="row">
                        <div class="col-md-6">
                            <label>Site Name</label>
                            <p id="show_site_name"></p>
                        </div>
                        <div class="col-md-6">
                            <label>Location</label>
                            <p id="show_site_location"></p>
                        </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <label>Site Building</label>
                            <p id="show_site_building"></p>
                        </div>
                          <div class="col-md-6">
                            <label>Site Floor</label>
                            <p id="show_site_floor"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Room Number</label>
                            <p id="show_room_number"></p>
                        </div>
                            <div class="col-md-6">
                            <label>Site Address</label>
                            <p id="show_site_address"></p>
                        </div>
                    </div>
                    <div class="row">
                          <div class="col-md-6">
                            <label>Site Status</label>
                            <p id="show_site_status"></p>
                        </div>
                          <div class="col-md-6">
                            <label>Site Manager</label>
                            <p id="show_firstname"></p>
                        </div>
                    </div>
                    <div class="row">
                          <div class="col-md-6">
                            <label>Description</label>
                            <p id="show_description"></p>
                        </div>
                          <div class="col-md-6">
                            <label>Site Code</label>
                            <p id="show_site_code"></p>
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
             $('#heading_name').text("Add SiteMaster").css('font-weight', 'bold');
             $('#site_code').hide();
             $('#code_lable').hide();
             $('#show').css('display','none');
             $('#form').css('display','block');
          }
// DELETE FUNCTION
          function handleDelete(id){
             let url = '{{route('siteApi.delete',":site_no")}}';
            url= url.replace(':site_no',id);
            if (confirm("Are you sure you want to delete this site master?")) {
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
             url = '{{route('siteApi.store')}}';
             type  = 'POST';
            
         } else {
            let id = $('#site_no').val();
            url = '{{route('siteApi.update',":site_no")}}';
            url= url.replace(':site_no',id);
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
            let url = '{{route('siteApi.show',":site_no")}}';
            url = url.replace(':site_no',id);
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
//   console.log(`${key}: ${value}`);
  $(`#${key}`).val(value);
  console.log( $(`#${key}`).val(value));
                }
                $('#method').val('UPDATE');
                $('#submit').text('UPDATE');
} else {
    for (const [key, value] of Object.entries(message[0])) {
         $(`#show_${key}`).text(value);
    }
    $('#heading_name').text("View SiteMaster").css('font-weight', 'bold');
     $('#show').css('display','block');
    $('#form').css('display','none');
}
 document.getElementById("myDialog").open = true;
          
            },
        })
          }
  
// auto complete
$("#firstname").autocomplete(
      {

      source: function( request, response ) {
        $.ajax( {
        type:"GET",
          url: "{{ route('getemployeedata') }}",
          dataType: "json",
          data:{
            'firstname':$("#firstname").val()
          },
          success: function( data ) {
console.log(data);
            result = [];
            for(var i in data)
            {
              result.push(data[i]["firstname"]);
            }

             response(result);
          },fail: function(xhr, textStatus, errorThrown){
       alert(errorThrown);
    }
        } );
      },
      });
    // EMPLOYEE CODE
      $("#firstname").on('change',function(){
   var code= $(this).val();

   $.ajax( {
        type:"GET",
          url: "{{ route('getemployeedata') }}",
          dataType: "json",
          data:{
            'firstname':$(this).val()
          },
          success: function( data ) {
            console.log(data);
            result = [];
            for(var i in data)
            {
              $('#site_manager').val(data[i]["id"]);
            }
             console.log(result);
          },fail: function(xhr, textStatus, errorThrown){
       alert(errorThrown);
    }
        } );
});
        </script>
    
    

@stop