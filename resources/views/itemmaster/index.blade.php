@extends('adminlte::page')

@section('plugins.Datatables', true)

@section('title', 'Item Master')

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
                <div class="container-fluid">
                    <div class="card shadow">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h4 class="font-weight-bold text-dark py">ITEM MASTER</h4>
                                <div style="width:120px" id="create_btn">
                                    <button type="button" class="btn btn-block btn-primary" data-toggle="modal"   data-target="#create">Add</button>
                                </div>
                            </div>
                        </div>
                        @include('itemmaster.create')
                       
           
                        <div class="card">
                            <div class="card-body">
                                <table id="myTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Item ID</th>
                                            <th>Item Name</th>
                                            <th>Item Category</th>
                                            <th>Stock Type</th>
                                            <th>Item Type</th>
                                            <th>Supplier Name</th>
                                            <th>Supplier Code</th>
                                            <th>Show</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @foreach ($items as $item)
                                            <tr>
                                                <td>{{"IM00".$item->id}}</td>
                                                <td>{{$item->item_name}}</td>
                                                <td>{{$item->item_category}}</td>
                                                <td>{{$item->stock_type}}</td>
                                                <td>{{$item->item_type}}</td>
                                                <td>{{$item->supplier_name}}</td>
                                                <td>{{$item->supplier_code}}</td>
                                                <td>
                                                    <a href="{{route('itemmaster.show',$item->id)}}"
                                                        class="btn btn-primary btn-circle btn-sm show"  data-toggle="modal" id="{{$item->id}}" data-target="#view_itemmaster_{{$item->id}}" >
                                                        <i class="fas fa-flag"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{route('itemmaster.edit',$item->id)}}"
                                                        class="btn btn-info btn-circle btn-sm mx-2v edit" data-toggle="modal" name="edit" id="{{$item->id}}" data-target="#edit" >
                                                        <i class="fas fa-check"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                <form method="POST" action="{{route('itemmaster.destroy',$item->id)}}" accept-charset="UTF-8" style="display:inline">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-danger btn-sm" title="Delete data" onclick="return confirm(&quot;Confirm delete?&quot;)"> <i class="fa fa-trash"></i></button>
                                </form>
                                                    <!-- <form action="{{route('itemmaster.destroy',$item->id)}}" method="post">
                                                        @csrf
                                                        @method("DELETE")
                                                        
                                                    <button onclick="deleteAd({{$item->id}})"  type="submit" name="submit" class="btn btn-sm btn-danger">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                    </form> -->
                                                    
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
          @foreach ($items as $item)    
           @include('itemmaster.edit') 
           @endforeach
           @foreach ($items as $item)
         <div class="modal fade" id="view_itemmaster_{{$item->id}}">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title"><b>View Item</b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-striped" >
                        <tr>
                            <th>Item ID</th>
                            <td>{{"IM00".$item->id}}</td>
                        </tr>
                        <tr>
                            <th>Item Name</th>
                            <td>{{$item->item_name}}</td>
                        </tr>
                        <tr>
                            <th>First Name</th>
                            <td>{{$item->item_category}}</td>
                        </tr>
                        <tr>
                            <th>Last Name</th>
                            <td>{{$item->stock_type}}</td>
                        </tr>
                        <tr>
                            <th>Middle Name</th>
                            <td>{{$item->item_type}}</td>
                        </tr>
                        <tr>
                            <th>Date of Joining</th>
                            <td>{{$item->supplier_name}}</td>
                        </tr>
                        <tr>
                            <th>Category</th>
                            <td>{{$item->supplier_code}}</td>
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
