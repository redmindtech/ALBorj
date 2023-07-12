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

<link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/css/intlTelInput.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/intlTelInput.min.js"></script>

<!-- autocomplete -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"> </link>

<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>



<!-- timecalculation -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>


<!-- sudha validation -->


<link href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.min.css" rel="stylesheet">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script>href="https://code.jquery.com/jquery-migrate-3.0.0.min.js"</script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.19.3/jquery.validate.min.js"></script>
<script>scr="http://ajax.microsoft.com/ajax/jquery.validate/1.19.3/additional-methods.js"</script>



<!-- @php
    $currentUrl = url()->current();
@endphp -->

 <!-- DATA TABLE FILTERS -->
 <script>
   $(document).ready(function() {
    var column_length = $('#myTable tr th').length;

    var table = $('#myTable').DataTable({
        lengthChange: false,
        columnDefs: [
            {
                visible: true,
                targets: [0, 1, 2, 3, column_length - 3, column_length - 2, column_length - 1]
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
                        orientation: 'landscape',
                        pageSize: 'A0'
                    }
                ]
            },
            'colvis',
            {
                extend: 'collection',
                        text: '<i class="fa fa-print" aria-hidden="true"></i>',
                        buttons: [{
                            extend: 'print',
                            exportOptions: {
                                columns: ':not(.notexport)'
                            },
                            customize: function(win) {
                        // Add custom CSS class to the table for print styling
                        $(win.document.body).find('table').addClass('print-table');

                        // Get the current page's URL
                        var currentPageUrl = window.location.href;

                        // Extract the directory path from the URL
                        var currentDirectory = currentPageUrl.substring(0, currentPageUrl.lastIndexOf('/') + 1);

                        // Construct the image paths relative to the current directory
                        var headerImagePath = currentDirectory + 'vendor/adminlte/dist/img/al_borj.jpeg';
                        var footerImagePath = currentDirectory + 'vendor/adminlte/dist/img/footer.png';

                        // Add header image
                        var headerImage = new Image();
                        headerImage.src = headerImagePath;
                        headerImage.alt = 'Header Image';
                        headerImage.onload = function() {
                            var headerImgElement = $('<img>').attr('src', headerImage.src).attr('alt', headerImage.alt).css('width', '100%').css('height', '160px');
                            $(win.document.body).find('thead').prepend($('<tr>').append($('<th>').attr('colspan', column_length).append(headerImgElement)));
                        };

                        // Add footer image
                        var footerImage = new Image();
                        footerImage.src = footerImagePath;
                        footerImage.alt = 'Footer Image';

                        function appendFooterImage() {
                            var footerImgElement = $('<img>').attr('src', footerImage.src).attr('alt', footerImage.alt).css('width', '100%').css('height', 'auto');
                            $(win.document.body).find('.total-values').after($('<div>').addClass('footer-image-container').append(footerImgElement));
                        }

                        if (footerImage.complete) {
                            // If the footer image is already loaded, append it immediately
                            appendFooterImage();
                        } else {
                            // If the footer image is not yet loaded, wait for it to load before appending
                            footerImage.onload = function() {
                                appendFooterImage();
                            };
                        }

                        // Add total values section to the print output
                        var totalValues = $('.total-values').clone();
                        $(win.document.body).find('.total-values').remove();
                        $(win.document.body).find('table').after(totalValues);

                    }

                        }]
                    }
                ]
            });

    table.buttons().container().appendTo('#myTable_wrapper .col-md-6:eq(0)');

    // Add date range filter
    $('<div class="d-flex justify-content-around ml-2 mr-2"><div class="d-flex flex-row"><label class="form-control" for="startDate">Start Date:</label> <input class="form-control" type="date" id="startDate"></div><div class="d-flex flex-row"><label class="form-control" for="endDate">End Date:</label> <input class="form-control" type="date" id="endDate"></div></div>').appendTo('#myTable_wrapper .col-md-6:eq(0) .dt-buttons:eq(0)');
    $('#startDate, #endDate').on('change', function() {
        var startDate = moment($('#startDate').val()).startOf('day');
    var endDate = moment($('#endDate').val()).endOf('day');

    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
        var currentDate = moment(data[data.length - 4], 'DD-MM-YYYY');
        if (startDate.isValid() && endDate.isValid()) {
            return currentDate.isBetween(startDate, endDate, null, '[]');
        } else if (startDate.isValid()) {
            return currentDate.isSameOrAfter(startDate);
        } else if (endDate.isValid()) {
            return currentDate.isSameOrBefore(endDate);
        }
        return true;
    });
    var table = $('#myTable').DataTable();
    table.draw();

    $.fn.dataTable.ext.search.pop();
});
//date filter alignment above table
$(document).ready(function() {
        // Identify the target div
        var $targetDiv1 = $('#myTable_wrapper .row:eq(0) .col-sm-12');  
        // Remove the old class name
        $targetDiv1.removeClass('col-sm-12 col-md-6');
        
        // Identify the target div
        var $targetDiv2 = $('#myTable_wrapper .row:eq(0)');
        // Remove the old class name
        $targetDiv2.removeClass('row');
        // Add the new class name
        $targetDiv2.addClass('d-flex justify-content-between');
    });

//     $('#startDate, #endDate').on('change', function() {
//         var startDate = $('#startDate').val();
//         var endDate = $('#endDate').val();
//         alert(startDate) ;
//         alert (endDate);
//         var currentUrl = "{{ $currentUrl }}";    
//         console.log("Current URL: " + currentUrl);
//         var lastSegment = currentUrl.substring(currentUrl.lastIndexOf('/') + 1);
//         console.log("Last Segment: " + lastSegment);
//         var searchUrl = lastSegment + '_datesearch';
// console.log("Search URL: " + searchUrl);
// var startDate = $('#startDate').val();
//     var endDate = $('#endDate').val();

//     $.fn.dataTable.ext.search.push(
//         function(settings, data, dataIndex) {
//             var currentDate = data[0]; // Assuming the date column is at index 0
            
//             if (startDate && endDate) {
//                 return (currentDate >= startDate && currentDate <= endDate);
//             } else if (startDate) {
//                 return (currentDate >= startDate);
//             } else if (endDate) {
//                 return (currentDate <= endDate);
//             }
            
//             return true;
//         }
//     );

//     var table = $('#myTable').DataTable();
//     table.draw();

//     $.fn.dataTable.ext.search.pop();
//         // $.ajax({
//         //         url: "{{ route('clientmaster_datesearch') }}",
//         //         method: 'POST',
//         //         data: {
//         //             startDate: startDate,
//         //             endDate: endDate
//         //         },
//         //         success: function() {
//         //           console.log('j');
//         //         },
//         //         error: function(xhr, textStatus, errorThrown) {
//         //             // Handle any error that occurs during the AJAX request
//         //         }
//         //     });
//         // table.columns(0).search('^' + startDate + '$', true, false).draw();
//     // table.columns(0).search('^' + startDate + '|-' + endDate + '$', true, false).draw();

//         //  table.columns(0).search(startDate + '|' + endDate, true).draw();
//     });
});



    </script>

<!-- Styles -->
    <style>
        .main-sidebar{
        z-index: 0 !important;
    }
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
#dialog1{
            width: 1000px;
    position: absolute;
    top: 10px;
    border: none;
    box-shadow: 2px 20px 10px 5px #999;
    border-radius:8px;
    margin-top:45px !important;

    margin: auto;

        }

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
    height:36px !important;
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
            margin-top:10%;
            margin-left:10%;
            position: relative;
            width: 45px;
            height: 20px;
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
            height: 15px;
            width: 15px;
            left: 4px;
            bottom: 2px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
            box-shadow: 0px 0px 5px 2px rgba(0, 0, 0, 0.05);
        }
        .toggle .slider { background-color: #e3eefa; }
        .toggle.on .slider { background-color: #4287f5; }
        .toggle.on .slider:before { transform: translateX(26px); box-shadow: 0px 0px 5px 2px rgba(0, 0, 0, 0.2); }
        .toggle .label { position: absolute; left: 50px; top: 0px; vertical-align: middle; }
        .st { height: 100%; width: 100%; opacity: 0; position: absolute; z-index: 100; cursor: pointer; vertical-align: middle;}
        .toggle.focus .slider, .checkbox.focus   { box-shadow: 0px 0px 0px 2px #bababa; transition: all 0.4s; }
     /* style for percentage and ruper to toggle  ends*/   
    
     .toggle-retention {
            margin-top:10%;
            margin-left:10%;
            position: relative;
            width: 45px;
            height: 20px;
            display: inline-block;
        }
        .toggle-retention .slider {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            transition: 0.4s;
            border-radius: 34px;
        }
        .toggle-retention .slider:before {
            position: absolute;
            content: "";
            height: 15px;
            width: 15px;
            left: 4px;
            bottom: 2px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
            box-shadow: 0px 0px 5px 2px rgba(0, 0, 0, 0.05);
        }
        .toggle-retention .slider { background-color: #e3eefa; }
        .toggle-retention.on .slider { background-color: #4287f5; }
        .toggle-retention.on .slider:before { transform: translateX(26px); box-shadow: 0px 0px 5px 2px rgba(0, 0, 0, 0.2); }
        .toggle-retention .label { position: absolute; left: 60px; top: 4px; vertical-align: middle; }
        .st { height: 100%; width: 100%; opacity: 0; position: absolute; z-index: 100; cursor: pointer; vertical-align: middle;}
        .toggle-retention.focus .slider, .checkbox.focus   { box-shadow: 0px 0px 0px 2px #bababa; transition: all 0.4s; }
        .toggle-label {
            border:solid;
        }
        .toggle-label:before {
            bottom:2px !important;
        }
     
        /* style for percentage and ruper to toggle  ends*/
           /* background blur style */
     .blur-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            backdrop-filter: blur(8px);
            z-index:1;
            display: none; /* Initially hidden */
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background color */
        }

        dialog {
            z-index:2;
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
   /* css for error */
   .error-msg {

  color: red;
  }
  .has-error .form-control {
    border-color: red;
  }
  .valid-msg {
    color: green;
  }
/* phone number */
   .input-group-prepend {
    position: relative;
    }

  #contact_number-error, #UAE_mobile_number-error, #advanced_amount-error, #total_price_cost-error{
    position: absolute;
    top: 100%;
    left: 0;
}

, #desigination-error, , #visa_status-error {
    position: absolute;
    top: 75%;
    left: 1%;
}
 #desigination-error, #visa_status-error, #category-error, #sponser-error, #working_as-error, #depart-error,#exp_category_no-error {
    position: absolute;
    top: 95%;
    left: 1%;
}
#total_price_cost {
    width:revert;
}

/* end phone number */
/* css end for error */
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

    .iti__flag-container{
        top:20% !important;
        bottom: auto;
    }
    /* style for table show */
    #show table {
        border-collapse: collapse;
    }
    
    #show td {
        padding: 5px;
        border: 1px solid black;
    }
    
  

  @media print {
        body::before {
            content: none;
        }
        body::after {
            content: none;
        }
        #print,#closeButton,#submit,#delete {
            display: none;
        }

    }
/* payroll */
    .earnings-column {
    border: 2px solid #9c9999;
    padding: 15px;
    margin-bottom: 15px;
    border-radius: 10px; /* Optional: Add border radius for rounded corners */
    box-sizing: border-box; /* Optional: Include padding within the element's total width */
}

.deduction-column {
    border: 2px solid #9c9999;
    padding: 15px;
    margin-bottom: 15px;
    border-radius: 10px; /* Optional: Add border radius for rounded corners */
    box-sizing: border-box; /* Optional: Include padding within the element's total width */
}
    /* end style for table show */
    </style>



</head>
<body>

</body>
</html>