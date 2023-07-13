<!-- STYLE INCLUDED IN LAYOUT PAGE -->
@extends('layouts.app', [
    'activeName' => 'GRN',
])
@section('title', 'GRN Inventory Report')

@section('content_header')
@stop

@section('content')
    <!-- DATA table -->
    <div class="row">
        <div class="container-fluid">
            <div class="card shadow">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h4 class="font-weight-bold text-dark py">GRN Inventory Report</h4>

                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <table id="myTable" class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-center">
                                    <!-- <th>S.No</th> -->
                                    <th>Supplier name</th>
                                    <th>Item Name</th>
                                    <th>Item Category</th>
                                    <th>Quantity</th>
                                    <th>Stock Type</th>
                                    <th>Item Type</th>
                                    <th>Unit</th>
                                    <th>Price per quantity</th>
                                    <th>Total Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $key => $item)
                                <tr class="text-center">
                                    <!-- <td>{{ $key += 1 }}</td> -->
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->item_name }}</td>
                                    <td>{{ $item->item_category }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->stock_type }}</td>
                                    <td>{{ $item->item_type }}</td>
                                    <td>{{ $item->item_unit }}</td>
                                    <td>{{ $item->price_per_qty }}</td>
                                    <td>{{ $item->total_price }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="total-values">
                            <center>
                            <p><strong>Total Quantity:</strong> {{ $totalquant }}</p>
                            <p><strong>Total Inventory Value:</strong> {{ $totalAmount }}</p></center>
                        </div>
                    </div>
                    </div>
                </div>

            </div>

            <script type="text/javascript">
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });


            </script>



@stop