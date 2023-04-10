@extends('adminlte::page')

@section('plugins.Datatables', true)

@section('title', 'Employee Master')

@section('content_header')
@stop

@section('content')
    <div class="container-fluid">
        <div class="col-md-12 mx-auto">
            {{-- <div class="container-fluid">
                <div class="col-md-6 mx-auto">
                    @include('layouts.alert')
                </div> --}}
            </div>
            <div class="row">
                <div class="container-fluid">
                    <div class="card shadow">
                      <div class="card-header">
                        <div class="d-flex justify-content-between">
                          <h4 class="font-weight-bold text-dark py">EMPLOYEE MASTER</h4>
                          <div style="width:120px">
                            <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#myModal1">Add</button>
                          </div>
                        </div>
                      </div>
                          <div class="card">

                            <div class="card-body">
                                <div class="table-responsive">
                                <table id="myTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            {{-- <th>S.No</th> --}}
                                            <th>Employee Id</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            {{-- <th>Department</th>
                                            <th>Date of Joining</th> --}}
                                            <th>Show</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($employes as $key => $employe)
                                            <tr>
                                                {{-- <td>{{$key+=1}}</td> --}}
                                                <td>{{"EMP00".$employe->id}}</td>
                                                <td>{{$employe->firstname}}</td>
                                                <td>{{$employe->lastname}}</td>
                                                {{-- <td>{{$employe->depart}}</td>
                                                <td>{{$employe->join_date}}</td> --}}
                                                <td>
                                                    {{-- <a href="{{route("employeemaster.show",$employe->id)}}"
                                                        class="btn btn-primary btn-circle btn-sm"  data-toggle="modal" data-target="#view_employee_{{$employe->id}}" >
                                                        <i class="fas fa-flag"></i>
                                                    </a> --}}
                                                    <a href="{{route("employeemaster.show",$employe->id)}}"
                                                        class="btn btn-primary btn-circle btn-sm"  data-toggle="modal" data-target="#view_employeemaster_{{$employe->id}}" >
                                                        <i class="fas fa-flag"></i>
                                                    </a>

                                                </td>

                                                   <td>
                                                    <a href="{{route("employeemaster.edit",$employe->id)}}"
                                                    class="btn btn-info btn-circle btn-sm mx-2 edit" id="{{$employe->id}}"  data-toggle="modal" data-target="#edit_employee_{{$employe->id}}" >
                                                        <i class="fas fa-check"></i>
                                                    </a>
                                                </td>
                                                   <td>
                                                    {{-- <form id="{{$employe->id}}" action="{{route("employeemaster.destroy",$employe->id)}}" method="post">
                                                        @csrfz
                                                        @method("DELETE")
                                                    </form>
                                                    <button onclick="deleteAd({{$employe->id}})"
                                                        type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fa fa-trash"></i>
                                                    </button> --}}
                                                    <form method="POST" action="{{route("employeemaster.destroy",$employe->id)}}" accept-charset="UTF-8" style="display:inline">
                                                        {{ method_field('DELETE') }}
                                                        {{ csrf_field() }}
                                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete data" onclick="return confirm(&quot;Confirm delete?&quot;)"> <i class="fa fa-trash"></i></button>
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
{{--------employee Add------------}}

            <div id="myModal1" class="modal fade" role="dialog">
                <div class="modal-dialog modal-xl">
            <div class="modal-content ">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title text-center">Employee Details</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>
                <div class="modal-body">

                          <div class="card-body ">
                            @include('employeemaster.form')
                        </div>


                    </div>

                  </div>
                </div>
              </div>

{{--employee edit--}}

@include('employeemaster.edit')

  </div>
 </div>
</div>

{{--employee view--}}

@foreach ($employes as $employe)
    <div class="modal fade" id="view_employeemaster_{{$employe->id}}">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title"><b>View Employee</b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-striped" >
                        <h3 class="text-primary font-weight-bold text-center">
                            Profile: {{$employe->firstname}}
                        </h3>
                        <tr>
                            <th>Employee ID</th>
                            <td>{{ "EMP00" . $employe->id }}</td>
                        </tr>
                        <tr>
                            <th>First Name</th>
                            <td>{{ $employe->firstname }}</td>
                        </tr>
                        <tr>
                            <th>Last Name</th>
                            <td>{{ $employe->lastname }}</td>
                        </tr>


                        <tr>
                            <th>Father Name</th>
                            <td>{{ $employe->fathername }}</td>
                        </tr>
                        <tr>
                            <th>Mother Name</th>
                            <td>{{ $employe->mothername }}</td>
                        </tr>
                        <tr>
                            <th>Date of Joining</th>
                            <td>{{ $employe->join_date }}</td>
                        </tr>
                        <tr>
                            <th>End Date</th>
                            <td>{{ $employe->end_date }}</td>
                        </tr>
                        <tr>
                            <th>Category</th>
                            <td>{{ $employe->category }}</td>
                        </tr>
                        <tr>
                            <th>Sponsor</th>
                            <td>{{ $employe->sponser }}</td>
                        </tr>
                        <tr>
                            <th>Working As</th>
                            <td>{{ $employe->working_as }}</td>
                        </tr>
                        <tr>
                            <th>Visa Designation</th>
                            <td>{{ $employe->desigination }}</td>
                        </tr>
                        <tr>
                            <th>Department</th>
                            <td>{{ $employe->depart }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>{{ $employe->status }}</td>
                        </tr>
                        <tr>
                            <th>Religion</th>
                            <td>{{ $employe->religion }}</td>
                        </tr>
                        <tr>
                            <th>Nationality</th>
                            <td>{{ $employe->nationality }}</td>
                        </tr>


                        <tr>
                            <th>Location</th>
                            <td>{{ $employe->city }}</td>
                        </tr>
                        <tr>
                            <th>Home Country Contact Number</th>
                            <td>{{ $employe->phone }}</td>
                        </tr>
                        <tr>
                            <th>UAE Mobile Number</th>
                            <td>{{ $employe->UAE_mobile_number }}</td>
                        </tr>
                        <tr>
                            <th>Pay Group</th>
                            <td>{{ $employe->pay_group }}</td>
                        </tr>
                        <tr>
                            <th>Accomodation</th>
                            <td>{{ $employe->accomodation }}</td>
                        </tr>
                        <tr>
                            <th>Passport Number</th>
                            <td>{{ $employe->passport_no }}</td>
                        </tr>
                        <tr>
                            <th>Passport Expiry Date</th>
                            <td>{{ $employe->passport_expiry_date }}</td>
                        </tr>
                        <tr>
                            <th>Emirates Id No</th>
                            <td>{{ $employe->emirates_id_no }}</td>
                        </tr>
                        <tr>
                            <th>Emirates Id From Date</th>
                            <td>{{ $employe->emirates_id_from_date }}</td>
                        </tr>
                        <tr>
                            <th>Emirates Id To Date</th>
                            <td>{{ $employe->emirates_id_to_date }}</td>
                        </tr>
                        <tr>
                            <th>Visa End Date</th>
                            <td>{{ $employe->expiry_date }}</td>
                        </tr>
                        <tr>
                            <th>Visa Status</th>
                            <td>{{ $employe->category }}</td>
                        </tr>
                        <tr>
                            <th>Total Salary</th>
                            <td>{{ $employe->total_salary }}</td>
                        </tr>
                        <tr>
                            <th>HRA</th>
                            <td>{{ $employe->hra }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endforeach


{{--employee index--}}



        </div>
    </div>

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
            buttons: ['csv','excel','pdf',]

        },
        'colvis',
        {
            extend: 'collection',
            text: '<i class="fa fa-print" aria-hidden="true"></i>',
            buttons: ['print',]
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
    {{-- <script>
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
    </script> --}}






@stop
