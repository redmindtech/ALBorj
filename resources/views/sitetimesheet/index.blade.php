<!-- STYLE INCLUDED IN LAYOUT PAGE -->
@extends('layouts.app',[
    'activeName' => 'SiteLevel TimeSheet'
])
@section('title', 'SiteLevel TimeSheet')

@section('content_header')
@stop

@section('content')
<!-- DATA table -->
<div class="row">
    <div class="container-fluid">
        <div class="card shadow">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="font-weight-bold text-dark py">SiteLevel TimeSheet</h4>
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
                                <th>Site Name</th>
                                <th>Site Incharge</th>
                                <th>Site Location</th>
                                <th>Employee Names</th>
                                <th>From Date</th>
                                <th>To Date</th>
                                <th>Date</th>
                                <th data-orderable="false" class="action notexport">Show</th>
                                <th data-orderable="false" class="action notexport">Edit</th>
                                <th data-orderable="false" class="action notexport">Delete</th>
                                <div id="blur-background" class="blur-background"></div>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sitetimes as $time)
                                <tr class="text-center">
                                    <td>{{$time->site_name}}</td>
                                    <td>{{$time->site_manager}}</td>
                                    <td>{{$time->site_location}}</td>
                                    <td>{{$time->remarks}}</td>
                                    <td>{{date('d-m-Y', strtotime($time->from_date))}}</td>
                                    <td>{{date('d-m-Y', strtotime($time->to_date))}}</td>
                                    <td>{{ date('d-m-Y', strtotime($time->created_at)) }}</td>
                                    <td>
                                        <a  onclick="handleShowAndEdit('{{$time->id}}','show')"
                                            class="btn btn-primary btn-circle btn-sm"   >
                                            <i class="fas fa-flag"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a onclick="handleShowAndEdit('{{$time->id}}','edit')"
                                            class="btn btn-info btn-circle btn-sm mx-2" >
                                            <i class="fas fa-check"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <button  type="submit" class="btn btn-sm btn-danger" onclick="handleDelete('{{$time->id}}')">
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
</div>  

<!-- ADD AND EDIT FORM -->
<dialog id="myDialog">
    <div class="row">
        <div class="col-md-12">
            <a class="btn btn-sm" onclick="handleClose()" style="float:right;padding: 10px 10px;"><i class="fas fa-close"></i></a>
            <h4  id='heading_name' style='color:white' align="center"><b>Update Site TimeSheet</b></h4>
        </div>
    </div>
    <form  class="form-row"  enctype="multipart/form-data" style="display:block" id="form" onsubmit="handleSubmit()">
        <input type="hidden" id="method" value="ADD"/>
        <input type="hidden" id="id" name="id" value=""/><br>

        {!! csrf_field() !!}
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="site_name" class="form-label fw-bold">Site Name<a style="text-decoration: none;color:red">*</a></label>
                    <input type="text" id="site_name" name="site_name" value="{{ old('site_name') }}" placeholder="Site Name" class="form-control" autocomplete="off">
                    <input type="text" id="site_no" name="site_no" hidden  value="{{ old('site_no') }}" class="form-control" autocomplete="off"> 
                </div>
                <div class="form-group col-md-4">
                    <label for="site_manager" class="form-label fw-bold">Site Incharge</label>
                    <input type="text" id="site_manager" readonly value="{{ old('site_manager') }}" placeholder="Site Incharge" class="form-control" autocomplete="off">
                </div>
                <div class="form-group col-md-4">
                    <label for="site_location" class="form-label fw-bold">Location</label>
                    <input type="text" id="site_location" readonly name="site_location" value="{{ old('site_location') }}" placeholder="Site Location" class="form-control" autocomplete="off">
                  
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="join_date" class="form-label fw-bold">From Date<a style="text-decoration: none;color:red">*</a></label>
                    <input type="date" id="from_date" name="from_date" value="{{ old('date') }}" placeholder="date" class="form-control" autocomplete="off">
                </div>
                <div class="form-group col-md-4">
                    <label for="join_date" class="form-label fw-bold">To Date<a style="text-decoration: none;color:red">*</a></label>
                    <input type="date" id="to_date" name="to_date" value="{{ old('date') }}" placeholder="date" class="form-control" autocomplete="off">
                </div>
                <div class="form-group col-md-4">
                    <label for="employee_name" class="form-label fw-bold">Employee Name<a style="text-decoration: none;color:red">*</a></label>
                        <div class="input-group">
                            <input type="text" id="firstname" value="{{ old('firstname') }}" placeholder="Manager Name" class="form-control" autocomplete="off">
                            <button type="button" class="btn btn-primary" onclick="addEmployeeName()">ADD</button>
                        </div>
                        <input type="text" id="emp_no" name="emp_no" hidden value="{{ old('emp_no') }}" class="form-control" autocomplete="off">

                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label">Employee Names</label>
                    <textarea class="form-control" id="remarks" cols="30" rows="5" name="remarks" autocomplete="off"></textarea>
                </div>
            </div>
            <script>
                    
                var employee = [];
                function addEmployeeName() 
                {
                    var firstname = document.getElementById('firstname').value;
                    var empNo = document.getElementById('emp_no').value; // Retrieve emp_no value
                    var remarks = document.getElementById('remarks');
                    // Append the entered name to the textarea
                    remarks.value += firstname + "\n";
                    // Add emp_no to the employee array
                    employee.push(empNo);

                    // Clear the input fields
                    document.getElementById('firstname').value = '';
                    document.getElementById('emp_no').value = '';
                    // console.log(employee);
                }
            </script>


             <!-- ADD & Remove table Employee Attendance Table Heading -->
            <div class="container pt-4">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead id="time_table">
                            <tr>
                                <th>Date</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Total Hours</th>
                                <th>OT Start Time</th>
                                <th>OT End Time</th>
                                <th>OT Total Hours</th>
                                <th>Holiday</th>
                                <th>Leave</th>
                                <th>Leave Type</th>
                            </tr>
                        </thead>
                        <tbody id="tbody"></tbody>
                    </table>
                </div>
            </div>
            <!-- End Employee Attendance Table Heading -->
            
            <div class="row mt-3">
                <div class="form-group col-md-12">
                    <button type="submit" id="submit1"  class="btn btn-primary mx-3 mt-3 ">SAVE</button>
                </div>
            </div>
    </form>
    <!-- SHOW DIALOG -->
    <div class="card" id="show" style="display:none">
        <div class="card-body" style="background-color:white;width:100%;height:20%;" >
            <div class="row">
                <div class="col-md-3">
                    <label>Site Name</label>
                    <p id="show_site_name"></p>
                </div>
                <div class="col-md-3">
                    <label>Site Incharge</label>
                    <p id="show_site_manager"></p>
                </div>
                <div class="col-md-3">
                    <label>Location</label>
                    <p id="show_site_location"></p>
                </div>
                <div class="col-md-3">
                    <label>From Date</label>
                    <p id="show_from_date"></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <label>To Date</label>
                    <p id="show_to_date"></p>
                </div>
                <!-- <div class="col-md-3">
                    <label>Employee Name</label>
                    <p id="show_firstname"></p>
                </div> -->
                <div class="col-md-6">
                    <label>Employee Names</label>
                    <p id="show_remarks"></p>
                </div>
               
            </div>
            <div id="item_details_show"></div>
        </div>
    </div>
</dialog>
<!-- Employee Attendance Sheet Calculations -->
<script>
    $('#time_table').hide();
    // Set the start and end dates
    var startDate;
    var endDate;
    var diffDays;
    function add_text(i, formattedDate) 
    {
        var dateObj = new Date(formattedDate);
        var day = dateObj.getDate();
        var month = dateObj.getMonth() + 1;
        var year = dateObj.getFullYear();
        var formattedDateNew = year + '/' + ('0' + month).slice(-2) + '/' + ('0' + day).slice(-2);
        // var formattedDateNew = ('0' + day).slice(-2) + '/' + ('0' + month).slice(-2) + '/' + year;      
        var rowHtml = '<tr id="R' + i + '">' +
            '<td class="row-index">' +
            '<p><input type="text" class="date small-input" name="date[]" value="' + formattedDateNew + '" id="date_' + i + '" readonly></p>' +
            '</td>' +
            '<td class="row-index">' +
            '<p><input type="time" class="start_time" name="start_time[]" id="start_time_' + i + '"></p>' +
            '</td>' +
            '<td class="row-index">' +
            '<p><input type="time" class="end_time" name="end_time[]" id="end_time_' + i + '"></p>' +
            '</td>' +
            '<td class="row-index">' +
            '<p><input type="text" class="total_time small-input" name="total_time[]" id="total_time_' + i + '" readonly></p>' +
            '</td>' +
            '<td class="row-index">' +
            '<p><input type="time" class="ot_start_time" name="ot_start_time[]" id="ot_start_time_' + i + '"></p>' +
            '</td>' +
            '<td class="row-index">' +
            '<p><input type="time" class="ot_end_time" name="ot_end_time[]" id="ot_end_time_' + i + '"></p>' +
            '</td>' +
            '<td class="row-index">' +
            '<p><input type="text" class="ot_total_time small-input" name="ot_total_time[]" id="ot_total_time_' + i + '" readonly></p>' +
            '</td>' +
            '<td class="row-index">' +
            '<p><input type="checkbox" class="holiday" name="holiday[]" id="holiday_' + i + '" ></p>' +
            '</td>' +
            '<td class="row-index">' +
            '<p><input type="checkbox" class="leave" name="leave[]" id="leave_' + i + '" ></p>' +
            '</td>' +
            '<td class="row-index">' +
            '<p><input type="text" class="leave_type" name="leave_type[]" id="leave_type_' + i + '"></p>' +
            '</td>' +
            '<td class="row-index" hidden>' +
            '<p><input type="text" class="holiday_ref" name="holiday_ref[]" id="holiday_ref_' + i + '" value="0"></p>' +
            '</td>' +
            '<td class="row-index" hidden>' +
            '<p><input type="text" class="leave_ref" name="leave_ref[]" id="leave_ref_' + i + '" value="0"></p>' +
            '</td>' +
            '</tr>';

        $('#tbody').append(rowHtml);
    }
    // Function to validate holiday and leave checkboxes
    function validateHolidayLeave() 
    {
        $('.holiday').on('change', function() 
        {
            if ($(this).is(':checked')) 
            {
                var rowId = $(this).attr('id').split('_')[1];
                $('#leave_' + rowId).prop('checked', false);
                $('input[name="holiday_ref[]"]').eq(rowId).val(1);
                $('input[name="leave_ref[]"]').eq(rowId).val(0);
            }
        });
        $('.leave').on('change', function() 
        {
            if ($(this).is(':checked')) 
            {
                var rowId = $(this).attr('id').split('_')[1];
                $('#holiday_' + rowId).prop('checked', false);
                $('input[name="leave_ref[]"]').eq(rowId).val(1);
                $('input[name="holiday_ref[]"]').eq(rowId).val(0);
             }
        });
    }
    // function to calculate and populate table rows
    function dateCal() 
    {
        startDate = new Date($('#from_date').val());
        endDate = new Date($('#to_date').val());

        // Calculate the number of days between the two dates
        var timeDiff = Math.abs(endDate.getTime() - startDate.getTime());
        diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));

        // Clear previous rows
        $('#tbody').empty();
        // create table
        for(let i = 0; i <= diffDays; i++) 
        {
            let currentDate = new Date(startDate.getTime() + (i * 24 * 60 * 60 * 1000));
            let formattedDate = currentDate.toISOString().split('T')[0];
            add_text(i, formattedDate);
        }

        // Validate holiday and leave checkboxes
        validateHolidayLeave();
    }
    // table head show
    $('#to_date').on('change', function() 
    {
        dateCal();
        $('#time_table').show();
    });

        
    // jQuery function to calculate total hours
    function calculateTotalHours() 
    {
        $('input[name="end_time[]"]').each(function(index) 
        {
            var row = $(this).closest('tr');
            var startTime = row.find('input[name="start_time[]"]').val();
            var endTime = row.find('input[name="end_time[]"]').val();
            var totalHours = 0;

            if (startTime && endTime) 
            {
                var start = moment(startTime, 'HH:mm');
                var end = moment(endTime, 'HH:mm');

                if (end.isBefore(start)) 
                {
                    end.add(1, 'day');
                }
                totalHours = end.diff(start, 'hours', true);
            }
            $('input[name="total_time[]"]').eq(index).val(totalHours.toFixed(2) + " hours");
        });
    }

    // Call the function on change of start and end time inputs
    $('body').on('change', 'input[name="end_time[]"]', function() 
    {
        calculateTotalHours();
    });

    // Call the function on page load
    function calculateTotalHours1()
    {
        $('input[name="ot_end_time[]"]').each(function(index) 
        {
            var row = $(this).closest('tr');
            var startTime = row.find('input[name="ot_start_time[]"]').val();
            var endTime = row.find('input[name="ot_end_time[]"]').val();
            var totalHours = 0;

            if (startTime && endTime) 
            {
                var start = moment(startTime, 'HH:mm');
                var end = moment(endTime, 'HH:mm');

                if (end.isBefore(start)) 
                {
                    end.add(1, 'day');
                }
                totalHours = end.diff(start, 'hours', true);
            }
            $('input[name="ot_total_time[]"]').eq(index).val(totalHours.toFixed(2) + " hours");
        });
    }

    // Call the function on change of start and end time inputs
    $('body').on('change', 'input[name="ot_end_time[]"]', function() 
    {
        calculateTotalHours1();
    });
</script>

<script type="text/javascript">
    $.ajaxSetup
    ({
        headers: 
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(function () 
    {
        $("#myTable").DataTable();
    });
       
    //  <!--ADD DIALOG  -->         
    function handleDialog()
    {
        document.getElementById("myDialog").open = true;
        window.scrollTo(0, 0);
        $('#method').val("ADD");
        $('#submit').text("ADD");
        $('#heading_name').text("Add SiteTimesheet Details").css('font-weight', 'bold');
        $('#show').css('display','none');
        $('#form').css('display','block');
        $('#blur-background').css('display','block');
    }

    // DELETE FUNCTION
    function handleDelete(id)
    {
        let url = '{{route('sitetimesheetApi.delete',":id")}}';
        url= url.replace(':id',id);
        if (confirm("Are you sure you want to delete this Site Timesheet Details?"))
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
        // Clear the form fields
        $('#form')[0].reset();
        // $('#form1')[0].reset();
        // $('#form2')[0].reset();
        $("#tbody").empty();
        $('#time_table').hide();
        // Hide any error messages
        i=1;
        // Hide any error messages
        $('p[id^="error_"]').html('');
        // Hide the dialog background
        $('#blur-background').css('display','none');
    }

    // DIALOG SUBMIT FOR ADD AND EDIT
  
    function handleSubmit() 
    {
        event.preventDefault(); 

        let form_data = new FormData(document.getElementById('form'));
        let method = $('#method').val();
        let url;
        let type;

        if (method == 'ADD') 
        {
            url = '{{route('sitetimesheetApi.store')}}';
            type = 'POST';
        } 
        else 
        {
            let id = $('#id').val();
            url = '{{route('sitetimesheetApi.update',":id")}}';
            url = url.replace(':id', id);
            type = 'POST';
        }
        form_data.append('employee', JSON.stringify(employee));
        console.log(employee);
        $.ajax(
        {
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
            },
            error: function (message) 
            {
                var data = message.responseJSON;
                $('p[id ^= "error_"]').html("");
                $.each(data.errors, function (key, val) 
                {
                    $(`#error_${key}`).html(val[0]);
                });
            }
        });
    }


    //DATA SHOW FOR EDIT AND SHOW
    function handleShowAndEdit(id,action)
    {
        let url = '{{route('sitetimesheetApi.show',":id")}}';
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
                if(action == 'edit')
                {
                    $('#heading_name').text("Update site Timesheet Details").css('font-weight', 'bold');
                    $('#show').css('display','none');
                    $('#form').css('display','block');
                    $('#blur-background').css('display','block');
                    
                    for (const [key, value] of Object.entries(message.time[0]))
                    {
                        
                        $(`#${key}`).val(value);
                        
                    }
                    let a=0;
                    for (const item of message.time_sheet) 
                    {
                        $('#time_table').show();
                        add_text(a,item.date);
                        console.log(message.time_sheet);
                        $('#date_'+a).val(item.date);
                        $('#start_time_'+a).val(item.start_time);
                        $('#end_time_'+a).val(item.end_time);
                        $('#total_time_'+a).val(item.total_time);
                        $('#ot_start_time_'+a).val(item.ot_start_time);
                        $('#ot_end_time_'+a).val(item.ot_end_time);
                        $('#ot_total_time_'+a).val(item.ot_total_time);
                        $('#holiday_'+a).prop('checked', item.holiday == "1");
                        $('#leave_'+a).prop('checked', item.leave == "1");
                        $('#leave_type_'+a).val(item.leave_type);
                        a++;
                        console.log(item.holiday);
                        console.log(item.leave);
                        console.log(item.date);
                    }
                        $('#method').val('UPDATE');
                        $('#submit').text('UPDATE');
        
                } 
                else
                {
                    for (let [key, value] of Object.entries(message.time[0]))
                    {
                        if (key === "from_date" || key === "to_date") 
                        {
                            var dateObj = new Date(value);
                            var day = dateObj.getDate();
                            var month = dateObj.getMonth() + 1;
                            var year = dateObj.getFullYear();
                            value= day + '-' + month + '-' + year
                        }
                        $(`#show_${key}`).text(value);
                        if(message.time[0].over_time=="1")
                            {
                                $('#show_over_time').text("Yes");
                            }
                            else
                            {
                                $('#show_over_time').text("No");
                            }   
                    }
                        let script = '<table id="show_table" class="table table-striped"><thead><tr><th>Date</th><th>Start Time</th><th>End Time</th><th>Total Time</th><th>Ot start Time</th><th>Ot End Time</th><th>Ot Toteal Time</th><th>Holiday</th><th>Leave</th><th>Leave Type</th></tr></thead><tbody>';
                        for (const time of message.time_sheet) 
                        {
                            let holiday_flag = time.holiday;
                            if(holiday_flag == "1"){
                                holiday_flag = "Yes";
                            }else{
                                holiday_flag = "No";
                            }
                            let leave_flag = time.leave;
                            if(leave_flag == "1"){
                                leave_flag = "Yes";
                            }else{
                                leave_flag = "No";
                            }
                            script += '<tr>';
                            script += '<td>' + (time.date || '') + '</td>';
                            script += '<td>' + (time.start_time ? convertTo12HourFormat(time.start_time) : '-') + '</td>';
                            script += '<td>' + (time.end_time ? convertTo12HourFormat(time.end_time) : '-') + '</td>';
                            script += '<td>' + (time.total_time || '-') + '</td>';
                            script += '<td>' + (time.ot_start_time ? convertTo12HourFormat(time.ot_start_time) : '-') + '</td>';
                            script += '<td>' + (time.ot_end_time ? convertTo12HourFormat(time.ot_end_time) : '-') + '</td>';
                            script += '<td>' + (time.ot_total_time || '-') + '</td>';
                            script += '<td>' + (holiday_flag || '-') + '</td>';
                            script += '<td>' + (leave_flag || '-') + '</td>';
                            script += '<td>' + (time.leave_type || '-') + '</td>';
                            script += '</tr>';
                        }
                        script+= '</tbody></table>';
                        $('#show_table').remove();
                        $('#item_details_show').append(script); 
                        $('#heading_name').text("View site Timesheet Details").css('font-weight', 'bold');
                        $('#show').css('display','block');
                        $('#form').css('display','none');
                        $('#blur-background').css('display','block');
                        function convertTo12HourFormat(time) 
                        {
                            var timeParts = time.split(':');
                            var hours = parseInt(timeParts[0]);
                            var minutes = parseInt(timeParts[1]);
                            var meridiem = 'AM';
                            if (hours >= 12) 
                            {
                                meridiem = 'PM';
                                if (hours > 12) {
                                    hours -= 12;
                                }
                            }
                            var formattedTime7 = ('0' + hours).slice(-2) + ':' + ('0' + minutes).slice(-2) + ' ' + meridiem;
                            return formattedTime7;
                        }
                }
                        document.getElementById("myDialog").open = true;
                        window.scrollTo(0, 0);                       
            },
        })
    }

        // auto complete from employeemaster
    jQuery($ => 
    {
        $(document).on('focus', 'input',"#firstname", function() 
        {
            $("#firstname").autocomplete(
            {
                source: function(request, response) 
                {
                    $.ajax(
                    {
                        type: "GET",
                        url: "{{ route('getemployeedata') }}",
                        dataType: "json",
                        data: 
                        {
                            'firstname': $("#firstname").val()
                        },
                        success: function(data) 
                        {
                            result = [];
                            for (var i in data) 
                            {
                                result.push(data[i]["firstname"]);
                            }
                            response(result);
                        },
                        fail: function(xhr, textStatus, errorThrown) 
                        {
                            alert(errorThrown);
                        }
                    });
                },
                select: function(event, ui) 
                {
                    $('#emp_no').val(null);
                    var selectedFirstName = ui.item.value;
                    updateEmployeeValue(selectedFirstName);
                }
            });
        });

        // EMPLOYEE CODE
        $("#firstname").on('input', function() 
        {
            $('#emp_no').val(null);
            var selectedFirstName = $(this).val();
            updateEmployeeValue(selectedFirstName);
        });

        function updateEmployeeValue(firstName) 
        {
            $.ajax(
            {
                type: "GET",
                url: "{{ route('getemployeedata') }}",
                dataType: "json",
                data: 
                {
                    'firstname': firstName
                },
                success: function(data) 
                {
                    for (var i in data) 
                    {
                        $('#emp_no').val(data[i]["id"]);
                    }
                },
                fail: function(xhr, textStatus, errorThrown) 
                {
                    alert(errorThrown);
                }
            });
        }
    });


        // auto complete for sitename from sitemaster
        jQuery($ => 
        {
            $(document).on('focus click', $("#site_name"), function() 
            {
                $("#site_name").autocomplete(
                {
                    source: function( request, response ) 
                    {
                        $.ajax
                        ({
                            type:"GET",
                            url: "{{ route('getsitedata') }}",
                            dataType: "json",
                            data:
                            {
                                'site_name':$("#site_name").val()
                            },
                            success: function( data ) 
                            {
                                result = [];
                                for(var i in data)
                                {
                                    result.push(data[i]["site_name"]);
                                }
                                response(result);
                            },
                            fail: function(xhr, textStatus, errorThrown)
                            {
                                alert(errorThrown);
                            }
                        });
                    },
                    select: function(event, ui) 
                    {
                        $('#site_no').val(null);
                        var selectedSiteName = ui.item.value;
                        updateSiteNoValue(selectedSiteName);
                    }
                });
            });
       
        // site code
        $("#site_name").on('input', function() 
        {
            $('#site_no').val(null);
            var selectedSiteName = $(this).val();
            updateSiteNoValue(selectedSiteName);
        });
        function updateSiteNoValue(SiteName) 
        {
            $.ajax
            ({
                type:"GET",
                url: "{{ route('getsitedata') }}",
                dataType: "json",
                data:
                {
                    'site_name':SiteName
                },
                success: function( data ) 
                {
                    for(var i in data)
                    {
                        $('#site_no').val(data[i]["site_no"]);
                        $('#site_manager').val(data[i]["firstname"]);
                        $('#site_location').val(data[i]["site_location"]);
                    }
                },
                fail: function(xhr, textStatus, errorThrown)
                {
                     alert(errorThrown);
                }
            });
        }
    });


</script>
@stop 