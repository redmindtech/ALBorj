@extends('layouts.app',[
    'activeName' => 'Purchase Return'
])
@section('title', 'Purchase Return')

@section('content_header')
@stop

@section('content')
<div class="row">
    <div class="container-fluid">
        <div class="card shadow">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="font-weight-bold text-dark py">PURCHASE RETURN</h4>
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
                                <th>Purchase Return Code</th>
                                <th>Supplier Name</th>
                                <th>Project Name</th>
                                <th>Purchase Type</th>
                                <th data-orderable="false" class="action notexport" >Show</th>
                                <th data-orderable="false" class="action notexport">Edit</th>
                                <th data-orderable="false" class="action notexport">Delete</th>
                                <div id="blur-background" class="blur-background"></div>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($prs as $key => $pr)
                                <tr class="text-center">
                                    <!-- <td>{{$key+=1}}</td> -->
                                    <td>{{$pr->pr_code}}</td>
                                    <td>{{$pr->name}}</td>
                                    <td>{{$pr->project_name}}</td>
                                    <td>{{$pr->pr_purchase_type}}</td>

                                    <td>
                                        <a  onclick="handleShowAndEdit('{{$pr->pr_no}}','show')" class="btn btn-primary btn-circle btn-sm">
                                            <i class="fas fa-flag"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a onclick="handleShowAndEdit('{{$pr->pr_no}}','edit')" class="btn btn-info btn-circle btn-sm mx-2" >
                                            <i class="fas fa-check"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <button  type="submit" class="btn btn-sm btn-danger" onclick="handleDelete('{{$pr->pr_no}}')">
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

        <dialog id="myDialog">
            <div class="row">
                <div class="col-md-12">
                    <a class="btn  btn-sm" onclick="handleClose()" style="float:right;padding: 10px 10px;">
                        <i class="fas fa-close"></i>
                    </a>
                    <h4  id='heading_name' style='color:white' align="center"><b>Update Purchase Return Details</b></h4>
                </div>
            </div>

            <form  class="form-row"  enctype="multipart/form-data" style="display:block" id="form" onsubmit="handleSubmit()">
                <input type="hidden" id="method" value="ADD"/>
                <input type="hidden" id="pr_no" name="pr_no" value=""/><br>

                {!! csrf_field() !!}
                <div class="row g-3">
                    <div class="form-group col-md-4">
                        <label for="grn_code" class="form-label fw-bold">Grn Code<a style="text-decoration: none;color:red">*</a></label>
                        <input type="text" id="grn_code" name="grn_code"  value="{{ old('grn_code') }}"  placeholder="GRN Code" class="form-control" autocomplete="off">
                        <input type="text" id="grn_no" name="grn_no" hidden value="{{ old('grn_no') }}"  class="form-control" autocomplete="off">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="name" class="form-label fw-bold">Supplier Name<a style="text-decoration: none;color:red">*</a></label>
                        <input type="text" id="name" readonly name="name" value="{{ old('name') }}" placeholder="Supplier Name" class="form-control" autocomplete="off">
                        <input type="text" id="supplier_no" hidden  name="supplier_no"  value="{{ old('supplier_no') }}"  class="form-control" autocomplete="off">

                    </div>
                    <div class="form-group col-md-4">
                        <label for="project_name" class="form-label fw-bold">Project Name<a style="text-decoration: none;color:red">*</a></label>
                        <input type="text" id="project_name" readonly name="project_name"  value="{{ old('project_name') }}" placeholder="Project Name" class="form-control" autocomplete="off">
                        <input type="text" id="project_no" name="project_no" hidden value="{{ old('project_no') }}"  class="form-control" autocomplete="off">


                    </div>
                    <div class="form-group col-md-4">
                        <label for="project_code" class="form-label fw-bold">Project Code</label>
                        <input type="text" id="project_code" readonly  name="project_code" value="{{ old('project_code') }}" readonly placeholder="Project Code" class="form-control" autocomplete="off">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="pr_purchase_type" class="form-label fw-bold">Purchase Type<a style="text-decoration: none;color:red">*</a></label>
                        <select id="pr_purchase_type" name="pr_purchase_type" class="form-control" autocomplete="off">
                            <option value="">Select Option</option>
                            @foreach($grn_purchase_type as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="currency" class="form-label fw-bold">Currency</label>
                        <select id="currency" name="currency" class="form-control form-select" autocomplete="off">
                            <option value="">Select Option</option>
                            @foreach ($currency as $key => $value)
                                <option value="{{ $key }}"{{ $key == 'AED' ? ' selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>

                    </div>
                    <div class="form-group col-md-4">
                        <label for="invoice_no" class="form-label fw-bold">Invoice No</label>
                        <input type="text" id="invoice_no" name="invoice_no"  value="{{ old('invoice_no') }}" placeholder="Invoice No" class="form-control" autocomplete="off">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="date" class="form-label fw-bold">Grn Date<a style="text-decoration: none;color:red">*</a></label>
                        <input type="text" readonly id="grn_date" name="grn_date"  value="{{ old('grn_date') }}" placeholder="Grn Date" class="form-control" autocomplete="off">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="date" class="form-label fw-bold">Date<a style="text-decoration: none;color:red">*</a></label>
                        <input type="date" id="date" name="date"  value="{{ old('date') }}" placeholder="Purchase Date" class="form-control" autocomplete="off">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="pr_code" id="lable_pr_code" class="form-label fw-bold">Purchase Return Code</label>
                        <input type="text" id="pr_code" readonly  name="pr_code" value="{{ old('pr_code') }}" class="form-control" autocomplete="off">
                    </div>
                </div>
                <div class="container pt-4">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="register">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th style="width:15%">Item Name</th>
                                    <th hidden>item_id</th>
                                    <th >Pack Specification</th>
                                    <th>Qty</th>
                                    <th>Received Qty</th>
                                    <th>Return Qty</th>
                                    <th>Rate per Qty</th>
                                    <th>Total</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody id="tbody1">
                            </tbody>
                        </table>
                    </div>
                    <br>
                    {{-- <div style="margin-top:8px">
                        <button class="btn btn-md btn-primary" id="addBtn" type="button">
                            Add Row
                        </button>
                    </div> --}}
                </div>
                <br>
                <div class="row" style="margin-top:8px">
                    <div class="col-md-2">
                        <label for="vat" class="float-end my-3">VAT Amount</label><br>
                        <label for="return_amount" class="float-end my-3">Total Return Amount</label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="vat_amount" id="vat_amount"  class="form-control mb-2"><br>
                        <input type="text" name="return_amount" id="return_amount" class="form-control mb-2">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="form-group col-md-12">
                        <center>
                            <button id="submit" class="btn btn-primary mx-3 mt-3">Save</button>
                        </center>
                    </div>
                </div>
            </form>
                <!-- SHOW DIALOG -->
            <div class="card" id="show" style="display:none">
                <div class="card-body" style="background-color:white;width:100%;height:20%;" >

                    <div class="row">
                        <div class="col-md-3">
                            <label>GRN Code</label>
                            <p id="show_grn_code"></p>
                        </div>
                        <div class="col-md-3">
                            <label>Supplier Name</label>
                            <p id="show_name"></p>
                        </div>
                        <div class="col-md-3">
                            <label>Project Name</label>
                            <p id="show_project_name"></p>
                        </div>
                        <div class="col-md-3">
                            <label>Project Code</label>
                            <p id="show_project_code"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label>Purchase type</label>
                            <p id="show_pr_purchase_type"></p>
                        </div>
                        <div class="col-md-3">
                            <label>Purchase Return Code</label>
                            <p id="show_pr_code"></p>
                        </div>
                        <div class="col-md-3">
                            <label>Date</label>
                            <p id="show_date"></p>
                        </div>
                        <div class="col-md-3">
                            <label>GRN Date</label>
                            <p id="show_grn_date"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label>Invoice No</label>
                            <p id="show_invoice_no"></p>
                        </div>
                        <div class="col-md-3">
                            <label>Currency</label>
                            <p id="show_currency"></p>
                        </div>
                        <div class="col-md-3">
                            <label>Vat Amount</label>
                            <p id="show_vat_amount"></p>
                        </div>
                        <div class="col-md-3">
                            <label>Total Return Amount</label>
                            <p id="show_return_amount"></p>
                        </div>
                    </div>

                    <div id="item_detail_show"></div>

                </div>
            </div>
        </dialog>

<script>
    // $('#addBtn').on('click', function ()
    // {
    //     add_text();
    // });

    // add dynamic row
    var rowIdx = 1;

    function add_text()
    {
        var html = '';
        html += '<tr id="row' + rowIdx + '" class="rowtr">';
        html += '<td>' + rowIdx + '</td>';
        html += '<td><div class="col-xs-12" ><input type="text"  id="item_name_' +rowIdx+'"  name="item_name[]" class="item_name form-control" placeholder="Item name"></div></td>';
        html += '<td hidden ><div class="col-xs-12"><input type="text"  id="item_no_'+rowIdx+'"  name="item_no[]" class="item_no_'+rowIdx+'"></div></td>';
        html += '<td><div class="col-xs-12"><input type="text" id="pack_specification_'+rowIdx+'"  name="pack_specification[]" class="pack_specification form-control"></div></td>';
        html += '<td><div class="col-xs-12"><input type="text" id="quantity_'+rowIdx+'" name="quantity[]" class="quantity form-control"></div></td>';
        html += '<td><div class="col-xs-12"><input type="text" id="receiving_qty_'+rowIdx+'" name="receiving_qty[]" class="receiving_qty form-control"></div></td>';
        html += '<td><div class="col-xs-12"><input type="text" id="return_qty_'+rowIdx+'" name="return_qty[]" class="return_qty form-control"></div></td>';
        html += '<td><div class="col-xs-12"><input type="text" id="rate_per_qty_'+rowIdx+'"  name="rate_per_qty[]"class="rate_per_qty form-control"></div></td>';
        html += '<td><div class="col-xs-12"><input type="text"  id="item_amount_'+rowIdx+'"name="item_amount[]" class="item_amount form-control"></div></td>';
        html += '<td><button class="btn btn-danger remove  btn-sm" id="delete" type="button"><i class="fa fa-trash"></i></button></td>';
        html += '</tr>';
        $("#tbody1").append(html);

        rowIdx++;
    }




    // dialog open
    function handleDialog()
    {
        document.getElementById("myDialog").open = true;
        window.scrollTo(0, 0);
        // add_text();

        $('#method').val("ADD");
        $('#submit').text("Save");
        $('#heading_name').text("Add Purchase Return Details").css('font-weight', 'bold');
        $("#lable_pr_code").hide();
        $("#pr_code").hide();
        $('#show').css('display','none');
        $('#form').css('display','block');
        $('#blur-background').css('display','block');
    }
    // dialogclose
    function handleClose()
    {
        document.getElementById("myDialog").open = false;
        $("#myDialog").load(" #myDialog > *");
        rowIdx=1;
        $('#blur-background').css('display','none');
        // window.location.reload();
    }

          // DELETE FUNCTION
    function handleDelete(id)
    {
        let url = '{{route('prApi.delete',":id")}}';
        url= url.replace(':id',id);
        if (confirm("Are you sure you want to delete this purchase Return Details?"))
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
    // DIALOG SUBMIT FOR ADD AND EDIT

    function handleSubmit()
    {
        event.preventDefault();
        let form_data = new FormData(document.getElementById('form'));
        let method = $('#method').val();
        let url;
        let type;
        if (method == 'ADD') {
            url = '{{ route('prApi.store') }}';
            type = 'POST';
        } else {
            let id = $('#pr_no').val();
            url = '{{ route('prApi.update', ":id") }}';
            url = url.replace(':id', id);
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
            },
            error: function (message)
            {
                var data = message.responseJSON;

            }
        });

    }


    //DATA SHOW FOR EDIT AND SHOW
    function handleShowAndEdit(id,action)
    {
        let url = "{{ route('prApi.show', ':pr_no') }}";
        url = url.replace(':pr_no',id);
        let type= "GET"
        console.log(id);
        $.ajax(
        {
            url: url,
            type: type,
            contentType: false,
            cache: false,
            processData: false,
            success: function(message)
            {
                console.log(message.pr);
                console.log(message.pr_item);
                if (action == 'edit')
                {
                    $('#show').css('display', 'none');
                    $('#form').css('display', 'block');
                    $('#blur-background').css('display','block');
                    for (const [key, value] of Object.entries(message.pr[0]))
                    {
                        //   console.log(`${key}: ${value}`);
                        $(`#${key}`).val(value);
                    }

                    var create_id=1;

                    for (const item of message.pr_item)
                        {
                            add_text();
                            $('#item_name_' + create_id).val(item.item_name);
                            $('#item_no_' + create_id).val(item.item_no);
                            $('#pack_specification_'+ create_id).val(item.pack_specification);
                            $('#quantity_'+create_id).val(item.quantity);
                            $('#receiving_qty_'+create_id).val(item.receiving_qty);
                            $('#return_qty_'+create_id).val(item.return_qty);
                            $('#rate_per_qty_'+create_id).val(item.rate_per_qty);
                            $('#item_amount_'+create_id).val(item.item_amount);
                            create_id++;
                        }
                    $('#method').val('UPDATE');
                    $('#submit').text('UPDATE');

                }

                else {

                    for (const [key, value] of Object.entries(message.pr[0]))
                    {
                        if (key === "grn_date" || key === "date")
                        {
                            var dateObj = new Date(value);
                            var day = dateObj.getDate();
                            var month = dateObj.getMonth() + 1;
                            var year = dateObj.getFullYear();
                            datepr= day + '-' + month + '-' + year

                        }
                        console.log(`${key}: ${value}`);
                        $(`#show_${key}`).text(value);

                    }
                    let script =
                        '<table id="show_table" class="table table-striped"><thead><tr><th>Item Name</th><th>Pack Specification</th><th>Qty</th><th>Received Qty</th><th>Return Qty</th><th>Rate per Qty</th><th>Total</th></tr></thead><tbody>';
                    for (const item of message.pr_item) {
                        script += '<tr>';
                        script += '<td>' + item.item_name + '</td>';
                        script += '<td>' + item.pack_specification + '</td>';
                        script += '<td>' + item.quantity + '</td>';
                        script += '<td>' + item.receiving_qty+ '</td>';
                        script += '<td>' + item.return_qty +'</td>';
                        script += '<td>' + item.rate_per_qty + '</td>';
                        script += '<td >' + item.item_amount + '</td>';

                        script += '</tr>';
                    }
                     script += '</tbody></table>';
                    $('#show_table').remove();
                    $('#item_detail_show').append(script);
                    $('#heading_name').text("View Purchase Return Details").css('font-weight', 'bold');
                    $('#show').css('display', 'block');
                    $('#form').css('display', 'none');
                    $('#blur-background').css('display','block');
                }
                 document.getElementById("myDialog").open = true;
                 window.scrollTo(0, 0);
            },
        })
    }

   // GRN auto complete
//    jQuery($ =>
//     {
//         $(document).on('focus', 'input',  "#grn_code", function()
//         {
//             $("#grn_code").autocomplete(
//             {
//                 source: function(request, response)
//                 {
//                     $.ajax({
//                     type: "GET",
//                     url: "{{ route('get_grn_details') }}",
//                     dataType: "json",
//                     data: {
//                         'grn_code':$('#grn_code').val()
//                     },
//                     success: function(data) {
//                         result = [];
//                         for (var i in data) {
//                         result.push(data[i]["grn_code"]);
//                         }
//                         response(result);
//                     },
//                     fail: function(xhr, textStatus, errorThrown) {
//                         alert(errorThrown);
//                     }
//                     });
//                 },
//             });
//         });
//     });
    $("#grn_code").on('change',function()
    {
        $('.rowtr').remove();

        $.ajax
        ({
            type:"GET",
            url: "{{ route('get_grn_details') }}",
            dataType: "json",
            data:
            {
                'grn_code':$('#grn_code').val()
            },
            success: function( data )
            {
                console.log(data);
                result = [];
                var dateParts = data.grn_date.split(' ')[0].split('-');
                var formattedDate = dateParts[2] + '-' + dateParts[1] + '-' + dateParts[0];

                $('#grn_date').val(formattedDate);
                $('#grn_code').val(data.grn_code);
                $('#grn_no').val(data.grn_no);
                $('#name').val(data.name);
                $('#supplier_no').val(data.supplier_no);
                $('#project_name').val(data.project_name);
                $('#project_no').val(data.project_no);
                $('#project_code').val(data.project_code);
                $('#pr_purchase_type').val(data.grn_purchase_type);
                //$('#grn_date').val(data.grn_date.split(' ')[0]);

                var create_id=1;
                for (const item of data.grn_items)
                {
                    add_text();
                    $('#item_name_' + create_id).val(item.item_name);
                    $('#item_no_' + create_id).val(item.item_no);
                    $('#pack_specification_'+ create_id).val(item.pack_specification);
                    $('#quantity_'+create_id).val(item.quantity);
                    $('#receiving_qty_'+create_id).val(item.receiving_qty);
                    $('#rate_per_qty_'+create_id).val(item.rate_per_qty);
                    $('#item_amount_'+create_id).val(item.item_amount);
                    create_id++;
                }
                rowIdx=1;
            },fail: function(xhr, textStatus, errorThrown)
            {
                alert(errorThrown);
            }
        });
    });


</script>

@stop