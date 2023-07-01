<!-- STYLE INCLUDED IN LAYOUT PAGE -->
@extends('layouts.app', [
    'activeName' => 'item',
])
@section('title', 'Item Master')

@section('content_header')
@stop

@section('content')
    <!-- DATA table -->
    <div class="row">
        <div class="container-fluid">
            <div class="card shadow">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h4 class="font-weight-bold text-dark py">ITEM MASTER</h4>
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
                                    <!-- <th>S.No</th> -->
                                    <!-- <th>Item ID</th> -->
                                    <th>Item Name</th>
                                    <th>Item Category</th>
                                    <th>Item Subcategory</th>
                                    <th>Item Type</th>
                                    <th>Item Quantity</th>
                                    <th>Date</th>
                                    <th data-orderable="false" class="action notexport">Show</th>
                                    <th data-orderable="false" class="action notexport">Edit</th>
                                    <th data-orderable="false" class="action notexport">Delete</th>
                                    <div id="blur-background" class="blur-background"></div>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $key => $item)
                                    <tr class="text-center">
                                        <!-- <td>{{ $key += 1 }}</td> -->
                                        {{-- <td>{{$item->id}}</td> --}}
                                        <td>
                                            <a href="#{{ $item->id }}"
                                                onclick="handleShowAndEdit('{{ $item->id }}','audit')">{{ $item->item_name }}</a>
                                        </td>
                                        <td>{{ $item->item_category }}</td>
                                        <td>{{ $item->item_subcategory }}</td>

                                        <td>{{ $item->item_type }}</td>
                                        <td>{{ $item->total_quantity }}</td>
                                        <td>{{ date('d-m-Y', strtotime($item->created_at)) }}</td>


                                        <td>
                                            <a onclick="handleShowAndEdit('{{ $item->id }}','show')"
                                                class="btn btn-primary btn-circle btn-sm">
                                                <i class="fas fa-flag"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a onclick="handleShowAndEdit('{{ $item->id }}','edit')"
                                                class="btn btn-info btn-circle btn-sm mx-2">
                                                <i class="fas fa-check"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="handleDelete('{{ $item->id }}')">
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
                        <h4 id='heading_name' style='color:white' align="center"><b>Update Item </b></h4>
                    </div>
                </div>
                <form class="form-row" enctype="multipart/form-data" style="display:block" id="form"
                    onsubmit="handleSubmit()">
                    <input type="hidden" id="method" value="ADD" />
                    <input type="hidden" id="id" name="id" value="" /><br>

                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="item_name" class="form-label fw-bold">Item Name<a
                                    style="text-decoration: none;color:red">*</a></label>
                            <input type="text" id="item_name" name="item_name" value="{{ old('item_name') }}"
                                placeholder="Item Name" class="form-control" autocomplete="off">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="item_category" class="form-label fw-bold">Item category<a
                                    style="text-decoration: none;color:red">*</a></label>
                            <select id="item_category" name="item_category" class="form-control form-select" autocomplete="off"
                                onchange="itemcategory_load()">
                                <option value="">Select Option</option>
                                @foreach ($item_category as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="item_subcategory" class="form-label fw-bold">Item Sub category<a
                                    style="text-decoration: none;color:red">*</a></label>
                            <select id="item_subcategory" name="item_subcategory" class="form-control form-select"
                                autocomplete="off"></select>
                        </div>
                        </div>
                        <div class="row">
                        <div class="form-group col-md-4">
                            <label for="stock_type" class="form-label fw-bold">Stock Type<a
                                    style="text-decoration: none;color:red">*</a></label>
                            <select id="stock_type" name="stock_type" class="form-control form-select" autocomplete="off">
                                <option value="">Select Option</option>
                                @foreach ($stock_type as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="item_type" class="form-label fw-bold">Item Type<a
                                    style="text-decoration: none;color:red">*</a></label>
                            <select id="item_type" name="item_type" class="form-control form-select" autocomplete="off">
                                <option value="">Select Option</option>
                                @foreach ($item_type as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="item_unit" class="form-label fw-bold">Unit<a
                                    style="text-decoration: none;color:red">*</a></label>
                            <input type="text" id="item_unit" name="item_unit" value="{{ old('item_unit') }}"
                                placeholder="Item Unit" class="form-control" autocomplete="off">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="name" class="form-label fw-bold">Supplier Company Name</label>
                            <input type="text" id="company_name" name="company_name" value="{{ old('company_name') }}"
                                placeholder="Supplier Company Name" class="form-control" autocomplete="off" onchange="showQuantityField()">
                            <input type="text" id="supplier_no" name="supplier_no" hidden
                                value="{{ old('supplier_no') }}" placeholder="Supplier Id" class="form-control"
                                autocomplete="off">
                        </div>
                        <div class="form-group col-md-4" id="quantityField">
                            <label for="name" class="form-label fw-bold">Item Quantity</label>
                            <input type="number" id="quantity" name="quantity"
                                value="{{ old('quantity') }}" placeholder="Item Quantity" class="form-control"
                                autocomplete="off">
                                <input type="text" id="total_quantity" name="total_quantity" hidden
                                value="{{ old('total_quantity') }}" placeholder="Item Quantity" class="form-control"
                                autocomplete="off">
                                <div id="quantity-error" class="error-msg" style="display: none; color: red;"></div>
                        </div>
                        
                        <div class="form-group col-md-4">
                            <label for="supplier_code" class="form-label fw-bold">Supplier Code</label>
                            <input type="text" id="code" name="code" value="{{ old('code') }}"
                                placeholder="Supplier code" class="form-control" autocomplete="off" readonly>
                        </div>

                    </div>
                    <div class="form-group col-md-12">
                        <button type="submit" id="submit" class="btn btn-primary float-end ">ADD</button>
                    </div>
                </form>
                <!-- SHOW DIALOG -->
                <div class="card" id="show" style="display:none">
    <div class="card-body" style="background-color:white;">
        <table class="table">
            <tbody>
                <tr>
                    <td><label>Item Name</label></td>
                    <td><p id="show_item_name"></p></td>
                    <td><label>Item Unit</label></td>
                    <td><p id="show_item_unit"></p></td>
                    <td><label>Item Category</label></td>
                    <td><p id="show_item_category"></p></td>
                    <td><label>Item Subcategory</label></td>
                    <td><p id="show_item_subcategory"></p></td>
                </tr>
                <tr>
                    <td><label>Item Type</label></td>
                    <td><p id="show_item_type"></p></td>
                    <td><label>Stock Type</label></td>
                    <td><p id="show_stock_type"></p></td>
                    <td><label id="item_quantity">Item Total Quantity</label></td>
                    <td><p id="show_total_quantity"></p></td>
                </tr>
            </tbody>
        </table>
        <div id="item_details_show"></div>
    </div>
        
    <button type="button" id="print" class="btn btn-primary float-end">Print</button>
</div>
       
            </dialog>
            <script type="text/javascript">
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            </script>

            <script>
                $(function() {
                    $("#myTable").DataTable();
                });
                 $(document).ready(function() {
        // Update the total_quantity field when the quantity field changes
        $('#quantity').on('input', function() {
            var quantity = $(this).val();
            $('#total_quantity').val(quantity);
        });
    });
            </script>
            <!--ADD DIALOG  -->
            <script type="text/javascript">
                function handleDialog() {
                    document.getElementById("myDialog").open = true;
                    window.scrollTo(0, 0)
                    $('#method').val("ADD");
                    $('#submit').text("ADD");
                    $('#heading_name').text("Add Item Details").css('font-weight', 'bold');
                    $('#supplier_id').hide();
                    $('#show').css('display', 'none');
                    $('#form').css('display', 'block');
                    $('#blur-background').css('display', 'block');
                    // $('#total_quantity').val('0');
                     // Set default value of total_quantity to 0 if it is empty
                    $("#quantity").val('0' || $("#quantity").val());
                    itemcategory_load();
                    showQuantityField();
                }
                // DELETE FUNCTION
                function handleDelete(id) {
                    let url = '{{ route('itemApi.delete', ':id') }}';
                    url = url.replace(':id', id);
                    if (confirm("Are you sure want to delete this item Details?")) {
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            success: function(message) {
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
                        // Remove the show_table element
                        $('#show_table').remove();
                        $('.error-msg').removeClass('error-msg');
                        $('.has-error').removeClass('has-error');
                        // Hide any error messages
                        $('error').html('');
                        $("#quantity-error").hide();
                        // Hide the dialog background
                        $('#blur-background').css('display', 'none');
                      
                    }
                // DIALOG SUBMIT FOR ADD AND EDIT
                function handleSubmit() {
                    event.preventDefault();
                    var hiddenErrorElements = $('.error-msg:not(:hidden)').length;
                    //   alert(hiddenErrorElements);
                    if(hiddenErrorElements === 0)
                    {
                        let form_data = new FormData(document.getElementById('form'));
                        let method = $('#method').val();
                        let url;
                        let type;
                        if (method == 'ADD') {
                            url = '{{ route('store') }}';
                            type = 'POST';
                        } else {
                            let id = $('#id').val();
                            url = '{{ route('itemApi.update', ':id') }}';
                            url = url.replace(':id', id);
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
                            success: function(message) {
                                alert(message);
                                window.location.reload();
                            },
                            error: function(message) 
                            {
                                var data = message.responseJSON;
                               
                            }
                        })
                    }
                    
                }

                //DATA SHOW FOR EDIT AND SHOW
                var currentItemName;
                function handleShowAndEdit(id, action) {
                    let url = '{{ route('itemApi.show', ':id') }}';
                    url = url.replace(':id', id);

                    let type = "GET"
                    $.ajax({
                        url: url,
                        type: type,
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function(message) {

                            if (action == 'edit') {
                                $('#heading_name').text("Update Item Details").css('font-weight', 'bold');
                                $('#show').css('display', 'none');
                                $('#form').css('display', 'block');
                                $('#blur-background').css('display', 'block');
                                $("#item_category").val(message.itemsupplier[0].item_category).attr("selected",
                                    "selected");
                                itemcategory_load();
                                $("#item_subcategory").val(message.itemsupplier[0].item_subcategory).attr("selected",
                                    "selected");
                                for (const [key, value] of Object.entries(message.itemsupplier[0])) {
                                    $(`#${key}`).val(value);
                                }
                                showQuantityField();
                                document.getElementById("myDialog").open = true;
                                window.scrollTo(0, 0)
                                $('#method').val('UPDATE');
                                $('#submit').text('UPDATE');
                                currentItemName = message.itemsupplier[0].item_name.toLowerCase().replace(/ /g, '');
                            } else if (action == 'show') {
                                for (const [key, value] of Object.entries(message.itemsupplier[0])) {
                                    $(`#show_${key}`).text(value);
                                }
                                $('#heading_name').text("Item Details").css('font-weight', 'bold');
                                $('#show').css('display', 'block');
                                $('#form').css('display', 'none');
                                $('#supplier_name').hide();
                                $('#show_company_name').hide();
                                $('#supplier_code').hide();
                                $('#show_code').hide();
                                $('#item_quantity').show();
                                $('#show_total_quantity').show();
                                document.getElementById("myDialog").open = true;
                                window.scrollTo(0, 0)
                                $('#blur-background').css('display', 'block');

                            } else if (action == 'audit') {
                                if (message.items && message.items.length > 0) {
                                    // Rest of your code inside the 'if' block
                                    for (const [key, value] of Object.entries(message.itemsupplier[0])) {
                                        $(`#show_${key}`).text(value);
                                    }

                                    let script =
                                        '<table id="show_table" class="table table-striped"><thead><tr><th>Supplier Company Name</th><th>Quantity</th><th>Price</th></tr></thead><tbody>';

                                    for (const item of message.items) {
                                        script += '<tr>';
                                        script += '<td>' + item.company_name + '</td>';
                                        script += '<td>' + item.quantity + '</td>';
                                        script += '<td>' + item.price_per_qty + '</td>';
                                        script += '</tr>';
                                    }

                                    script += '</tbody></table>';
                                    $('#show_table').remove();
                                    $('#item_details_show').append(script);
                                    $('#heading_name').text("Audit Inventory").css('font-weight', 'bold');
                                    $('#show').css('display', 'block');
                                    $('#form').css('display', 'none');
                                    $('#supplier_name').hide();
                                    $('#show_company_name').hide();
                                    $('#supplier_code').hide();
                                    $('#show_code').hide();
                                    $('#item_quantity').hide();
                                    $('#show_total_quantity').hide();
                                    $('#blur-background').css('display', 'block');

                                    document.getElementById("myDialog").open = true;
                                    window.scrollTo(0, 0)
                                } else {
                                    
                                    for (const [key, value] of Object.entries(message.itemsupplier[0])) {
                                        $(`#show_${key}`).text(value);
                                    }

                                    let script =
                                        '<table id="show_table" class="table table-striped"><thead><tr><th>Company Name</th><th>Quantity</th><th>Price</th></tr></thead><tbody>';

                                    if (message.items && message.items.length > 0) {
                                        for (const item of message.items) {
                                            script += '<tr>';
                                            script += '<td>' + item.company_name + '</td>';
                                            script += '<td>' + item.quantity + '</td>';
                                            script += '<td>' + item.price_per_qty + '</td>';
                                            script += '</tr>';
                                        }
                                    } else {
                                        script += '<tr>';
                                        script += '<td colspan="3" style="text-align: center;">No data available in table</td>';
                                        script += '</tr>';
                                    }

                                    script += '</tbody></table>';
                                    $('#show_table').remove();
                                    $('#item_details_show').append(script);
                                    $('#heading_name').text("Audit Inventory").css('font-weight', 'bold');
                                    $('#show').css('display', 'block');
                                    $('#form').css('display', 'none');
                                    $('#supplier_name').hide();
                                    $('#show_company_name').hide();
                                    $('#supplier_code').hide();
                                    $('#show_code').hide();
                                    $('#item_quantity').hide();
                                    $('#show_total_quantity').hide();
                                    $('#blur-background').css('display', 'block');

                                    document.getElementById("myDialog").open = true;
                                    window.scrollTo(0, 0)

                                }

                            }
                        },
                    })
                }
            </script>

 <!-- Autocomplete company name from supplier master -->
<script>

jQuery($ => {
    $("#company_name").autocomplete({
        source: function(request, response) {
            $.ajax({
                type: "GET",
                url: "{{ route('getempdata_supplier_company') }}",
                dataType: "json",
                data: {
                    'suppliername': $("#company_name").val()
                },
                success: function(data) {
                    const result = data.map(item => item.company_name);
                    response(result);
                },
                fail: function(xhr, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        },
        select: function(event, ui) {
            var selectedCompanyName = ui.item.value;
            updateCompanyValue(selectedCompanyName);
        }
    });

    $("#company_name").on('focus click change', function() {
        var companyName = $(this).val();
        updateCompanyValue(companyName);
    });

    function updateCompanyValue(companyName) {
        $.ajax({
            type: "GET",
            url: "{{ route('getempdata_supplier_company') }}",
            dataType: "json",
            data: {
                'suppliername': companyName
            },
            success: function(data) {
                if (data.length > 0) {
                    $('#supplier_no').val(data[0].supplier_no);
                    $('#code').val(data[0].code);
                } else {
                    $('#supplier_no').val('');
                    $('#code').val('');
                }
                $("#quantity").val('');
                $("#quantity").prop('readonly', !companyName);
            },
            fail: function(xhr, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
    }
});



                function itemcategory_load() {
                    var selectedCategory = $('#item_category').val();
                    var subcategoryOptions = '';
                    if (selectedCategory === 'Electrical Works') {
                        @foreach (ITEMSUBCATEGORY['Electrical Items'] as $key => $value)
                            subcategoryOptions += '<option value="{{ $key }}">{{ $value }}</option>';
                        @endforeach
                    } else if (selectedCategory === 'Plumbing Works') {
                        @foreach (ITEMSUBCATEGORY['Plumbing Items'] as $key => $value)
                            subcategoryOptions += '<option value="{{ $key }}">{{ $value }}</option>';
                        @endforeach
                    }
                    $('#item_subcategory').html('<option value="" class="default-option">Select Option</option>' +
                        subcategoryOptions);
                }

            //    Quantity Field supplier name null quantity field readonly
                function showQuantityField() 
                {
                    var supplierName = document.getElementById("company_name").value;
                    var quantityField = document.getElementById("quantity");

                    if (supplierName !== "") 
                    {
                        quantityField.removeAttribute("readonly");
                    } 
                    else 
                    {
                        quantityField.setAttribute("readonly", "readonly");
                        quantityField.value = 0; // Set the quantity value to 0 when hiding the field
                    }

                    handleShowAndEdit('edit');
                }

                document.getElementById("print").addEventListener("click", function() {
                    $('#heading_name').css('color', 'black').css('font-weight', 'bold');
                   window.print();
                   $('#heading_name').css('color', 'white').css('font-weight', 'bold');
                });
                var item_Name = @json($itemName);
   
    var supplier_company=@json($supplier_company);

    $.validator.addMethod("uniqueItemName", function(value, element)
    {
        var lowercaseValue = value.toLowerCase().replace(/\s/g, '');

        if ($("#method").val() !== "ADD" && lowercaseValue === currentItemName)
        {
            return true;
        }
        var lowercaseValu = value.toLowerCase().replace(/\s/g, '');
        return !item_Name.includes(lowercaseValu);
    });

  
    $.validator.addMethod("suppliercompanyCheck", function(value, element) {
  if (value.trim() === "") {
    return true; // If value is empty, validation is considered successful
  }
  return supplier_company.includes(value);
});

         
    var formValidationConfig ={
    
        rules:
        {
            item_name:
            {
                required: true,
                uniqueItemName:true
            },
           item_unit:"required",
            item_category:"required",
            item_subcategory:"required",
            stock_type:"required",
            item_type:"required",
            company_name: {
            suppliercompanyCheck: true
        },
        
        },
        messages:
        {
            item_name: {
            required: "Please enter the item name",
            uniqueItemName: "This item name already exists. Please enter a different item name."
        },
        item_unit:"Please enter the item unit",
        item_category: "Please select the item category",
        item_subcategory: "Please select the item subcategory",
        stock_type: "Please select the stock type",
        item_type: "Please select the item type",
        company_name: {
            suppliercompanyCheck: "Please enter a valid supplier company name."
        },

            

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
       
    $(document).ready(function() {
  $("#company_name").on("focusout", function() {
    var companyName = $(this).val().trim();
    var quantity = $("#quantity").val().trim();

    if (companyName !== "" && quantity === "") {
      $("#quantity-error").text("Please enter the item quantity ");
      $("#quantity-error").show();
    } 
    
    else {
      $("#quantity-error").hide();
    }
  });
  $("#quantity").on("focusout", function() {
    var companyName = $("#company_name").val().trim();
    var quantity = $(this).val().trim();

    if (companyName !== "" && quantity === "0") {
      $("#quantity-error").text("The item quantity should not be 0");
      $("#quantity-error").show();
    }
     else {
      $("#quantity-error").hide();
    }
});
  });
    $("#form").validate(formValidationConfig);
</script>
@stop