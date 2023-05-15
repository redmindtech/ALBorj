<!-- STYLE INCLUDED IN LAYOUT PAGE -->
@extends('layouts.app',[
    'activeName' => 'client'
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
                                            <th>Name</th>
                                            <th>Company Name</th>
                                            <th>Contact Number</th>
                                            <!-- <th>Address</th> -->
                                            <th data-orderable="false" class="action notexport">Show</th>
                                            <th data-orderable="false" class="action notexport">Edit</th>
                                            <th data-orderable="false" class="action notexport">Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($clients as $key => $client)
                                            <tr class="text-center">
                                                {{-- <td>{{$key+=1}}</td> --}}
                                                <!-- <td>{{$client->client_no}}</td> -->
                                                <td>{{$client->client_code}}</td>
                                                <td>{{$client->name}}</td>
                                                <td>{{$client->company_name}}</td>
                                                <td>{{$client->contact_number}}</td>
                                                <!-- <td>{{$client->address}}</td> -->
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
                                                    {{-- <form id="{{$supplier->supplier_no}}" action="{{route("suppliermaster.destroy",$supplier->supplier_no)}}" method="post">
                                                        @csrf
                                                        @method("DELETE")
                                                    </form> --}}
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
                    <dialog id="myDialog"  style="width:1000px;">
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
                                    <p style="color: red" id="error_name"></p>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="company_name" class="form-label fw-bold">Company Name<a style="text-decoration: none;color:red">*</a></label>
                                    <input type="text" id="company_name" name="company_name" value="{{ old('company_name') }}" placeholder="Company Name" class="form-control" autocomplete="off">
                                    <p style="color: red" id="error_company_name"></p>
                                </div>
                            </div>
                            <div class="row">
                            <div class="form-group col-md-6">
                                    <label for="contact_number" class="form-label fw-bold">Contact Number<a style="text-decoration: none;color:red">*</a></label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">{{+971}}</span>
                                        <!-- </div> -->
                                        <input type="text" id="contact_number" name="contact_number" value="{{ old('contact_number') }}" maxlength="10" placeholder="Contact Number" class="form-control" autocomplete="off">
                                    </div>
                                    <p style="color: red" id="error_contact_number"></p>
                                </div>                                <div class="form-group col-md-6">
                                    <label for="address" class="form-label fw-bold">Address<a style="text-decoration: none;color:red">*</a></label>
                                    <input type="text" id="address" name="address" value="{{ old('address') }}" placeholder="Address" class="form-control" autocomplete="off">
                                    <p style="color: red" id="error_address"></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="website" class="form-label fw-bold">Website<a style="text-decoration: none;color:red">*</a></label>
                                    <input type="url" id="website" name="website" value="{{ old('website') }}" placeholder="Website" class="form-control" autocomplete="off">
                                    <p style="color: red" id="error_website"></p>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="client_code" id="code_lable"class="form-label fw-bold">Client Code<a style="text-decoration: none;color:red">*</a></label>
                                    <input type="text" id="client_code" name="client_code" readonly value="{{ old('client_code') }}" placeholder="Client Code" class="form-control" autocomplete="off">
                                    <p style="color: red" id="error_code"></p>
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
            $('#method').val("ADD");
            $('#submit').text("ADD");
            $('#heading_name').text("Add Client").css('font-weight', 'bold');
            $('#client_code').hide();
            $('#code_lable').hide();
            $('#show').css('display','none');
            $('#form').css('display','block');
        }
// DELETE FUNCTION
        function handleDelete(id)
        {
            let url = '{{route('clientApi.delete',":id")}}';
            url= url.replace(':id',id);
            if (confirm("Are you sure you want to delete this client?"))
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
                $.each(data.errors, function (key, val)
                {
                    console.log(key,val);
                    $(`#error_${key}`).html(val[0]);
                })
            }
        })
    }
//DATA SHOW FOR EDIT AND SHOW
    function handleShowAndEdit(id,action)
    {
        // alert('')
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
                    $('#show').css('display','none');
                    $('#form').css('display','block');
                    for (const [key, value] of Object.entries(message))
                    {
                        console.log(`${key}: ${value}`);
                        $(`#${key}`).val(value);
                    }
                    $('#method').val('UPDATE');
                    $('#submit').text('UPDATE');
                }
                else
                {

                    for (const [key, value] of Object.entries(message))
                    {
                        $(`#show_${key}`).text(value);
                    }
                    $('#heading_name').text("View Supplier").css('font-weight', 'bold');
                    $('#show').css('display','block');
                    $('#form').css('display','none');
                }
                document.getElementById("myDialog").open = true;

            },
        })
    }
</script>
@stop