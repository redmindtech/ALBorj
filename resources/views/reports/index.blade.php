@extends('layouts.app',[
    'activeName' => 'REPORTS'
])
@section('title', 'REPORTS')

@section('content_header')
@stop

@section('content')

<div class="row">
    <div class="container-fluid">
        <div class="card shadow">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="font-weight-bold text-dark py">Reports</h4>
                    <div>
                        <button type="button" id="printButton" class="btn btn-primary">Print</button>
                        <button type="button" id="csvButton" class="btn btn-primary">CSV</button>
                        <!-- <button type="button" id="exportButton" class="btn btn-primary">PDF</button> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="form">
    <div class="row g-2">
        <div class="form-group col-md-3">
            <label for="month" class="form-label fw-bold">Month<a style="text-decoration: none;color:red">*</a></label>
                <select id="month" class="form-control form-select" autocomplete="off">
                    <option value="">Select Option</option>
                        @foreach ($report_month as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                </select>
        </div>
        <div class="form-group col-md-3">
            <label for="year" class="form-label fw-bold">Year <a style="text-decoration: none;color:red">*</a></label>
                <select id="year" class="form-control form-select" autocomplete="off">
                    <option value="">Select Option</option>
                    @foreach ($report_year as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
                        <!-- <input type="text" id="year" name="year" placeholder="Year" class="form-control year" autocomplete="off"> -->
        </div>
    </div>
    </form>  
        <div class="container pt-4">
            <div class="table-responsive">
                <table class="table table-bordered sales" id="reports" style="width:100%;display:none;">
                    <thead>
                        <tr class="text-center">
                            <th>S.NO</th>
                            <th>COMPANYNAME</th>
                            <th>CUSTOMER NUMBER</th>
                            <th>PROJECT CODE</th>
                            <th>DATE</th>
                            <th>TAXABLE AMOUNT</th>
                            <th>VAT 5%</th>
                            <th>TOTAL AMOUNT</th>
                        </tr>
                        </thead>
                        <tbody id="abuthabi">
                           
                        </tbody>
                        <tbody id="ajman">
                           
                        </tbody>
                        <tbody id="dubai">
                            
                        </tbody>
                        <tbody id="fujairah">
                            
                        </tbody>
                        <tbody id="ras_al_khaimah">
                            
                        </tbody>                       
                        <tbody id="sharjah">
                            
                        </tbody>
                        <tbody id="umm_al_quwain">
                           
                        </tbody>
                    </table>

                </div>
            </div>
            <div class="container pt-4">
                <div class="table-responsive">
                    <table class="table table-bordered"  id="sales_reports"style="width:100%;display:none;">
                        <thead>
                            <tr>
                                <th colspan="4" class="text-center text-danger"><h5><b>SALES REPORT</b></h5></th>
                            </tr>
                            <tr class="text-center">
                                <th>SITE LOCATION</th>
                                <th>AMOUNT</th>
                                <th>VAT 5%</th>
                                <th>TOTAL AMOUNT</th>
                            </tr>
                        </thead>
                        <tbody id=show_salesreport>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="container pt-4">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="purchase_report" style="width:100%;display:none;">
                            <thead>
                                <tr>
                                    <th colspan="5" class="text-center text-danger"><h5><b>PURCHASE REPORT</b></h5></th>
                                </tr>
                                <tr class="text-center">
                                    <th>S.no</th>
                                    <th>SITE LOCATION</th>
                                    <th>AMOUNT</th>
                                    <th>VAT 5%</th>
                                    <th>TOTAL</th>
                                </tr>
                            </thead>
                            <tbody id="purchase">

                            </tbody>
                        </table>
                    </div>
                </div>               
<script>
$(document).on('change', '#month,#year', function() 
{
    var month = $("#month").val();
    var year = $("#year").val();
     // Check if both month and year are selected
     if (month && year) {
        $('#reports').show(); // Show the reports table
        $('#sales_reports').show(); // Show the sales reports table
        $('#purchase_report').show(); // Show the purchase report table
    } else {
        $('#reports').hide(); // Hide the reports table
        $('#sales_reports').hide(); // Hide the sales reports table
        $('#purchase_report').hide(); // Hide the purchase report table
    }

    var dateRangeString = month;

    // Split the string into before and after values
    var dateRangeParts = dateRangeString.split(' to ');
    var beforeValue = dateRangeParts[0];
    var afterValue = dateRangeParts[1];

    // Output the before and after values
    var startdate = year + beforeValue;
    var enddate =  year + afterValue;
    
    $.ajax(
    {
        type: "POST",
        url: "{{ route('dateReport') }}",
        dataType: "json",
        data:
        {
            'startdate':startdate,
            'enddate' : enddate
        },
            

        success: function(data) 
        {

            // Clear the existing table rows
            $('#abuthabi').empty();
            $('#ajman').empty();
            $('#dubai').empty();
            $('#fujairah').empty();
            $('#ras_al_khaimah').empty();
            $('#sharjah').empty();
            $('#umm_al_quwain').empty();
            $('#show_salesreport').empty();

            var create_id = 1;           
            var abuItemTotal = 0;
            var abuVatAmount = 0;
            var abuTotalAmount = 0;
           
            // Create a table row with a colspan for the header
            var headerRow = $('<tr>').append($('<td>').attr('colspan', '8').addClass('font-weight-bold').text('ABU DHABI'));

            // Append the header row to the table
            $('#abuthabi').append(headerRow);

            for (var item of data.reports2)
                {
                    var row = '<tr>';
                    row += '<td>' + create_id + '</td>';
                    row += '<td>' + item.company_name + '</td>';
                    row += '<td>' + item.receivables_code + '</td>';
                    row += '<td>' + item.project_code + '</td>';
                    row += '<td>' + new Date(item.created_at).toLocaleDateString('en-GB') + '</td>';
                    row += '<td>' + item.item_amount + '</td>';
                    row += '<td>' + item.vat_amount + '</td>';
                    row += '<td>' + item.total_amount + '</td>';
                    row += '</tr>';

                    $('#abuthabi').append(row);

                    create_id++;

                    // Calculate the sum
                    abuItemTotal += parseFloat(item.item_amount);
                    abuVatAmount += parseFloat(item.vat_amount);
                    abuTotalAmount += parseFloat(item.total_amount);

                }            
            let abu_script ='<tr><td colspan="5" class="text-right font-weight-bold">TOTAL AMOUNT</td>';
            abu_script +='<td class="font-weight-bold">' + abuItemTotal + '</td>';
            abu_script +='<td class="font-weight-bold">' + abuVatAmount + '</td>';
            abu_script +='<td class="font-weight-bold">' + abuTotalAmount + '</td></tr>';
            $('#abuthabi').append(abu_script);   

            var adjmanItemTotal = 0;
            var adjmanVatAmount = 0;
            var adjmanTotalAmount = 0;
                    
            // Create a table row with a colspan for the header
            var headerRow = $('<tr>').append($('<td>').attr('colspan', '8').addClass('font-weight-bold').text('AJMAN'));

            // Append the header row to the table
            $('#ajman').append(headerRow);

            for (var item of data.reports4)
            {
                var row = '<tr>';
                row += '<td>' + create_id + '</td>';
                row += '<td>' + item.company_name + '</td>';
                row += '<td>' + item.receivables_code + '</td>';
                row += '<td>' + item.project_code + '</td>';
                row += '<td>' + new Date(item.created_at).toLocaleDateString('en-GB') + '</td>';
                row += '<td>' + item.item_amount + '</td>';
                row += '<td>' + item.vat_amount + '</td>';
                row += '<td>' + item.total_amount + '</td>';
                row += '</tr>';

                $('#ajman').append(row);

                create_id++;

                // Calculate the sum
                adjmanItemTotal += parseFloat(item.item_amount);
                adjmanVatAmount += parseFloat(item.vat_amount);
                adjmanTotalAmount += parseFloat(item.total_amount);

            }            
        let adjman_script ='<tr><td colspan="5" class="text-right font-weight-bold">TOTAL AMOUNT</td>';
        adjman_script +='<td class="font-weight-bold">' + adjmanItemTotal + '</td>';
        adjman_script +='<td class="font-weight-bold">' + adjmanVatAmount + '</td>';
        adjman_script +='<td class="font-weight-bold">' + adjmanTotalAmount + '</td></tr>';
        $('#ajman').append(adjman_script);          

            var dubaiItemTotal = 0;
            var dubaiVatAmount = 0;
            var dubaiTotalAmount = 0;
                  
            // Create a table row with a colspan for the header
            var headerRow = $('<tr>').append($('<td>').attr('colspan', '8').addClass('font-weight-bold').text('DUBAI'));

            // Append the header row to the table
            $('#dubai').append(headerRow);

            for (var item of data.reports)
            {
                var row = '<tr>';
                row += '<td>' + create_id + '</td>';
                row += '<td>' + item.company_name + '</td>';
                row += '<td>' + item.receivables_code + '</td>';
                row += '<td>' + item.project_code + '</td>';
                row += '<td>' + new Date(item.created_at).toLocaleDateString('en-GB') + '</td>';
                row += '<td>' + item.item_amount + '</td>';
                row += '<td>' + item.vat_amount + '</td>';
                row += '<td>' + item.total_amount + '</td>';
                row += '</tr>';

                $('#dubai').append(row);

                create_id++;

                // Calculate the sum
                dubaiItemTotal += parseFloat(item.item_amount);
                dubaiVatAmount += parseFloat(item.vat_amount);
                dubaiTotalAmount += parseFloat(item.total_amount);

            }            
        let dubai_script ='<tr><td colspan="5" class="text-right font-weight-bold">TOTAL AMOUNT</td>';
        dubai_script +='<td class="font-weight-bold">' + dubaiItemTotal + '</td>';
        dubai_script +='<td class="font-weight-bold">' + dubaiVatAmount + '</td>';
        dubai_script +='<td class="font-weight-bold">' + dubaiTotalAmount + '</td></tr>';
        $('#dubai').append(dubai_script);          

            var fujairahItemTotal = 0;
            var fujairahVatAmount = 0;
            var fujairahTotalAmount = 0;
                  
            // Create a table row with a colspan for the header
            var headerRow = $('<tr>').append($('<td>').attr('colspan', '8').addClass('font-weight-bold').text('FUJAIRAH'));

            // Append the header row to the table
            $('#fujairah').append(headerRow);

            for (var item of data.reports5)
            {
                var row = '<tr>';
                row += '<td>' + create_id + '</td>';
                row += '<td>' + item.company_name + '</td>';
                row += '<td>' + item.receivables_code + '</td>';
                row += '<td>' + item.project_code + '</td>';
                row += '<td>' + new Date(item.created_at).toLocaleDateString('en-GB') + '</td>';
                row += '<td>' + item.item_amount + '</td>';
                row += '<td>' + item.vat_amount + '</td>';
                row += '<td>' + item.total_amount + '</td>';
                row += '</tr>';

                $('#fujairah').append(row);

                create_id++;

                // Calculate the sum
                fujairahItemTotal += parseFloat(item.item_amount);
                fujairahVatAmount += parseFloat(item.vat_amount);
                fujairahTotalAmount += parseFloat(item.total_amount);

            }            
        let fujairah_script ='<tr><td colspan="5" class="text-right font-weight-bold">TOTAL AMOUNT</td>';
        fujairah_script +='<td class="font-weight-bold">' + fujairahItemTotal + '</td>';
        fujairah_script +='<td class="font-weight-bold">' + fujairahVatAmount + '</td>';
        fujairah_script +='<td class="font-weight-bold">' + fujairahTotalAmount + '</td></tr>';
        $('#fujairah').append(fujairah_script); 
        
            var rasItemTotal = 0;
            var rasVatAmount = 0;
            var rasTotalAmount = 0;
                  
            // Create a table row with a colspan for the header
            var headerRow = $('<tr>').append($('<td>').attr('colspan', '8').addClass('font-weight-bold').text('RAS AL KHAIMAH'));

            // Append the header row to the table
            $('#ras_al_khaimah').append(headerRow);

            for (var item of data.reports3)
            {
                var row = '<tr>';
                row += '<td>' + create_id + '</td>';
                row += '<td>' + item.company_name + '</td>';
                row += '<td>' + item.receivables_code + '</td>';
                row += '<td>' + item.project_code + '</td>';
                row += '<td>' + new Date(item.created_at).toLocaleDateString('en-GB') + '</td>';
                row += '<td>' + item.item_amount + '</td>';
                row += '<td>' + item.vat_amount + '</td>';
                row += '<td>' + item.total_amount + '</td>';
                row += '</tr>';

                $('#ras_al_khaimah').append(row);

                create_id++;

                // Calculate the sum
                rasItemTotal += parseFloat(item.item_amount);
                rasVatAmount += parseFloat(item.vat_amount);
                rasTotalAmount += parseFloat(item.total_amount);

            }            
        let ras_script ='<tr><td colspan="5" class="text-right font-weight-bold">TOTAL AMOUNT</td>';
        ras_script +='<td class="font-weight-bold">' + rasItemTotal + '</td>';
        ras_script +='<td class="font-weight-bold">' + rasVatAmount + '</td>';
        ras_script +='<td class="font-weight-bold">' + rasTotalAmount + '</td></tr>';
        $('#ras_al_khaimah').append(ras_script);    
        
            var sharjahItemTotal = 0;
            var sharjahVatAmount = 0;
            var sharjahTotalAmount = 0;
                  
            // Create a table row with a colspan for the header
            var headerRow = $('<tr>').append($('<td>').attr('colspan', '8').addClass('font-weight-bold').text('SHARJAN'));

            // Append the header row to the table
            $('#sharjah').append(headerRow);

            for (var item of data.reports6)
            {
                var row = '<tr>';
                row += '<td>' + create_id + '</td>';
                row += '<td>' + item.company_name + '</td>';
                row += '<td>' + item.receivables_code + '</td>';
                row += '<td>' + item.project_code + '</td>';
                row += '<td>' + new Date(item.created_at).toLocaleDateString('en-GB') + '</td>';
                row += '<td>' + item.item_amount + '</td>';
                row += '<td>' + item.vat_amount + '</td>';
                row += '<td>' + item.total_amount + '</td>';
                row += '</tr>';

                $('#sharjah').append(row);

                create_id++;

                // Calculate the sum
                sharjahItemTotal += parseFloat(item.item_amount);
                sharjahVatAmount += parseFloat(item.vat_amount);
                sharjahTotalAmount += parseFloat(item.total_amount);

            }            
        let sharjah_script ='<tr><td colspan="5" class="text-right font-weight-bold">TOTAL AMOUNT</td>';
        sharjah_script +='<td class="font-weight-bold">' + sharjahItemTotal + '</td>';
        sharjah_script +='<td class="font-weight-bold">' + sharjahVatAmount + '</td>';
        sharjah_script +='<td class="font-weight-bold">' + sharjahTotalAmount + '</td></tr>';
        $('#sharjah').append(sharjah_script); 
        
            var umm_al_quwainItemTotal = 0;
            var umm_al_quwainVatAmount = 0;
            var umm_al_quwainTotalAmount = 0;
                  
            // Create a table row with a colspan for the header
            var headerRow = $('<tr>').append($('<td>').attr('colspan', '8').addClass('font-weight-bold').text('UMM AL QUWAIN'));

            // Append the header row to the table
            $('#umm_al_quwain').append(headerRow);

            for (var item of data.reports7)
            {
                var row = '<tr>';
                row += '<td>' + create_id + '</td>';
                row += '<td>' + item.company_name + '</td>';
                row += '<td>' + item.receivables_code + '</td>';
                row += '<td>' + item.project_code + '</td>';
                row += '<td>' + new Date(item.created_at).toLocaleDateString('en-GB') + '</td>';
                row += '<td>' + item.item_amount + '</td>';
                row += '<td>' + item.vat_amount + '</td>';
                row += '<td>' + item.total_amount + '</td>';
                row += '</tr>';

                $('#umm_al_quwain').append(row);

                create_id++;

                // Calculate the sum
                umm_al_quwainItemTotal += parseFloat(item.item_amount);
                umm_al_quwainVatAmount += parseFloat(item.vat_amount);
                umm_al_quwainTotalAmount += parseFloat(item.total_amount);

            }            
        let quwain_script ='<tr><td colspan="5" class="text-right font-weight-bold">TOTAL AMOUNT </td>';
        quwain_script +='<td class="font-weight-bold">' + umm_al_quwainItemTotal + '</td>';
        quwain_script +='<td class="font-weight-bold">' + umm_al_quwainVatAmount + '</td>';
        quwain_script +='<td class="font-weight-bold">' + umm_al_quwainTotalAmount + '</td></tr>';
        $('#umm_al_quwain').append(quwain_script);
        
            var grandItemTotal = 0;
            var grandVatTotal = 0;
            var grandTotalAmount = 0;
       
            grandItemTotal += abuItemTotal + adjmanItemTotal + dubaiItemTotal + fujairahItemTotal + rasItemTotal + sharjahItemTotal + umm_al_quwainItemTotal;
            grandVatTotal += abuVatAmount + adjmanVatAmount + dubaiVatAmount + fujairahVatAmount + rasVatAmount + sharjahVatAmount + umm_al_quwainVatAmount;
            grandTotalAmount += abuTotalAmount + adjmanTotalAmount + dubaiTotalAmount + fujairahTotalAmount + rasTotalAmount + sharjahTotalAmount + umm_al_quwainTotalAmount;

            let Grand_total ='<tr><td colspan="5" class="text-right font-weight-bold">GRAND TOTAl</td>';
            Grand_total +='<td class="font-weight-bold">' + grandItemTotal + '</td>';
            Grand_total +='<td class="font-weight-bold">' + grandVatTotal + '</td>';
            Grand_total +='<td class="font-weight-bold">' + grandTotalAmount + '</td></tr>';
            $('#umm_al_quwain').append(Grand_total);

        // SALES REPORT 
        let abu_sales ='<tr>';
            abu_sales +='<td class="text-center">Abu Dhabi</td>';
            abu_sales +='<td class="text-center">' + abuItemTotal + '</td>';
            abu_sales +='<td class="text-center">' + abuVatAmount + '</td>';
            abu_sales +='<td class="text-center">' + abuTotalAmount + '</td></tr>';
            $('#show_salesreport').append(abu_sales); 

        let adjman_sales ='<tr>';
            adjman_sales +='<td class="text-center">Ajman</td>';
            adjman_sales +='<td class="text-center">' + adjmanItemTotal + '</td>';
            adjman_sales +='<td class="text-center">' + adjmanVatAmount + '</td>';
            adjman_sales +='<td class="text-center">' + adjmanTotalAmount + '</td></tr>';
            $('#show_salesreport').append(adjman_sales);
        let dubai_sales ='<tr>';
            dubai_sales +='<td class="text-center">Dubai</td>';
            dubai_sales +='<td class="text-center">' + dubaiItemTotal + '</td>';
            dubai_sales +='<td class="text-center">' + dubaiVatAmount + '</td>';
            dubai_sales +='<td class="text-center">' + dubaiTotalAmount + '</td></tr>';
            $('#show_salesreport').append(dubai_sales);
            let fujairah_sales ='<tr>';
            fujairah_sales +='<td class="text-center">Fujairah</td>';
            fujairah_sales +='<td class="text-center">' + fujairahItemTotal + '</td>';
            fujairah_sales +='<td class="text-center">' + fujairahVatAmount + '</td>';
            fujairah_sales +='<td class="text-center">' + fujairahTotalAmount + '</td></tr>';
            $('#show_salesreport').append(fujairah_sales);
            let ras_sales ='<tr>';
            ras_sales +='<td class="text-center">Ras Al Khaimah</td>';
            ras_sales +='<td class="text-center">' + rasItemTotal + '</td>';
            ras_sales +='<td class="text-center">' + rasVatAmount + '</td>';
            ras_sales +='<td class="text-center">' + rasTotalAmount + '</td></tr>';
            $('#show_salesreport').append(ras_sales);
            let sharjah_sales ='<tr>';
            sharjah_sales +='<td class="text-center">Sharjah</td>';
            sharjah_sales +='<td class="text-center">' + sharjahItemTotal + '</td>';
            sharjah_sales +='<td class="text-center">' + sharjahVatAmount + '</td>';
            sharjah_sales +='<td class="text-center">' + sharjahTotalAmount + '</td></tr>';
            $('#show_salesreport').append(sharjah_sales);
            let quwain_sales ='<tr>';
            quwain_sales +='<td class="text-center">Umm Al Quwain</td>';
            quwain_sales +='<td class="text-center">' + umm_al_quwainItemTotal + '</td>';
            quwain_sales +='<td class="text-center">' + umm_al_quwainVatAmount + '</td>';
            quwain_sales +='<td class="text-center">' + umm_al_quwainTotalAmount + '</td></tr>';
            $('#show_salesreport').append(quwain_sales);
           
            let grand_sale ='<tr>';
            grand_sale +='<td class="text-center font-weight-bold">SALES GRAND TOTAl</td>';
            grand_sale +='<td class="text-center font-weight-bold">' + grandItemTotal + '</td>';
            grand_sale +='<td class="text-center font-weight-bold">' + grandVatTotal + '</td>';
            grand_sale +='<td class="text-center font-weight-bold">' + grandTotalAmount + '</td></tr>';
            $('#show_salesreport').append(grand_sale);



        },
        fail: function(xhr, textStatus, errorThrown)
            {
                alert(errorThrown);
            }
    });
});




    $(document).on('change', '#year, #month', function()
    {
        var month = $("#month").val();
        console.log(month);
        var year = $("#year").val();
        // console.log(year);

        // Input string
        var dateRangeString = month;

        // Split the string into before and after values
        var dateRangeParts = dateRangeString.split(' to ');
        var beforeValue = dateRangeParts[0];
        var afterValue = dateRangeParts[1];

        // Output the before and after values
        console.log(beforeValue); // Output: -01-01
        console.log(afterValue); // Output: -03-31

        var startdate = year + beforeValue;
        var enddate =  year + afterValue;
        console.log(startdate);
        console.log(enddate);

        var pur_total_total_amount1 = 0;
        var pur_total_vat_amount1 = 0;
        var pur_total_gross_amount1 = 0;

        $.ajax({
            type: "POST",
            url: "{{ route('purchaseReport') }}",
            dataType: "json",
            data:
            {
                'startdate': startdate,
                'enddate' : enddate
            },
            success: function(data)
            {
                console.log(data.pur_report);

                // Clear the existing table rows
                $('#purchase').empty();

                var create_id = 1;

                for (var item of data.pur_report)
                {
                    console.log(item);

                    var row = '<tr>';
                    row += '<td class="text-center">' + create_id + '</td>';
                    row += '<td class="text-center">' + item.site_location + '</td>';
                    row += '<td class="text-center">' + item.total_amount + '</td>';
                    row += '<td class="text-center">' + item.vat_amount + '</td>';
                    row += '<td class="text-center">' + item.gross_amount + '</td>';
                    row += '</tr>';

                    $('#purchase').append(row);

                    create_id++;

                    // Calculate the sum
                    pur_total_total_amount1 += parseFloat(item.total_amount);
                    pur_total_vat_amount1 += parseFloat(item.vat_amount);
                    pur_total_gross_amount1 += parseFloat(item.gross_amount);
                }

                // Update the total row
                var totalRow = '<tr>';
                totalRow += '<td colspan="2" class="text-center font-weight-bold">PURCHASE GRAND TOTAL</td>';
                totalRow += '<td class="text-center font-weight-bold">' + pur_total_total_amount1 + '</td>';
                totalRow += '<td class="text-center font-weight-bold">' + pur_total_vat_amount1 + '</td>';
                totalRow += '<td class="text-center font-weight-bold">' + pur_total_gross_amount1 + '</td>';
                totalRow += '</tr>';

                $('#purchase').append(totalRow);
            },
            error: function(xhr, textStatus, errorThrown)
            {
                alert(errorThrown);
            }
        });
    });
    


    // Function to print the page
function printPage() 
{
    window.print();
}

// Add a button or link to trigger the print function
$('#printButton').on('click', function() {
    $('#printButton').hide(); // Hide the print button
    $('#csvButton').hide(); // Hide the print button 
    printPage();
});
window.addEventListener('afterprint', function() {
    $('#printButton').show(); // Show the print button
    $('#csvButton').show(); // Show the CSV button
});

function exportToCSV() {
    var csvString = '';

    // Get data from the first table (reports)
    var tableReports = document.getElementById('reports');
    for (var i = 0; i < tableReports.rows.length; i++) {
        var rowData = tableReports.rows[i].cells;
        for (var j = 0; j < rowData.length; j++) {
            csvString += rowData[j].innerText + ',';
        }
        csvString += '\n';
    }

    // Get data from the second table (sales report)
    var tableSalesReport = document.getElementById('sales_reports');
    for (var i = 0; i < tableSalesReport.rows.length; i++) {
        var rowData = tableSalesReport.rows[i].cells;
        for (var j = 0; j < rowData.length; j++) {
            csvString += rowData[j].innerText + ',';
        }
        csvString += '\n';
    }

    // Get data from the third table (purchase report)
    var tablePurchaseReport = document.getElementById('purchase_report');
    for (var i = 0; i < tablePurchaseReport.rows.length; i++) {
        var rowData = tablePurchaseReport.rows[i].cells;
        for (var j = 0; j < rowData.length; j++) {
            csvString += rowData[j].innerText + ',';
        }
        csvString += '\n';
    }

    // Create a temporary link element to download the CSV file
    var link = document.createElement('a');
    link.href = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csvString);
    link.download = 'combined_report.csv';
    link.style.display = 'none';

    // Add the link element to the page and trigger the download
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}



// Add event listener to the CSV button
$('#csvButton').on('click', function() {
    exportToCSV();
});



</script>
@stop


