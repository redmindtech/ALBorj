@extends('adminlte::page')

@section('plugins.Datatables', true)

@section('title', 'Client Master')

@section('content_header')
@stop

@section('content')
    <div class="container-fluid">
        <div class="col-md-12 mx-auto">
            <div class="row">
                <div class="container-fluid">
                    <div class="card shadow">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h4 class="font-weight-bold text-dark py">Client MASTER</h4>
                                <div style="width:120px">
                                    <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#myModal1">Add</button>
                                </div>
                            </div>
                        </div>
                        @include('clientmaster.create')
                        <div class="card">
                            <div class="card-body">
                                <table id="myTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th hidden>Id</th>
                                            <th>Client No</th>
                                            <th>Name</th>
                                            <th>Company Name</th>
                                            <th>Contact Number</th>
                                            <th>Address</th>
                                            <th>Show</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($clients as $key => $client)
                                                <td hidden>{{$client->client_no}}</td>
                                                <td>{{"CM0".$client->client_no}}</td>
                                                <td>{{$client->name}}</td>
                                                <td>{{$client->company_name}}</td>
                                                <td>{{$client->contact_number}}</td>
                                                <td>{{$client->address}}</td>
                                                <td>
                                                    <a href="{{route("clientmaster.show",$client->client_no)}}"
                                                        class="btn btn-primary btn-circle btn-sm"  data-toggle="modal" data-target="#view_clientmaster_{{$client->client_no}}" >
                                                        <i class="fas fa-flag"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{route("clientmaster.edit",$client->client_no)}}"
                                                        class="btn btn-info btn-circle btn-sm mx-2 edit" data-toggle="modal" id="{{$client->client_no}}" data-target="#edit_clientmaster">
                                                        <i class="fas fa-check"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <form method="POST" action="{{route('clientmaster.destroy',$client->client_no)}}" accept-charset="UTF-8" style="display:inline">
                                                        {{ method_field('DELETE') }}
                                                        {{ csrf_field() }}
                                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete data" onclick="return confirm(&quot;Confirm delete?&quot;)">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
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
        </div>
    </div>
{{-- Edit client master --}}

@include('clientmaster.edit')






{{-- View Client Master --}}
@foreach ($clients as $client)
    <div class="modal fade" id="view_clientmaster_{{$client->client_no}}">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title"><b>View Client</b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-striped" >

                        <tr>
                            <th>Client Number</th>
                            <td>{{'CM0'.$client->client_no}}</td>
                        </tr>

                        <tr>
                            <th>Name</th>
                            <td>{{$client->name}}</td>
                        </tr>
                        <tr>
                            <th>Company Name</th>
                            <td>{{$client->company_name}}</td>
                        </tr>
                        <tr>
                            <th>Contact Number</th>
                            <td>{{$client->contact_number}}</td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td>{{$client->address}}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endforeach

@stop


@section('css')

@stop

@section('js')
{{--Datatable search bar and export button code here--}}

<script>
    $("#myTable").DataTable(
    {
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons":
        [
            {
                extend: 'collection',
                text: '<i class="fa fa-file-export" aria-hidden="true"></i>',
                buttons: [ 'csv', 'excel', 'pdf',]

            },
            {
                extend: 'collection',
                text: '<i class="fa fa-print" aria-hidden="true"></i>',
                buttons: 'print',
            },
        ]
    }).buttons().container().appendTo('#myTable_wrapper .col-md-6:eq(0)');
    $('#myTable1').DataTable(
    {
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
    });
</script>

{{--Delete Button Sweet Alert Code here--}}
    @if(session()->has("success"))
        <script>
            Swal.fire
            ({
                position: 'top-end',
                icon: 'success',
                title: "{{session()->get('success')}}",
                showConfirmButton: false,
                timer: 3500
            });
        </script>
    @endif
    <script>
        function deleteAd(id)
        {
            const swalWithBootstrapButtons = Swal.mixin
            ({
                customClass:
                {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger mr-2'
                },
                buttonsStyling: false
            })
            swalWithBootstrapButtons.fire
            ({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) =>
            {
                if (result.isConfirmed)
                {
                    document.getElementById(id).submit();
                }
                else if ( result.dismiss === Swal.DismissReason.cancel)  /* Read more about handling dismissals below */
                {
                    swalWithBootstrapButtons.fire
                    (
                        'Cancelled',
                        'Your data was not deleted..',
                        'error'
                    )
                }
            })
        }
    </script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
    $(document).ready(function()
    {
        $('#add_button').prop('disabled', true);

        $("#name").focusout(function()
        {
            var name_reg=/^[a-zA-Z ]+$/;

            if($(this).val()== '')
            {
                document.getElementById("c1").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#add_button').prop('disabled',true);
            }
            else if(name_reg.test($(this).val()) == true)
            {
                document.getElementById("c1").innerHTML="";
                $('#add_button').prop('disabled',false);
            }
            else if(name_reg.test($(this).val()) == false)
            {
                document.getElementById("c1").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('#add_button').prop('disabled',true);
            }
        });
        $("#company_name").focusout(function()
        {
            var name_reg=/^[a-zA-Z ]+$/;

            if($(this).val()== '')
            {
                document.getElementById("c2").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#add_button').prop('disabled',true);
            }
            else if(name_reg.test($(this).val()) == true)
            {
                document.getElementById("c2").innerHTML="";
                $('#add_button').prop('disabled',false);
            }
            else if(name_reg.test($(this).val()) == false)
            {
                document.getElementById("c2").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('#add_button').prop('disabled',true);
            }
        });
        $("#contact_number").focusout(function()
        {
            var re=/^[6789]\d{9}$/;

            if($(this).val()== '')
            {
                document.getElementById("c3").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#add_button').prop('disabled',true);
            }
            else if(re.test($(this).val()) == true)
            {
                document.getElementById("c3").innerHTML="";
                $('#add_button').prop('disabled',false);
            }
            else if(re.test($(this).val()) == false)
            {
                document.getElementById("c3").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
                $('#add_button').prop('disabled',true);
            }
        });
        $("#address").focusout(function()
        {
            if($(this).val()== '')
            {
                document.getElementById("c4").innerHTML="<span class='text-danger m-2'>This field is required</span>";
                $('#add_button').prop('disabled',true);
            }
            else if(re.test($(this).val()) != '')
            {
                document.getElementById("c4").innerHTML="";
                $('#add_button').prop('disabled',false);
            }
        });

    });

</script>
@stop
