<!-- STYLE INCLUDED IN LAYOUT PAGE -->
@extends('layouts.app', [
     'activeName' => 'Material Issue/Return',
 ])
 @section('title', 'Material Issue/Return')

 @section('content_header')

 @stop


 @section('content')
     <!-- DATA table -->
     <div class="row">
         <div class="container-fluid">
             <div class="card shadow">
                 <div class="card-header">
                     <div class="d-flex justify-content-between">
                         <h4 class="font-weight-bold text-dark py">MATERIAL ISSUE/RETURN</h4>
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
                                     <!-- <th>S.NO</th> -->
                                     <th>MIR Code</th>
                                     <th>Location</th>
                                     <!-- <th>Issue Date</th> -->
                                     <th>Project Name</th>
                                     {{-- <th>Employee Name</th> --}}
                                     <th>Type</th>
                                     <th data-orderable="false" class="action notexport">Show</th>
                                     <th data-orderable="false" class="action notexport">Edit</th>
                                     <th data-orderable="false" class="action notexport">Delete</th>
                                     <div id="blur-background" class="blur-background"></div>
                                 </tr>
                             </thead>

                             <tbody>
                                 @foreach ($material_issues as $key => $material_issue)
                                     <tr class="text-center">
                                         <!-- <td>{{ $key += 1 }}</td> -->
                                         <td>{{ $material_issue->mir_code }}</td>
                                         <td>{{ $material_issue->location }}</td>
                                         {{-- {{ $material_issue->issue_date }}</td>  --}}
                                         <td>{{ $material_issue->project_name }}</td>
                                         {{-- <td>{{ $material_issue->firstname }}</td> --}}
                                         <td>{{ $material_issue->type }}</td>
                                         <td>
                                             <a onclick="handleShowAndEdit('{{ $material_issue->mir_no }}','show')"
                                                 class="btn btn-primary btn-circle btn-sm">
                                                 <i class="fas fa-flag"></i>
                                             </a>
                                         </td>
                                         <td>
                                             <a onclick="handleShowAndEdit('{{ $material_issue->mir_no }}','edit')"
                                                 class="btn btn-info btn-circle btn-sm mx-2">
                                                 <i class="fas fa-check"></i>
                                             </a>
                                         </td>
                                         <td>
                                             <button type="submit" class="btn btn-sm btn-danger"
                                                 onclick="handleDelete('{{ $material_issue->mir_no }}')">
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

                        <a class="btn  btn-sm" onclick="handleClose()" style="float:right;padding: 10px 10px;"><i
                                class="fas fa-close"></i></a>
                        <h4 id='heading_name' style='color:white' align="center"><b>Update Material Issue/Return Details</b></h4>
                    </div>
                </div>



                <form class="form-row" enctype="multipart/form-data" style="display:block" id="form"
                    onsubmit="handleSubmit()">
                    <input type="hidden" id="method" value="ADD" />
                    <input type="hidden" id="mir_no" name="mir_no" value="" /><br>

                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="location" class="form-label fw-bold">Location (Site location)<a
                                    style="text-decoration: none;color:red">*</a></label>
                            {{-- <input type="text" id="location" name="location" value="{{ old('location') }}"
                                placeholder="Location" class="form-control" autocomplete="off"> --}}
                                <select id="location" name="location" class="form-control form-select" autocomplete="off">
                                    <option value="">Select Option</option>
                                        @foreach($site_location as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>

                        </div>

                        <div class="form-group col-md-4">
                            <label for="issue_date" class="form-label fw-bold">Issue Date<a
                                    style="text-decoration: none;color:red">*</a></label>
                            <input type="date" id="issue_date" name="issue_date" value="{{ old('issue_date') }}"
                                placeholder="dd-mm-yyyy" class="form-control" autocomplete="off">

                        </div>
                        <div class="form-group col-md-4">
                            <label for="issue_ref_no" class="form-label fw-bold">Issue Ref No<a
                                    style="text-decoration: none;color:red">*</a></label>
                            <input type="text" id="issue_ref_no" name="issue_ref_no" value="{{ old('issue_ref_no') }}"
                                placeholder="Issue Ref No" class="form-control" autocomplete="off">

                        </div>
                    </div>
                    <div class="row">

                        <div class="form-group col-md-4">
                            <label for="project_name" class="form-label fw-bold">Project Name<a
                                    style="text-decoration: none;color:red">*</a></label>
                            <input type="text" id="project_name" name="project_name" value="{{ old('project_name') }}"
                                placeholder="Project Name" class="form-control" autocomplete="off">
                            <input type="text" id="project_no" hidden name="project_no"
                                value="{{ old('project_no') }}" class="form-control" autocomplete="off">

                        </div>
                        <div class="form-group col-md-4">
                            <label for="receiving_employee" class="form-label fw-bold">Receiving Employee</label>
                            <input type="text" id="firstname" name="firstname" value="{{ old('firstname') }}"
                                placeholder="Receiving Employee" class="form-control" autocomplete="off">
                            <input type="text" id="receiving_employee" hidden name="receiving_employee"
                                value="{{ old('receiving_employee') }}" class="form-control" autocomplete="off">

                        </div>
                        <div class="form-group col-md-4">
                            <label for="type" class="form-label fw-bold">Type<a
                                    style="text-decoration: none;color:red">*</a></label>
                            <select id="type" name="type" class="form-control form-select" autocomplete="off">
                                <option value="">Select Option</option>
                                @foreach ($type as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>

                        </div>


                    </div>


                    <div class="row">

                        <div class="form-group col-md-4">
                            <label for="grn_code" class="form-label fw-bold">PULL MR No</label>
                            <input type="text" id="mr_id" name="mr_no" value="{{ old('mr_no') }}"
                                class="form-control" autocomplete="off" hidden>
                            <input type="text" id="mr_reference_code" name="mr_reference_code"
                                value="{{ old('mr_reference_code') }}" placeholder="MR Code" class="form-control"
                                autocomplete="off">

                        </div>
                    </div>


                    {{-- Add row table code --}}

                    <h4>
                        <center><b>Item Details</b></center>
                    </h4>
                    <div class="container pt-4">
                        <div class="table-responsive">
                            <center>
                                <table class="table table-bordered" id="material" style="width: 95%;">
                                    <thead>
                                        <tr>
                                            <th class="text-center">S.No</th>

                                            <th class="text-center" style="width: 45%;">Item Name</th>
                                            <th class="text-center" style="width: 30%;">Store Room</th>
                                            <th class="text-center" style="width: 20%;">Item Stock</th>
                                            <th class="text-center" style="width: 20%;">Requested Qty</th>
                                            <th class="text-center" style="width: 20%;">Qty</th>
                                            <th class="text-center"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody">


                                    </tbody>
                                </table>
                            </center>
                        </div>
                         <button class="btn btn-md btn-primary" id="addBtn" type="button">
                             Add Row
                         </button>
                     </div>
                     <div class="row mt-5">
                         <div class="col-md-2">
                             <label for="">Remarks</label>
                         </div>
                         <div class="col-md-4">
                             <textarea name="remarks" id="remarks" cols="30" rows="4" class="form-control" name="remarks"
                                 id="remarks" autocomplete="off"></textarea>
                         </div>

                     </div>


                     <div class="row mt-3">
                         <div class="form-group col-md-12">
                             <center><button id="submit" class="btn btn-primary mx-3">Save</button>
                             </center>
                         </div>
                     </div>
                 </form>
                 <!-- SHOW DIALOG -->
                 <div class="card" id="show" style="display:none">
                     <div class="card-body" style="background-color:white;width:100%;height:20%;">

                        <div class="row">
                            <div class="col-md-4">
                                <label>Location</label>
                                <p id="show_location"></p>
                            </div>
                            <div class="col-md-4">
                                <label>Issue Date</label>
                                <p id="show_issue_date"></p>
                            </div>
                            <div class="col-md-4">
                                <label>Remarks</label>
                                <p id="show_remarks"></p>
                            </div>
                            </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label>Issue Ref No</label>
                                <p id="show_issue_ref_no"></p>
                            </div>
                            <div class="col-md-4">
                                <label>Project Name</label>
                                <p id="show_project_name"></p>
                            </div>
                            <div class="col-md-4">
                                <label>MIR Code</label>
                                <p id="show_mir_code"></p>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-md-4">
                                <label>Receiving Employee</label>
                                <p id="show_firstname"></p>
                            </div>
                            <div class="col-md-4">
                                <label>Type</label>
                                <p id="show_type"></p>
                            </div>
                            <div class="col-md-4">
                                <label>Pull Mr Code</label>
                                <p id="show_mr_reference_code"></p>
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
             </script>
             {{-- Add row table script --}}
             <script>
                 // jQuery button click event to add a row
                //  let itemNames = []; // Array to store encountered item names
                $('#addBtn').on('click', function() {

                    // var row = rowIdx - 1;
                    // var itemName = $('#item_name_' + row).val();

                    // if ($('#item_name_' + row).val() == '') {
                    //     alert("Please enter item name in row" + row);
                    // } else if (itemNames.includes(itemName)) {
                    //     alert('Item name "' + itemName + '" is repeated. Please enter a unique item name in row ' + row);
                    // } else if ($('#item_quantity_' + row).val() == '') {
                    //     alert("Please enter item quantity in row" + row);
                    // } else {
                    //     itemNames.push(itemName);
                        add_text();
                    // }
                    //  detele row

                });
                 $('#tbody').on('click', '.remove', function() {
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

                 var rowIdx = 1;

                 function add_text() {
                     var html = '';
                     html += '<tr id="row' + rowIdx + '" class="rowtr">';
                    html += '<td>' + rowIdx + '</td>';
                    html += '<td><div class="col-xs-12"><input type="text" id="item_name_' + rowIdx +
                        '"  name="item_name[]" class="item_name form-control" placeholder="Item name"><input type="text"  name="item_no[]" id="item_no_' +
                        rowIdx + '" class="item_no_' + rowIdx + '" hidden placeholder=" Item no"></div></td>';

                    html += '<td><div class="col-xs-12"><input type="text" name="store_room[]" id="store_room_' + rowIdx +
                        '"  name="store_room[]" class="store_room form-control"></div></td>';
                    html += '<td><center><div class="col-xs-12" id="total_quantity_' + rowIdx + '" ></div></center></td>';
                    html += '<td><div class="col-xs-12 requesting_qty" id="requesting_qty_' + rowIdx + '"></div></td>';
                    html += '<td><div class="col-xs-12"><input type="text" name="item_quantity[]"  id="item_quantity_' + rowIdx +
                        '"name="item_quantity[]" class="item_quantity form-control" style="width: 100px;"></div></td>';
if(rowIdx!=1){
                    html +=
                        '<td><button class="btn btn-danger remove" id="delete" type="button"><i class="fa fa-trash"></i></button></td>';
                    html += '</tr>';}
                    $("#tbody").append(html);
                    rowIdx++;
                     //    auto();
                     // Add autocomplete to the new item_name input field

                 }
                 jQuery($ => {

                     $(document).on('focus', '.item_name', function() {
                         $('#tbody').find('.item_name').autocomplete({
                             source: function(request, response) {

                                 $.ajax({
                                     type: "GET",
                                     url: "{{ route('getitemnamedata') }}",
                                     dataType: "json",
                                     data: {
                                         'itemname': request.term
                                     },
                                     success: function(data) {
                                         console.log(data);

                                         result = [];
                                         for (var i in data) {
                                             result.push(data[i]["item_name"]);
                                         }
                                         response(result);
                                     },
                                     fail: function(xhr, textStatus, errorThrown) {
                                         alert(errorThrown);
                                     }
                                 });
                             },
                             minLength: 1
                         });

                     });

                 });
                 $(document).on('change', '.item_name', function() {
                     // var code= $(this).val();
                     //  alert(rowIdx);
                     var id = rowIdx - 1;
                     //  alert('#item_no_' + id);
                     $.ajax({
                         type: "GET",
                         url: "{{ route('getitemnamedata') }}",
                         dataType: "json",
                         data: {
                             'itemname': $(this).val()
                         },
                         success: function(data) {
                             console.log(data[0]['id']);
                             result = [];
                             for (var i in data) {

                                 $('#item_no_' + id).val(data[0]["id"]);
                                 $('#total_quantity_' + id).text(data[0]["total_quantity"]);
                             }
                         },
                         fail: function(xhr, textStatus, errorThrown) {
                             alert(errorThrown);
                         }
                     });
                 });
             </script>


             <script>
                 $(function() {
                     $("#myTable").DataTable();
                 });
             </script>
             <!--ADD DIALOG  -->
             <script type="text/javascript">
                 function handleDialog() {
                     document.getElementById("myDialog").open = true;
                     window.scrollTo(0, 0);
                     add_text();
                     $('#method').val("ADD");
                     $('#submit').text("Save");
                     $('#heading_name').text("Add Material Issue/Return Details").css('font-weight', 'bold');
                     $('#mir_code').hide();
                     $('#mir_code_lable').hide();
                     $('#show').css('display', 'none');
                     $('#form').css('display', 'block');
                     $('#blur-background').css('display','block');

                 }
                 // DELETE FUNCTION
                 function handleDelete(id) {
                     let url = '{{ route('materialissueApi.delete', ':mir_no') }}';
                     url = url.replace(':mir_no', id);
                     if (confirm("Are you sure you want to delete this material issue/return?")) {
                         $.ajax({
                             url: url,
                             type: 'DELETE',
                             success: function(message) {
                                 alert(message);
                                 window.location.reload();
                             },
                         })
                     }

                 }
                 // DIALOG CLOSE BUTTON
                 function handleClose(){
                     document.getElementById("myDialog").open = false;
                     $('#form')[0].reset();
                    $("#tbody").empty();
                    rowIdx=1;
                    itemNames = []; // Clear the itemNames array
                    // Hide any error messages
                    $('.error-msg').removeClass('error-msg');
                    $('.has-error').removeClass('has-error');
                    // Hide any error messages
                    $('error').html('');
                    $('#blur-background').css('display','none');
                    // window.location.reload();
                }
                 // DIALOG SUBMIT FOR ADD AND EDIT
                 function handleSubmit() {
    event.preventDefault();
    var hiddenErrorElements = $('.error-msg:not(:hidden)').length;
    if (hiddenErrorElements === 0) {
        var hasError = false; // Declare hasError variable and set it to false

        $('.rowtr').each(function() {
            var rowIdx = $(this).attr('id').replace('row', '');
            var itemname = $('#item_name_' + rowIdx).val();
            var quantity = $('#item_quantity_' + rowIdx).val();

            if (itemname === '') {
                alert('Please enter an item name for row ' + rowIdx);
                hasError = true;
                return false;
            }

            if (quantity === '') {
                alert('Please enter a quantity for row ' + rowIdx);
                hasError = true;
                return false;
            }
        });

        if (!hasError) {
            let form_data = new FormData(document.getElementById('form'));
            let method = $('#method').val();
            let url;
            let type;
            if (method == 'ADD') {
                url = '{{ route('materialissueApi.store') }}';
                type = 'POST';
            } else {
                let id = $('#mir_no').val();
                url = '{{ route('materialissueApi.update', ':mir_no') }}';
                url = url.replace(':mir_no', id);
                type = 'POST';
            }
            $.ajax({
                url: url,
                type: type,
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                success: function(message) {
                    alert(message);
                    window.location.reload();
                },
                error: function(message) {
                    var data = message.responseJSON;
                    $('p[id ^= "error_"]').html("");
                    $.each(data.errors, function(key, val) {
                        console.log(key, val);
                        $(`#error_${key}`).html(val[0]);
                    });
                }
            });
        }
    }
}

                 //DATA SHOW FOR EDIT AND SHOW
                 function handleShowAndEdit(id, action) {
                    // alert(id);
                     let url = "{{ route('materialissueApi.show', ':mir_no') }}";
                     url = url.replace(':mir_no', id);
                     let type = "GET"
                     $.ajax({
                         url: url,
                         type: type,
                         contentType: false,
                         cache: false,
                         processData: false,
                         success: function(message) {
                             console.log(message.material_issues);
                             console.log(message.material_issues_item)

                             if (action == 'edit') {

                                 $('#show').css('display', 'none');
                                 $('#form').css('display', 'block');
                                 $('#blur-background').css('display','block');

                                 for (const [key, value] of Object.entries(message.material_issues[0])) {
                                     //  console.log(`${key}: ${value}`);
                                     $(`#${key}`).val(value);
                                 }
                                 var rowid = 1;
                                 for (const item of message.material_issues_item) {
                                    add_text(); // add a new row to the table
                                    //  console.log(item.item_no);
                                    console.log(rowid);
                                    $('#item_name_' + rowid).val(item.item_name);
                                    $('#item_no_' + rowid).val(item.item_no);
                                    $('#total_quantity_' + rowid).text(item.total_quantity);
                                    $('#store_room_' + rowid).val(item.store_room);
                                    $('#item_quantity_' + rowid).val(item.item_quantity);
                                    $('#requesting_qty_' + rowid).text(item.quantity);

                                    rowid++;
                                }
                                $('#heading_name').text("Update Material issue/return Details").css('font-weight', 'bold');
                                 $('#method').val('UPDATE');
                                 $('#submit').text('UPDATE');
                             } else {

                                 for (let [key, value] of Object.entries(message.material_issues[0])) {
                                    if (key === "issue_date") {
                                    var dateObj = new Date(value);
                                    var day = dateObj.getDate();
                                    var month = dateObj.getMonth() + 1;
                                    var year = dateObj.getFullYear();
                                    value= day + '-' + month + '-' + year
                                    }
                                     $(`#show_${key}`).text(value);
                                 }
                                 let script =
                                    '<table id="show_table" class="table table-striped"><thead><tr><th>Item Name</th><th>Store Room</th><th>Item in stock</th><th>Requesting qty</th><th>Item Quantity</th></tr></thead><tbody>';
                                for (const item of message.material_issues_item) {
                                    script += '<tr>';
                                    script += '<td>' + item.item_name + '</td>';
                                    script += '<td>' + (item.store_room || '-') + '</td>';
                                    script += '<td>' + (item.total_quantity || '-') + '</td>';
                                    script += '<td>' + (item.quantity || '-') + '</td>';
                                    script += '<td>' + item.item_quantity + '</td>';
                                    script += '</tr>';
                                }
                                 script += '</tbody></table>';
                                 $('#show_table').remove();
                                 $('#item_details_show').append(script);
                                 $('#heading_name').text("View Material issue/return Details").css('font-weight', 'bold');
                                 $('#show').css('display', 'block');
                                 $('#form').css('display', 'none');
                                 $('#blur-background').css('display','block');

                             }
                             document.getElementById("myDialog").open = true;
                             window.scrollTo(0, 0);
                         },
                     })
                 }


                jQuery($ => {

                $(document).on('focus click', $("#project_name"), function() {

                 $("#project_name").autocomplete({
                     source: function(request, response) {
                         $.ajax({
                             type: "GET",
                             url: "{{ route('getlocdata') }}",
                             dataType: "json",
                             data: {
                                 'projectname': $("#project_name").val()
                             },
                             success: function(data) {
                                 result = [];
                                 for (var i in data) {
                                     result.push(data[i]["project_name"]);
                                 }
                                 response(result);
                             },
                             fail: function(xhr, textStatus, errorThrown) {
                                 alert(errorThrown);
                             }
                         });
                     },
                 });
                });
            });
                 $("#project_name").on('change', function() {
                     var code = $(this).val();

                     $.ajax({
                         type: "GET",
                         url: "{{ route('getlocdata') }}",
                         dataType: "json",
                         data: {
                             'projectname': $(this).val()
                         },
                         success: function(data) {
                             result = [];
                             for (var i in data) {
                                 $('#project_no').val(data[i]["project_no"]);

                             }
                         },
                         fail: function(xhr, textStatus, errorThrown) {
                             alert(errorThrown);
                         }
                     });
                 });

                jQuery($ => {

                $(document).on('focus click', $("#firstname"), function() {
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
                 });
                });
            });
                 $("#firstname").on('change', function() {
                     var code = $(this).val();

                     $.ajax({
                         type: "GET",
                         url: "{{ route('getemployeedata') }}",
                         dataType: "json",
                         data: {
                             'firstname': $(this).val()
                         },
                         success: function(data) {
                             result = [];
                             for (var i in data) {
                                 $('#receiving_employee').val(data[i]["id"]);

                             }
                         },
                         fail: function(xhr, textStatus, errorThrown) {
                             alert(errorThrown);
                         }
                     });
                 });
             </script>


             {{-- Auto complete for location in sitemaster --}}
             <script>
                 // auto complete for sitename
                jQuery($ => {

                $(document).on('focus click', $("#location"), function() {
                 $("#location").autocomplete({
                     source: function(request, response) {
                         $.ajax({
                             type: "GET",
                             url: "{{ route('getsitelocationdata') }}",
                             dataType: "json",
                             data: {
                                 'site_name': $("#location").val()
                             },
                             success: function(data) {
                                 var result = [];
                                 for (var i in data) {
                                     result.push(data[i]["site_location"]);
                                 }
                                 response(result);
                                 console.log(result);
                             },
                             fail: function(xhr, textStatus, errorThrown) {
                                 alert(errorThrown);
                             }
                         });
                     }
                 });
                });
            });
                  //mr no
                  jQuery($ => 
                    {
                        $(document).on('focus click', $("#mr_reference_code"), function() 
                        {
                            $("#mr_reference_code").autocomplete(
                            {
                                source: function(request, response) 
                                {
                                    $.ajax(
                                    {
                                        type: "GET",
                                        url: "{{ route('getmrcode') }}",
                                        dataType: "json",
                                        data: 
                                        {
                                            'mrcode': $("#mr_reference_code").val()
                                        },
                                        success: function(data) 
                                        {

                                            result = [];
                                            for (var i in data) 
                                            {
                                                result.push(data[i]["mr_reference_code"]);
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

                $("#mr_reference_code").on('change', function() {
                    var code = $(this).val();

                    $.ajax({
                        type: "GET",
                        url: "{{ route('getmrdata') }}",
                        dataType: "json",
                        data: {
                            'mrcode': $('#mr_reference_code').val()
                        },
                        success: function(data) {
                            console.log(data.mr_no);
                            console.log(data.mr_items);
                            // console.log(data.grn_data);
                            result = [];
                            var mr = data.mr_items.length;
                            console.log(mr);
                            $('#mr_id').val(data.mr_data[0].mr_id);
                            var create_id = 1;



                            if (mr == 1) {
                                for (const item of data.mr_items) {

                                    $('#item_name_' + create_id).val(item.item_name);
                                    $('#item_no_' + create_id).val(item.item_no);
                                    $('#total_quantity_' + create_id).text(item.total_quantity);
                                    $('#item_quantity_' + create_id).val(item.item_qty);
                                    $('#requesting_qty_' + create_id).text(item.quantity);

                                }
                            } else {
                                for (const item of data.mr_items) {
                                    console.log(item.item_name)
                                    add_text();
                                    $('#item_name_' + create_id).val(item.item_name);
                                    $('#item_no_' + create_id).val(item.item_no);
                                    $('#total_quantity_' + create_id).text(item.total_quantity);
                                    $('#item_quantity_' + create_id).val(item.item_qty);
                                    $('#store_room_' + create_id).val(item.store_room);
                                    $('#requesting_qty_' + create_id).text(item.quantity);

                                    create_id++;
                                }
                            }
                        },
                        fail: function(xhr, textStatus, errorThrown) {
                            alert(errorThrown);
                        }
                    });
                });
                   //  Initialize form validation

              

                var project_Names = @json($projectNames);
                $.validator.addMethod("projectNameCheck", function(value, element) {
                    return project_Names.includes(value);
                });
                $.validator.addMethod("lessThanStockQty", function(value, element) {
                    var rowId = $(element).closest('tr').index() + 1;
                    var stockQuantity = $('#total_quantity_' + rowId).text().trim();
                    var type = $('#type').val(); // Assuming the type value is stored in an input field with id "type"

                    if (type === 'Issue') {
                        return parseFloat(value) <= parseFloat(stockQuantity);
                    } else if (type === 'Return') {
                        return true; // Allow any value for Return type, no error message will be shown
                    }

                    return false; // Invalid type, show error message
                }, "Please enter a value less than or equal to the stock quantity for Issue type.");



                // var employee_name=@json($employeeNames);
                //  $.validator.addMethod("employeeNameCheck", function(value, element)
                //  {
                //     return employee_name.includes(value);
                // });

                var item_Names = @json($itemNames);
                $.validator.addMethod("itemNameCheck", function(value, element) {
                    return item_Names.includes(value.trim());
                });

                $.validator.addMethod("alphanumeric_mrno", function(value, element) {
                    return this.optional(element) || /^[a-zA-Z0-9]+$/i.test(value);
                });
                $.validator.addMethod("alphanumeric_Qty", function(value, element) {
                    return this.optional(element) || /^\d+(\.\d+)?$/i.test(value);
                });

                var formValidationConfig = {

                    // Specify validation rules
                    rules: {
                        location: {
                            required: true,

                        },
                        issue_date: {
                            required: true
                        },
                        issue_ref_no: "required",
                        project_name: {
                            required: true,
                            projectNameCheck: true
                        },
                        // firstname:
                        // {
                        //   employeeNameCheck:true
                        // },
                        type: "required",
                        mr_reference_code: {
                            alphanumeric_mrno: true
                        },
                        "item_name[]": {
                            required: true,
                            itemNameCheck: true
                        },
                        "item_quantity[]": {
                            required: true,
                            alphanumeric_Qty: true,
                            lessThanStockQty:true
                        }

                    },
                    // Specify validation error messages

                    messages: {
                        location: {
                            required: "Please select the location",

                        },
                        issue_date: {
                            required: "Please select the issue date"
                        },
                        issue_ref_no: "Please enter the issue reference number",
                        project_name: {
                            required: "Please enter the project name",
                            projectNameCheck: "Please enter valid project name"
                        },
                        // firstname:
                        // {

                        //     employeeNameCheck: "Please enter valid  receiving employee"

                        // },
                        type: {
                            required: "Please select the type"
                        },
                        mr_reference_code: {
                            alphanumeric_mrno: "Please enter valid MR NO"
                        },

                        "item_name[]": {
                            required: "Please enter the item name.",
                            itemNameCheck: "Please enter valid item name."
                        },
                        "item_quantity[]": {
                            required: "Please enter the item qty",
                            alphanumeric_Qty: "please enter numbers only",
                            lessThanStockQty: "Item quantity should be less than or equal to stock quantity."
                        },
                    },
                    errorElement: "error",
                    errorClass: "error-msg",
                    highlight: function(element, errorClass, validClass) {
                        $(element).addClass(errorClass).removeClass(validClass);
                        $(element).closest('.form-group').addClass('has-error');
                        flag = '1';
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).removeClass(errorClass).addClass(validClass);
                        $(element).closest('.form-group').removeClass('has-error');
                        flag = '0';
                    }
                };

                $("#form").validate(formValidationConfig);

             </script>





         @stop