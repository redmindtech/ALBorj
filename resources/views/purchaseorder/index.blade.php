<!-- STYLE INCLUDED IN LAYOUT PAGE -->
@extends('layouts.app',[
    'activeName' => 'purchase'
])
@section('title', 'Purchase Order')

@section('content_header')
@stop

@section('content')
<!-- DATA table -->
    <div class="row">
        <div class="container-fluid">
            <div class="card shadow">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h4 class="font-weight-bold text-dark py">PURCHASE ORDER</h4>
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
                                    <th>S.NO</th>
                                    <th>PO Code</th>
                                    <th>PO Type</th>
                                    <!-- <th>PO Date</th> -->
                                    <th>Supplier Name</th>
                                    <th>Delivery Location</th>
                                    <th>Delivery Terms</th>
                                    <th>PO Prepared By</th>
                                    <th>Vat</th>
                                    <th>Grand Total</th>
                                    <th data-orderable="false" class="action notexport">Show</th>
                                    <th data-orderable="false" class="action notexport">Edit</th>
                                    <th data-orderable="false" class="action notexport">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($purchase_orders as $key => $purchase_order)
                                    <tr class="text-center">
                                        <td>{{$key+=1}}</td>
                                        <td>{{$purchase_order->po_code}}<div id="blur-background" class="blur-background"></div></td>
                                        <td>{{$purchase_order->po_type}}</td>
                                        <!-- <td>{{$purchase_order->po_date}}</td> -->
                                        <td>{{$purchase_order->name}}</td>
                                        <td>{{$purchase_order->delivery_location}}</td>
                                        <td>{{$purchase_order->delivery_terms}}</td>
                                        <td>{{$purchase_order->po_prepared}}</td>
                                        <td>{{$purchase_order->vat}}</td>
                                        <td>{{$purchase_order->gross_amount}}</td>
                                        <td>
                                            <a  onclick="handleShowAndEdit('{{$purchase_order->po_no}}','show')"
                                                class="btn btn-primary btn-circle btn-sm"   >
                                                <i class="fas fa-flag"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a onclick="handleShowAndEdit('{{$purchase_order->po_no}}','edit')"
                                                        class="btn btn-info btn-circle btn-sm mx-2" >
                                                        <i class="fas fa-check"></i>
                                                    </a>
                                                </td>
                                                <td>
                                        <button  type="submit" class="btn btn-sm btn-danger" onclick="handleDelete('{{$purchase_order->po_no}}')">
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
                    <dialog id="myDialog"  style="width:1000px;">
                        <div class="row">

                            <div class="col-md-12">

                                 <a class="btn  btn-sm" onclick="handleClose()" style="float:right;padding: 10px 10px;"><i class="fas fa-close"></i></a>
                                 <h4  id='heading_name' style='color:white' align="center"><b>Update purchaseOrder </b></h4>
                                </div>
                        </div>



                        <form  class="form-row"  enctype="multipart/form-data" style="display:block" id="form" onsubmit="handleSubmit()">
                            <input type="hidden" id="method" value="ADD"/>
                            <input type="hidden" id="po_no" name="po_no" value=""/><br>

            {!! csrf_field() !!}
            <div class="row g-3">
                <div class="form-group col-md-4">
                    <label for="po_type" class="form-label fw-bold">Type<a style="text-decoration: none;color:red">*</a></label>
                    <select id="po_type" name="po_type" class="form-control" autocomplete="off">
                    <option value="">Select Option</option>
                    @foreach($po_type as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
                    </select>
                    <p style="color: red" id="error_po_type"></p>
                </div>

                <div class="form-group col-md-4">
                    <label for="supplier_name" class="form-label fw-bold">Supplier Name<a
                            style="text-decoration: none;color:red">*</a></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                        placeholder="Supplier Name" class="form-control supplier_name" autocomplete="off">
                    <input type="text" id="supplier_no" hidden name="supplier_no"
                        value="{{ old('supplier_no') }}" class="form-control supplier_no" autocomplete="off">
                    <p style="color: red" id="error_supplier_no"></p>
                </div>

                <div class="form-group col-md-4">
                    <label for="po_date" class="form-label fw-bold">Date<a style="text-decoration: none;color:red">*</a></label>
                    <input type="date" id="po_date" name="po_date" value="{{ old('po_date') }}" placeholder="Site Building" class="form-control" autocomplete="off" data-date-format="dd-mm-yy">
                    <p style="color: red" id="error_po_date"></p>
                </div>

                <div class="form-group col-md-4">
                    <label for="quote_ref" class="form-label fw-bold">Quote Reference</label>
                    <input type="text" id="quote_ref" name="quote_ref" value="{{ old('quote_ref') }}" placeholder="Quote Reference" class="form-control" autocomplete="off">
                    <p style="color: red" id="error_quote_ref"></p>
                </div>
                <div class="form-group col-md-4">
                    <label for="quote_date" class="form-label fw-bold">Quote Date<a style="text-decoration: none;color:red">*</a></label>
                    <input type="date" id="quote_date" name="quote_date" value="{{ old('quote_date') }}" class="form-control" autocomplete="off">
                    <p style="color: red" id="error_quote_date"></p>
                </div>
                <div class="form-group col-md-4">
                    <label for="currency" class="form-label fw-bold">Currency<a style="text-decoration: none;color:red">*</a></label>
                    <select id="currency" name="currency" class="form-control" autocomplete="off">
                        @foreach ($currency as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    <p style="color: red" id="error_currency"></p>
                </div>
                <div class="form-group col-md-4">
                    <label for="email" class="form-label fw-bold">Email</label>
                    <input type="email" id="mail_id" name="mail_id" value="{{ old('mail_id') }}"
                        placeholder="Email" class="form-control email" autocomplete="off" readonly>
                    <p style="color: red" id="error_email"></p>
                </div>
                <div class="form-group col-md-4">
                    <label for="contact_person" class="form-label fw-bold">Contact Person</label>
                    <input type="text" id="c_name" name="c_name" value="{{ old('name') }}" placeholder="Contact Person" class="form-control contact_person" autocomplete="off" readonly>
                    <p style="color: red" id="error_contact_person"></p>
                </div>
                <div class="form-group col-md-4">
                    <label for="mobile_no" class="form-label fw-bold">Mobile Number</label>
                    <input type="text" id="contact_number" name="contact_number" value="{{ old('mobile_no') }}" placeholder="Mobile Number" class="form-control mobile_no" autocomplete="off" readonly>
                    <p style="color: red" id="error_mobile_no"></p>
                </div>
                <div class="form-group col-md-4">
                    <label for="website" class="form-label fw-bold">Website</label>
                    <input type="text" id="website" name="website" value="{{ old('website') }}" placeholder="Website" class="form-control website" autocomplete="off" readonly>
                    <p style="color: red" id="error_website"></p>
                </div>
                <div class="form-group col-md-4">
                    <label for="credit_period" class="form-label fw-bold">Credit period<a style="text-decoration: none;color:red">*</a></label>
                    <input type="date" id="credit_period" name="credit_period" value="{{ old('credit_period') }}"  class="form-control" autocomplete="off">
                    <p style="color: red" id="error_credit_period"></p>
                </div>
                <div class="form-group col-md-4">
                    <label for="Payment Terms" class="form-label fw-bold">Payment Terms (In Percentage)<a style="text-decoration: none;color:red">*</a></label>
                    <input type="text" id="payment_terms" name="payment_terms" value="{{ old('payment_terms') }}" placeholder="Payment Terms" class="form-control" autocomplete="off">
                    <p style="color: red" id="error_payment_terms"></p>
                </div>
                <div class="form-group col-md-4">
                    <label for="delivery_location" class="form-label fw-bold">Delivery Location<a
                            style="text-decoration: none;color:red">*</a></label>
                    <input type="text" id="project_name" name="delivery_location"
                        value="{{ old('delivery_location') }}" placeholder="Delivery Location"
                        class="form-control" autocomplete="off">
                    <input type="text" id="project_no" hidden name="delivery_location"
                        value="{{ old('delivery_location') }}" class="form-control" autocomplete="off">
                        <p style="color: red" id="error_delivery_location"></p>
                </div>
                <div class="form-group col-md-4">
                    <label for="delivery_terms" class="form-label fw-bold">Delivery Terms<a style="text-decoration: none;color:red">*</a></label>
                    <input type="text" id="delivery_terms" name="delivery_terms" value="{{ old('delivery_terms') }}" placeholder="Delivery Terms" class="form-control" autocomplete="off">
                    <p style="color: red" id="error_delivery_terms"></p>
                </div>
                <div class="form-group col-md-4">
                    <label for="po_prepared" class="form-label fw-bold">Prepared By<a
                            style="text-decoration: none;color:red">*</a></label>
                    <input type="text" id="firstname" name="firstname"
                        value="{{ old('firstname') }}" placeholder="Po Prepared By"
                        class="form-control" autocomplete="off">
                    <input type="text" id="id" hidden name="po_prepared"
                        value="{{ old('po_prepared') }}" class="form-control" autocomplete="off">
                        <p style="color: red" id="error_po_prepared"></p>
                </div>

                <div class="form-group col-md-1">
                    <label for="mr_reference_code" class="form-label fw-bold">PULL MR NO</label>
                </div>
                <div class="form-group col-md-6">

                    <input type="text" id="mr_id" name="mr_no" value="{{ old('mr_no') }}"  class="form-control" autocomplete="off" hidden >
                    <input type="text" id="mr_reference_code" name="mr_reference_code" value="{{ old('mr_reference_code') }}" placeholder="MR Code" class="form-control" autocomplete="off">
                    <p style="color: red" id="error_mr_reference_code"></p>
                </div>

            </div>

{{-- Add row table code --}}

    <div class="container pt-4">
        <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>S.No</th>
                <th>Item Name</th>
                <th>Qty</th>
                <th>Rate</th>
                <th>Discount</th>
                <th>Amount</th>
                <th>Previous Rate</th>
                {{-- <th id="th_qty">Pending Qty</th> --}}
                <th>Remove</th>
            </tr>
            </thead>
            <tbody id="tbody">

            </tbody>
        </table>
        </div>
        <button class="btn btn-md btn-primary"
        id="addBtn" type="button">
            Add Row
        </button>
    </div>

<div class="row mt-5">
    <div class="col-md-2">
        <label for="">Remarks</label>
    </div>
    <div class="col-md-4">
        <textarea name="remarks" id="remarks" cols="30" rows="4" class="form-control"></textarea>
    </div>
    <div class="col-md-2">
        <label for="" class="float-end mt-2">Total Amount</label><br>
        <label for="" class="float-end mt-2">Total Discount</label><br>
        <label for="" class="float-end my-2">VAT Amount</label>
        <label for=""class="float-end my-2" >Grand Total</label>
    </div>
    <div class="col-md-4">
        <input type="text" name="total_amount" id="total_amount" class="form-control mb-2">
        <input type="text" name="total_discount" id="total_discount" class="form-control mb-2">
        <input type="text" name="vat" id="vat" class="form-control mb-2">
        <input type="text" name="gross_amount" id="gross_amount" class="form-control mb-2 total">
    </div>
</div>
<div class="row mt-5">
    <div class="col-md-2">
        <label for="">Attachments</label>
    </div>
    <div class="col-md-4">
        <input type="file" name="attachments" class="form-control">
        <span id="filename"></span>
    </div>
    <div class="col-md-6">
        <button type="button" id="deleteButton" class="btn btn-danger">Delete</button>
        <input type="hidden" name="delete_attachment" id="deleteAttachmentInput" value="0">
    </div>
</div>
    <div class="row mt-3">
        <div class="form-group col-md-12">
            <center><button id="submit" class="btn btn-primary mx-3 mt-3">Save</button>
            </center>
        </div>
    </div>
</form>
<!-- SHOW DIALOG -->
<div class="card" id="show" style="display:none">
    <div class="card-body" style="background-color:white;width:100%;height:20%;">

        <div class="row">
            <div class="col-md-6">
                <label>Type</label>
                <p id="show_po_type"></p>
            </div>
            <div class="col-md-6">
                <label>Code</label>
                <p id="show_po_code"></p>
            </div>
            <div class="col-md-6">
                <label>Date</label>
                <p id="show_po_date"></p>
            </div>
            <div class="col-md-6">
                <label>Quote Referance</label>
                <p id="show_quote_ref"></p>
            </div>

        </div>
        <div class="row">
            <div class="col-md-6">
                <label>Currency</label>
                <p id="show_currency"></p>
            </div>
            <div class="col-md-6">
                <label>Email</label>
                <p id="show_mail_id"></p>
            </div>
            <div class="col-md-6">
                <label>Contact Person</label>
                <p id="show_name"></p>
            </div>
            <div class="col-md-6">
                <label>Mobile Number</label>
                <p id="show_contact_number"></p>
            </div>
        </div>
        <div class="row">

            <div class="col-md-6">
                <label>Website</label>
                <p id="show_website"></p>
            </div>
            <div class="col-md-6">
                <label>Credit period</label>
                <p id="show_credit_period"></p>
            </div>
            <div class="col-md-6">
                <label>Payment Terms</label>
                <p id="show_payment_terms"></p>
            </div>
            <div class="col-md-6">
                <label>Delivery Location</label>
                <p id="show_project_name"></p>
            </div>

        </div>
        <div class="row">
            <div class="col-md-6">
                <label>Quote Date</label>
                <p id="show_quote_date"></p>
            </div>
            <div class="col-md-6">
                <label>Delivery Terms</label>
                <p id="show_delivery_terms"></p>
            </div>
            <div class="col-md-6">
                <label>Prepared By</label>
                <p id="show_firstname"></p>
            </div>
            <div class="col-md-6">
                <label>Pull Mr Code</label>
                <p id="show_mr_reference_code"></p>
            </div>
            <div class="col-md-3">
                <label>Attachments</label>
                <p id="show_filename"></p>
            </div>
        </div>

        <div id="item_details_show"></div>
    </div>
</div>
</dialog>
          <script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
</script>
 {{-- Add row table script --}}
<script>
    //row wise amount calculation
$(document).on('change', 'input[name="qty[]"], input[name="rate_per_qty[]"],input[name="discount[]"]', function () {
    var row = $(this).closest('tr');
    var qty = parseInt(row.find('input[name="qty[]"]').val());
    var rate = parseFloat(row.find('input[name="rate_per_qty[]"]').val());
    var discount = parseFloat(row.find('input[name="discount[]"]').val());
    if (isNaN(qty) || isNaN(rate)) {
        return;
    }
    var total =qty*rate-discount;
    row.find('input[name^="item_amount"]').val(total);
});

//total amount calculation without discount
$(document).ready(function() {
      $('#tbody').on('input', 'input[name^="quantity"], input[name^="rate_per_qty"]', function() {
        calculateTotal();
      });
      function calculateTotal() {
        var total = 0;
        $('#tbody tr').each(function() {
          var qty = parseInt($(this).find('input[name^="qty"]').val()) || 0;
          var ratePerQuantity = parseFloat($(this).find('input[name^="rate_per_qty"]').val()) || 0;

          var amount = qty * ratePerQuantity;
          total += amount;
        });
        $('#total_amount').val(total);
      }
    });


//grand discount calculation
    $(document).ready(function() {
      $('#tbody').on('input', 'input[name^="discount"]', function() {
        calculateTotal();
      });
      function calculateTotal() {
        var total = 0;
        $('#tbody tr').each(function() {
          var discount = parseFloat($(this).find('input[name^="discount"]').val()) || 0;
          total += discount;
        });
        $('#total_discount').val(total);
      }
    });

    //grand total calcualtion
    $(document).ready(function() {
      $('#tbody').on('input', 'input[name^="qty"], input[name^="rate_per_qty"], input[name^="discount"]', function() {
        calculateTotal();
      });
      function calculateTotal() {
        var total =0;
        $('#tbody tr').each(function() {
          var qty = parseInt($(this).find('input[name^="qty"]').val()) || 0;
          var ratePerQuantity = parseFloat($(this).find('input[name^="rate_per_qty"]').val()) || 0;
          var discount = parseFloat($(this).find('input[name^="discount"]').val()) || 0;
          var amount = qty * ratePerQuantity;
          var discountedAmount = amount - discount;
          total += discountedAmount;
        });
        $('.total').val(total);
      }
    });
    </script>





<script>
      // delete attachment
      document.getElementById("deleteButton").addEventListener("click", function() {
                     if (confirm("Are you sure you want to delete this attachment?")) {
                         document.getElementById("deleteAttachmentInput").value = "1";
                         document.querySelector("input[name='attachments']").value = "";
                         document.getElementById("filename").textContent = "";
                     }
                 });

    // jQuery button click event to add a row
    $('#addBtn').on('click', function() {
        //     alert('');
        //     alert(rowIdx);
        var row = rowIdx - 1;
        //    alert(row)

        if ($('#item_name_' + row).val() == '') {
            alert("Please enter item name.");
        } else if (!/^[a-zA-Z]+$/.test($('#item_name_' + row).val())) {
            alert("Item name should only contain alphabets.");
        } else if ($('#qty_' + row).val() == '') {
            alert("Please enter the quantity.");
        } else if (!/^\d+(\.\d+)?$/.test($('#qty_' + row).val())) {
            alert("Item quantity should only contain numbers.");
        }
        else if ($('#rate_per_qty_' + row).val() == '') {
            alert("Please enter rate per quantity.");
        } else if (!/^\d+(\.\d+)?$/.test($('#rate_per_qty_' + row).val())) {
            alert("Rate Per quantity should only contain numbers.");
        }
        else {
        add_text();
         }
        // detele row

    });
    $('#tbody').on('click', '.remove', function() {
        // Getting all the rows next to the row containing the clicked button
        var child = $(this).closest('tr').nextAll();

        // Iterating across all the rows obtained to change the index
        child.each(function() {
            // Getting <tr> id.
            var id = $(this).attr('id');

            // Getting the <p> inside the .row-index class.
            var idx = $(this).children('.row-index').children('p');

            // Gets the row number from <tr> id.
            var dig = parseInt(id.substring(1));

            // Modifying row index.
            idx.html(`<input type='text'>`);

            // Modifying row id.
            $(this).attr('id', `R${dig - 1}`);
        });

        // Removing the current row.
        $(this).closest('tr').remove();

        // Decreasing total number of rows by 1.
        rowIdx--;
    });

    var rowIdx = 1;

    function add_text() {
        var html = '';
        html += '<tr id="row' + rowIdx + '">';
        html += '<td>' + rowIdx + '</td>';
        html += '<td><div class="col-xs-12"><input type="text" id="item_name_' + rowIdx +
        '"  name="item_name[]" class="item_name" placeholder="Item name"><input type="text"  name="item_no[]" id="item_no_' +
        rowIdx + '" class="item_no_' + rowIdx + '" hidden placeholder=" Item no"></div></td>';
        html += '<td><div class="col-xs-12"><input type="text" name="qty[]"  id="qty_' + rowIdx +
            '"name="qty[]" class="qty"></div></td>';
        html += '<td><div class="col-xs-12"><input type="text" name="rate_per_qty[]" id="rate_per_qty_' + rowIdx +
            '"  name="rate_per_qty[]" class="rate_per_qty"></div></td>';
        html += '<td><div class="col-xs-12"><input type="text" name="discount[]" id="discount_' + rowIdx +
            '"  name="discount[]" class="discount"></div></td>';
        html += '<td><div class="col-xs-12"><input type="text" name="item_amount[]" id="item_amount_' + rowIdx +
            '"  name="item_amount[]" class="item_amount"></div></td>';
            html += '<td><center><div class="col-xs-12" id="price_per_qty_'+ rowIdx + '" ></div></center></td>';
        // html += '<td id="tr_qty"><div class="col-xs-12"><input type="text" name="pending_qty[]" id="pending_qty_' + rowIdx +
        //     '"  name="pending_qty[]" class="pending_qty" ></div></td>';
        html +=
            '<td><button class="btn btn-danger remove" id="delete" type="button"><i class="fa fa-trash"></i></button></td>';
        html += '</tr>';
        $("#tbody").append(html);
        rowIdx++;
        //    auto();
        // Add autocomplete to the new item_name input field

    }
    jQuery($ => {

        $(document).on('focus', '.item_name', function() {
    $(this).autocomplete({
        source: function(request, response) {
            $.ajax({
                type: "GET",
                url: "{{ route('getpopricedata') }}",
                dataType: "json",
                data: {
                    'itemname': request.term,
                    'price_per_qty': request.term // assuming the price input field has an ID of "price_per_qty"
                },
                success: function(data) {
                    console.log(data);
                    result = [];
                    for (var i in data) {
                        result.push(data[i]["item_name"]);

                    }
                    response(result);
                },
                fail: function(xhr, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        },
        minLength: 1
    });
});

$(document).on('change', '.item_name', function() {
    // alert('hi');
    var id = rowIdx - 1;
    $.ajax({
        type: "GET",
        url: "{{ route('getpopricedata') }}",
        dataType: "json",
        data: {
            'itemname': $(this).val(),
            'price_per_qty': $(this).val() // assuming the price input field has an ID of "price_per_qty"
        },
        success: function(data) {
            $('#item_no_' + id).val(data[0]["id"]);
            $('#supplier_no_' + id).val(data[0]["supplier_no"]);
             $('#price_per_qty_' + id).text(data[0]["price_per_qty"]);

        },
        fail: function(xhr, textStatus, errorThrown) {
            alert(errorThrown);
        }
    });
});
});

</script>
    <script>
        $(function () {
            $("#myTable").DataTable();
        });
    </script>
     <!--ADD DIALOG  -->
          <script type="text/javascript">
          function handleDialog()
          {
             document.getElementById("myDialog").open = true;
             add_text();
             $('#method').val("ADD");
             $('#submit').text("Save");
             $('#heading_name').text("Add Purchase Order").css('font-weight', 'bold');
             $('#site_code').hide();
             $('#code_lable').hide();


             $('#show').css('display','none');
             $('#form').css('display','block');
             $('#blur-background').css('display','block');

          }
// DELETE FUNCTION
          function handleDelete(id){
             let url = '{{route('purchaseorderApi.delete',":po_no")}}';
            url= url.replace(':po_no',id);
            if (confirm("Are you sure you want to delete this Purchase Order?")) {
              $.ajax({
            url: url,
            type: 'DELETE',
            success: function (message) {
             alert(message);
             window.location.reload();
            },
        })}

          }
// DIALOG CLOSE BUTTON
          function handleClose(){
            document.getElementById("myDialog").open = false;
            window.location.reload();
          }
// DIALOG SUBMIT FOR ADD AND EDIT
          function handleSubmit(){
            event.preventDefault();
         let form_data = new FormData(document.getElementById('form'));
         let method = $('#method').val();
         let url;
         let type;
         if(method == 'ADD'){
             url = '{{route('purchaseorderApi.store')}}';
             type  = 'POST';

         } else {
            let id = $('#po_no').val();
            url = '{{route('purchaseorderApi.update',":po_no")}}';
            url= url.replace(':po_no',id);
            type = 'POST';
         }
        $.ajax({
            url: url,
            type: type,
            data: form_data,
             contentType: false,
            cache: false,
            processData: false,
            success: function (message) {
             alert(message);
             window.location.reload();
            },error: function (message) {
                var data = message.responseJSON;
                $.each(data.errors, function (key, val) {
                    console.log(key,val);
                    $(`#error_${key}`).html(val[0]);
                })
            }
        })
          }

        //DATA SHOW FOR EDIT AND SHOW
        function handleShowAndEdit(id,action){

            let url = "{{ route('purchaseorderApi.show', ':po_no') }}";
            url = url.replace(':po_no',id);
            let type= "GET"
            console.log(id);
            $.ajax({
                        url: url,
                        type: type,
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function(message) {
                            console.log(message.purchase_orders);
                             console.log(message.purchase_orders_item);
                            if (action == 'edit') {

                                $('#show').css('display', 'none');
                                $('#form').css('display', 'block');
                                $('#blur-background').css('display','block');

                                for (const [key, value] of Object.entries(message.purchase_orders[0])) {
                                    //  console.log(`${key}: ${value}`);
                                    $(`#${key}`).val(value);

                                }
                                console.log(message.purchase_orders[0].mr_reference_code);
                                console.log(message.purchase_orders[0].filename);
                                $('#c_name').val(message.purchase_orders[0].name);
                                $('#filename').text(message.purchase_orders[0].filename);

                                var rowid = 1;
                                for (const item of message.purchase_orders_item) {
                                    add_text(); // add a new row to the table
                                    //  console.log(item.item_no);
                                    console.log(rowid);
                                    $('#item_name_' + rowid).val(item.item_name);
                                    $('#item_no_' + rowid).val(item.item_no);
                                    $('#qty_' + rowid).val(item.qty);
                                    $('#rate_per_qty_' + rowid).val(item.rate_per_qty);
                                    $('#discount_' + rowid).val(item.discount);
                                    $('#item_amount_' + rowid).val(item.item_amount);
                                    $('#price_per_qty_' + rowid).text(item.price_per_qty);
                                    // $('#pending_qty_' + rowid).val(item.pending_qty);
                                    rowid++;
                                }
                                $('#method').val('UPDATE');
                                $('#submit').text('UPDATE');
                 }
                 else {

                    for (const [key, value] of Object.entries(message.purchase_orders[0])) {
                                    console.log(`${key}: ${value}`);
                                    $(`#show_${key}`).text(value);

                                }
                                let script =
                                    '<table id="show_table" class="table table-striped"><thead><tr><th>Item Name</th><th>Item Quantity</th><th>Rate Per Quantity</th><th>Discount</th><th>Item Amount</th><th>Previous Rate</th></tr></thead><tbody>';
                                for (const item of message.purchase_orders_item) {
                                    script += '<tr>';
                                    script += '<td>' + item.item_name + '</td>';
                                    script += '<td>' + item.qty + '</td>';
                                    script += '<td>' + item.rate_per_qty + '</td>';
                                    script += '<td>' + item.discount + '</td>';
                                    script += '<td>' + item.item_amount + '</td>';
                                    script += '<td >' + item.price_per_qty + '</td>';
                                    // script += '<td>' + item.pending_qty + '</td>';
                                    script += '</tr>';
                                }
                                script += '</tbody></table>';
                                $('show_table').remove();
                                $('#item_details_show').append(script);
                                $('#heading_name').text("View Purchase Order").css('font-weight', 'bold');
                                $('#show').css('display', 'block');
                                $('#form').css('display', 'none');
                                $('#blur-background').css('display','block');

                            }
                            document.getElementById("myDialog").open = true;
                        },
                    })
                }

        </script>



<script>
    $(".supplier_name").autocomplete({

        source: function(request, response) {
            $.ajax({
                type: "GET",
                url: "{{ route('getempdata') }}",
                dataType: "json",
                data: {
                    'suppliername': $(".supplier_name").val()
                },
                success: function(data) {

                    result = [];
                    for (var i in data) {
                        result.push(data[i]["name"]);
                    }

                    response(result);
                },
                fail: function(xhr, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        },
    });

    $(".supplier_name").on('change', function() {
        var code = $(this).val();

        $.ajax({
            type: "GET",
            url: "{{ route('getempdata') }}",
            dataType: "json",
            data: {
                'suppliername': $(this).val()
            },
            success: function(data) {
                result = [];
                for (var i in data) {
                    //console.log(data);
                    $('.contact_person').val(data[i]["name"]);
                    $('.supplier_no').val(data[i]["supplier_no"]);
                    $('.email').val(data[i]["mail_id"]);
                    $('.website').val(data[i]["website"]);
                    $('.mobile_no').val(data[i]["contact_number"]);
                }
            },
            fail: function(xhr, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
    });
</script>

<script>
    $("#project_name").autocomplete({

source: function(request, response) {
    $.ajax({
        type: "GET",
        url: "{{ route('getlocdata') }}",
        dataType: "json",
        data: {
            'projectname': $("#project_name").val()
        },
        success: function(data) {

            result = [];
            for (var i in data) {
                result.push(data[i]["project_name"]);
            }

            response(result);
        },
        fail: function(xhr, textStatus, errorThrown) {
            alert(errorThrown);
        }
    });
},
});
$("#project_name").on('change', function() {
var code = $(this).val();

$.ajax({
    type: "GET",
    url: "{{ route('getlocdata') }}",
    dataType: "json",
    data: {
        'projectname': $(this).val()
    },
    success: function(data) {
        result = [];
        for (var i in data) {
            //console.log(data);
            $('#project_name').val(data[i]["project_name"]);
            $('#project_no').val(data[i]["project_no"]);

        }
    },
    fail: function(xhr, textStatus, errorThrown) {
        alert(errorThrown);
    }
});
});
    //po prepared

    $("#firstname").autocomplete({

source: function(request, response) {
    $.ajax({
        type: "GET",
        url: "{{ route('getemployeedata') }}",
        dataType: "json",
        data: {
            'firstname': $("#firstname").val()
        },
        success: function(data) {

            result = [];
            for (var i in data) {
                result.push(data[i]["firstname"]);
            }

            response(result);
        },
        fail: function(xhr, textStatus, errorThrown) {
            alert(errorThrown);
        }
    });
},
});
$("#firstname").on('change', function() {
var code = $(this).val();

$.ajax({
    type: "GET",
    url: "{{ route('getemployeedata') }}",
    dataType: "json",
    data: {
        'firstname': $(this).val()
    },
    success: function(data) {
        result = [];
        for (var i in data) {
            //console.log(data);
            $('#firstname').val(data[i]["firstname"]);
            $('#id').val(data[i]["id"]);

        }
    },
    fail: function(xhr, textStatus, errorThrown) {
        alert(errorThrown);
    }
});
});
// table create with data for ref MR number
$("#mr_reference_code").on('change',function()
    {
        var code= $(this).val();

        $.ajax
        ({
            type:"GET",
            url: "{{ route('getmrdata') }}",
            dataType: "json",
            data:
            {
                'mrcode':$('#mr_reference_code').val()
            },
            success: function( data )
            {
                console.log(data.mr_no);
                console.log(data.mr_items);

                result = [];
                var mr = data.mr_items.length;
                console.log(mr);
                $('#mr_id').val(data.mr_data[0].mr_id);

                var create_id=1;



                if(mr == 1)
                {
                    for (const item of data.mr_items)
                    {

                        $('#item_name_' + create_id).val(item.item_name);
                        $('#item_no_' + create_id).val(item.item_no);
                        $('#qty_'+ create_id).val(item.quantity);
                        // $('#rate_per_qty_'+ create_id).val(item.rate_per_qty);
                        // $('#discount_' + create_id).val(item.discount);
                        // $('#item_amount_' + create_id).val(item.item_amount);
                        // $('#price_per_qty_' + create_id).text(item.price_per_qty);
                    }

                }
                else
                {
                    for (const item of data.mr_items)
                    {
                        //console.log(item.item_name)
                        add_text();
                        $('#item_name_' + create_id).val(item.item_name);
                        $('#item_no_' + create_id).val(item.item_no);
                        $('#qty_'+ create_id).val(item.quantity);
                        // $('#rate_per_qty_'+ create_id).val(item.rate_per_qty);
                        // $('#discount_' + create_id).val(item.discount);
                        // $('#item_amount_' + create_id).val(item.item_amount);
                        // $('#price_per_qty_' + create_id).text(item.price_per_qty);
                        create_id++;
                    }


                }
            },fail: function(xhr, textStatus, errorThrown)
            {
                alert(errorThrown);
            }
        });
    });
</script>

@stop
