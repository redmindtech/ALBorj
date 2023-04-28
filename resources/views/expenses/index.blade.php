<!-- STYLE INCLUDED IN LAYOUT PAGE -->
@extends('layouts.app',[
    'activeName' => 'Expenses'
])
@section('title', 'Expenses')

@section('content_header')
@stop

@section('content')
<!-- DATA table -->
<div class="row">
                <div class="container-fluid">
                    <div class="card shadow">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h4 class="font-weight-bold text-dark py">EXPENSES</h4>
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
                                                
                                                <th>voucher No</th>
                                                <!-- <th>Date</th> -->
                                                <th>Project Name</th>
                                                <th>Supplier Name</th>
                                                <th>Total Amount</th>
                                                <!-- <th>Employee Name</th> -->
                                                <!-- <th>Created By</th> -->
                                                <th data-orderable="false" class="action">Show</th>
                                                <th data-orderable="false" class="action">Edit</th>
                                                <th data-orderable="false" class="action">Delete</th>
                                            </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($expenses as $expense)
                                            <tr class="text-center">
                                                <td>{{$expense->exp_code}}</td>
                                                <!-- <td>{{$expense->bill_date}}</td> -->
                                                <td>{{$expense->project_name}}</td>
                                                <td>{{$expense->name}}</td>
                                                <td>{{$expense->total_amount}}</td>
                                                <!-- <td>{{$expense->firstname}}</td> -->
                                                <td>
                                                    <a  onclick="handleShowAndEdit('{{$expense->exp_no}}','show')"
                                                        class="btn btn-primary btn-circle btn-sm"   >
                                                        <i class="fas fa-flag"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a onclick="handleShowAndEdit('{{$expense->exp_no}}','edit')"
                                                        class="btn btn-info btn-circle btn-sm mx-2" >
                                                        <i class="fas fa-check"></i>
                                                    </a>
                                                </td>
                                                <td>

                                                    <button  type="submit" class="btn btn-sm btn-danger" onclick="handleDelete('{{$expense->exp_no}}')">
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
                </div>
            </div>

                 <!-- ADD AND EDIT FORM -->
                 <dialog id="myDialog"  style="width:1000px;" >


<div class="row">

    <div class="col-md-12">

        <a class="btn btn-sm" onclick="handleClose()" style="float:right;padding: 10px 10px;"><i class="fas fa-close"></i></a>
            <h4  id='heading_name' style='color:white' align="center"><b>Update</b></h4>
    </div>
</div>
<form  class="form-row"  enctype="multipart/form-data" style="display:block" id="form" onsubmit="handleSubmit()">
    <input type="hidden" id="method" value="ADD"/>
    <input type="hidden" id="exp_no" name="exp_no" value=""/><br>

{!! csrf_field() !!}
<div class="row">
<div class="form-group col-md-12">
<label for="exp_code" id="code_lable" class="form-label fw-bold">Voucher No<a style="text-decoration: none;color:red">*</a></label>
<input type="text" id="exp_code"  name="exp_code" readonly value="{{ old('exp_code') }}" placeholder="Voucher No" class="form-control" autocomplete="off">
<p style="color: red" id="error_ap_code"></p>
</div>
</div>
<div class="row">
<div class="form-group col-md-6">
<label for="bill_no" class="form-label fw-bold">Bill No</label>
<input type="text" id="bill_no"  name="bill_no" value="{{ old('bill_no') }}" placeholder="Bill No" class="form-control" autocomplete="off">
<p style="color: red" id="error_bill_no"></p>
</div>
<div class="form-group col-md-6">
<label for="bill_date" class="form-label fw-bold">Bill Date</label>
<input type="date" id="bill_date"  name="bill_date" value="{{ old('bill_date') }}" placeholder="Bill Date" class="form-control" autocomplete="off">
<p style="color: red" id="error_bill_date"></p>
</div>

<div class="form-group col-md-6">
        <label for="employee_name" class="form-label fw-bold">Employee Name<a style="text-decoration: none;color:red">*</a></label>
        <input type="text" id="firstname" name="firstname" value="{{ old('firstname') }}" placeholder="Employee Name" class="form-control" autocomplete="off">
        <input type="text" id="employee_no" hidden name="employee_no" value="{{ old('employee_no') }}"  class="form-control" autocomplete="off">
        <p style="color: red" id="error_employee_no"></p>
    </div> 

<div class="form-group col-md-6">
        <label for="project_name" class="form-label fw-bold">Project Name<a style="text-decoration: none;color:red">*</a></label>
        <input type="text" id="project_name" name="project_name" value="{{ old('project_name') }}" placeholder="Project Name" class="form-control" autocomplete="off">
        <input type="text" id="project_no" hidden name="project_no" value="{{ old('project_no') }}"  class="form-control" autocomplete="off">
        <p style="color: red" id="error_project_no"></p>
    </div> 

<div class="form-group col-md-6">
        <label for="supplier_name" class="form-label fw-bold">Supplier Name<a style="text-decoration: none;color:red">*</a></label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Supplier Name" class="form-control" autocomplete="off">
        <input type="text" id="supplier_no" hidden name="supplier_no" value="{{ old('supplier_no') }}"  class="form-control" autocomplete="off">
        <p style="color: red" id="error_employee_nor"></p>
    </div>

<div class="form-group col-md-6">
<label for="expense_category" class="form-label fw-bold">Expense Category<a style="text-decoration: none;color:red">*</a></label>
<select id="exp_category_no" name="exp_category_no" class="form-control" autocomplete="off" style="width:100%">
<option value="">Select Option</option>
    @foreach ($exp_category as $key => $value)
        <option value="{{ $value->category_name  }}">{{ $value->category_name }}</option>
    @endforeach
</select>
<p style="color: red" id="error_exp_category_no"></p>
</div>
<div class="form-group col-md-6">
<label for="source" class="form-label fw-bold">Source<a style="text-decoration: none;color:red">*</a></label>
<!-- <input type="text" id="source"  name="source" value="{{ old('source') }}" placeholder="Source" class="form-control" autocomplete="off"> -->
<select id="source" name="source" class="form-control" autocomplete="off" >
        <option value="">Select Option</option>
            @foreach($source as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
<p style="color: red" id="error_source"></p>
</div>
<div class="form-group col-md-6">
<label for="bill_amount" class="form-label fw-bold">Bill Amount<a style="text-decoration: none;color:red">*</a></label>
<input type="text" id="bill_amount"  name="bill_amount" value="{{ old('bill_amount') }}" placeholder="Bill Amount" class="form-control" autocomplete="off">
<p style="color: red" id="error_bill_amount"></p>
</div>
<div class="form-group col-md-6">
<label for="vat" class="form-label fw-bold">Vat<a style="text-decoration: none;color:red">*</a></label>
<!-- <input type="text" id="vat"  name="vat" value="{{ old('vat') }}" placeholder="Vat" class="form-control" autocomplete="off"> -->

<select id="vat" name="vat" class="form-control" autocomplete="off">
        <option value="">Select Option</option>
            @foreach($vat as $key => $value)
                <option value="{{ $key }}">{{$value.'%'}}</option>
            @endforeach
        </select>
<p style="color: red" id="error_vat"></p>
</div>
<div class="form-group col-md-6">
<label for="total_amount" class="form-label fw-bold">Total Amount<a style="text-decoration: none;color:red">*</a></label>
<input type="text" id="total_amount"  name="total_amount" value="{{ old('total_amount') }}" placeholder="Total Amount" class="form-control" autocomplete="off">
<p style="color: red" id="error_total_amount"></p>
</div>
</div>
<div class="row">
<div class="form-group col-md-6">
<label for="attachment" class="form-label fw-bold">Attachment</label>
<input type="file" id="attachment"  name="attachment" value="{{ old('attachment') }}" placeholder="Attachment" class="form-control" autocomplete="off">
<p style="color: red" id="error_attachment"></p>
</div>
<!-- <div class="form-group col-md-6">
<label for="type" class="form-label fw-bold">Type</label>
<input type="text" id="type"  name="type" value="{{ old('type') }}" placeholder="Type" class="form-control" autocomplete="off">
<p style="color: red" id="error_type"></p>
</div> -->
</div>
<div class="row">
<div class="form-group col-md-12">
<label for="description" class="form-label fw-bold">Description</label>
<textarea id="description" name="description" value="{{ old('description') }}" placeholder="Description" class="form-control" autocomplete="off"></textarea>
<p style="color: red" id="error_description"></p>
</div>
</div>
<div class="form-group col-md-12">
<button type="submit" id="submit"  class="btn btn-primary float-end ">ADD</button>
</div>
</form>
<!-- SHOW DIALOG -->
<div class="card" id="show" style="display:none">
<div class="card-body" style="background-color:white;width:100%;height:20%;" >

            <div class="row">
            <div class="col-md-3">
                <label>Voucher No</label>
                <p id="show_exp_code"></p>
            </div>
            <div class="col-md-3">
                <label>Bill No</label>
                <p id="show_bill_no"></p>
            </div>                    
            <div class="col-md-3">
                <label>Bill Date</label>
                <p id="show_bill_date"></p>
            </div>
            <div class="col-md-3">
                <label>Employee Name</label>
                <p id="show_firstname"></p>
            </div>
            </div>
            <div class="row">
            <div class="col-md-3">
                <label>Project Name</label>
                <p id="show_project_name"></p>
            </div>
            <div class="col-md-3">
                <label>Supplier Name</label>
                <p id="show_name"></p>
            </div>
            <div class="col-md-3">
                <label>Expense Category</label>
                <p id="show_exp_category_no"></p>
            </div>            
            <div class="col-md-3">
                <label>Source</label>
                <p id="show_source"></p>
            </div>
            </div>
            <div class="row">
            <div class="col-md-3">
                <label>Bill Amount</label>
                <p id="show_bill_amount"></p>
            </div> 
            <div class="col-md-3">
                <label>Vat</label>
                <p id="show_vat"></p>
            </div>
            <div class="col-md-3">
                <label>Total Amount</label>
                <p id="show_total_amount"></p>
            </div>                        
            <div class="col-md-3">
                <label>Attachment</label>
                <p id="show_attachment"></p>
            </div>
            </div>
            <div class="row">
             <div class="col-md-12">
                <label>Description</label>
                <p id="show_description"></p>
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

$(function () {
            $("#myTable").DataTable();
        });
       
    //  <!--ADD DIALOG  -->

         
        function handleDialog(){
             document.getElementById("myDialog").open = true;
             $('#method').val("ADD");
             $('#submit').text("ADD");
             $('#heading_name').text("Add Expenses").css('font-weight', 'bold');
             $('#exp_code').hide();
             $('#code_lable').hide();
             $('#show').css('display','none');
             $('#form').css('display','block');
          }

    // DELETE FUNCTION
        function handleDelete(id){
             let url = '{{route('expenseApi.delete',":exp_no")}}';
            url= url.replace(':exp_no',id);
            if (confirm("Are you sure you want to delete this Expenses?")) {
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
             url = '{{route('expenseApi.store')}}';
             type  = 'POST';
            
         } else {
            let id = $('#exp_no').val();
            url = '{{route('expenseApi.update',":exp_no")}}';
            url= url.replace(':exp_no',id);
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
    function handleShowAndEdit(id,action)
    {
        let url = '{{route('expenseApi.show',":exp_no")}}';
        url = url.replace(':exp_no',id);

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
                    $('#show').css('display','none');
                    $('#form').css('display','block');
                    console.log(message[0]);
                    for (const [key, value] of Object.entries(message[0]))
                    {
                        $(`#${key}`).val(value);
                        $('#attachment').val(message[0].attachment);
                        // Select the option with a value of '1'
                        $('#exp_category_no').val(message[0].exp_category_no);
                        $('#exp_category_no').select2().trigger('change'); 
                    }
                    $('#method').val('UPDATE');
                    $('#submit').text('UPDATE');
                } else
                {
                    for (const [key, value] of Object.entries(message[0]))
                    {
                        $(`#show_${key}`).text(value);
                    }
                    $('#heading_name').text("View Item").css('font-weight', 'bold');
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
              $('#employee_no').val(data[i]["id"]);
            }
             console.log(result);
          },fail: function(xhr, textStatus, errorThrown){
       alert(errorThrown);
    }
        } );
});

// Supplier name Autocomplete
    $("#name").autocomplete(
    {

        source: function( request, response )
        {
            $.ajax
            ({
                type:"GET",
                url: "{{ route('getempdata') }}",
                dataType: "json",
                data:
                {
                    'suppliername':$("#name").val()
                },
                success: function( data )
                {

                    result = [];
                    for(var i in data)
                    {
                        result.push(data[i]["name"]);
                    }
                    response(result);
                },fail: function(xhr, textStatus, errorThrown)
                {
                    alert(errorThrown);
                }
            });
        },
    });
    $("#name").on('change',function()
    {
        var code= $(this).val();

        $.ajax
        ({
            type:"GET",
            url: "{{ route('getempdata') }}",
            dataType: "json",
            data:
            {
                'suppliername':$(this).val()
            },
            success: function( data )
            {
                result = [];
                for(var i in data)
                {
                    $('#supplier_no').val(data[i]["supplier_no"]);
                    $('#code').val(data[i]["code"]);
                }
            },fail: function(xhr, textStatus, errorThrown){
            alert(errorThrown);
            }
        });
    });

// projectname
// current location auto complete
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
      $("#project_name").on('change',function()
    {
        var code= $(this).val();

        $.ajax
        ({
            type:"GET",
            url: "{{ route('getlocdata') }}",
            dataType: "json",
            data:
            {
                'projectname':$(this).val()
            },
            success: function( data )
            {
                result = [];
                for(var i in data)
                { 
                    $('#project_no').val(data[i]["project_no"]);
                    
                }
            },fail: function(xhr, textStatus, errorThrown){
            alert(errorThrown);
            }
        });
    });

// bill_amount and vat inputs
$('#bill_amount, #vat').on('input', function() {
            
            var billAmount = parseFloat($('#bill_amount').val()) || 0;
            var vat = parseFloat($('#vat').val()) || 0;
            var totalAmount = billAmount + (billAmount * (vat / 100));
            $('#total_amount').val(totalAmount.toFixed(2));
        });

</script>
    <script>
         $(document).ready(function(){
          $('#exp_category_no').select2({
              tags:true
        });
    });
</script>
@stop
