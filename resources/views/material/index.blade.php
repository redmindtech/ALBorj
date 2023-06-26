<style>
    .input-text {
    width: 100%;
    padding: 6px;
}
</style>
<!-- STYLE INCLUDED IN LAYOUT PAGE -->
@extends('layouts.app',[
    'activeName' => 'Material Requisition'
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
                                    <th>MRno</th>
                                    <th>Date</th>
                                    <th>Project Name</th>   
                                    <th>Employee Name</th>                                        
                                    <th>Invoice No</th>
                                    <!-- <th>Purchase Type</th> -->
                                    <th data-orderable="false" class="action notexport">Show</th>
                                    <th data-orderable="false" class="action notexport">Edit</th>
                                    <th data-orderable="false" class="action notexport">Delete</th>
                                    <div id="blur-background" class="blur-background"></div>
                                </tr>
                            </thead>
                                <tbody>
                                    @foreach ($materials as $key => $material)
                                        <tr class="text-center">
                                            <td>{{$material->mr_reference_code}}</td>
                                            <td>{{ date('d-m-Y', strtotime($material->date))}}</td>
                                            <td>{{$material->project_name}}</td>  
                                            <td>{{$material->firstname}}</td>                                      
                                            <td>{{$material->voucher_no}}</td>
                                            <!-- <td>{{$material->purchase_type}}</td> -->
                                            <td>
                                                <a onclick="handleShowAndEdit('{{$material->mr_id}}','show')"
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
    </div>
</div>

                        <!-- ADD AND EDIT FORM -->
    <dialog id="myDialog">
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
                        <label for="date" class="form-label fw-bold">Date</label>
                            <input type="date" id="date" name="date" value="{{ old('date')}}" placeholder="Company Name" class="form-control" autocomplete="off">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="voucher_no" class="form-label fw-bold">Invoice Voucher No</label>
                            <input type="text" id="voucher_no"  name="voucher_no" value="{{ old('voucher_no') }}" placeholder="Voucher No" class="form-control" autocomplete="off">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="reference_date" class="form-label fw-bold">REF DATE</label>
                            <input type="date" id="reference_date" name="reference_date" value="{{ old('reference_date') }}" placeholder="Reference Date" class="form-control" autocomplete="off">
                        </div>
                    </div>
                    <div class="row">
                    <div class="form-group col-md-4">
                            <label for="contact_number" class="form-label fw-bold">Project Name<a style="text-decoration: none;color:red">*</a></label>
                            <input type="text" id="project_name" name="project_name" value="{{ old('project_name') }}"  placeholder="Project Name" class="form-control" autocomplete="off" >
                            <input type="text" hidden  id="project_id" name="project_id" value="{{ old('project_id') }}"   class="form-control" />
                        </div>
                        <div class="form-group col-md-4">
                            <label for="project_code" class="form-label fw-bold">Project Code</label>
                            <input type="text" id="project_code" name="project_code" readonly value="{{ old('project_code') }}" placeholder="Project Code" class="form-control" autocomplete="off">
                        </div>
                    <!-- </div> -->
                    <!-- <div class="row"> -->
                        <div class="form-group col-md-4">
                            <label for="contact_number" class="form-label fw-bold">Employee Name<a style="text-decoration: none;color:red">*</a></label>
                            <input type="text" id="firstname" name="firstname" value="{{ old('firstname') }}"  placeholder="Employee Name" class="form-control"  autocomplete="off">
                            <input type="text"  id="user_id" hidden name="user_id" value="{{ old('user_id') }}"   class="form-control" />
                        </div>
                        <div class="form-group col-md-4">
                            <label for="mr_reference_code"  id="mr_reference_code_lable" class="form-label fw-bold">MR Code<a style="text-decoration: none;color:red">*</a></label>
                            <input type="text" readonly id="mr_reference_code" name="mr_reference_code" value="{{ old('mr_reference_code') }}" placeholder="Reference No" class="form-control" autocomplete="off">
                        </div>
                    </div>

                    <!-- inline table head -->
                    <div class="container pt-4">
                        <div class="table-responsive">
                            <center><table class="table table-bordered" id="register" style="width: 85%;">
                                <thead>
                                    <tr>
                                        <th class="text-center">S.No</th>
                                        <th class="text-center" style="width: 75%;">Item Name</th>
                                        <th hidden>item_id</th>
                                        <th class="text-center" style="width: 12%;">Item Stock</th>
                                        <th class="text-center" style="width: 13%;">Quantity</th>
                                        <th class="text-center"></th>

                                    </tr>
                                </thead>
                                <tbody id="tbodyMI">

                                </tbody>
                            </table></center>
                        </div>
                        <div style="margin-top:8px">
                            <button class="btn btn-md btn-primary" id="addBtn" type="button">
                                Add Row
                            </button>
                        </div>
                    </div>
                    <!-- inline table head end -->

                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">Remarks</label>
                            <textarea class="form-control" id="remarks" cols="30" rows="5" name="remarks" autocomplete="off" ></textarea>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="form-group col-md-12">
                            <center><button id="submit" class="btn btn-primary mx-3 mt-3">Save</button> </center>
                        </div>
                    </div>
            </form>
                        <!-- SHOW FORM DIALOG -->
            <div class="card" id="show" style="display:none">
                <div class="card-body" style="background-color:white;width:100%;height:20%;" >
                    <div class="row">
                        <div class="col-md-3">
                            <label>MR Code</label>
                            <p id="show_mr_reference_code"></p>
                        </div>
                        <div class="col-md-3">
                            <label>Date</label>
                            <p id="show_date"></p>
                        </div>
                        <!-- <div class="col-md-3"> -->
                         <!--   <label>Purchase Type</label>  -->
                         <!--   <p id="show_purchase_type"></p> -->
                        <!-- </div> -->
                        <div class="col-md-3">
                            <label>Reference Date</label>
                            <p id="show_reference_date"></p>
                        </div>
                    <!-- </div> -->
                    <!-- <div class="row"> -->
                        <div class="col-md-3">
                            <label>Project Name</label>
                            <p id="show_project_name"></p>
                        </div>
                    </div>
                        <div class="row">
                        <div class="col-md-3">
                            <label>Project Code</label>
                            <p id="show_project_code"></p>
                        </div>
                        <div class="col-md-3">
                            <label>Employee Name</label>
                            <p id="show_firstname"></p>
                        </div>
                        <div class="col-md-3">
                            <label>Invoice Voucher No</label>
                            <p id="show_voucher_no"></p>
                        </div>
                    <!-- </div> -->
                    <!-- <div class="row"> -->
                        <div class="col-md-3">
                            <label>Remarks</label>
                            <p id="show_remarks"></p>
                        </div>
                    </div>
                    <div id="item_details_show">
                    </div>
                </div>
            </div>
    </dialog>

            <!-- Script Start -->
     
    <script type="text/javascript">
        $.ajaxSetup
        ({
            headers: 
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(function () 
        {
            $("#myTable").DataTable();
        });
       
            //  <!--ADD DIALOG  -->
          
        function handleDialog()
        {
             document.getElementById("myDialog").open = true;
             window.scrollTo(0, 0);
             $('#method').val("ADD");
             $('#submit').text("Save");
             getTodayDate();
             $('#mr_reference_code').hide();
             $("#mr_reference_code_lable").hide();
             add_text();
             $('#heading_name').text("Add Material Requisition Details").css('font-weight', 'bold');
             $('#show').css('display','none');
             $('#form').css('display','block');
             $('#blur-background').css('display','block');

        }

            // DELETE FUNCTION

        function handleDelete(id)
        {
            let url = '{{route('material.delete',":id")}}';
            url= url.replace(':id',id);
            if (confirm("Are you sure you want to delete this material requisition?")) 
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
            $("#tbodyMI").empty();
            rowIdx=1;
            // Hide any error messages
            $('.error-msg').removeClass('error-msg');
            $('.has-error').removeClass('has-error');       
            $('error').html('');
            // Hide the dialog background
            $('#blur-background').css('display','none');
        }

            // DIALOG SUBMIT FOR ADD AND EDIT

        function handleSubmit()
        {
            event.preventDefault();
            var hasError = true;
            let itemNames = []; // Array to store encountered item names
            $('.rowtr').each(function() 
            {
                let rowId = $(this).attr('id');
                let itemName = $('#' + rowId + ' .item_name').val();
                let quantity= $('#' + rowId + ' .quantity').val();
                if (itemName === '') 
                {
                    alert('Please enter an item name in ' + rowId);
                    hasError = false;
                    return false; // Exit the loop
                }
                if (itemNames.includes(itemName)) 
                {
                    alert('Item name "' + itemName + '" is repeated. Please enter a unique item name in ' + rowId);
                    hasError = false;
                    return false; // Exit the loop
                }
                itemNames.push(itemName);
                if (quantity === '' ) 
                {
                    alert('Please enter quantity in ' + rowId);
                    hasError = false;
                    return false; // Exit the loop
                }
                if (quantity === '0' ) 
                {
                    alert('Please enter quantity in ' + rowId + 'otherthan 0');
                    hasError = false;
                    return false; // Exit the loop
                }
            });
            if(hasError) 
            { event.preventDefault();
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
                        url = '{{route('material.store')}}';
                        type  = 'POST';
                    } 
                    else 
                    {
                        let id = $('#mr_id').val();
                        url = '{{route('material.update',":id")}}';
                        url= url.replace(':id',id);
                        type = 'POST';
                    }
                    $.ajax(
                    {
                        url: url,
                        type: type,
                        data: form_data,
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (message) 
                        {
                            alert(message)
                            window.location.reload();
                        },
                        error: function (message) 
                        {
                            var data = message.responseJSON;
                        }
                    });
                }
            }
        }

            //DATA SHOW FOR EDIT AND SHOW 
          
        function handleShowAndEdit(id,action)
        {   
            let url = '{{route('material.show',":id")}}';
            url = url.replace(':id',id);
            let type= "GET"
            $.ajax(
            {
                url: url,
                type: type,
                contentType: false,
                cache: false,
                processData: false,
                success: function (message) 
                {
                    // console.log(message);
                    if(action == 'edit'){
                    $('#heading_name').text("Update Material Requisition Details").css('font-weight', 'bold');
                    $('#show').css('display','none');
                    $('#form').css('display','block');  
                    $('#blur-background').css('display','block');
       
                    for (const [key, value] of Object.entries(message.mi[0])) 
                    {
                        console.log(`${key}: ${value}`);
                        $(`#${key}`).val(value);
                    }
                    var rowid=1;
                    for (const item of message.mi_item) 
                    {
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
                    } 
                    else 
                    {
                        for (let [key, value] of Object.entries(message.mi[0])) 
                        {
                            if (key === "date" || key === "reference_date") 
                            {                      
                                if( value == null)
                                {
                                    value="";
                                }
                                else
                                {
                                    var dateObj = new Date(value);
                                    var day = dateObj.getDate();
                                    var month = dateObj.getMonth() + 1;
                                    var year = dateObj.getFullYear();
                                    value= day + '-' + month + '-' + year
                                }
                            }
                            $(`#show_${key}`).text(value);
                        }
                        let script = '<table id="show_table" class="table table-striped"><thead><tr><th>Item Name</th><th>Item Stock</th><th>Quantity</th></tr></thead><tbody>';
                        for (const item of message.mi_item) 
                        {
                            script += '<tr>';
                            script += '<td>' + item.item_name + '</td>';
                            script += '<td>' + item.total_quantity + '</td>';
                            script += '<td>' + item.quantity+ '</td>';
                            script += '</tr>';
                        }
                        script+= '</tbody></table>';
                        $('#show_table').remove();
                        $('#item_details_show').append(script);               
                        $('#heading_name').text("View Material Requisition Details").css('font-weight', 'bold');
                        $('#show').css('display','block');
                        $('#form').css('display','none');
                        $('#blur-background').css('display','block');
                    }
                    document.getElementById("myDialog").open = true;
                    window.scrollTo(0, 0);
                },
            })
        }

            //   today date for date
        function getTodayDate() 
        {
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
            html +='<tr id="row'+rowIdx+'" class="rowtr">';
            html += '<td><center>'+rowIdx+'</center></td>';
            html += '<td><div class="col-xs-12"><input type="text" id="item_name_'+rowIdx+'"  name="item_name[]" autocomplete="off" class="item_name input-text form-control" placeholder="Start Typing Item name..."></div></td>';
            html += '<td hidden ><div class="col-xs-12"><input type="text"  id="item_no_'+rowIdx+'"  name="item_no[]" class="item_no_'+rowIdx+'"></div></td>';
            html += '<td><center><div class="col-xs-12" id="total_quantity_'+ rowIdx + '" ></div></center></td>';
            html += '<td><div class="col-xs-12"><input type="number" id="quantity_'+rowIdx+'"  name="quantity[]" class="quantity form-control"></div></td>';
            if(rowIdx != 1){
            html +='<td><button class="btn btn-danger btn-sm remove" id="delete" type="button"><i class="fa fa-trash"></i></button></td>';     
            html+='</tr>';
            }
            $("#tbodyMI").append(html);        
            rowIdx++;     
        }
    // auto complete function for item name and item no
    // jQuery($ => 
    // {
    //     $(document).on('focus', '.item_name', function()
    //     {            
    //         $('#tbodyMI').find('.item_name').autocomplete(
    //         {
    //             source: function( request, response )
    //             {
    //                 $.ajax
    //                 ({
    //                     type:"GET",
    //                     url: "{{ route('getitemnamedata') }}",
    //                     dataType: "json",
    //                     data:
    //                     {
    //                         'itemname':request.term
    //                     },
    //                     success: function( data )
    //                     {
    //                         result = [];
    //                         for(var i in data)
    //                         {
    //                             result.push(data[i]["item_name"]);
    //                         }
    //                         response(result);
    //                     },
    //                     fail: function(xhr, textStatus, errorThrown)
    //                     {
    //                         alert(errorThrown);
    //                     }
    //                 });
    //             },
    //             minLength: 1
    //         });
    //     });        
    // });
        
    // $(document).on('change', 'input.item_name', function() 
    // {     
    //     var id=rowIdx-1;
    //     $.ajax
    //     ({
    //         type:"GET",
    //         url: "{{ route('getitemnamedata') }}",
    //         dataType: "json",
    //         data:
    //         {
    //             'itemname':$(this).val()
    //         },
    //         success: function( data )
    //         { 
    //             result = [];
    //             for(var i in data)
    //             {                    
    //                 $('#item_no_'+id).val(data[0]["id"]);
    //                 $('#total_quantity_'+id).text(data[0]["total_quantity"]);       
    //             }
    //         },
    //         fail: function(xhr, textStatus, errorThrown)
    //         {
    //             alert(errorThrown);
    //         }
    //     });
    // });
    jQuery($ => {
  $(document).on('focus', 'input.item_name', function() {
    $('#tbodyMI').find('.item_name').autocomplete({
      source: function(request, response) {
        $.ajax({
          type: "GET",
          url: "{{ route('getitemnamedata') }}",
          dataType: "json",
          data: {
            'itemname': request.term
          },
          success: function(data) {
            var result = [];
            for (var i in data) {
              result.push(data[i]["item_name"]);
            }
            response(result);
          },
          error: function(xhr, textStatus, errorThrown) {
            alert(errorThrown);
          }
        });
      },
      minLength: 1,
      select: function(event, ui) {
        var id = rowIdx - 1;
        $('#item_no_' + id).val(ui.item.id);
        $('#total_quantity_' + id).text(ui.item.total_quantity);
      }
    });
  });
});

$(document).on( 'change','input.item_name', function() {
  handleItemNameChange($(this).val());
});

function handleItemNameChange(item) {
  var id = rowIdx - 1;
  $.ajax({
    type: "GET",
    url: "{{ route('getitemnamedata') }}",
    dataType: "json",
    data: {
      'itemname': item
    },
    success: function(data) {
      var result = [];
      for (var i in data) {
        $('#item_no_' + id).val(data[i]["id"]);
        $('#total_quantity_' + id).text(data[i]["total_quantity"]);
      }
    },
    error: function(xhr, textStatus, errorThrown) {
      alert(errorThrown);
    }
  });
}

    // jQuery button click event to add a row
    // let itemNames = []; // Array to store encountered item names           

    $('#addBtn').on('click', function () 
    {   
        // var row=rowIdx-1;
        // var itemName = $('#item_name_' + row).val();

        // if (itemName == '') 
        // {
        //     alert("Please enter item name in row " +row);        
        // }
        // else if (itemNames.includes(itemName)) 
        // {
        // alert('Item name "' + itemName + '" is repeated. Please enter a unique item name in row ' + row);
        // }
        // else if ($('#quantity_'+row).val() == '') 
        // {
        //     alert("Please enter quantity in row" +row);
        // } 
        // else if (!/^\d+(\.\d+)?$/.test($('#quantity_'+row).val())) 
        // {
        //     alert("Quantity should only contain numbers.");
        // } 
        // else
        // {    
            // itemNames.push(itemName);         
        add_text();
        // }                               
    });
    
            // delete row in dynamically created table
    $('#tbodyMI').on('click', '.remove', function() 
    {
        // Getting all the rows next to the row containing the clicked button
        var child = $(this).closest('tr').nextAll();
        // Iterating across all the rows obtained to change the index
        child.each(function() 
        {
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

            // EMPLOYEE firstname autocomplete
    
    jQuery($ => 
    {
        $(document).on('focus click', $("#firstname"), function() 
        {
            $("#firstname").autocomplete(
            {
                source: function( request, response ) 
                {
                    $.ajax( 
                    {
                        type:"GET",
                        url: "{{ route('getemployeedata') }}",
                        dataType: "json",
                        data:
                        {
                            'firstname':$("#firstname").val()
                        },
                        success: function( data ) 
                        {
                            result = [];
                            for(var i in data)
                            {
                                result.push(data[i]["firstname"]);
                            }
                            response(result);
                        },
                        fail: function(xhr, textStatus, errorThrown)
                        {
                            alert(errorThrown);
                        }
                    });
                },
            });
        });
    });
            
            // EMPLOYEE CODE
        
    $("#firstname").on('change',function()
    {
        var code= $(this).val();
        $.ajax( 
        {
            type:"GET",
            url: "{{ route('getemployeedata') }}",
            dataType: "json",
            data:
            {
                'firstname':$(this).val()
            },
            success: function( data ) 
            {
                console.log(data);
                result = [];
                for(var i in data)
                {
                    $('#user_id').val(data[i]["id"]);
                }
                console.log(result);
            },
            fail: function(xhr, textStatus, errorThrown)
            {
                alert(errorThrown);
            }
        });
    });

            //project name autocomplete

    jQuery($ => 
    {
        $(document).on('focus click', $("#project_name"), function() 
        {
            $("#project_name").autocomplete(
            {
                source: function( request, response ) 
                {
                    $.ajax( 
                    {
                        type:"GET",
                        url: "{{ route('getlocdata') }}",
                        dataType: "json",
                        data:
                        {
                            'projectname':$("#project_name").val()
                        },
                        success: function( data ) 
                        {
                            result = [];
                            for(var i in data)
                            {
                                result.push(data[i]["project_name"]);
                            }
                            response(result);
                        },
                        fail: function(xhr, textStatus, errorThrown)
                        {
                            alert(errorThrown);
                        }
                    });
                },
            });
        });
    });

            // project code 
    $("#project_name").on('change',function()
    {
        var code= $(this).val();
        $.ajax( 
        {
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
                    $('#project_id').val(data[i]["project_no"]);
                    $('#project_code').val(data[i]["project_code"]);
                }
            },
            fail: function(xhr, textStatus, errorThrown)
            {
                alert(errorThrown);
            }
        });
    });
        
    // Initialize form validation
    var employee_name=@json($employee_name);
    $.validator.addMethod("employeeNameCheck", function(value, element) 
    {
        return employee_name.includes(value);
    });
            
    var project_name=@json($project_name);
    $.validator.addMethod("projectNameCheck", function(value, element) 
    {
        return project_name.includes(value);
    });

    var item_name = @json($item_name);
    $.validator.addMethod("ItemName", function(value, element) 
    {
        return item_name.includes(value.trim());
    });

    var formValidationConfig = 
    {
        rules: 
        {
         //   purchase_type: "required",
            firstname:
            {
                required:true,
                employeeNameCheck:true
            },
            project_name:
            {
                required:true,
                projectNameCheck:true
            },
            "item_name[]": 
            {
                required: true,
                ItemName: true
            },
            "quantity[]": 
            {
                required: true,
                digits: true
            }
            
        },
        messages:
        {
            
            //purchase_type: "Please select the purchase type ",
            firstname:
            {
                required:"Please enter the Employee Name",
                employeeNameCheck:"Please enter valid Employee Name"
            },
            project_name:
            {
                required:"Please enter the Project Name",
                projectNameCheck:"Please enter valid Project Name"
            },
            "item_name[]": 
            {
                required: "Please enter the item name",
                ItemName: "Please enter a valid item name"
            },
            "quantity[]": 
            {
                required: "Please enter the quantity",
                digits: "Please enter an integer value"
            }
        
        },
        errorElement: "error",
        errorClass: "error-msg",
        highlight: function(element, errorClass, validClass) 
        {
            $(element).addClass(errorClass).removeClass(validClass);
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass) 
        {
            $(element).removeClass(errorClass).addClass(validClass);
            $(element).closest('.form-group').removeClass('has-error');
        }
    };

    jQuery($ => 
    {
        var form = $("#form");
        form.validate(formValidationConfig);
    });

</script>

@stop