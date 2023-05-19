<!-- STYLE INCLUDED IN LAYOUT PAGE -->
@extends('layouts.app',[
    'activeName' => 'item'
])
@section('title', 'Item Master')

@section('content_header')
@stop

@section('content')
    <!-- DATA table -->
    <div class="row">
        <div class="container-fluid">
            <div class="card shadow">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h4 class="font-weight-bold text-dark py">ITEM MASTER</h4>
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
                                     <th>S.No</th>
                                    <!-- <th>Item ID</th> -->
                                    <th>Item Name</th>
                                    <th>Item Category</th>
                                    <th>Item Subcategory</th>
                                    <th>Item Type</th>
                                    <th>Item Quentity</th>
                                    <th data-orderable="false" class="action notexport">Show</th>
                                    <th data-orderable="false" class="action notexport">Edit</th>
                                    <th data-orderable="false" class="action notexport">Delete</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as $key => $item)
                                        <tr class="text-center">
                                            <td>{{$key+=1}}</td>
                                             {{-- <td>{{$item->id}}</td> --}}
                                            <td>{{$item->item_name}}<div id="blur-background" class="blur-background"></div></td>
                                            <td>{{$item->item_category}}</td>
                                            <td>{{$item->item_subcategory}}</td>

                                            <td>{{$item->item_type}}</td>
                                            <td>{{$item->total_quantity}}</td>

                                            <td>
                                                <a  onclick="handleShowAndEdit('{{$item->id}}','show')"
                                                    class="btn btn-primary btn-circle btn-sm"   >
                                                    <i class="fas fa-flag"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <a onclick="handleShowAndEdit('{{$item->id}}','edit')"
                                                    class="btn btn-info btn-circle btn-sm mx-2" >
                                                    <i class="fas fa-check"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <button  type="submit" class="btn btn-sm btn-danger" onclick="handleDelete('{{$item->id}}')">
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
                <dialog id="myDialog"  style="width:1000px;" >
                    <div class="row">
                        <div class="col-md-12">
                            <a class="btn  btn-sm" onclick="handleClose()" style="float:right;padding: 10px 10px;">
                                <i class="fas fa-close"></i>
                            </a>
                            <h4  id='heading_name' style='color:white' align="center"><b>Update Item </b></h4>
                        </div>
                    </div>
                    <form  class="form-row"  enctype="multipart/form-data" style="display:block" id="form" onsubmit="handleSubmit()">
                        <input type="hidden" id="method" value="ADD"/>
                        <input type="hidden" id="id" name="id" value=""/><br>

                        {!! csrf_field() !!}
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="item_name" class="form-label fw-bold">Item Name<a style="text-decoration: none;color:red">*</a></label>
                                <input type="text" id="item_name"  name="item_name" value="{{ old('item_name') }}" placeholder="Item Name" class="form-control" autocomplete="off">
                                <p style="color: red" id="error_item_name"></p>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="item_category" class="form-label fw-bold">Item category<a style="text-decoration: none;color:red">*</a></label>
                                <select id="item_category" name="item_category" class="form-control" autocomplete="off" onchange="itemcategory_load()">
                                <option value="">Select Option</option>
                                @foreach($item_category as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                </select>
                                <p style="color: red" id="error_item_category"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="item_subcategory" class="form-label fw-bold">Item Sub category<a style="text-decoration: none;color:red">*</a></label>
                                <select id="item_subcategory" name="item_subcategory" class="form-control" autocomplete="off"></select>
                                <p style="color: red" id="error_item_subcategory"></p>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="stock_type" class="form-label fw-bold">Stock Type<a style="text-decoration: none;color:red">*</a></label>
                                <select id="stock_type" name="stock_type" class="form-control" autocomplete="off">
                                    <option value="">Select Option</option>
                                    @foreach($stock_type as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                <p style="color: red" id="error_stock_type"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="item_type" class="form-label fw-bold">Item Type<a style="text-decoration: none;color:red">*</a></label>
                                <select id="item_type" name="item_type" class="form-control" autocomplete="off">
                                    <option value="">Select Option</option>
                                    @foreach($item_type as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                <p style="color: red" id="error_item_type"></p>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="name" class="form-label fw-bold">Item Quantity<a style="text-decoration: none;color:red">*</a></label>
                                <input type="text" id="total_quantity	" name="total_quantity"  value="{{ old('total_quantity	') }}" placeholder="Item Quantity" class="form-control" autocomplete="off">
                                <p style="color: red" id="error_total_quantity	"></p>
                            </div>
                        </div>
                        <div class="row">
                        <div class="form-group col-md-6">
                                <label for="name" class="form-label fw-bold">Supplier Name<a style="text-decoration: none;color:red">*</a></label>
                                <input type="text" id="name" name="name"  value="{{ old('name') }}" placeholder="Supplier Name" class="form-control" autocomplete="off">
                                <input type="text" id="supplier_no" name="supplier_no" hidden value="{{ old('supplier_no') }}" placeholder="Supplier Id" class="form-control" autocomplete="off" >
                                <p style="color: red" id="error_name"></p>
                            </div>
                            <div class="form-group col-md-6" >
                                <label for="supplier_code" class="form-label fw-bold">Supplier Code</label>
                                <input type="text" id="code" name="code"  value="{{ old('code') }}" placeholder="Supplier code" class="form-control" autocomplete="off" readonly>
                                <p style="color: red" id="error_code"></p>
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
                            <div class="col-md-6">
                                <label>Item Name</label>
                                <p id="show_item_name"></p>
                            </div>
                            <div class="col-md-6">
                                <label>Item category</label>
                                <p id="show_item_category"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Item Subcategory</label>
                                <p id="show_item_subcategory"></p>
                            </div>
                            <div class="col-md-6">
                                <label>Stock Type</label>
                                <p id="show_stock_type"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Item Type</label>
                                <p id="show_item_type"></p>
                            </div>
                                <div class="col-md-6">
                                <label>Item Quantity</label>
                                <p id="show_total_quantity"></p>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-md-6">
                                <label>Supplier Code</label>
                                <p id="show_supplier_no"></p>
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
        $('#method').val("ADD");
        $('#submit').text("ADD");
        $('#heading_name').text("Add Item").css('font-weight', 'bold');
        $('#supplier_id').hide();
        $('#show').css('display','none');
        $('#form').css('display','block');
        $('#blur-background').css('display','block');
        $('#item_qty').val('0');
        itemcategory_load();
          }
    // DELETE FUNCTION
    function handleDelete(id)
    {
        let url = '{{route('itemApi.delete',":id")}}';
        url= url.replace(':id',id);
        if (confirm("Are you sure you want to delete this item?"))
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
        // $("#myDialog").load(" #myDialog > *");
        //      rowIdx=1;
        //      $('#blur-background').css('display','none');
        window.location.reload();
    }
    // DIALOG SUBMIT FOR ADD AND EDIT
    function handleSubmit()
    {
        event.preventDefault();
        let form_data = new FormData(document.getElementById('form'));
        let method = $('#method').val();
        let url;
        let type;
        if(method == 'ADD')
        {
            url = '{{route('store')}}';
            type  = 'POST';
        }
        else
        {
            let id = $('#id').val();
            url = '{{route('itemApi.update',":id")}}';
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
                $.each(data.errors, function (key, val)
                {
                    $(`#error_${key}`).html(val[0]);
                })
            }
        })
    }

    //DATA SHOW FOR EDIT AND SHOW
    function handleShowAndEdit(id,action)
    {
        let url = '{{route('itemApi.show',":id")}}';
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
                    $('#show').css('display','none');
                    $('#form').css('display','block');
                    $('#blur-background').css('display','block');

                    $("#item_category").val(message[0].item_category).attr("selected","selected");
                    itemcategory_load();
                    $("#item_subcategory").val(message[0].item_subcategory).attr("selected","selected");
                    for (const [key, value] of Object.entries(message[0]))
                    {
                        $(`#${key}`).val(value);

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
                    $('#blur-background').css('display','block');

                }
                document.getElementById("myDialog").open = true;

            },
        })
    }
</script>

{{--Autocomplete --}}
<script>
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


    function itemcategory_load()
    {
        var selectedCategory = $('#item_category').val();
        console.log($('#item_category').val());
        var subcategoryOptions = '';
        if (selectedCategory === 'Electrical Works')
        {
            @foreach(ITEMSUBCATEGORY['Electrical Items'] as $key => $value)
                subcategoryOptions += '<option value="{{ $key }}">{{ $value }}</option>';
            @endforeach
        } else if (selectedCategory === 'Plumbing Works')
        {
            @foreach(ITEMSUBCATEGORY['Plumbing Items'] as $key => $value)
                subcategoryOptions += '<option value="{{ $key }}">{{ $value }}</option>';
            @endforeach
        }
        $('#item_subcategory').html('<option value="" class="default-option">Select Option</option>'+ subcategoryOptions);
    }
</script>



@stop
