<!-- STYLE INCLUDED IN LAYOUT PAGE -->
@extends('layouts.app',[
    'activeName' => 'Expenses'
])
@section('title', 'Expenses')

@section('content_header')
@stop

@section('content')
<!-- DATA table -->
<div class="row">
    <div class="container-fluid">
        <div class="card shadow">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h4 class="font-weight-bold text-dark py">EXPENSES</h4>
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

                                <th>voucher No</th>
                                <th>Bill Date</th>
                                <th>Employee Name</th>
                                <th>Project Name</th>
                                <th>Total Amount</th>
                                <th>Supplier Name</th>
                                <th>Expense Category</th>
                                <th>Source</th>
                                <th>Bill Amount</th>
                                <th>Vat</th>
                                <th>Date</th>
                                <th data-orderable="false" class="action notexport">Show</th>
                                <th data-orderable="false" class="action notexport">Edit</th>
                                <th data-orderable="false" class="action notexport">Delete</th>
                                <div id="blur-background" class="blur-background"></div>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($expenses as $expense)
                                <tr class="text-center">
                                    <td>{{$expense->exp_code}}</td>
                                    <td>{{date('d-m-Y', strtotime($expense->bill_date))}}</td>
                                    <td>{{$expense->firstname}}</td>
                                    <td>{{$expense->project_name}}</td>
                                    <td>{{$expense->total_amount}}</td>
                                    <td>{{$expense->name}}</td>
                                    <td>{{$expense->exp_category_no}}</td>
                                    <td>{{$expense->source}}</td>
                                    <td>{{$expense->bill_amount}}</td>
                                    <td>{{$expense->vat}}</td>
                                    <td>{{ date('d-m-Y', strtotime($expense->date)) }}</td>
                                    <td>
                                        <a  onclick="handleShowAndEdit('{{$expense->exp_no}}','show')" class="btn btn-primary btn-circle btn-sm">
                                            <i class="fas fa-flag"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a onclick="handleShowAndEdit('{{$expense->exp_no}}','edit')" class="btn btn-info btn-circle btn-sm mx-2" >
                                            <i class="fas fa-check"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <button  type="submit" class="btn btn-sm btn-danger" onclick="handleDelete('{{$expense->exp_no}}')">
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
                <h4  id='heading_name' style='color:white' align="center"><b>Update</b></h4>
            </div>
        </div>
        <form  class="form-row"  enctype="multipart/form-data" style="display:block" id="form" onsubmit="handleSubmit()">
            <input type="hidden" id="method" value="ADD"/>
            <input type="hidden" id="exp_no" name="exp_no" value=""/><br>

            {!! csrf_field() !!}

            <div class="row">
                <div class="form-group col-md-12">
                    <label for="exp_code" id="code_lable"class="form-label fw-bold">Voucher No</label>
                    <input type="text" id="exp_code" name="exp_code" readonly value="{{ old('exp_code') }}" placeholder="Expenses Code" class="form-control" autocomplete="off">
                </div>
            </div>
            <div class="row g-3">
                <div class="form-group col-md-4">
                    <label for="bill_no" class="form-label fw-bold">Bill No</label>
                    <input type="text" id="bill_no"  name="bill_no" value="{{ old('bill_no') }}" placeholder="Bill No" class="form-control" autocomplete="off">
                </div>
                <div class="form-group col-md-4">
                    <label for="bill_date" class="form-label fw-bold">Bill Date</label>
                    <input type="date" id="bill_date"  name="bill_date" value="{{ old('bill_date') }}" placeholder="Bill Date" class="form-control" autocomplete="off">
                </div>
                <div class="form-group col-md-4">
                    <label for="employee_name" class="form-label fw-bold">Employee Name<a style="text-decoration: none;color:red">*</a></label>
                    <input type="text" id="firstname" name="firstname" value="{{ old('firstname') }}" placeholder="Employee Name" class="form-control" autocomplete="off">
                    <input type="text" id="employee_no" hidden name="employee_no" value="{{ old('employee_no') }}"  class="form-control" autocomplete="off">
                </div>
                <div class="form-group col-md-4">
                    <label for="project_name" class="form-label fw-bold">Project Name<a style="text-decoration: none;color:red">*</a></label>
                    <input type="text" id="project_name" name="project_name" value="{{ old('project_name') }}" placeholder="Project Name" class="form-control" autocomplete="off">
                    <input type="text" id="project_no" hidden name="project_no" value="{{ old('project_no') }}"  class="form-control" autocomplete="off">
                </div>
                <div class="form-group col-md-4">
                    <label for="supplier_name" class="form-label fw-bold">Supplier Name<a style="text-decoration: none;color:red">*</a></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Supplier Name" class="form-control" autocomplete="off">
                    <input type="text" id="supplier_no" hidden name="supplier_no" value="{{ old('supplier_no') }}"  class="form-control" autocomplete="off">
                </div>

                <div class="form-group col-md-4">
                    <label for="expense_category" class="form-label fw-bold">Expense Category<a style="text-decoration: none;color:red">*</a></label>
                    <select id="exp_category_no" name="exp_category_no" class="form-control form-select" autocomplete="off" style="width:100%">
                        <option value="">Select Option</option>
                        @foreach ($exp_category as $key => $value)
                            <option value="{{ $value->category_name  }}">{{ $value->category_name }}</option>
                        @endforeach
                    </select>
                    <div id="exp_category_no-error" class="error-msg" style="display: none;"></div>
                </div>
                <div class="form-group col-md-4">
                    <label for="bill_amount" class="form-label fw-bold">Bill Amount<a style="text-decoration: none;color:red">*</a></label>
                    <input type="text" id="bill_amount"  name="bill_amount" value="{{ old('bill_amount') }}" placeholder="Bill Amount" class="form-control" autocomplete="off">
                </div>
                <div class="form-group col-md-4">
                    <label for="vat" class="form-label fw-bold">Vat<a style="text-decoration: none;color:red">*</a></label>
                    <select id="vat" name="vat" class="form-control form-select" autocomplete="off">
                        <option value="">Select Option</option>
                        @foreach($vat as $key => $value)
                            <option value="{{ $key }}">{{$value.'%'}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="total_amount" class="form-label fw-bold">Total Amount</a></label>
                    <input type="text" id="total_amount"  name="total_amount" readonly value="{{ old('total_amount') }}" placeholder="Total Amount" class="form-control" autocomplete="off">
                </div>
                <div class="form-group col-md-4">
                    <label for="source" class="form-label fw-bold">Source<a style="text-decoration: none;color:red">*</a></label>
                    <select id="source" name="source" class="form-control form-select" autocomplete="off" >
                        <option value="">Select Option</option>
                        @foreach($source as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="cheque_no" class="form-label fw-bold">Cheque No</a></label>
                    <input type="text" id="cheque_no"  name="cheque_no" value="{{ old('cheque_no') }}" placeholder="Cheque No" class="form-control" autocomplete="off">
                </div>
                <div class="form-group col-md-4">
                    <label for="cheque_date" class="form-label fw-bold">Cheque Date</a></label>
                    <input type="date" id="cheque_date"  name="cheque_date" value="{{ old('cheque_date') }}" placeholder="Cheque Date" class="form-control" autocomplete="off">
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-2">
                    <label for="">Attachments</label>
                </div>
                <div class="col-md-4">
                    <input type="file" name="attachment" class="form-control">
                    <span id="filename"></span>
                </div>
                <div class="col-md-6">
                    <button type="button" id="deleteButton" class="btn btn-danger">Delete</button>
                    <input type="hidden" name="delete_attachment" id="deleteAttachmentInput" value="0">
                </div>
            </div>
        <div class="row">
            <div class="form-group col-md-12">
                <label for="description" class="form-label fw-bold">Description</label>
                <textarea id="description" name="description" value="{{ old('description') }}" placeholder="Description" class="form-control" autocomplete="off"></textarea>
            </div>
        </div>
        <div class="form-group col-md-12">
            <button type="submit" id="submit"  class="btn btn-primary float-end ">ADD</button>
        </div>
    </form>
    <!-- SHOW DIALOG -->
    <div class="card" id="show" style="display:none">
        <div class="card-body" style="background-color:white;">
            <table class="table">
                <tbody>
                <tr>
                    <td><label>Voucher No</label></td>
                    <td><p id="show_exp_code"></p></td>
                    <td><label>Bill No</label></td>
                    <td><p id="show_bill_no"></p></td>
                </tr>
                <tr>
                    <td><label>Bill Date</label></td>
                    <td><p id="show_bill_date"></p></td>
                    <td><label>Employee Name</label></td>
                    <td><p id="show_firstname"></p></td>
                </tr>
                <tr>
                    <td><label>Project Name</label></td>
                    <td><p id="show_project_name"></p></td>
                    <td><label>Supplier Name</label></td>
                    <td><p id="show_name"></p></td>
                </tr>
                <tr>
                    <td><label>Expense Category</label></td>
                    <td><p id="show_exp_category_no"></p></td>
                    <td><label>Source</label></td>
                    <td><p id="show_source"></p></td>
                </tr>
                <tr>
                    <td><label>Bill Amount</label></td>
                    <td><p id="show_bill_amount"></p></td>
                    <td> <label>Vat</label>
                    <td><p id="show_vat"></p></td>
                <tr>
                    <td><label>Total Amount</label></td>
                    <td><p id="show_total_amount"></p></td>
                    <td><label>Attachment</label></td>
                    <td><p id="show_filename"></p></td>
                </tr>
                <tr>
                    <td><label>Cheque No</label></td>
                    <td><p id ="show_cheque_no"></p></td>
                    <td><label>Cheque Date</label></td>
                    <td><p id ="show_cheque_date"></p></td>
                </tr>
                <tr>
                    <td><label>Description</label></td>
                    <td><p id="show_description"></p></td>
                </tr>
                </tbody>
            </table>
            <br>
            <button type="button" id="print" class="btn btn-primary float-end">Print</button>
        </div>
    </div>

</dialog>


<script type="text/javascript">
    $.ajaxSetup(
    {
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script>
    $(function ()
    {
        $("#myTable").DataTable();
    });
</script>
<script>
    // delete attachment

    document.getElementById("deleteButton").addEventListener("click", function()
    {
        if (confirm("Are you sure you want to delete this attachment?"))
        {
            document.getElementById("deleteAttachmentInput").value = "1";
            document.querySelector("input[name='attachment']").value = "";
            document.getElementById("filename").textContent = "";
        }
    });
    //Print
    document.getElementById("print").addEventListener("click", function()
    {
        $('#heading_name').css('color', 'black').css('font-weight', 'bold');
        window.print();
        $('#heading_name').css('color', 'white').css('font-weight', 'bold');
    });
</script>
<script type="text/javascript">

    //ADD DIALOG

    function handleDialog()
    {
        document.getElementById("myDialog").open = true;
        window.scrollTo(0, 0);
        $('#method').val("ADD");
        $('#submit').text("ADD");
        $('#heading_name').text("Add Expenses Details").css('font-weight', 'bold');
        $('#exp_code').hide();
        $('#code_lable').hide();
        $('#show').css('display','none');
        $('#form').css('display','block');
        $('#blur-background').css('display','block');

    }

    // DELETE FUNCTION
    function handleDelete(id)
    {
        let url = '{{route('expenseApi.delete',":exp_no")}}';
        url= url.replace(':exp_no',id);
        if (confirm("Are you sure you want to delete this Expenses Details?"))
        {
            $.ajax(
            {
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
        $('.error-msg').removeClass('error-msg');
        $('.has-error').removeClass('has-error');
        // Hide any error messages
        $('error').html('');
        // Hide the dialog background
        $('#blur-background').css('display','none');
        // Reset Select2 dropdowns
        $('#exp_category_no').val(null).trigger('change');
    }

    // DIALOG SUBMIT FOR ADD AND EDIT
    function handleSubmit()
    {
        event.preventDefault();
        var hiddenErrorElements = $('.error-msg:not(:hidden)').length;
            // alert(hiddenErrorElements);
        if(hiddenErrorElements === 0)
        {
            let form_data = new FormData(document.getElementById('form'));
            let method = $('#method').val();
            let url;
            let type;
            if(method == 'ADD')
            {
                url = '{{route('expenseApi.store')}}';
                type  = 'POST';

            } else
            {
                let id = $('#exp_no').val();
                url = '{{route('expenseApi.update',":exp_no")}}';
                url= url.replace(':exp_no',id);
                type = 'POST';
            }
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
                },error: function (message)
                {
                    var data = message.responseJSON;

                }
            })
        }
    }

        //DATA SHOW FOR EDIT AND SHOW
    function handleShowAndEdit(id,action)
    {
        let url = '{{route('expenseApi.show',":exp_no")}}';
        url = url.replace(':exp_no',id);

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
                    $('#heading_name').text("Update Expenses Details").css('font-weight', 'bold');
                    $('#show').css('display','none');
                    $('#form').css('display','block');
                    $('#blur-background').css('display','block');

                    console.log(message[0]);
                    for (const [key, value] of Object.entries(message[0]))
                    {
                        $(`#${key}`).val(value);
                        // Select the option with a value of '1'
                        $('#exp_category_no').val(message[0].exp_category_no);
                        $('#exp_category_no').select2({ tags: true }).trigger('change');
                    }
                    console.log(message.filename);
                    $('#filename').text(message.filename);
                    $('#method').val('UPDATE');
                    $('#submit').text('UPDATE');
                }
                else
                {
                    for (let [key, value] of Object.entries(message[0]))
                    {
                        if (key === "bill_date" || key === "cheque_date")
                        {
                            if(value == '')
                            {
                                value='';
                            }
                            else
                            {
                                var dateObj = new Date(value);
                                var day = dateObj.getDate();
                                var month = dateObj.getMonth() + 1;
                                var year = dateObj.getFullYear();
                                value= day + '-' + month + '-' + year
                            }
                        }
                        $(`#show_${key}`).text(value);
                    }
                    $('#heading_name').text("View Expenses Details").css('font-weight', 'bold');
                    $('#show').css('display','block');
                    $('#form').css('display','none');
                    $('#blur-background').css('display','block');

                }
                document.getElementById("myDialog").open = true;
                window.scrollTo(0, 0);
            },
        })
    }

    // auto complete project master from project name
    jQuery($ =>
    {
        $(document).on('focus click', $("#firstname"), function()
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
                console.log(data);
                result = [];
                for(var i in data)
                {
                    $('#employee_no').val(data[i]["id"]);
                }
                    console.log(result);
            },
            fail: function(xhr, textStatus, errorThrown)
            {
                alert(errorThrown);
            }
        });
    });

    // Supplier name Autocomplete from supplier master
    jQuery($ =>
    {
        $(document).on('focus click', $("#name"), function()
        {
            $("#name").autocomplete(
            {
                source: function( request, response )
                {
                    $.ajax
                    ({
                        type:"GET",
                        url: "{{ route('getempdata') }}",
                        dataType: "json",
                        data:
                        {
                            'suppliername':$("#name").val()
                        },
                        success: function( data )
                        {

                            result = [];
                            for(var i in data)
                            {
                                result.push(data[i]["name"]);
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
    // Supplier code
    $("#name").on('change',function()
    {
        var code= $(this).val();
        $.ajax
        ({
            type:"GET",
            url: "{{ route('getempdata') }}",
            dataType: "json",
            data:
            {
                'suppliername':$(this).val()
            },
            success: function( data )
            {
                result = [];
                for(var i in data)
                {
                    $('#supplier_no').val(data[i]["supplier_no"]);
                    $('#code').val(data[i]["code"]);
                }
            },
            fail: function(xhr, textStatus, errorThrown)
            {
            alert(errorThrown);
            }
        });
    });

    // projectname
    // current location auto complete
    jQuery($ =>
    {
        $(document).on('focus click', $("#project_name"), function()
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
    //Project number
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

    // bill_amount and vat inputs
    $('#bill_amount, #vat').on('input', function()
    {
        var billAmount = parseFloat($('#bill_amount').val()) || 0;
        var vat = parseFloat($('#vat').val()) || 0;
        var totalAmount = billAmount + (billAmount * (vat / 100));
        $('#total_amount').val(totalAmount.toFixed(2));
    });

     // select 2
    $(document).ready(function()
    {
        $('#exp_category_no').select2(
        {
            tags: true
        }).next().find('.select2-selection').attr('aria-labelledby', 'exp_category_no-label');
    });
    // Initialize form validation

    var employee_name = @json($employee_name);
    var project_name=@json($project_name);
    var supplier_name =@json($supplier_name);

    $.validator.addMethod("employeeNameCheck", function(value, element)
    {
        return employee_name.includes(value);
    });
    $.validator.addMethod("projectNameCheck", function(value, element)
    {
        return project_name.includes(value);
    });
    $.validator.addMethod("supplierNameCheck", function(value, element)
    {
        return supplier_name.includes(value);
    });

    jQuery($ => {
                    $(document).on('focusout', '.select2-selection', function()
                    {
                        var value = $(this).text();
                        console.log(value);
                        console.log($(this).attr('aria-labelledby'));


                        if ($(this).attr('aria-labelledby') == 'exp_category_no-label')
                        {
                            if (!/^[A-Za-z0-9\s\W]+$/i.test(value)) {
                                $("#exp_category_no-error").text("Please enter the valid working.");
                                $("#exp_category_no-error").show();
                            } else {
                                $("#exp_category_no-error").hide();
                            }
                        }
                    });
                });

    var formValidationConfig = {
        rules:
        {
            firstname:
            {
                required : true,
                employeeNameCheck:true
            },
            project_name:
            {
                required : true,
                projectNameCheck:true
            },
            name:
            {
                required : true,
                supplierNameCheck:true
            },
            exp_category_no:"required",
            bill_amount:"required",
            vat:"required",
            source:"required",
        },
        messages:
        {
            firstname:
            {
                required :"Please enter the employee name",
                employeeNameCheck:"Please enter valid employee name"
            },
            project_name:
            {
                required :"Please select a Project Name",
                projectNameCheck:"Please enter valid project name"
            },
            name:
            {
                required :"Please enter supplier name",
                supplierNameCheck:"Please enter valid supplier name"
            },
            exp_category_no:"please select the expense category",
            bill_amount:"Please enter the bill amount",
            vat:"Please select the vat",
            source:"Please select the Source"
        },
        errorElement: "error",
        errorClass: "error-msg",
        highlight: function(element, errorClass, validClass)
        {
            $(element).addClass(errorClass).removeClass(validClass);
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass)
        {
            $(element).removeClass(errorClass).addClass(validClass);
            $(element).closest('.form-group').removeClass('has-error');
        }
    };

    $("#form").validate(formValidationConfig);

</script>

@stop