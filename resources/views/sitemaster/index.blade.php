@extends('adminlte::page')

@section('plugins.Datatables', true)

@section('title', 'Site Master')

@section('content_header')
@stop


@section('content')
<div class="container-fluid">
        <div class="col-md-12 mx-auto">
            <div class="container-fluid">
                <div class="col-md-6 mx-auto">
                    @include('layouts.alert')
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-left text-dark font-weight-bold" style="margin-top: 5px">SITE MASTER</h4>
                </div>

                <div class="col-md-6" style="margin-top: 5px; width:120px;" >
                    <button type="button" class="btn btn-primary btn-lg float-right bg-gradient " data-toggle="modal" data-target="#myModal1">Add</button>
                </div>
            </div>
  @include('sitemaster.create')

<div class="card my-3">
    <div class="card-body">
        <table id="myTable" class="table table-bordered table-striped">
            <thead>
                <tr>

                    <th>Site No</th>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>view</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datas as $value)
                    <tr>

                        <td>{{"SM00".$value->site_no}}</td>
                        <td>{{$value->site_name}}</td>
                        <td>{{$value->site_location}}</td>
                        <td>{{$value->site_status}}</td>
                        <td>
                            <a href="{{route('sitemaster.show',$value->site_no)}}"
                                class="btn btn-primary btn-circle btn-sm"  data-toggle="modal" data-target="#view_{{$value->site_no}}">
                                <i class="fas fa-flag"></i>
                            </a></td>

                                <td> <a href="{{route('sitemaster.edit',$value->site_no)}}"
                                            class="btn btn-info btn-circle btn-sm mx-2 edit" data-toggle="modal" data-target="#editModal" id="{{$value->site_no}}" >
                                            <i class="fas fa-check"></i>
                                </a></td>
                                <td> <form id="{{$value->site_no}}" action="{{route("sitemaster.destroy",$value->site_no)}}" method="post">
                                            @csrf
                                            @method("DELETE")
                                        </form>
                                        <button onclick="deleteAd({{$value->site_no}})"
                                            type="submit" class="btn btn-sm btn-danger">
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

@include('sitemaster.edit')

@include('sitemaster.show')

@stop

@section('css')

@stop

@section('js')
{{--Datatable search bar and export button code here--}}

    <script>
         $("#myTable").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": [
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
    $('#myTable1').DataTable({
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
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: "{{session()->get('success')}}",
                showConfirmButton: false,
                timer: 3500
            });
        </script>
    @endif

    <!-- <script>
function deleteAd(id){
const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
        confirmButton: 'btn btn-success',
        cancelButton: 'btn btn-danger mr-2'
    },
    buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
    if (result.isConfirmed) {
        document.getElementById(id).submit();
    } else if (
        /* Read more about handling dismissals below */
        result.dismiss === Swal.DismissReason.cancel
    ) {
        swalWithBootstrapButtons.fire(
            'Cancelled',
            'Your data was not deleted..',
            'error'
        )
    }
    })
}


    </script>
 -->



@stop
