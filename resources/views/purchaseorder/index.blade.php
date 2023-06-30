<style>

    #vat-error
    {
        position: inherit;
        top: 100%;
        left: 0;
    }

    .switch 
    {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input 
    { 
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider 
    {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before 
    {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked + .slider 
    {
        background-color: #2196F3;
    }

    input:focus + .slider 
    {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before 
    {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round 
    {
        border-radius: 34px;
    }

    .slider.round:before 
    {
        border-radius: 50%;
    }
        /* new style */
    .radio-buttons 
    {
        display: flex;
        align-items: center;
    }

    .radio-buttons input[type="radio"] 
    {
        margin-right: 8px;
        transform: scale(1.5); /* Increase the scale value as needed */
    }
    .toggle-switch 
    {
        margin-top:10%;
        margin-left:10%;
        position: relative;
        width: 60px;
        height: 34px;
        display: inline-block;
    }

    .toggle-switch input[type="checkbox"] 
    {
        opacity: 5;
        width: 0;
        height: 0;
    }

    .toggle-label 
    {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        transition: 0.1s;
        border-radius: 34px;
        width: 57px; /* Decrease the width */
        height: 27px;
    }

    .toggle-label:before 
    {
        position: absolute;
        content: "";
        height: 20px;
        width: 20px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: 0.4s;
        transition: 0.4s;
        border-radius: 50%;
        box-shadow: 0px 0px 5px 2px rgba(0, 0, 0, 0.09); /* Add this line */
    }

    .toggle-switch input[type="checkbox"]:checked + .toggle-label 
    {
        background-color: #2196F3;
        border-color: transparent; /* Set the border color to transparent for checked state */
    }

    .toggle-switch input[type="checkbox"]:checked + .toggle-label:before 
    {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }
    .toggle-switch input[type="checkbox"]:not(:checked) + .toggle-label 
    {
        border-color: gray; /* Set the border color to gray for unchecked state */
    }
    .toggle-text 
    {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: #fff;
        font-size: 16px;
        width: 100%;
        text-align: center;
        display: flex;
        justify-content: center;
        align-items: center;
        pointer-events: none;
        color: black; 
    }

    .discount-type:checked + .toggle-label #toggle-text::before 
    {
        content: '%';        
    }

    .discount-type:not(:checked) + .toggle-label #toggle-text::before 
    {
        content: '₹';
        color: black; 
    }
</style>

<!-- STYLE INCLUDED IN LAYOUT PAGE -->
@extends('layouts.app',[
    'activeName' => 'Purchase Order'
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
                                    <th>PO Code</th>
                                    <th>Site Location</th>
                                    <th>Supplier Name</th>
                                    <th>Grand Total</th>
                                    <th>Purchase Type</th>
                                    <th>Vat</th>
                                    <th>Delivery Terms</th>
                                    <th>PO Prepared By</th>
                                    <th>Date</th>
                                    <th data-orderable="false" class="action notexport">Show</th>
                                    <th data-orderable="false" class="action notexport">Edit</th>
                                    <th data-orderable="false" class="action notexport">Delete</th>
                                    <div id="blur-background" class="blur-background"></div>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($purchase_orders as $key => $purchase_order)
                                    <tr class="text-center">
                                        <td>{{$purchase_order->po_code}}</td>
                                        <td>{{$purchase_order->site_location}}</td>
                                        <td>{{$purchase_order->name}}</td>
                                        <td>{{$purchase_order->gross_amount}}</td>
                                        <td>{{$purchase_order->po_type}}</td>
                                        <td>{{$purchase_order->vat}}</td>
                                        <td>{{$purchase_order->delivery_terms}}</td>
                                        <td>{{$purchase_order->firstname}}</td>
                                        <td>{{ date('d-m-Y', strtotime($purchase_order->po_date)) }}</td>
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
        </div>
    </div>

            <!-- ADD AND EDIT FORM -->
    <dialog id="myDialog">
        <div class="row">
            <div class="col-md-12">
                <a class="btn  btn-sm" onclick="handleClose()" style="float:right;padding: 10px 10px;"><i class="fas fa-close"></i></a>
                <h4  id='heading_name' style='color:white' align="center"><b>Update purchaseOrder Details</b></h4>
            </div>
        </div>
        <form  class="form-row"  enctype="multipart/form-data" style="display:block" id="form" onsubmit="handleSubmit()">
            <input type="hidden" id="method" value="ADD"/>
            <input type="hidden" id="po_no" name="po_no" value=""/><br>
            {!! csrf_field() !!}
                <div class="row g-3">
                    <div class="form-group col-md-4">
                        <label for="po_type" class="form-label fw-bold">Purchase Type<a style="text-decoration: none;color:red">*</a></label>
                        <select id="po_type" name="po_type" class="form-control form-select" autocomplete="off">
                            <option value="">Select Option</option>
                            @foreach($po_type as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="supplier_name" class="form-label fw-bold">Supplier Name<a
                                style="text-decoration: none;color:red">*</a></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                            placeholder="Supplier Name" class="form-control supplier_name" autocomplete="off">
                        <input type="text" id="supplier_no" hidden name="supplier_no"
                            value="{{ old('supplier_no') }}" class="form-control supplier_no" autocomplete="off">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="contact_person" class="form-label fw-bold">Contact Person</label>
                        <input type="text" id="c_name" name="c_name" value="{{ old('name') }}" placeholder="Contact Person" class="form-control contact_person" autocomplete="off" readonly>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="mobile_no" class="form-label fw-bold">Mobile Number</label>
                        <input type="text" id="contact_number" name="contact_number" value="{{ old('mobile_no') }}" placeholder="Mobile Number" class="form-control mobile_no" autocomplete="off" readonly>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="email" class="form-label fw-bold">Email</label>
                        <input type="email" id="mail_id" name="mail_id" value="{{ old('mail_id') }}"
                            placeholder="Email" class="form-control email" autocomplete="off" readonly>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="website" class="form-label fw-bold">Website</label>
                        <input type="text" id="website" name="website" value="{{ old('website') }}" placeholder="Website" class="form-control website" autocomplete="off" readonly>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="po_date" class="form-label fw-bold">Date<a style="text-decoration: none;color:red">*</a></label>
                        <input type="date" id="po_date" name="po_date" value="{{ old('po_date') }}" placeholder="Site Building" class="form-control" autocomplete="off" data-date-format="dd-mm-yy">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="quote_ref" class="form-label fw-bold">Quote Reference</label>
                        <input type="text" id="quote_ref" name="quote_ref" value="{{ old('quote_ref') }}" placeholder="Quote Reference" class="form-control" autocomplete="off">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="quote_date" class="form-label fw-bold">Quote Date</label>
                        <input type="date" id="quote_date" name="quote_date" value="{{ old('quote_date') }}" class="form-control" autocomplete="off">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="currency" class="form-label fw-bold">Currency<a style="text-decoration: none;color:red">*</a></label>
                        <select id="currency" name="currency" class="form-control form-select" autocomplete="off">
                            @foreach ($currency as $key => $value)
                            <option value="{{ $key }}"{{ $key == 'AED' ? ' selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="credit_period" class="form-label fw-bold">Credit period</label>
                        <input type="date" id="credit_period" name="credit_period" value="{{ old('credit_period') }}"  class="form-control" autocomplete="off">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="Payment Terms" class="form-label fw-bold">Payment Terms (In Percentage)<a style="text-decoration: none;color:red">*</a></label>
                        <input type="number" id="payment_terms" name="payment_terms" value="{{ old('payment_terms') }}" placeholder="Payment Terms" class="form-control" autocomplete="off">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="delivery_location" class="form-label fw-bold">Site Location<a
                                style="text-decoration: none;color:red">*</a></label>
                        <input type="text" id="site_location" name="site_location"
                            value="{{ old('site_location') }}" placeholder="site Location"
                            class="form-control" autocomplete="off">
                        <input type="text" id="site_no" hidden name="delivery_location"
                            value="{{ old('delivery_location') }}" class="form-control" autocomplete="off">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="delivery_terms" class="form-label fw-bold">Delivery Terms</label>
                        <input type="text" id="delivery_terms" name="delivery_terms" value="{{ old('delivery_terms') }}" placeholder="Delivery Terms" class="form-control" autocomplete="off">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="po_prepared" class="form-label fw-bold">Prepared By<a style="text-decoration: none;color:red">*</a></label>
                        <input type="text" id="firstname" name="firstname"
                            value="{{ old('firstname') }}" placeholder="Po Prepared By"
                            class="form-control" autocomplete="off">
                        <input type="text" id="id" hidden name="po_prepared"
                            value="{{ old('po_prepared') }}" class="form-control" autocomplete="off">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="mr_reference_code" class="form-label fw-bold">PULL MR NO</label>
                        <input type="text" id="mr_id" name="mr_no" value="{{ old('mr_no') }}"  class="form-control" autocomplete="off" hidden >
                        <input type="text" id="mr_reference_code" name="mr_reference_code" value="{{ old('mr_reference_code') }}" placeholder="MR Code" class="form-control" autocomplete="off">
                    </div>
                </div>
               
                {{-- Add row table code --}}

                <div class="container pt-4">
                    <div class="table-responsive">
                    <center>
                        <table class="table table-bordered" style="width:79%">
                            <thead>
                                <tr>
                                    <th class="text-center">S.No</th>
                                    <th class="text-center" style="width:35%">Item Name</th>
                                    <th class="text-center" style="width:12%">Qty</th>
                                    <th class="text-center" style="width:5%">Unit</th>
                                    <th class="text-center" style="width:12%">Rate Per Qty</th>                                   
                                    <th class="text-center" style="width:15%">Total</th>
                                    <th class="text-center" style="width:5%">Prior Cost</th>
                                   
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                            </tbody>
                        </table>
                    </center>
                    </div>
                </div>
                <div style="text-align: right;">
                    <div style="margin-top: 8px; margin-right: 106px; display: inline-block;">
                        <button class="btn btn-md btn-primary" id="addBtn" type="button">Add Row</button>
                    </div>
                </div>
                <div class="row" style="margin-top:10px;">
                    <div class="form-group col-md-2" style="margin-left:110px; margin-top:12px;">
                        <label for="misc_expenses" class="form-label fw-bold">Misc Expenses</label>
                        <input type="number" id="misc_expenses" name="misc_expenses" value="{{ old('misc_expenses')}}" placeholder="Misc Expenses" class="form-control" autocomplete="off">
                    </div>
                    <div class="form-group col-md-2" style="margin-left:30px; margin-top:12px;">
                        <label for="freight" class="form-label fw-bold">Freight</label>
                        <input type="number" id="freight" name="freight" value="{{ old('freight')}}" placeholder="Freight" class="form-control" autocomplete="off">
                    </div>
                    <div class="col-md-2" style="margin-left: 30px;margin-top:12px;">
                        <label for="discount" class="form-label fw-bold">Discount</label>
                    
                        <!-- <div class="col-md-2" style="margin-right: 3px;">    -->
                            <div class="input-group">
                                <input type="number" style="height: 34px;"  name="discount" id="discount" class="discount  form-control" autocomplete="off">
                                    <div class="input-group-append">
                                        <div class="toggle-switch">
                                            <input type="checkbox" id="discount-type" name="discount_type" class="discount-type" value="1" {{ old('discount_type') ? 'checked' : '' }}>
                                            <label for="discount-type" class="toggle-label">
                                                <span class="toggle-text" id="toggle-symbol">AED</span>
                                            </label>                                    
                                        </div>
                                    </div>
                            </div>
                        <!-- </div>  -->
                    </div>             
                    <div class="col-md-3" style="margin-left: 35px;margin-top: 12px;">
                        <label for="vat">Vat<a style="text-decoration: none;color:red">*</a></label>
                    
                        <!-- <div class="col-md-3" style="margin-left: 5px">  -->
                            <div style="display: flex;flex-wrap:wrap">
                                <div class="form-check" style="margin-right: 8px;">
                                    <input class="form-check-input" type="radio" name="vat" value="0" id="vat1">
                                    <label class="form-check-label" for="0%">0%</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="vat" value="5" id="vat2">
                                    <label class="form-check-label" for="5%">5%</label>
                                </div>
                            </div>
                        <!-- </div> -->
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-md-2">
                        <label for="">Remarks</label>
                    </div>
                    <div class="col-md-4">
                        <textarea name="remarks" id="remarks" cols="30" rows="4" class="form-control"></textarea>
                    </div>
                    <div class="col-md-2">
                        <label for="" class="float-end mt-2">Item Amount</label><br>
                        <label for="" class="float-end mt-3">Total Discount</label><br>
                        <label for="" class="float-end my-2">VAT Amount</label>
                        <label for=""class="float-end my-3" >Grand Total</label>
                    </div>
                    <div class="col-md-4">
                        <input type="text" readonly name="total_amount" id="total_amount" class="form-control mb-2" autocomplete="off">
                        <input type="text" readonly name="total_discount" id="total_discount" class="form-control mb-2" autocomplete="off">
                        <input type="text" readonly name="total_vat" id="total_vat" class="form-control mb-2" autocomplete="off">
                        <input type="text" readonly name="gross_amount" id="gross_amount" class="form-control mb-2 total" autocomplete="off">
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
                        <center><button id="submit" class="btn btn-primary mx-3 mt-3">Save</button></center>
                    </div>
                </div>
        </form>

        <!-- SHOW DIALOG -->
        <div class="card" id="show" style="display:none">
            <div class="card-body" style="background-color:white;width:100%;height:20%;">
                <div class="row">
                    <div class="col-md-3">
                        <label>Po Code</label>
                        <p id="show_po_code"></p>
                    </div>
                    <div class="col-md-3">
                        <label>Purchase Type</label>
                        <p id="show_po_type"></p>
                    </div>
                    <div class="col-md-3">
                        <label>Date</label>
                        <p id="show_po_date"></p>
                    </div>
                    <div class="col-md-3">
                        <label>Supplier Name</label>
                        <p id="show_name"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label>Contact Person</label>
                        <p id="show_name"></p>
                    </div>
                    <div class="col-md-3">
                        <label>Mobile Number</label>
                        <p id="show_contact_number"></p>
                    </div>                  
                    <div class="col-md-3">
                        <label>Email</label>
                        <p id="show_mail_id"></p>
                    </div>
                    <div class="col-md-3">
                        <label>Website</label>
                        <p id="show_website"></p>
                    </div>                    
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label>Currency</label>
                        <p id="show_currency"></p>
                    </div>          
                    <div class="col-md-3">
                        <label>Quote Reference</label>
                        <p id="show_quote_ref"></p>
                    </div>
                    <div class="col-md-3">
                        <label>Quote Date</label>
                        <p id="show_quote_date"></p>
                    </div>
                    <div class="col-md-3">
                        <label>Credit period</label>
                        <p id="show_credit_period"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label>Payment Terms</label>
                        <p id="show_payment_terms"></p>
                    </div>
                    <div class="col-md-3">
                        <label>Delivery Location</label>
                        <p id="show_site_location"></p>
                    </div>                    
                    <div class="col-md-3">
                        <label>Delivery Terms</label>
                        <p id="show_delivery_terms"></p>
                    </div>
                    <div class="col-md-3">
                        <label>Prepared By</label>
                        <p id="show_firstname"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label>Pull Mr Code</label>
                        <p id="show_mr_reference_code"></p>
                    </div>
                    <div class="col-md-3">
                        <label>Total Amount</label>
                        <p id="show_total_amount"></p>
                    </div>
                    <div class="col-md-3">
                        <label>Misc Expenses</label>
                        <p id="show_misc_expenses"></p>
                    </div>
                    <div class="col-md-3">
                        <label>Freight</label>
                        <p id="show_freight"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label>Discount</label>
                        <p id="show_discount"></p>
                    </div>
                    <div class="col-md-3">
                        <label>Total Discount</label>
                        <p id="show_total_discount"></p>
                    </div>
                    <div class="col-md-3">
                        <label>VAT</label>
                        <p id="show_vat"></p>
                    </div>
                    <div class="col-md-3">
                        <label>VAT Amount</label>
                        <p id="show_total_vat"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label>Grand Total</label>
                        <p id="show_gross_amount"></p>
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

    $.ajaxSetup(
    {
        headers: 
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(function () 
    {
        $("#myTable").DataTable();
    });

   
        // delete function for attachment
    document.getElementById("deleteButton").addEventListener("click", function() 
    {
        if (confirm("Are you sure you want to delete this attachment?")) 
        {
            document.getElementById("deleteAttachmentInput").value = "1";
            document.querySelector("input[name='attachments']").value = "";
            document.getElementById("filename").textContent = "";
        }
    });

            // jQuery button click event to add a row
            // let itemNames = []; // Array to store encountered item names           
    $('#addBtn').on('click', function() 
    {
        // var row = rowIdx - 1;
        // var itemName = $('#item_name_' + row).val();

        // if ($('#item_name_' + row).val() == '') 
        // {
        //     alert("Please enter an item name in " + row);
        // } 
        // else if (itemNames.includes(itemName)) 
        // {
        // alert('Item name "' + itemName + '" is repeated. Please enter a unique item name in row ' + row);
        // }
        // else if ($('#qty_' + row).val() == '') 
        // {
        //     alert("Please enter the quantity." + row);
        // } else if (!/^\d+(\.\d+)?$/.test($('#qty_' + row).val())) 
        // {
        //     alert("Item quantity should only contain numbers.");
        // }
        // else if ($('#rate_per_qty_' + row).val() == '') 
        // {
        //     alert("Please enter rate per quantity." + row);
        // } 
        // else if (!/^\d+(\.\d+)?$/.test($('#rate_per_qty_' + row).val())) 
        // {
        //     alert("Rate Per quantity should only contain numbers.");
        // }
        // else 
        // {
        //     itemNames.push(itemName);         
             add_text();
        // }
        // detele row
    });

    $('#tbody').on('click', '.remove', function() 
    {
        // Getting all the rows next to the row containing the clicked button
        var child = $(this).closest('tr').nextAll();

        // Iterating across all the rows obtained to change the index
        child.each(function() 
        {
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
        calculateRowTotal();
        calculateSubtotal();
        calculateTotalAmount();
        calculateTotalDiscount();
        calculateVATAmount();
        calculateGrandTotal();
    });

            // table body
    var rowIdx = 1;
    function add_text() 
    {
        var html = '';
        html += '<tr id="row' + rowIdx + '" class="rowtr">';
        html += '<td>' + rowIdx + '</td>';
        html += '<td><div class="col-xs-12"><input type="text" id="item_name_' + rowIdx +
        '"  name="item_name[]" class="item_name form-control" placeholder="Item name"><input type="text"  name="item_no[]" id="item_no_' +
        rowIdx + '" class="item_no_' + rowIdx + '" hidden placeholder=" Item no"></div></td>';
        html += '<td><div class="col-xs-12"><input type="number" name="qty[]"  id="qty_' + rowIdx +
            '"name="qty[]" class="qty form-control"></div></td>';
            html += '<td><center><div class="col-xs-12" id="item_unit_'+ rowIdx + '" ></div></center></td>';
        html += '<td><div class="col-xs-12"><input type="number" name="rate_per_qty[]" id="rate_per_qty_' + rowIdx +
            '"  name="rate_per_qty[]" class="rate_per_qty form-control"></div></td>';
        // html += '<td><div class="col-xs-12"><input type="number" name="discount[]" id="discount_' + rowIdx +
        //     '"  name="discount[]" class="discount form-control"></div></td>';
        html += '<td><div class="col-xs-12"><input type="text" name="item_amount[]" id="item_amount_' + rowIdx +
            '"  name="item_amount[]" class="item_amount form-control" readonly></div></td>';
        html += '<td><center><div class="col-xs-12" id="price_per_qty_'+ rowIdx + '" ></div></center></td>';
       
        // html += '<td id="tr_qty"><div class="col-xs-12"><input type="text" name="pending_qty[]" id="pending_qty_' + rowIdx +
        //     '"  name="pending_qty[]" class="pending_qty" ></div></td>';
        if(rowIdx !=1){
        html +=
            '<td><button class="btn btn-danger remove btn-sm" id="delete" type="button"><i class="fa fa-trash"></i></button></td>';
        html += '</tr>';
        }

        $("#tbody").append(html);
        rowIdx++;
    }

            // Add autocomplete to the new item_name input field
    jQuery($ => 
    {
        $(document).on('focus', '.item_name', function() 
        {
            $(this).autocomplete(
            {
                source: function(request, response) 
                {
                    $.ajax(
                    {
                        type: "GET",
                        url: "{{ route('getpopricedata') }}",
                        dataType: "json",
                        data: 
                        {
                            'itemname': request.term,
                            'price_per_qty': request.term // assuming the price input field has an ID of "price_per_qty"
                        },
                        success: function(data) 
                        {
                            console.log(data);
                            result = [];
                            for (var i in data) 
                            {
                                result.push(data[i]["item_name"]);
                            }
                            response(result);
                        },
                        fail: function(xhr, textStatus, errorThrown) 
                        {
                            alert(errorThrown);
                        }
                    });
                },
                minLength: 1
            });
        });
    });

    $(document).on('change', '.item_name', function() 
    {
        var id = rowIdx - 1;
        $.ajax(
        {
            type: "GET",
            url: "{{ route('getpopricedata') }}",
            dataType: "json",
            data: 
            {
                'itemname': $(this).val(),
                'price_per_qty': $(this).val(),// assuming the price input field has an ID of "price_per_qty"
                'item_unit': $(this).val()
            },
            success: function(data) 
            {
                $('#item_no_' + id).val(data[0]["id"]);
                $('#supplier_no_' + id).val(data[0]["supplier_no"]);
                $('#price_per_qty_' + id).text(data[0]["price_per_qty"]);
                $('#item_unit_' + id).text(data[0]["item_unit"]);
            },
            fail: function(xhr, textStatus, errorThrown) 
            {
                alert(errorThrown);
            }
        });
    });

            // ADD DIALOG  
          
    function handleDialog()
    {
        document.getElementById("myDialog").open = true;
        window.scrollTo(0, 0);
         add_text();
        $('#method').val("ADD");
        $('#submit').text("Save");
        $('#vat1').prop('checked', true);
        $('#heading_name').text("Add Purchase Order Details").css('font-weight', 'bold');
        $('#site_code').hide();
        $('#code_lable').hide();
        $('#show').css('display','none');
        $('#form').css('display','block');
        $('#blur-background').css('display','block');
    }

            // DELETE FUNCTION
    function handleDelete(id)
    {
        let url = '{{route('purchaseorderApi.delete',":po_no")}}';
        url= url.replace(':po_no',id);
        if (confirm("Are you sure want to delete this Purchase Order Details?")) 
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
            }
        )}
    }

            // DIALOG CLOSE BUTTON
    function handleClose()
    {
        document.getElementById("myDialog").open = false;
        $('#form')[0].reset();
        $("#tbody").empty();
        rowIdx = 1; // Reset the row index to 1
        itemNames = []; // Clear the itemNames array
        $('.error-msg').removeClass('error-msg');
        $('.has-error').removeClass('has-error');       
        $('error').html('');   // Hide any error messages
        $('#blur-background').css('display','none');   // window.location.reload();
        $('#toggle-symbol').text('AED');  // Set the symbol to "AED"
    }

            // DIALOG SUBMIT FOR ADD AND EDIT
    function handleSubmit()
    {
        event.preventDefault();
        var hasError = true;
        let itemNames = []; // Array to store encountered item names
        $('.rowtr').each(function() 
        {
            let rowId = $(this).attr('id');
            let itemName = $('#' + rowId + ' .item_name').val();
            let quantity= $('#' + rowId + ' .qty').val();
            let price = $('#' + rowId + ' .rate_per_qty').val();
            if (itemName === '') 
            {
                alert('Please enter an item name in ' + rowId);
                hasError = false;
                return false; // Exit the loop
            }
            if (itemNames.includes(itemName)) 
                {
                    alert('Item name "' + itemName + '" is repeated. Please enter a unique item name in ' + rowId);
                    hasError = false;
                    return false; // Exit the loop
                }
            itemNames.push(itemName);
            if (quantity === '' ) 
            {
                alert('Please enter quantity in ' + rowId);
                hasError = false;
                return false; // Exit the loop
            }
            if (quantity === '0' ) 
            {
                alert('Please enter quantity in ' + rowId + 'otherthan 0');
                hasError = false;
                return false; // Exit the loop
            }
            if (price === '' ) 
            {
                alert('Please enter Rate in ' + rowId);
                hasError = false;
                return false; // Exit the loop
            }
        });
             
        if(hasError) 
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
                    url = '{{route('purchaseorderApi.store')}}';
                    type  = 'POST';
                } else 
                {
                    let id = $('#po_no').val();
                    url = '{{route('purchaseorderApi.update',":po_no")}}';
                    url= url.replace(':po_no',id);
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
                    },
                    error: function (message) 
                    {
                        var data = message.responseJSON;
                    }
                })
            }
        }
    }

        //DATA SHOW FOR EDIT AND SHOW
    function handleShowAndEdit(id,action)
    {
        let url = "{{ route('purchaseorderApi.show', ':po_no') }}";
        url = url.replace(':po_no',id);
        let type= "GET"
        console.log(id);
        $.ajax(
        {
            url: url,
            type: type,
            contentType: false,
            cache: false,
            processData: false,
            success: function(message) 
            {
                console.log(message.purchase_orders);
                console.log(message.purchase_orders_item);
                if (action == 'edit') 
                {
                    $('#show').css('display', 'none');
                    $('#form').css('display', 'block');
                    $('#blur-background').css('display','block');
                    $('#heading_name').text("Update Purchase Order Details").css('font-weight', 'bold');
                    for (const [key, value] of Object.entries(message.purchase_orders[0])) 
                    {
                        //  console.log(`${key}: ${value}`);
                        if (key === 'discount') 
                        {
                            if (value.endsWith('%')) 
                            {
                                const discountPercentage = value.slice(0, -1);
                                $('#discount').val(discountPercentage);
                                $('#discount-type').prop('checked', false);
                                $('#toggle-symbol').text('%');
                            } 
                            else 
                            {
                                $('#discount').val(value);
                                $('#discount-type').prop('checked', true);
                                $('#toggle-symbol').text('AED');
                            }
                        } 
                        else if (key === 'discount_type') 
                        {
                            if (value === '1') 
                            {
                                $('#discount-type').prop('checked', true);
                                $('#toggle-symbol').text('%');
                            } 
                            else 
                            {
                                $('#discount-type').prop('checked', false);
                                $('#toggle-symbol').text('AED');
                            }
                        } 
                        else 
                        {
                            $(`#${key}`).val(value);
                        }
                    }
                    $(document).ready(function() 
                    {
                        var vatValue = message.purchase_orders[0]['vat'];
                        console.log(vatValue);
                        if (vatValue == '0') 
                        {
                            $('#vat1').prop('checked', true);
                        } 
                        else if (vatValue == '5') 
                        {
                            $('#vat2').prop('checked', true);
                        }
                    });
                    $('#c_name').val(message.purchase_orders[0].name);
                    $('#filename').text(message.purchase_orders[0].filename);
                    var rowid = 1;
                    for (const item of message.purchase_orders_item) 
                    {
                        add_text(); // add a new row to the table
                        //  console.log(item.item_no);
                        console.log(rowid);
                        $('#item_name_' + rowid).val(item.item_name);
                        $('#item_no_' + rowid).val(item.item_no);
                        $('#qty_' + rowid).val(item.qty);
                        $('#rate_per_qty_' + rowid).val(item.rate_per_qty);
                        // $('#discount_' + rowid).val(item.discount);
                        $('#item_amount_' + rowid).val(item.item_amount);
                        $('#price_per_qty_' + rowid).text(item.price_per_qty);
                        $('#item_unit_' + rowid).text(item.item_unit);
                        // $('#pending_qty_' + rowid).val(item.pending_qty);
                        rowid++;
                    }
                    $('#method').val('UPDATE');
                    $('#submit').text('UPDATE');
                }
                else 
                {
                    for (let [key, value] of Object.entries(message.purchase_orders[0])) 
                    {
                        // console.log(`${key}: ${value}`);
                        if (key === "po_date" || key === "quote_date" || key === "credit_period") 
                        {
                            console.log(value);
                            if( value == '')
                            {
                                value="";
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
                    let script ='<table id="show_table" class="table table-striped"><thead style="text-align: center;"><tr><th>Item Name</th><th>Quantity</th><th>Unit</th><th>Rate Per Quantity</th><th>Total</th><th>Previous Rate</th></tr></thead><tbody>';
                    for (const item of message.purchase_orders_item)
                    {
                        script += '<tr>';
                        script += '<td>' + item.item_name + '</td>';
                        script += '<td style="text-align: center;">' + item.qty + '</td>';
                        script += '<td style="text-align: center;">' + (item.item_unit || '-') + '</td>';
                        script += '<td style="text-align: center;">' + item.rate_per_qty + '</td>';                           
                        script += '<td style="text-align: center;">' + item.item_amount + '</td>';
                        script += '<td style="text-align: center;">' + item.price_per_qty + '</td>';
                                                 
                        script += '</tr>';
                    }
                    script += '</tbody></table>';
                    $('#show_table').remove();
                    $('#item_details_show').append(script);
                    $('#heading_name').text("View Purchase Order Details").css('font-weight', 'bold');
                    $('#show').css('display', 'block');
                    $('#form').css('display', 'none');
                    $('#blur-background').css('display','block');
                }
                document.getElementById("myDialog").open = true;
                window.scrollTo(0, 0);
            },
        })
    }


        //  Autocomplete for supplier name from supplier master   
    jQuery($ => 
    {
        $(document).on('focus click', $("#name"), function() 
        {
            $(".supplier_name").autocomplete(
            {
                source: function(request, response) 
                {
                    $.ajax(
                    {
                        type: "GET",
                        url: "{{ route('getempdata') }}",
                        dataType: "json",
                        data: 
                        {
                            'suppliername': $(".supplier_name").val()
                        },
                        success: function(data) 
                        {
                            result = [];
                            for (var i in data) 
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

    $(".supplier_name").on('change', function() 
    {
        var code = $(this).val();
        $.ajax(
        {
            type: "GET",
            url: "{{ route('getempdata') }}",
            dataType: "json",
            data: 
            {
                'suppliername': $(this).val()
            },
            success: function(data) 
            {
                result = [];
                for (var i in data) 
                {
                    $('.contact_person').val(data[i]["name"]);
                    $('.supplier_no').val(data[i]["supplier_no"]);
                    $('.email').val(data[i]["mail_id"]);
                    $('.website').val(data[i]["website"]);
                    $('.mobile_no').val(data[i]["contact_number"]);
                }
            },
            fail: function(xhr, textStatus, errorThrown) 
            {
                alert(errorThrown);
            }
        });
    });


            // autocomplete for site location from site master
    jQuery($ => 
    {
        $(document).on('focus click', $("#site_location"), function() 
        {
            $("#site_location").autocomplete(
            {
                source: function(request, response) 
                {
                    $.ajax(
                    {
                        type: "GET",
                        url: "{{ route('getsitelocationdata') }}",
                        dataType: "json",
                        data: 
                        {
                            'site_name': $("#site_location").val()
                        },
                        success: function(data) 
                        {
                            result = [];
                            for (var i in data) 
                            {
                                result.push(data[i]["site_location"]);
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

    $("#site_location").on('change', function() 
    {
        var code = $(this).val();
        $.ajax(
        {
            type: "GET",
            url: "{{ route('getsitelocationdata') }}",
            dataType: "json",
            data: 
            {
                'site_name': $(this).val()
            },
            success: function(data) 
            {
                result = [];
                for (var i in data) 
                {
                    $('#site_location').val(data[i]["site_location"]);
                    $('#site_no').val(data[i]["site_no"]);

                }
            },
            fail: function(xhr, textStatus, errorThrown) 
            {
                alert(errorThrown);
            }
        });
    });
    
            //po prepared auttocomplete for employee name from employee master
    jQuery($ => 
    {
        $(document).on('focus click', $("#firstname"), function() 
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
            });
        });
    });

    $("#firstname").on('change', function() 
    {
        var code = $(this).val();
        $.ajax(
        {
            type: "GET",
            url: "{{ route('getemployeedata') }}",
            dataType: "json",
            data: 
            {
                'firstname': $(this).val()
            },
            success: function(data) 
            {
                result = [];
                for (var i in data) 
                {
                    //console.log(data);
                    $('#firstname').val(data[i]["firstname"]);
                    $('#id').val(data[i]["id"]);
                }
            },
            fail: function(xhr, textStatus, errorThrown) 
            {
                alert(errorThrown);
            }
        });
    });
    

            // autocomplete for mr code from MR 
    jQuery($ => 
    {
        $(document).on('focus click', $("#mr_reference_code"), function() 
        {
            $("#mr_reference_code").autocomplete(
            {
                source: function(request, response) 
                {
                    $.ajax(
                    {
                        type: "GET",
                        url: "{{ route('getmrcode') }}",
                        dataType: "json",
                        data: 
                        {
                            'mrcode': $("#mr_reference_code").val()
                        },
                        success: function(data) 
                        {

                            result = [];
                            for (var i in data) 
                            {
                                result.push(data[i]["mr_reference_code"]);
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
                        $('#item_unit_'+ create_id).text(item.item_unit);
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
                        $('#item_unit_'+ create_id).text(item.item_unit);
                        // $('#rate_per_qty_'+ create_id).val(item.rate_per_qty);
                        // $('#discount_' + create_id).val(item.discount);
                        // $('#item_amount_' + create_id).val(item.item_amount);
                        // $('#price_per_qty_' + create_id).text(item.price_per_qty);
                        create_id++;
                    }
                }
            },
            fail: function(xhr, textStatus, errorThrown)
            {
                alert(errorThrown);
            }
        });
    });


     // Initialize form validation
 
        var site_location=@json($site_location);
        $.validator.addMethod("sitelocationCheck", function(value, element) 
        {
            return site_location.includes(value);
        });

        var item_name = @json($item_name);
        $.validator.addMethod("ItemName", function(value, element) 
        {
            return item_name.includes(value.trim());
        });

        var supplier_name=@json($supplier_name);
        $.validator.addMethod("suppliernameCheck", function(value, element) 
        {
        return supplier_name.includes(value);
        });

        var employee_name=@json($employee_name);
        $.validator.addMethod("employeeNameCheck", function(value, element) 
        {
            return employee_name.includes(value);
        });

        $.validator.addMethod("alphanumeric_mrno", function(value, element) {
            return this.optional(element) || /^[a-zA-Z0-9]+$/i.test(value);
        });

        $.validator.addMethod("alphanumeric_Qty", function(value, element) {
            return this.optional(element) || /^(\d+(\.\d*)?|\.\d+)$/i.test(value);
        });
       

        var formValidationConfig = 
        {
            rules: 
            {
                po_type: "required",
                name:
                {
                    required:true,
                    suppliernameCheck:true
                },
                po_date: 
                {
                    required: true,
                },
                site_location:
                {
                    required:true,
                    sitelocationCheck:true
                },
                currency:"required",
                payment_terms:
                {
                    required:true,
                    
                }, 
                
                firstname:
                {
                    required:true,
                    employeeNameCheck:true
                },
                mr_reference_code:
                {
                    alphanumeric_mrno:true
                },
                // vat:
                // {
                //     required:true,
                
                // },
                "item_name[]": 
                {
                    required: true,
                    ItemName: true
                },
                "qty[]":
                {
                    required:true,
                    digits:true
                },
                "rate_per_qty[]":
                {
                    required:true,
                    alphanumeric_Qty:true 
                },
                "discount[]":
                {
                    alphanumeric_Qty:true
                },
            },
            messages:
            {
                
                po_type: "Please select the purchase type ",
                name:
                {
                    required:"Please enter the Supplier Name",
                    suppliernameCheck:"Please enter valid Supplier Name"
                },
                po_date: 
                {
                    required: "Please enter the date",
                },
                site_location:
                {
                    required:"Please enter the Site Location",
                    sitelocationCheck:"Please enter valid Site location"
                },
                currency:"Please Select the currency",
                payment_terms:
                {
                    required:"Please enter the payment Terms",
                
                }, 
            
                firstname:
                {
                    required:"Please enter the Employee Name",
                    employeeNameCheck:"Please enter valid Employee Name"
                },
                mr_reference_code:
                {
                    alphanumeric_mrno:"Please enter valid MR NO"
                },
                // vat:
                // {
                //     required:"Please enter the VAT",
                // },
                "item_name[]": 
                {
                    required: "Please enter the item name",
                    ItemName: "Please enter a valid item name"
                },
                "qty[]":
                {
                    required: "Please enter the qty",
                    digits:"please enter an integer value"
                },
                "rate_per_qty[]":
                {
                    required: "Please enter the rate per qty",
                    alphanumeric_Qty:"please enter numbers only"
                },
                "discount[]":
                {
                    alphanumeric_Qty:"please enter numbers only"        
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

        jQuery($ => 
        {
            var form = $("#form");
            form.validate(formValidationConfig);
        });

                  
        const discountToggle = document.getElementById('discount-type');
        const toggleSymbol = document.getElementById('toggle-symbol');
        const discountInput = document.getElementById('discount');
        const totalAmountInput = document.getElementById('total_amount');
        const totalDiscountInput = document.getElementById('total_discount');
        const grandTotalInput = document.getElementById('gross_amount');
        const vatAmountInput = document.getElementById('total_vat');
        const miscExpensesInput = document.getElementById('misc_expenses');
        const freightInput = document.getElementById('freight');

        discountToggle.addEventListener('change', function()
        {
            if (discountToggle.checked) {
                toggleSymbol.textContent = '%';
            } else {
                toggleSymbol.textContent = 'AED';
            }
            calculateTotalAmount();
        });

        // Trigger calculation on input change
        $('#tbody').on('input', 'input[name^="qty"], input[name^="rate_per_qty"]', calculateRowTotal);
        discountInput.oninput = calculateTotalAmount;
        discountToggle.addEventListener('change', calculateTotalAmount);
        $('input[name="vat"]').on('change', calculateVATAmount);
        miscExpensesInput.oninput = calculateGrandTotal;
        freightInput.oninput = calculateGrandTotal;

// Row wise calculation
function calculateRowTotal() {
    var row = $(this).closest('tr');
    var qty = parseInt(row.find('input[name^="qty"]').val()) || 0;
    var ratePerQuantity = parseFloat(row.find('input[name^="rate_per_qty"]').val()) || 0;
    var total = qty * ratePerQuantity;
    row.find('input[name^="item_amount"]').val(total.toFixed(2));
    calculateTotalAmount();
}

// Calculate Total Amount
function calculateTotalAmount() {
    const totalAmount = calculateSubtotal();
    totalAmountInput.value = totalAmount.toFixed(2); // Set the total_amount value

    calculateTotalDiscount(); // Calculate the total discount
    calculateVATAmount(); // Calculate the VAT amount
    calculateGrandTotal(); // Calculate the grand total
}

function calculateSubtotal() {
    var subtotal = 0;
    $('#tbody tr').each(function() {
        var total = parseFloat($(this).find('input[name^="item_amount"]').val()) || 0;
        subtotal += total;
    });
    return subtotal;
}

function calculateTotalDiscount() {
    const totalAmount = calculateSubtotal();
    const discount = discountInput.value ? parseFloat(discountInput.value) : 0;

    if (discountToggle.checked) {
        const discountAmount = (totalAmount * discount) / 100;
        const discountPercentage = discount.toFixed(2); // Discount percentage

        totalDiscountInput.value = discountAmount.toFixed(2); // Set the total discount value
    } else {
        const discountAmount = discountInput.value ? parseFloat(discountInput.value) : 0;
        const discountAmountAED = discountAmount.toFixed(2); // Discount amount in AED format

        totalDiscountInput.value = discountAmountAED; // Set the total discount value
    }

    calculateGrandTotal(); // Recalculate the grand total
}

// Calculate VAT Amount
function calculateVATAmount() {
    const totalAmount = parseFloat(totalAmountInput.value) || 0;
    const discount = parseFloat(totalDiscountInput.value) || 0;
    const vatRate = parseFloat($('input[name="vat"]:checked').val()) || 0;

    const vatAmount = (totalAmount - discount) * (vatRate / 100);
    vatAmountInput.value = vatAmount.toFixed(2);
    calculateGrandTotal();
}

// Calculate Grand Total
function calculateGrandTotal() {
    const totalAmount = parseFloat(totalAmountInput.value) || 0;
    const totalDiscount = parseFloat(totalDiscountInput.value) || 0;
    const miscExpenses = parseFloat(miscExpensesInput.value) || 0;
    const freight = parseFloat(freightInput.value) || 0;
    const vatAmount = parseFloat(vatAmountInput.value) || 0;

    const grossAmount = totalAmount - totalDiscount + miscExpenses + freight + vatAmount;
    grandTotalInput.value = grossAmount.toFixed(2);
}
</script>
                
@stop
