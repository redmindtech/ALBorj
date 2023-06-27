<!-- STYLE INCLUDED IN LAYOUT PAGE -->
@extends('layouts.app',[
    'activeName' => 'Expensescatergory Master'
])
@section('title', 'ExpensesCatergory Master')

@section('content_header')
@stop

@section('content')
<!-- DATA table -->
     <div class="row">
                <div class="container-fluid">
                    <div class="card shadow">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h4 class="font-weight-bold text-dark py">EXPENSES CATEGORY MASTER</h4>
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
                                            <!-- <th>ID</th> -->
                                             <th>S.No</th>
                                            <th>Category Name</th>                                            
                                            <th>Description</th>
                                            <th>Date</th>
                                            <th data-orderable="false" class="action notexport">Show</th>
                                            <th data-orderable="false" class="action notexport">Edit</th>
                                            <th data-orderable="false"class="action notexport">Delete</th>
                                            <div id="blur-background" class="blur-background"></div>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($expenses as $key => $expense)
                                            <tr class="text-center">
                                                <!-- <td>{{$expense->id}}</td> -->
                                                <td>{{ $key += 1 }}</td>
                                                <td>{{$expense->category_name}}</td>
                                                <td>{{$expense->category_description}}</td>
                                                <td>{{ date('d-m-Y', strtotime($expense->created_at)) }}</td>
                                                <td>
                                                    <a  onclick="handleShowAndEdit('{{$expense->id}}','show')"
                                                        class="btn btn-primary btn-circle btn-sm"   >
                                                        <i class="fas fa-flag"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a onclick="handleShowAndEdit('{{$expense->id}}','edit')"
                                                        class="btn btn-info btn-circle btn-sm mx-2" >
                                                        <i class="fas fa-check"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <button  type="submit" class="btn btn-sm btn-danger" onclick="handleDelete('{{$expense->id}}')">
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
                        <!-- ADD AND EDIT FORM -->
                    <dialog id="myDialog">
                        <div class="row">
                            <div class="col-md-12">
                                <a class="btn  btn-sm" id="closeButton" onclick="handleClose()" style="float:right;padding: 10px 10px;">
                                    <i class="fas fa-close"></i>
                                </a>
                                <h4  id='heading_name' style='color:white' align="center"><b>Update ExpensesCategory</b></h4>
                            </div>
                        </div>
                        <form  class="form-row"  enctype="multipart/form-data" style="display:block" id="form" onsubmit="handleSubmit()">
                            <input type="hidden" id="method" value="ADD"/>
                            <input type="hidden" id="id" name="id" value=""/><br>

                            {!! csrf_field() !!}
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="category_name" class="form-label fw-bold">Category Name<a style="text-decoration: none;color:red">*</a></label>
                                    <input type="text" id="category_name"  name="category_name" value="{{ old('category_name') }}" placeholder="Category Name" class="form-control" autocomplete="off">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="category_description" class="form-label fw-bold">Description</label>
                                    <textarea id="category_description" name="category_description" value="{{ old('category_description') }}" placeholder="Category Description" class="form-control" autocomplete="off"></textarea>
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
                    <td><label>Category Name</label></td>
                    <td><p id="show_category_name"></p></td>
                </tr>
                <tr>
                    <td><label>Description</label></td>
                    <td><p id="show_category_description"></p></td>
                </tr>
            </tbody>
        </table>
        <br>
        <button type="button" id="print" class="btn btn-primary float-end">Print</button>
        </div>
</div>

                    </dialog>

<script type="text/javascript">
    $.ajaxSetup
    ({
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
         <!--ADD DIALOG  -->
<script type="text/javascript">
    function handleDialog()
    {
        document.getElementById("myDialog").open = true;
        window.scrollTo(0, 0);
        $('#method').val("ADD");
        $('#submit').text("ADD");
        $('#heading_name').text("Add ExpensesCategory Details").css('font-weight', 'bold');
        $('#show').css('display','none');
        $('#form').css('display','block');
        $('#blur-background').css('display','block');

    }
      // DELETE FUNCTION
    function handleDelete(id)
    {
        let url = '{{route('expensescategoryApi.delete',":id")}}';
        url= url.replace(':id',id);
        if (confirm("Are you sure want to delete this ExpensesCategory Details?"))
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
        $('.error-msg').removeClass('error-msg');
        $('.has-error').removeClass('has-error');
        // Hide any error messages
        $('error').html('');
        // Hide the dialog background
        $('#blur-background').css('display','none');
        
    }
    // DIALOG SUBMIT FOR ADD AND EDIT
    function handleSubmit()
    {
        event.preventDefault();
        var hiddenErrorElements = $('.error-msg:not(:hidden)').length;
            //  alert(hiddenErrorElements);
        if(hiddenErrorElements === 0)
        {
            let form_data = new FormData(document.getElementById('form'));
            let method = $('#method').val();
            let url;
            let type;
            if(method == 'ADD')
            {
                url = '{{route('expensescategoryApi.store')}}';
                type  = 'POST';
            }
            else
            {
                let id = $('#id').val();
                url = '{{route('expensescategoryApi.update',":id")}}';
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
                },error: function (message)
                {
                    var data = message.responseJSON;
                }
            })
        }

    }
    //DATA SHOW FOR EDIT AND SHOW
    var currentCategoryName;
    function handleShowAndEdit(id,action)
    {
        let url = '{{route('expensescategoryApi.show',":id")}}';
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
                    $('#heading_name').text("Update ExpensesCategory Details").css('font-weight', 'bold');
                    $('#show').css('display','none');
                    $('#form').css('display','block');
                    $('#blur-background').css('display','block');


                    for (const [key, value] of Object.entries(message))
                    {
                        console.log(`${key}: ${value}`);
                        $(`#${key}`).val(value);

                    }
                    $('#method').val('UPDATE');
                    $('#submit').text('UPDATE');
                    currentCategoryName = message.category_name.toLowerCase().replace(/ /g, '');
                } else
                {
                    for (const [key, value] of Object.entries(message))
                    {
                        $(`#show_${key}`).text(value);
                    }
                    $('#heading_name').text("ExpensesCategory Details").css('font-weight', 'bold');
                    $('#show').css('display','block');
                    $('#form').css('display','none');
                    $('#blur-background').css('display','block');

                }
                document.getElementById("myDialog").open = true;
                window.scrollTo(0, 0);
            },
        })
    }
    document.getElementById("print").addEventListener("click", function() {
        $('#heading_name').css('color', 'black').css('font-weight', 'bold');
        window.print();
        $('#heading_name').css('color', 'white').css('font-weight', 'bold');
    });
    // Initialize form validation

    var category_Name = @json($categoryNames);

    $.validator.addMethod("uniqueCategoryName", function(value, element)
    {
        var lowercaseValue = value.toLowerCase().replace(/\s/g, '');
        if ($("#method").val() !== "ADD" && lowercaseValue === currentCategoryName)
        {
            return true;
        }
        var lowercaseValu = value.toLowerCase().replace(/\s/g, '');
        return !category_Name.includes(lowercaseValu);
    });

    
    var formValidationConfig ={
        rules:
        {
            category_name:
            {
                required:true,
                uniqueCategoryName:true
            }
        },
        messages:
        {
            category_name: {
                required: "Please enter the category name",
                uniqueCategoryName: "This category name already exists. Please enter a different category name."
        }


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