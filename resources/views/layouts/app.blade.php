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

<!-- timecalculation -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>


 <!-- DATA TABLE FILTERS -->
 <script>
    $(document).ready(function() {
        var column_length = $('#myTable tr th').length;
        
        var table = $('#myTable').DataTable( {

            lengthChange: false,

        columnDefs:[
            {
                visible:true,targets:[0,1,2,3,column_length-3, column_length-2,column_length-1]
                
            },
           { targets: '_all', visible: false }
             ],

            buttons: [
            {
                extend: 'collection',
                text: '<i class="fa fa-file-export" aria-hidden="true"></i>',
                buttons: [
            {
                extend: 'csv',
                //title:    function () { return cfTitle; },
               filename: $('title').text().trim(),
                exportOptions: {
                    columns: ':not(.notexport)'
                }
            },
            {
                extend: 'pdf',
                 filename: $('title').text().trim(),
                exportOptions: {
                    columns: ':not(.notexport)'
                },
                orientation : 'landscape',
                pageSize : 'A0', 
            
            },
           
                ]
                 

            },
            'colvis',
            {
                extend: 'collection',
                text: '<i class="fa fa-print" aria-hidden="true"></i>',
                buttons:  [
            {
                extend: 'print',
                exportOptions: {
                    columns: ':not(.notexport)'
                }
            },
           
        ],
            },]
        } );

        table.buttons().container()
            .appendTo( '#myTable_wrapper .col-md-6:eq(0)' );
    } );


    </script>

<!-- Styles -->
    <style>
        .main-sidebar{
        z-index: 4 !important;
    }
        dialog{
            
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
.select2-container .select2-selection--single {
    height:38px !important;
}
input[type=checkbox] {
  width: 25px;
  height: 25px;
}
/* style for percentage and ruper to toggle */
.checkbox {
            width: 30px;
            height: 30px;
            position: relative;
            display: block;
        }
        .checkbox { background-color: #4287f5; }
        .checkbox {
            opacity: 1; 
            text-align: center;
            animation-name: eh;
            animation-duration: 0.3s;
        }
        .checkbox .checked-icon, .radio .rad-icon { transition: opacity 0.3s ease-out; }
        .toggle {
            position: relative;
            width: 60px;
            height: 34px;
            display: inline-block;
        }
        .toggle .slider {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            transition: 0.4s;
            border-radius: 34px;
        }
        .toggle .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
            box-shadow: 0px 0px 5px 2px rgba(0, 0, 0, 0.05);
        }
        .toggle .slider { background-color: #e3eefa; }
        .toggle.on .slider { background-color: #4287f5; }
        .toggle.on .slider:before { transform: translateX(26px); box-shadow: 0px 0px 5px 2px rgba(0, 0, 0, 0.2); }
        .toggle .label { position: absolute; left: 70px; top: 4px; vertical-align: middle; }
        .st { height: 100%; width: 100%; opacity: 0; position: absolute; z-index: 100; cursor: pointer; vertical-align: middle;}
        .toggle.focus .slider, .checkbox.focus   { box-shadow: 0px 0px 0px 2px #bababa; transition: all 0.4s; }
     /* style for percentage and ruper to toggle  ends*/ 
     /* background blur style */
     .blur-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            backdrop-filter: blur(8px);
            z-index:8;
            display: none; /* Initially hidden */
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background color */
        }

        dialog {
            z-index:9;
        }
         #myTable_paginate, #myTable_info  {
            position:relative;
            z-index: 0;
        }
        .main-header{
        z-index:0 !important;
        }
        /* end background blur style */
        
        /* chart css */
        #chartdiv{
        width: 100%;
        height: 500px;
        }
    /* chart css end */

    /* table text box size reduce */
        .small-input {
            width: 90px; /* Adjust the width value as needed */
        }
   
    /*table overflow */
    #myTable{
            width:100% !important;
        }
        #myTable_wrapper .row:nth-child(2) {
            overflow-x:auto;
        }

    /*sidebar for mobile view */
    #sidebar-overlay{
        z-index:1 !important;
    }
    @media only screen and (min-width: 1024px) {
      dialog {
        width: 1000px !important;
      }
    }
   
    </style>
  
   

</head>
<body>
    
</body>
</html>

