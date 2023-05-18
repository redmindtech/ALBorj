<!-- STYLE INCLUDED IN LAYOUT PAGE -->
@extends('layouts.app',[
    'activeName' => 'Material'
])
@section('title', 'Material Requisition')

@section('content_header')
@stop

@section('content')
<!-- DATA table -->
     <div class="row">
                <div class="container-fluid">
                    <div class="card shadow">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h4 class="font-weight-bold text-dark py">MATERIAL REQUISITION</h4>
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
                                            <th>MR Code</th>
                                            <th>Date</th>
                                            <th>Project Name</th>                                           
                                            <th>Invoice No</th>
                                            <th>Purchase Type</th>
                                            <th>Employee Name</th>
                                            <th data-orderable="false" class="action notexport">Show</th>
                                            <th data-orderable="false" class="action notexport">Edit</th>
                                            <th data-orderable="false" class="action notexport">Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                     @foreach ($materials as $key => $material)
                                            <tr class="text-center">
                                                <td>{{$material->mr_reference_code}}<div id="blur-background" class="blur-background"></div></td>
                                               
                                                <td>{{ date('d-m-Y', strtotime($material->date))}}</td>
                                                <td>{{$material->project_name}}</td>                                        
                                                <td>{{$material->voucher_no}}</td>
                                                <td>{{$material->purchase_type}}</td>
                                                <td>{{$material->firstname}}</td>
                                                <td>
                                                    <a  onclick="handleShowAndEdit('{{$material->mr_id}}','show')"
                                                        class="btn btn-primary btn-circle btn-sm"   >
                                                        <i class="fas fa-flag"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a onclick="handleShowAndEdit('{{$material->mr_id}}','edit')"
                                                        class="btn btn-info btn-circle btn-sm mx-2" >
                                                        <i class="fas fa-check"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    {{-- <form id="{{$material->mr_id}}" action="{{route("material.destroy",$material->mr_id)}}" method="post">
                                                        @csrf
                                                        @method("DELETE")
                                                    </form> --}}
                                                    <button  type="submit" class="btn btn-sm btn-danger" onclick="handleDelete('{{$material->mr_id}}')">
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
                    <a class="btn  btn-sm" onclick="handleClose()" style="float:right;padding: 10px 10px;">
                        <i class="fas fa-close"></i>
                    </a>
                    <h4  id='heading_name' style='color:white' align="center"><b>Update Material Requisition</b></h4>
                </div>
            </div>
            <form  class="form-row"  enctype="multipart/form-data" style="display:block" id="form" onsubmit="handleSubmit()">
                <input type="hidden" id="method" value="ADD"/>
                <input type="hidden" id="mr_id" name="mr_id" value=""/><br>

                {!! csrf_field() !!}

                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="date" class="form-label fw-bold">Date<a style="text-decoration: none;color:red">*</a></label>
                        <input type="date" id="date" name="date" value="{{ old('date')}}" placeholder="Company Name" class="form-control" autocomplete="off">
                        <p style="color: red" id="error_date"></p>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="voucher_no" class="form-label fw-bold">Invoice Voucher No</label>
                        <input type="text" id="voucher_no"  name="voucher_no" value="{{ old('voucher_no') }}" placeholder="Voucher No" class="form-control" autocomplete="off">
                        <p style="color: red" id="error_voucher_no"></p>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="reference_date" class="form-label fw-bold">REF DATE</label>
                        <input type="date" id="reference_date" name="reference_date" value="{{ old('reference_date') }}" placeholder="Reference Date" class="form-control" autocomplete="off">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="address" class="form-label fw-bold">Type of Purchase<a style="text-decoration: none;color:red">*</a></label>
                        <select name="purchase_type" id="purchase_type"class="form-control"  autocomplete="off">
                            <option value="">Select Option</option>
                            @foreach($purchase_type as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                        <p style="color: red" id="error_purchase_type"></p>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="contact_number" class="form-label fw-bold">Project Name<a style="text-decoration: none;color:red">*</a></label>
                        <input type="text" id="project_name" name="project_name" value="{{ old('project_name') }}"  placeholder="Project Name" class="form-control" autocomplete="off" >
                        <input type="text" hidden  id="project_id" name="project_id" value="{{ old('project_id') }}"   class="form-control" />
                        <p style="color: red" id="error_project_name"></p>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="project_code" class="form-label fw-bold">Project Code</label>
                        <input type="text" id="project_code" name="project_code" readonly value="{{ old('project_code') }}" placeholder="Project Code" class="form-control" autocomplete="off">
                        <p style="color: red" id="error_project_code"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="contact_number" class="form-label fw-bold">Employee Name<a style="text-decoration: none;color:red">*</a></label>
                        <input type="text" id="firstname" name="firstname" value="{{ old('firstname') }}"  placeholder="Employee Name" class="form-control"  autocomplete="off">
                        <input type="text"  id="user_id" hidden name="user_id" value="{{ old('user_id') }}"   class="form-control" />
                        <p style="color: red" id="error_firstname"></p>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="mr_reference_code"  id="mr_reference_code_lable" class="form-label fw-bold">MR No<a style="text-decoration: none;color:red">*</a></label>
                        <input type="text" readonly id="mr_reference_code" name="mr_reference_code" value="{{ old('mr_reference_code') }}" placeholder="Reference No" class="form-control" autocomplete="off">
                        <p style="color: red" id="error_mr_reference_code"></p>
                    </div>
                </div>
                {{-- <div class="row"></div> --}}
                <div class="container pt-4">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="register">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Item Name</th>
                                    <th hidden>item_id</th>
                                    <th>Item Stock</th>
                                    <th>Quantity</th>
                                    <th>Delete</th>

                                </tr>
                            </thead>
                            <tbody id="tbodyMI">
                            </tbody>
                        </table>
                    </div>
                    <div style="margin-top:8px">
                        <button class="btn btn-md btn-primary" id="addBtn" type="button">
                            Add Row
                        </button>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">Remarks</label>
                            <textarea class="form-control" id="remarks" cols="30" rows="5" name="remarks" autocomplete="off" ></textarea>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="form-group col-md-12">
                        <center><button id="submit" class="btn btn-primary mx-3 mt-3">Save</button> </center>
                    </div>
                </div>
            </form>
                <!-- SHOW DIALOG -->
            <div class="card" id="show" style="display:none">
                <div class="card-body" style="background-color:white;width:100%;height:20%;" >

                    <div class="row">
                        <div class="col-md-3">
                            <label>MR NO.</label>
                            <p id="show_mr_reference_code"></p>
                        </div>
                        <div class="col-md-3">
                            <label>Date</label>
                            <p id="show_date"></p>
                        </div>
                          <div class="col-md-3">
                            <label>Purchase Type</label>
                            <p id="show_purchase_type"></p>
                        </div>
                          <div class="col-md-3">
                            <label>Reference Date</label>
                            <p id="show_reference_date"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label>Project Name</label>
                            <p id="show_project_name"></p>
                        </div>
                        <div class="col-md-3">
                            <label>Project Code</label>
                            <p id="show_project_code"></p>
                        </div>
                        <div class="col-md-3">
                            <label>Employee Name</label>
                            <p id="show_firstname"></p>
                        </div>
                        <div class="col-md-3">
                            <label>Voucher No</label>
                            <p id="show_voucher_no"></p>
                        </div>
                    </div>
                    <div class="row">
                          <div class="col-md-3">
                            <label>Remarks</label>
                            <p id="show_remarks"></p>
                        </div>
                    </div>
                    <div id="item_details_show"></div>

                </div>
            </div>
        </dialog>
     
          <script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
        $(function () {
            $("#myTable").DataTable();
        });
       
    //  <!--ADD DIALOG  -->
          
          function handleDialog(){
             document.getElementById("myDialog").open = true;
             $('#method').val("ADD");
             $('#submit').text("Save");
             getTodayDate();
             $('#mr_reference_code').hide();
             $("#mr_reference_code_lable").hide();
             add_text();
             $('#heading_name').text("Add Material Requisition").css('font-weight', 'bold');
         
             $('#show').css('display','none');
             $('#form').css('display','block');
             $('#blur-background').css('display','block');

          }
// DELETE FUNCTION
          function handleDelete(id){
             let url = '{{route('material.delete',":id")}}';
            url= url.replace(':id',id);
            if (confirm("Are you sure you want to delete this material?")) {
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
            
             url = '{{route('material.store')}}';
             type  = 'POST';
            
         } else {
            let id = $('#mr_id').val();
        
            url = '{{route('material.update',":id")}}';
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

             alert(message)
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
           
            let url = '{{route('material.show',":id")}}';
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
                     $('#blur-background').css('display','block');
       
                for (const [key, value] of Object.entries(message.mi[0])) {
               console.log(`${key}: ${value}`);
                    $(`#${key}`).val(value);
                }
                var rowid=1;
               for (const item of message.mi_item) {
                console.log(item.total_quantity);
                add_text(); // add a new row to the table
                $('#item_name_' + rowid).val(item.item_name);
                $('#item_no_' + rowid).val(item.item_no);
                $('#total_quantity_'+ rowid).text(item.total_quantity);
                $('#quantity_'+ rowid).val(item.quantity);
                            
                rowid++;
            }
                $('#method').val('UPDATE');
                $('#submit').text('UPDATE');
            } else {

                for (let [key, value] of Object.entries(message.mi[0])) {
                    if (key === "date" || key === "reference_date") {
                    var dateObj = new Date(value);
                    var day = dateObj.getDate();
                    var month = dateObj.getMonth() + 1;
                    var year = dateObj.getFullYear();
                    value= day + '-' + month + '-' + year
                    }
                    $(`#show_${key}`).text(value);
                }
                let script = '<table id="show_table" class="table table-striped"><thead><tr><th>Item Name</th><th>Stock Quantity</th><th>Quantity</th></tr></thead><tbody>';
                    for (const item of message.mi_item) {
                   script += '<tr>';
                   script += '<td>' + item.item_name + '</td>';
                   script += '<td>' + item.total_quantity + '</td>';
                   script += '<td>' + item.quantity+ '</td>';
                    script += '</tr>';
                }
               script+= '</tbody></table>';
               $('show_table').remove();
               $('#item_details_show').append(script); 
                
                $('#heading_name').text("View Material Requisition").css('font-weight', 'bold');
                $('#show').css('display','block');
                $('#form').css('display','none');
                $('#blur-background').css('display','block');

            }
            document.getElementById("myDialog").open = true;
                    
            },
        })
          }
        //   today date for date
          function getTodayDate() {
            var today = new Date();
            var day = today.getDate();
            var month = today.getMonth() + 1;
            var year = today.getFullYear();

            // Pad the month and day with leading zeros if necessary
            month = (month < 10 ? "0" : "") + month;
            day = (day < 10 ? "0" : "") + day;

            // Return the date string in YYYY-MM-DD format
            date= year + "-" + month + "-" + day;
            $('#date').val(date);
        }
// function to add row dynamically
var rowIdx =1;
function add_text()
{
            var html = '';
		html +='<tr id="row'+rowIdx+'">';
        html += '<td>'+rowIdx+'</td>';
		html += '<td><div class="col-xs-12"><input type="text" id="item_name_'+rowIdx+'"  name="item_name[]" class="item_name" placeholder="Start Typing Item name..."></div></td>';
        html += '<td hidden ><div class="col-xs-12"><input type="text"  id="item_no_'+rowIdx+'"  name="item_no[]" class="item_no_'+rowIdx+'"></div></td>';
        html += '<td><center><div class="col-xs-12" id="total_quantity_'+ rowIdx + '" ></div></center></td>';
        html += '<td><div class="col-xs-12"><input type="text" id="quantity_'+rowIdx+'"  name="quantity[]" class="quantity"></div></td>';
               html +='<td><button class="btn btn-danger remove" id="delete" type="button"><i class="fa fa-trash"></i></button></td>';     
        html+='</tr>';
        
        $("#tbodyMI").append(html);        
        rowIdx++;     
  
}
// auto complete function for item name and item no
jQuery($ => {
  
$(document).on('focus', '.item_name', function() {
        
    $('#tbodyMI').find('.item_name').autocomplete({   

        source: function( request, response )
        {
            $.ajax
            ({
                type:"GET",
                url: "{{ route('getitemnamedata') }}",
                dataType: "json",
                data:
                {
                    'itemname':request.term
                },
                success: function( data )
                {
                    result = [];
                    for(var i in data)
                    {
                        result.push(data[i]["item_name"]);
                    }
                    response(result);
                },fail: function(xhr, textStatus, errorThrown)
                {
                    alert(errorThrown);
                }
            });
        },
        minLength: 1
    });

    });
    
});
    $(document).on('change', '.item_name', function() 
    {     
    var id=rowIdx-1;
        $.ajax
        ({
            type:"GET",
            url: "{{ route('getitemnamedata') }}",
            dataType: "json",
            data:
            {
                'itemname':$(this).val()
            },
            success: function( data )
            { 
                result = [];
                for(var i in data)
                {                    
                    $('#item_no_'+id).val(data[0]["id"]);
                    $('#total_quantity_'+id).text(data[0]["total_quantity"]);
                    
                }
            },fail: function(xhr, textStatus, errorThrown){
            alert(errorThrown);
            }
        });
    });
    // add button function 
    $('#addBtn').on('click', function () {               
           var row=rowIdx-1;
        
                if ($('#item_name_'+row).val() == '') {
                    alert("Please enter item name.");
                
                }  else if ($('#quantity_'+row).val() == '') {
                    alert("Please enter quantity.");
                } else if (!/^\d+(\.\d+)?$/.test($('#quantity_'+row).val())) {
                    alert("Quantity should only contain numbers.");
                } else{            

           add_text();
                  }                               
                         
            });
            // delete row in dynamically created table
            $('#tbodyMI').on('click', '.remove', function() {
                                 // Getting all the rows next to the row containing the clicked button
                                 var child = $(this).closest('tr').nextAll();

                                 // Iterating across all the rows obtained to change the index
                                 child.each(function() {
                                     // Getting <tr> id.
                                     var id = $(this).attr('id');

                                     // Getting the <p> inside the .row-index class.
                                     var idx = $(this).children('.row-index').children('p');

                                     // Gets the row number from <tr> id.
                                     var dig = parseInt(id.substring(1));

                                     // Modifying row index.
                                     idx.html(`<input type='text'>`);

                                     // Modifying row id.
                                     $(this).attr('id', `R${dig - 1}`);
                                 });

                                 // Removing the current row.
                                 $(this).closest('tr').remove();

                                 // Decreasing total number of rows by 1.
                                 rowIdx--;
                             });
   // EMPLOYEE firstname
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
              $('#user_id').val(data[i]["id"]);
            }
             console.log(result);
          },fail: function(xhr, textStatus, errorThrown){
       alert(errorThrown);
    }
        } );
});
$("#project_name").autocomplete(
      {
      source: function( request, response ) {
        $.ajax( {
            type:"GET",
            url: "{{ route('getlocdata') }}",
            dataType: "json",
            data:{
            'projectname':$("#project_name").val()
             },
             success: function( data ) {
             result = [];
             for(var i in data)
            {
              result.push(data[i]["project_name"]);
            }
             response(result);
           },fail: function(xhr, textStatus, errorThrown){
        alert(errorThrown);
      }
      });
      },
      });

      $("#project_name").on('change',function(){
     var code= $(this).val();
         $.ajax( {
          type:"GET",
          url: "{{ route('getlocdata') }}",
          dataType: "json",
          data:{
            'projectname':$(this).val()
          },
          success: function( data ) {
           result = [];
            for(var i in data)
            {
              $('#project_id').val(data[i]["project_no"]);
              $('#project_code').val(data[i]["project_code"]);

            }
          },fail: function(xhr, textStatus, errorThrown){
       alert(errorThrown);
    }
        });
        });
    


        </script>
    
    

          
          
        
    


@stop