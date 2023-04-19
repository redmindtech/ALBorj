@extends('adminlte::page')

@section('plugins.Datatables', true)

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=4, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
    </title>
     <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
        
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> 
  
    
 <!-- Fonts  -->
     <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
      <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- sudhachanges -->
<!-- phone number -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/css/intlTelInput.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/intlTelInput.min.js"></script> 

<!-- autocomplete -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"> </link>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->

 <!-- DATA TABLE FILTERS -->
 <script>
    $(document).ready(function() {
        var table = $('#myTable').DataTable( {

            lengthChange: false,


            buttons: [
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
            },]
        } );

        table.buttons().container()
            .appendTo( '#myTable_wrapper .col-md-6:eq(0)' );
    } );

    </script>

<!-- Styles -->
    <style>
        dialog{
            width: 1000px;
    position: absolute;
    top: 10px;
    border: none;
    box-shadow: 2px 20px 10px 5px #999;
    border-radius:8px;
    margin-top:45px !important;
   
    margin: auto;
        }
        /* dialog {
  width: 1000px;
} */

/* Target the div containing the header */
#myDialog > div {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0px;
/*  */
  background-color:#319DD9;
  border-bottom: 1px solid #ccc;
}


#heading_name{
   height:40px;
   text-align:center;
   padding-top:10px; 
}

/* phone number flag in employee master */
.iti-flag {
  background-image: url("https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/10.0.2/img/flags.png");
}
/* data table last 3 column style */
.action{
    width: 2px;
}
    </style>
  
   

</head>
<body>
    
</body>
</html>

