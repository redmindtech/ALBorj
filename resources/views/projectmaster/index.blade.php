@extends('adminlte::page')

@section('plugins.Datatables', true)

@section('title', 'Client Master')

@section('content_header')
@stop

@section('content')
    <div class="container-fluid">
        <div class="col-md-12 mx-auto">
            <div class="container-fluid">
                {{-- <div class="col-md-6 mx-auto">
                    @include('layouts.alert')
                </div> --}}
            </div>
            <div class="row">
                <div class="container-fluid">
                    <div class="card shadow">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h4 class="font-weight-bold text-dark py">PROJECT MASTER</h4>
                                <div style="width:120px">
                                    <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#myModal2">Add</button>
                                </div>
                            </div>
                        </div>
                            @include('projectmaster.create')
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <table id="myTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Site Name</th>
                                            <th>Project Name</th>
                                            <th>Project Type</th>
                                            <th>Show</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($projects as $key => $project)
                                                <td>{{$project->site_name}}</td>
                                                <td>{{$project->project_name}}</td>
                                                <td>{{$project->project_type}}</td>
                                                <td>
                                                    <a href="{{route("projectmaster.show",$project->project_no)}}"
                                                        class="btn btn-primary btn-circle btn-sm"  data-toggle="modal" data-target="#view_projectmaster_{{$project->project_no}}" >
                                                        <i class="fas fa-flag"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{route("projectmaster.edit",$project->project_no)}}"
                                                        class="btn btn-info btn-circle btn-sm mx-2 edit" data-toggle="modal" id="{{$project->project_no}}" data-target="#edit_projectmaster">
                                                        <i class="fas fa-check"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <form method="POST" action="{{route('projectmaster.destroy',$project->project_no)}}" accept-charset="UTF-8" style="display:inline">
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

@include('projectmaster.edit')






{{-- View Client Master --}}
 @foreach ($projects as $project)
    <div class="modal fade" id="view_projectmaster_{{$project->project_no}}">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title"><b>View Project</b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-striped" >
                        <tr>
                            <th>Site Number</th>
                            <td>{{$project->site_no}}</td>
                        </tr>
                        <tr>
                            <th>Site Name</th>
                            <td>{{$project->site_name}}</td>
                        </tr>
                        <tr>
                            <th>Project Number</th>
                            <td>{{$project->project_no}}</td>
                        </tr>
                        <tr>
                            <th>Project Name</th>
                            <td>{{$project->project_name}}</td>
                        </tr>
                        <tr>
                            <th>Project Type</th>
                            <td>{{$project->project_type}}</td>
                        </tr>
                        <tr>
                            <th>Manager Name</th>
                            <td>{{$project->manager_name}}</td>
                        </tr>
                        <tr>
                            <th>Manager Contact Number</th>
                            <td>{{$project->manager_contact_number}}</td>
                        </tr>
                        <tr>
                            <th>Client / Company Name</th>
                            <td>{{$project->company_name}}</td>
                        </tr>
                        <tr>
                            <th>Client Contact Name</th>
                            <td>{{$project->client_contact_name}}</td>
                        </tr>
                        <tr>
                            <th>Client Contact Number</th>
                            <td>{{$project->client_contact_number}}</td>
                        </tr>
                        <tr>
                            <th>Consultant Name</th>
                            <td>{{$project->consultant_name}}</td>
                        </tr>
                        <tr>
                            <th>Start Date</th>
                            <td>{{$project->start_date}}</td>
                        </tr>
                        <tr>
                            <th>Tentative End Date</th>
                            <td>{{$project->end_date}}</td>
                        </tr>
                        <tr>
                            <th>Actual Project End Date</th>
                            <td>{{$project->actual_project_end_date}}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>{{$project->status}}</td>
                        </tr>
                        <tr>
                            <th>Total Cost</th>
                            <td>{{$project->total_price_cost}}</td>
                        </tr>
                        <tr>
                            <th>Advanced Amount</th>
                            <td>{{$project->advanced_amount}}</td>
                        </tr>
                        <tr>
                            <th>Retention</th>
                            <td>{{$project->retention}}</td>
                        </tr>
                        <tr>
                            <th>Balance Amount To Received</th>
                            <td>{{$project->amount_to_be_received}}</td>
                        </tr>
                        <tr>
                            <th>Amount Return</th>
                            <td>{{$project->amount_return}}</td>
                        </tr>
                        <tr>
                            <th>Amount Return Date</th>
                            <td>{{$project->amount_return_date}}</td>
                        </tr>
                        <tr>
                            <th>Amount Return Comments</th>
                            <td>{{$project->amount_returns_comment}}</td>
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
@stop
