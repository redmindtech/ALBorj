<!-- STYLE INCLUDED IN LAYOUT PAGE -->
@extends('layouts.app',[
    'activeName' => 'Employee TimeSheet'
])
@section('title', 'Employee TimeSheet')

@section('content_header')
@stop

@section('content')
<!-- DATA table -->
<div class="row">
    <div class="container-fluid">
        <div class="card shadow">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="font-weight-bold text-dark py">Employee TimeSheet</h4>
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
                                <th>Employee Name</th>
                                <th>Designation</th>
                                <th>Department</th>
                                <th>Project Name</th>
                                <th data-orderable="false" class="action notexport">Show</th>
                                <th data-orderable="false" class="action notexport">Edit</th>
                                <th data-orderable="false" class="action notexport">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($times as $time)
                            <tr class="text-center">
                                <td>{{$time->firstname}}<div id="blur-background" class="blur-background"></div></td>
                                <td>{{$time->desigination}}</td>
                                <td>{{$time->depart}}</td>
                                <td>{{$time->project_name}}</td>
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
<dialog id="myDialog"  style="width:1000px;" >
    <div class="row">
        <div class="col-md-12">
            <a class="btn btn-sm" onclick="handleClose()" style="float:right;padding: 10px 10px;"><i class="fas fa-close"></i></a>
            <h4  id='heading_name' style='color:white' align="center"><b>Update</b></h4>
        </div>
    </div>
    <form  class="form-row"  enctype="multipart/form-data" style="display:block" id="form" onsubmit="handleSubmit()">
        <input type="hidden" id="method" value="ADD"/>
        <input type="hidden" id="id" name="id" value=""/><br>

        {!! csrf_field() !!}
        <div class="row"> 
            <div class="form-group col-md-6">
                <label for="employee_name" class="form-label fw-bold">Employee Name<a style="text-decoration: none;color:red">*</a></label>
                <input type="text" id="firstname" name="firstname" value="{{ old('firstname') }}" placeholder="Manager Name" class="form-control" autocomplete="off">
                <input type="text" id="emp_no" name="emp_no" hidden value="{{ old('emp_no') }}" class="form-control" autocomplete="off">
                <p style="color: red" id="error_firstname"></p>
            </div>
            <div class="form-group col-md-6">
                <label for="employee_no" class="form-label fw-bold">Employee No</label>
                <input type="text" id="employee_no" readonly name="employee_no" value="{{ old('employee_no') }}"  class="form-control" autocomplete="off">
            </div> 
            <div class="form-group col-md-6">
                <label for="emp_designation" class="form-label fw-bold">Employee Designation</label>
                <input type="text" id="desigination" readonly name="desigination" value="{{ old('desigination') }}" placeholder="Designation" class="form-control" autocomplete="off">
            </div> 
            <div class="form-group col-md-6">
                <label for="emp_dpart" class="form-label fw-bold">Employee Department</label>
                <input type="text" id="depart" name="depart" readonly value="{{ old('depart') }}" placeholder="Department" class="form-control" autocomplete="off">
            </div> 
        </div>
        <div class="row">
            <div class="form-group col-md-4">
                <label for="ot_eligibility" class="form-label fw-bold">OT Eligibility</label>
                <input type="text" id="over_time" name="over_time" readonly value="{{ old('over_time') }}" placeholder="OT" class="form-control" autocomplete="off">
            </div> 
            <div class="form-group col-md-4">
                <label for="project_name" class="form-label fw-bold">Project Name<a style="text-decoration: none;color:red">*</a></label>
                <input type="text" id="project_name" name="project_name" value="{{ old('project_name') }}" placeholder="Project Name" class="form-control" autocomplete="off">
                <input type="text" id="project_no" hidden name="project_no" value="{{ old('project_no') }}"  class="form-control" autocomplete="off">
                <p style="color: red" id="error_project_name"></p>
            </div> 
            <div class="form-group col-md-4">
                <label for="site_name" class="form-label fw-bold">Site Name<a style="text-decoration: none;color:red">*</a></label>
                <input type="text" id="site_name"  name="site_name" value="{{ old('site_name') }}" placeholder="Site Name" class="form-control" autocomplete="off">
                <input type="text" id="site_no"  name="site_no" hidden value="{{ old('site_no') }}"  class="form-control" autocomplete="off">
                <p style="color: red" id="error_site_name"></p>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-3">
                <label for="shift" class="form-label fw-bold">Shift</label>
                <input type="text" id="shift" name="shift" value="{{ old('shift') }}" placeholder="shift" class="form-control" autocomplete="off">
            </div>
            <div class="form-group col-md-3">
                <label for="task" class="form-label fw-bold">Task</label>
                <input type="text" id="task" name="task" value="{{ old('task') }}" placeholder="Task" class="form-control" autocomplete="off">
            </div>
            <div class="form-group col-md-3">
                <label for="join_date" class="form-label fw-bold">From Date<a style="text-decoration: none;color:red">*</a></label>
                <input type="date" id="from_date" name="from_date" value="{{ old('date') }}" placeholder="date" class="form-control" autocomplete="off">
                <p style="color: red" id="error_from_date"></p>
            </div>
            <div class="form-group col-md-3">
                <label for="join_date" class="form-label fw-bold">To Date<a style="text-decoration: none;color:red">*</a></label>
                <input type="date" id="to_date" name="to_date" value="{{ old('date') }}" placeholder="date" class="form-control" autocomplete="off">
                <p style="color: red" id="error_to_date"></p>
            </div>
        </div>
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
                <button type="submit" id="submit"  class="btn btn-primary mx-3 mt-3 ">ADD</button>
            </div>
        </div>
    </form>
    <!-- SHOW DIALOG -->
    <div class="card" id="show" style="display:none">
        <div class="card-body" style="background-color:white;width:100%;height:20%;" >
            <div class="row">
                <div class="col-md-3">
                    <label>Employee Name</label>
                    <p id="show_firstname"></p>
                </div>
                <div class="col-md-3">
                    <label>Employee No</label>
                    <p id="show_employee_no"></p>
                </div>
                <div class="col-md-3">
                    <label>Employee Designation</label>
                    <p id="show_desigination"></p>
                </div>
                <div class="col-md-3">
                    <label>Employee Department</label>
                    <p id="show_depart"></p>
                </div>
                <div class="col-md-3">
                    <label>OT Eligibility</label>
                    <p id="show_over_time"></p>
                </div>
                <div class="col-md-3">
                    <label>Project Name</label>
                    <p id="show_project_name"></p>
                </div>
                <div class="col-md-3">
                    <label>Site Name</label>
                    <p id="show_site_name"></p>
                </div>
                <div class="col-md-3">
                    <label>Shift</label>
                    <p id="show_shift"></p>
                </div>
                <div class="col-md-3">
                    <label>Task</label>
                    <p id="show_task"></p>
                </div>
                <div class="col-md-3">
                    <label>From Date</label>
                    <p id="show_from_date"></p>
                </div>
                <div class="col-md-3">
                    <label>To Date</label>
                    <p id="show_to_date"></p>
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
        var formattedDateNew = ('0' + day).slice(-2) + '/' + ('0' + month).slice(-2) + '/' + year;      
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
    // calculateTotalHours();
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
        $('#method').val("ADD");
        $('#submit').text("ADD");
        $('#heading_name').text("Add Timesheet").css('font-weight', 'bold');
        $('#show').css('display','none');
        $('#form').css('display','block');
        $('#blur-background').css('display','block');
    }

    // DELETE FUNCTION
    function handleDelete(id)
    {
        let url = '{{route('timesheetApi.delete',":id")}}';
        url= url.replace(':id',id);
        if (confirm("Are you sure you want to delete this Employee Timesheet?"))
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
        $("#myDialog").load(" #myDialog > *");
        i=1;
        $('#blur-background').css('display','none');
        // window.location.reload();
    }

    // DIALOG SUBMIT FOR ADD AND EDIT
    function handleSubmit()
    {
        event.preventDefault();
        let form_data = new FormData(document.getElementById('form'));
        let method = $('#method').val();
        let url;
        let type;
        if(method == 'ADD')
        {
            url = '{{route('timesheetApi.store')}}';
            type  = 'POST';
        } 
        else
        {
            let id = $('#id').val();
            url = '{{route('timesheetApi.update',":id")}}';
            url= url.replace(':id',id);
            type = 'POST';
        }
        $.ajax
        ({
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
                })
            }
        })
    }
    //DATA SHOW FOR EDIT AND SHOW
    function handleShowAndEdit(id,action)
    {
        let url = '{{route('timesheetApi.show',":id")}}';
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
                    $('#show').css('display','none');
                    $('#form').css('display','block');
                    $('#blur-background').css('display','block');

                    for (const [key, value] of Object.entries(message.time[0]))
                    {
                        $(`#${key}`).val(value);
                        if(message.time[0].over_time=="1")
                        {
                            $('#over_time').val("Yes");
                        }
                        else
                        {
                                $('#over_time').val("No");
                        }   
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
                        $('#heading_name').text('Edit Timesheet Entry').css('font-weight', 'bold');
        
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
                            script += '<td>' + (time.start_time || '-') + '</td>';
                            script += '<td>' + (time.end_time || '-') + '</td>';
                            script += '<td>' + (time.total_time || '-') + '</td>';
                            script += '<td>' + (time.ot_start_time || '-') + '</td>';
                            script += '<td>' + (time.ot_end_time || '-') + '</td>';
                            script += '<td>' + (time.ot_total_time || '-') + '</td>';
                            script += '<td>' + (holiday_flag || '-') + '</td>';
                            script += '<td>' + (leave_flag || '-') + '</td>';
                            script += '<td>' + (time.leave_type || '-') + '</td>';
                            script += '</tr>';
                        }
                        script+= '</tbody></table>';
                        $('#show_table').remove();
                        $('#item_details_show').append(script); 
                        $('#heading_name').text("View Timesheet").css('font-weight', 'bold');
                        $('#show').css('display','block');
                        $('#form').css('display','none');
                        $('#blur-background').css('display','block');
                        // script += '<td>' + convertTo12HourFormat(time.ot_end_time || '-') + '</td>';
                        // function convertTo12HourFormat(time) 
                        // {
                        //     var timeParts = time.split(':');
                        //     var hours = parseInt(timeParts[0]);
                        //     var minutes = parseInt(timeParts[1]);
                        //     var meridiem = 'AM';
                        //     if (hours >= 12) 
                        //     {
                        //         meridiem = 'PM';
                        //         if (hours > 12) {
                        //             hours -= 12;
                        //         }
                        //     }
                        //     var formattedTime = ('0' + hours).slice(-2) + ':' + ('0' + minutes).slice(-2) + ' ' + meridiem;
                        //     return formattedTime;
                        // }
                }
                        document.getElementById("myDialog").open = true;
            },
        })
    }



        // Employee master autocomplete
    jQuery($ => 
    {
        $(document).on('focus click', $("#city"), function()
        { 
            $("#firstname").autocomplete(
            {
                source: function( request, response ) 
                {
                    $.ajax
                    ({
                        type:"GET",
                        url: "{{ route('getemployeedata') }}",
                        dataType: "json",
                        data:
                        {
                            'firstname':$("#firstname").val()
                        },
                        success: function( data ) 
                        {
                            result = [];
                            for(var i in data)
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
            });
        });
    });
        // EMPLOYEE CODE
        $("#firstname").on('change',function()
        {
            var code= $(this).val();
            $.ajax
            ({
                type:"GET",
                url: "{{ route('getemployeedata') }}",
                dataType: "json",
                data:
                {
                    'firstname':$(this).val()
                },
                success: function( data ) 
                {
                    result = [];
                    for(var i in data)
                    {
                        $('#emp_no').val(data[i]["id"]);
                        $('#employee_no').val(data[i]["employee_no"]);
                        $('#desigination').val(data[i]["desigination"]);
                        $('#depart').val(data[i]["depart"]); 
                        if(data[i]["over_time"]=="1")
                        {
                            $('#over_time').val("Yes");
                        }
                        else
                        {
                            $('#over_time').val("No");
                        }   
                    }
                },
                fail: function(xhr, textStatus, errorThrown)
                {
                    alert(errorThrown);
                }
            });
        });


    // auto complete for sitename from sitemaster
    jQuery($ => 
    {
        $(document).on('focus click', $("#city"), function() 
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
            });
        });
    });
    // site code
        $("#site_name").on('change',function()
        {
            var code= $(this).val();
            $.ajax
            ({
                type:"GET",
                url: "{{ route('getsitedata') }}",
                dataType: "json",
                data:
                {
                    'site_name':$(this).val()
                },
                success: function( data ) 
                {
                    result = [];
                    for(var i in data)
                    {
                        $('#site_no').val(data[i]["site_no"]);
                        $('#site_code').val(data[i]["site_code"]);
                    }
                },
                fail: function(xhr, textStatus, errorThrown)
                {
                     alert(errorThrown);
                }
            });
        });


    //project name autocomplete from projectermaster
    jQuery($ => 
    {
        $(document).on('focus click', $("#city"), function() 
        {
            $("#project_name").autocomplete(
            {
                source: function( request, response ) 
                {
                    $.ajax
                    ({
                        type:"GET",
                        url: "{{ route('getlocdata') }}",
                        dataType: "json",
                        data:
                        {
                            'projectname':$("#project_name").val()
                        },
                        success: function( data ) 
                        {
                            result = [];
                            for(var i in data)
                            {
                                result.push(data[i]["project_name"]);
                            }
                            response(result);
                        },
                        fail: function(xhr, textStatus, errorThrown)
                        {
                            alert(errorThrown);
                        }
                    });
                },
            });
        });
    });
        $("#project_name").on('change',function()
        {
            var code= $(this).val();
            $.ajax
            ({
                type:"GET",
                url: "{{ route('getlocdata') }}",
                dataType: "json",
                data:
                {
                    'projectname':$(this).val()
                },
                success: function( data )
                {
                    result = [];
                    for(var i in data)
                    { 
                        $('#project_no').val(data[i]["project_no"]);
                        
                    }
                },
                fail: function(xhr, textStatus, errorThrown)
                {
                    alert(errorThrown);
                }
            });
        });

</script>

@stop                           
