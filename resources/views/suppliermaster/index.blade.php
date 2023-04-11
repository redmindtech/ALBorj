@extends('adminlte::page')

@section('plugins.Datatables', true)

@section('title', 'Supplier Master')

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
                                <h4 class="font-weight-bold text-dark py">SUPPLIER MASTER</h4>
                                <div style="width:120px">
                                    <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#myModal1">Add</button>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <table id="myTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Supplier Name</th>
                                            <th>Company</th>
                                            <th>Supplier Code</th>
                                            <th>Contact No</th>
                                            <th>Mail Id</th>
                                            <th>Show</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($suppliers as $key => $supplier)
                                            <tr>
                                                <td>{{$key+=1}}</td>
                                                <td>{{$supplier->name}}</td>
                                                <td>{{$supplier->company_name}}</td>
                                                <td>{{$supplier->code}}</td>
                                                <td>{{$supplier->contact_number}}</td>
                                                <td>{{$supplier->mail_id}}</td>
                                                <td>
                                                    <a href="{{route("suppliermaster.show",$supplier->supplier_no)}}"
                                                        class="btn btn-primary btn-circle btn-sm"  data-toggle="modal" data-target="#view_suppliermaster_{{$supplier->supplier_no}}" >
                                                        <i class="fas fa-flag"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{route("suppliermaster.edit",$supplier->supplier_no)}}"
                                                        class="btn btn-info btn-circle btn-sm mx-2 edit" id="{{$supplier->supplier_no}}" data-toggle="modal" data-target="#edit_suppliermaster" >
                                                        <i class="fas fa-check"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <!-- <form id="{{$supplier->supplier_no}}" action="{{route("suppliermaster.destroy",$supplier->supplier_no)}}" method="post">
                                                        @csrf
                                                        @method("DELETE")
                                                    </form>
                                                    <button onclick="deleteAd({{$supplier->supplier_no}})" type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fa fa-trash"></i>
                                                    </button> -->
                                                    <form method="POST" action="{{route("suppliermaster.destroy",$supplier->supplier_no)}}" accept-charset="UTF-8" style="display:inline">
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
                     <div id="myModal1" class="modal fade" role="dialog">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content ">
                                <div class="modal-header bg-primary">
                                    <h4 class="modal-title ">Add Supplier</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">

                                    <div class="card-body ">
                                        <form id="myform" method="POST" class="form-row" action="{{ route('suppliermaster.store') }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group col-md-6">
                                                <label for="name" class="form-label fw-bold"> Name<a style="text-decoration: none;color:red">*</a></label>
                                                <input type="text" name="name" value="{{old("name")}}" placeholder="Supplier Name" class="form-control name1" autocomplete="off" id="name1" required >
                                                <span id="name_val"></span>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="company_name" class="form-label fw-bold">Company Name<a style="text-decoration: none;color:red">*</a></label>
                                                <input type="text" name="company_name" value="{{old("company_name")}}" placeholder="Company Name" class="form-control" autocomplete="off" id="company_name" required>
                                                <span id="company_val"></span>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="address" class="form-label fw-bold">Address<a style="text-decoration: none;color:red">*</a></label>
                                                <input type="text" name="address" value="{{old("address")}}" placeholder="Address" class="form-control" autocomplete="off" id="address" required>
                                                <span id="address_val" required></span>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="contact_number" class="form-label fw-bold">Contact Number<a style="text-decoration: none;color:red">*</a></label>
                                                <input type="text" name="contact_number" value="{{old("contact_number")}}" maxlength="10" placeholder="Contact Number" class="form-control" autocomplete="off" id="contact_number" required>
                                                <span id="contact_number_val"></span>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="mail_id" class="form-label fw-bold">Email Id<a style="text-decoration: none;color:red">*</a></label>
                                                <input type="email" name="mail_id" value="{{old("mail_id")}}" placeholder="Email Id" class="form-control" autocomplete="off" id="mail_id" required>
                                                <span id="email_val"></span>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="website" class="form-label fw-bold">Website<a style="text-decoration: none;color:red">*</a></label>
                                                <input type="website" name="website" value="{{old("website")}}" placeholder="Website" class="form-control" autocomplete="off" id="website" required>
                                                <span id="website_val"></span>
                                            </div>

                                            <div class="form-group col-md-12">
                                                    <button type="submit" class="btn btn-primary float-end" id="add-info-btn">{{ __('Add') }}</button>
                                                </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

{{--supplier master edit--}}

@foreach ($suppliers as $supplier)
@include('suppliermaster.edit')
@endforeach

{{--supplier master view--}}

@foreach ($suppliers as $supplier)
    <div class="modal fade" id="view_suppliermaster_{{$supplier->supplier_no}}">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title"><b>View Supplier</b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-striped" >

                        <tr>
                            <th>Supplier Name</th>
                            <td>{{$supplier->name}}</td>
                        </tr>
                        <tr>
                            <th>Company Name</th>
                            <td>{{$supplier->company_name}}</td>
                        </tr>
                        <tr>
                            <th>Supplier Code</th>
                            <td>{{$supplier->code}}</td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td>{{$supplier->address}}</td>
                        </tr>
                        <tr>
                            <th>Contact Number</th>
                            <td>{{$supplier->contact_number}}</td>
                        </tr>
                        <tr>
                            <th>Email Id</th>
                            <td>{{$supplier->mail_id}}</td>
                        </tr>
                        <tr>
                            <th>Website</th>
                            <td>{{$supplier->website}}</td>
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

            buttons: [ 'csv', 'excel', 'pdf', ]

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
    <script>
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
 <script>
       $(document).ready(function() {
        $(".name1").input(function(){
            var re=/^[a-zA-Z ]+$/;
 if($(this).val()== ''){
    document.getElementById("name_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
    document.getElementById("add-info-btn").disabled=true;
 }

 else if(re.test($(this).val())==true)
 {
    document.getElementById("name_val").innerHTML="";
    document.getElementById("add-info-btn").disabled=false;
 }
 else if(re.test($(this).val())==false)
  {
    document.getElementById("add-info-btn").disabled=true;
    document.getElementById("name_val").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
  }

          });
        });


        $(document).ready(function() {
        $("#company_name").focusout(function(){
            var re=/^[a-zA-Z ]+$/;
            console.log((re.test($(this).val())));
 if($(this).val()== ''){

    document.getElementById("company_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
    document.getElementById("add-info-btn").disabled=true;
 }

 else if(re.test($(this).val())==true)
 {

    document.getElementById("company_val").innerHTML="";
    document.getElementById("add-info-btn").disabled=false;
 }
 else if(re.test($(this).val())==false)
  {
    document.getElementById("company_val").innerHTML="<span class='text-danger m-2'>Please enter valid data</span>";
    document.getElementById("add-info-btn").disabled=true;
  }

          });
        });




        $(document).ready(function() {
        $("#address").focusout(function(){

 if($(this).val()== ''){
    document.getElementById("address_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
    document.getElementById("add-info-btn").disabled=true;
 }
 else
 {
    document.getElementById("address_val").innerHTML="";
    document.getElementById("add-info-btn").disabled=false;
 }


          });
        });

        $(document).ready(function() {
        $("#contact_number").focusout(function(){
            var re=/^[6789]\d{9}$/;
 if($(this).val()== ''){
    document.getElementById("contact_number_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
    document.getElementById("add-info-btn").disabled=true;
 }
 else if(re.test($(this).val())==true)
 {
    document.getElementById("contact_number_val").innerHTML="";
    document.getElementById("add-info-btn").disabled=false;
 }
 else if(re.test($(this).val())==false)
  {
    document.getElementById("contact_number_val").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
    document.getElementById("add-info-btn").disabled=true;
  }

          });
        });



        $(document).ready(function() {
        $("#address").focusout(function(){

 if($(this).val()== ''){
    document.getElementById("address_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
    document.getElementById("add-info-btn").disabled=true;
 }
 else
 {
    document.getElementById("address_val").innerHTML="";
    document.getElementById("add-info-btn").disabled=false;
 }


          });
        });

        $(document).ready(function() {
        $("#mail_id").focusout(function(){
            var re=/^[a-zA-Z0-9.!#$%&'+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)$/;
 if($(this).val()== ''){
    document.getElementById("email_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
    document.getElementById("add-info-btn").disabled=true;
 }
 else if(re.test($(this).val())==true)
 {
    document.getElementById("email_val").innerHTML="";
    document.getElementById("add-info-btn").disabled=false;
 }
 else if(re.test($(this).val())==false)
  {
    document.getElementById("email_val").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
    document.getElementById("add-info-btn").disabled=true;
  }

          });
        });

        $(document).ready(function() {
        $("#website").focusout(function(){

 if($(this).val()== ''){
    document.getElementById("website_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
    document.getElementById("add-info-btn").disabled=true;
 }
 else
 {
    document.getElementById("website_val").innerHTML="";
    document.getElementById("add-info-btn").disabled=false;
 }


          });
        });

      </script>


{{-- edit validation --}}
<script>
    $(document).ready(function() {
     $("#u_name").focusout(function(){
         var re=/^[a-zA-Z ]+$/;
if($(this).val()== ''){
 document.getElementById("u_name_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
 document.getElementById("edit-info-btn").disabled=true;
}

else if(re.test($(this).val())==true)
{
 document.getElementById("u_name_val").innerHTML="";
 document.getElementById("edit-info-btn").disabled=false;
}
else if(re.test($(this).val())==false)
{
 document.getElementById("edit-info-btn").disabled=true;
 document.getElementById("u_name_val").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
}

       });
     });


     $(document).ready(function() {
     $("#u_company_name").focusout(function(){
         var re=/^[a-zA-Z ]+$/;
if($(this).val()== ''){
 document.getElementById("u_company_name_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
 document.getElementById("edit-info-btn").disabled=true;
}

else if(re.test($(this).val())==true)
{
 document.getElementById("u_company_name_val").innerHTML="";
 document.getElementById("edit-info-btn").disabled=false;
}
else if(re.test($(this).val())==false)
{
 document.getElementById("u_company_name_val").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
 document.getElementById("edit-info-btn").disabled=true;
}

       });
     });




     $(document).ready(function() {
            $("#u_address").focusout(function(){

     if($(this).val()== ''){
        document.getElementById("u_address_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
        document.getElementById("add-info-btn").disabled=true;
     }
     else
     {
        document.getElementById("u_address_val").innerHTML="";
        document.getElementById("add-info-btn").disabled=false;
     }


              });
            });


     $(document).ready(function() {
     $("#u_contact_number").focusout(function(){
         var re=/^[6789]\d{9}$/;
if($(this).val()== ''){
 document.getElementById("u_contact_number_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
 document.getElementById("edit-info-btn").disabled=true;
}
else if(re.test($(this).val())==true)
{
 document.getElementById("u_contact_number_val").innerHTML="";
 document.getElementById("edit-info-btn").disabled=false;
}
else if(re.test($(this).val())==false)
{
 document.getElementById("u_contact_number_val").innerHTML="<span class='text-danger m-2'>Please enter the valid</span>";
 document.getElementById("edit-info-btn").disabled=true;
}

       });
     });

     $(document).ready(function() {
     $("#u_mail_id").focusout(function(){
         var re=/^[a-zA-Z0-9.!#$%&'+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)$/;
if($(this).val()== ''){
 document.getElementById("u_email_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
 document.getElementById("edit-info-btn").disabled=true;
}
else if(re.test($(this).val())==true)
{
 document.getElementById("u_email_val").innerHTML="";
 document.getElementById("edit-info-btn").disabled=false;
}
else if(re.test($(this).val())==false)
{
 document.getElementById("u_email_val").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
 document.getElementById("edit-info-btn").disabled=true;
}

       });
     });
     $(document).ready(function() {
        $("#u_website").focusout(function(){

 if($(this).val()== ''){
    document.getElementById("u_website_val").innerHTML="<span class='text-danger m-2'>This field is required</span>";
    document.getElementById("edit-info-btn").disabled=true;
 }
 else
 {
    document.getElementById("u_website_val").innerHTML="";
    document.getElementById("edit-info-btn").disabled=false;
 }


          });
        });


   </script>

@stop