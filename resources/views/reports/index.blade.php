@extends('layouts.app',[
    'activeName' => 'Reports'
])
@section('title', 'Reports')

@section('content_header')
@stop
@section('content')
<style>
    table.table-bordered th,
table.table-bordered td {
  border: 1px solid black;
}
</style>
    <div class="row">
        <div class="container-fluid">
            <div class="card shadow">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h4 class="font-weight-bold text-dark py">Reports</h4>
                    </div>
                </div>
            </div>
            <form>
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
                        <input type="text" id="year" name="year" placeholder="Year" class="form-control year" autocomplete="off">
                    </div>
                </div>
            </form>
            <div class="container pt-4">
                <div class="table-responsive">
                    <table class="table table-bordered" style="width:100%;">
                        <thead>
                            <tr class="text-center">
                                <th>S.NO</th>
                                <th>CompanyName</th>
                                <th>CUSTOMER NUMBER</th>
                                <th>PROJECT CODE</th>
                                <th>MONTH/YEAR</th>
                                <th>TAXABLE AMOUNT</th>
                                <th>VAT 5%</th>
                                <th>TOTAL AMOUNT</th>
                            </tr>
                        </thead>
                        <tbody id="abuthabi">
                            <tr>
                                <td colspan="8" class="text-center font-weight-bold">ABU DHABI</td>
                            </tr>
                        </tbody>
                        <tbody id="ajman">
                            <tr>
                                <td colspan="8" class="text-center font-weight-bold">AJMAN</td>
                            </tr>
                        </tbody>
                        <tbody id="dubai">
                            <tr>
                                <td colspan="8" class="text-center font-weight-bold">DUBAI</td>
                            </tr>
                        </tbody>
                        <tbody id="fujairah">
                            <tr>
                                <td colspan="8" class="text-center font-weight-bold">FUJAIRAH</td>
                            </tr>
                        </tbody>
                        <tbody id="ras_al_khaimah">
                            <tr>
                                <td colspan="8" class="text-center font-weight-bold">RAS AL KHAIMAH</td>
                            </tr>
                        </tbody>                       
                        <tbody id="sharjah">
                            <tr>
                                <td colspan="8" class="text-center font-weight-bold">SHARJAH</td>
                            </tr>
                        </tbody>
                        <tbody id="umm_al_quwain">
                            <tr>
                                <td colspan="8" class="text-center font-weight-bold">UMM AL QUWAIN</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
            <div class="container pt-4">
                <div class="table-responsive">
                    <table class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th colspan="4" class="text-center text-danger"><h5><b>SALES REPORT</b></h5></th>
                            </tr>
                            <tr class="text-center">
                                <th>DESCRIPTION</th>
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

<script>
   // table body
   var rowIdx = 1;
   var city;
    function add_text(city) 
    { 
        var html = '';
        html += '<tr id="row' + rowIdx + '">';
        html += '<td>' + rowIdx + '</td>';
        html += '<td><div class="col-xs-12"  id="company_name_' + rowIdx +
        '"  name="company_name[]" class="company_name form-control" ></td>';
        html += '<td><div class="col-xs-12"  id="receivables_code_' + rowIdx +
        '"  name="receivables_code[]" class="receivables_code form-control" ></td>';
        html += '<td><div class="col-xs-12" id="project_code_' + rowIdx +
            '"name="project_code[]" class="project_code form-control"></td>';
        html += '<td><div class="col-xs-12" name="created_at[]" id="created_at_' + rowIdx +
            '"   class="created_at form-control"></td>';
        html += '<td><div class="col-xs-12" name="item_amount[]" id="item_amount_' + rowIdx +
            '"  class="item_amount form-control" ></td>';
        html += '<td><div class="col-xs-12" name="vat_amount[]" id="vat_amount_' + rowIdx +
            '"  class="vat_amount form-control" ></td>';
        html += '<td><div class="col-xs-12" name="total_amount[]" id="total_amount_' + rowIdx +
            '"  class="total_amount form-control" ></td>';
            '</tr>';
        
       
       if(city=='abuthabi')
       {
        $("#abuthabi").append(html);
       }
       else if(city=='Ajman')
       {
        $("#ajman").append(html);
       }
       else if(city=='dubai')
       {
        $("#dubai").append(html);
       }
       else if(city=='Fujairah')
       {
        $("#fujairah").append(html);
       }
       else if(city=='Ras Al Khaimah')
       {
        $("#ras_al_khaimah").append(html);
       }     
       else if(city=='Sharjah')
       {
        $("#sharjah").append(html);
       }
       else if(city=='Umm Al Quwain')
       {
        $("#umm_al_quwain").append(html);
       }
        rowIdx++;
    }
  
$(document).on('change', '#year', function() 
{
    var month = $("#month").val();
    var year = $("#year").val();
    

    // Input string
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
            var create_id = 1;           
            var totalItemTotal = 0;
            var totalVatAmount = 0;
            var totalTotalAmount = 0;
            var grandItemTotal = 0;
            var grandVatTotal = 0;
            var grandTotalAmount = 0;

            // Iterate over the reports for Dubai
            
            for (const item of data.reports2) 
            {
                add_text('abuthabi');
                console.log(data.reports2);

                // Find the corresponding table cells using the create_id_dubai variable
                    var clientCompanyName = $('#company_name_' + create_id);
                    var grnInvoiceNoCell = $('#receivables_code_' + create_id);
                    var projectCodeCell = $('#project_code_' + create_id);
                    var createdAtCell = $('#created_at_' + create_id);
                    var totalAmountCell = $('#item_amount_' + create_id);
                    var vatAmountCell = $('#vat_amount_' + create_id);
                    var grossAmountCell = $('#total_amount_' + create_id);

                //     // Set the text values in the table cells
                    clientCompanyName.text(item.company_name);
                    grnInvoiceNoCell.text(item.receivables_code);
                    projectCodeCell.text(item.project_code);
                    createdAtCell.text(item.created_at);
                    totalAmountCell.text(item.item_amount);
                    vatAmountCell.text(item.vat_amount);
                    grossAmountCell.text(item.total_amount);

                 // Calculate the sum
                    totalItemTotal += parseFloat(item.item_amount);
                    totalVatAmount += parseFloat(item.vat_amount);
                    totalTotalAmount += parseFloat(item.total_amount);

                    create_id++;
                        console.log("Total Item Total:", totalItemTotal);
                        console.log("Total Vat Amount:", totalVatAmount);
                        console.log("Total Total Amount:", totalTotalAmount);

            }
            let script ='<tr><td colspan="5" class="text-center font-weight-bold"><center>TOTAL AMOUNT OF ABU DHABI</center></td>';
            script +='<td class="font-weight-bold">' + totalItemTotal + '</td>';
            script +='<td class="font-weight-bold">' + totalVatAmount + '</td>';
            script +='<td class="font-weight-bold">' + totalTotalAmount + '</td></tr>';
            $('#abuthabi').append(script);

            var totalItemTotal1 = 0;
            var totalVatAmount1 = 0;
            var totalTotalAmount1 = 0;
            for (const item of data.reports4) 
            {
                add_text('Ajman');
                console.log(data.reports4);

                // Find the corresponding table cells using the create_id_dubai variable
                    var clientCompanyName = $('#company_name_' + create_id)
                    var grnInvoiceNoCell = $('#receivables_code_' + create_id);
                    var projectCodeCell = $('#project_code_' + create_id);
                    var createdAtCell = $('#created_at_' + create_id);
                    var totalAmountCell = $('#item_amount_' + create_id);
                    var vatAmountCell = $('#vat_amount_' + create_id);
                    var grossAmountCell = $('#total_amount_' + create_id);

                // Set the text values in the table cells
                    clientCompanyName.text(item.company_name);
                    grnInvoiceNoCell.text(item.receivables_code);
                    projectCodeCell.text(item.project_code);
                    createdAtCell.text(item.created_at);
                    totalAmountCell.text(item.item_amount);
                    vatAmountCell.text(item.vat_amount);
                    grossAmountCell.text(item.total_amount);

                // Calculate the sum
                    totalItemTotal1 += parseFloat(item.item_amount);
                    totalVatAmount1 += parseFloat(item.vat_amount);
                    totalTotalAmount1 += parseFloat(item.total_amount);

                    create_id++;
                        console.log("Total Item Total:", totalItemTotal1);
                        console.log("Total Vat Amount:", totalVatAmount1);
                        console.log("Total Total Amount:", totalTotalAmount1);

            }
            let script1 ='<tr><td colspan="5" class="text-center font-weight-bold"><center>TOTAL AMOUNT OF AJMAN</center></td>';
            script1 +='<td class="font-weight-bold">' + totalItemTotal1 + '</td>';
            script1 +='<td class="font-weight-bold">' + totalVatAmount1 + '</td>';
            script1 +='<td class="font-weight-bold">' + totalTotalAmount1 + '</td></tr>';
            $('#ajman').append(script1);

            var totalItemTotal2 = 0;
            var totalVatAmount2 = 0;
            var totalTotalAmount2 = 0;
            for (const item of data.reports) 
            {
                add_text('dubai');
                console.log(data.reports);
                // Find the corresponding table cells using the create_id_dubai variable
                    var clientCompanyName = $('#company_name_' + create_id)
                    var grnInvoiceNoCell = $('#receivables_code_' + create_id);
                    var projectCodeCell = $('#project_code_' + create_id);
                    var createdAtCell = $('#created_at_' + create_id);
                    var totalAmountCell = $('#item_amount_' + create_id);
                    var vatAmountCell = $('#vat_amount_' + create_id);
                    var grossAmountCell = $('#total_amount_' + create_id);

                // Set the text values in the table cells
                    clientCompanyName.text(item.company_name);
                    grnInvoiceNoCell.text(item.receivables_code);
                    projectCodeCell.text(item.project_code);
                    createdAtCell.text(item.created_at);
                    totalAmountCell.text(item.item_amount);
                    vatAmountCell.text(item.vat_amount);
                    grossAmountCell.text(item.total_amount);

                // Calculate the sum
                    totalItemTotal2 += parseFloat(item.item_amount);
                    totalVatAmount2 += parseFloat(item.vat_amount);
                    totalTotalAmount2 += parseFloat(item.total_amount);

                    create_id++;
                        console.log("Total Item Total:", totalItemTotal);
                        console.log("Total Vat Amount:", totalVatAmount);
                        console.log("Total Total Amount:", totalTotalAmount);

            }
            let script2 ='<tr><td colspan="5" class="text-center font-weight-bold"><center>TOTAL AMOUNT OF DUBAI</center></td>';
            script2 +='<td class="font-weight-bold">' + totalItemTotal2 + '</td>';
            script2 +='<td class="font-weight-bold">' + totalVatAmount2 + '</td>';
            script2 +='<td class="font-weight-bold">' + totalTotalAmount2 + '</td></tr>';
            $('#dubai').append(script2);

            var totalItemTotal3 = 0;
            var totalVatAmount3 = 0;
            var totalTotalAmount3 = 0;
            for (const item of data.reports5) 
            {
                add_text('Fujairah');
                console.log(data.reports5);

                // Find the corresponding table cells using the create_id_dubai variable
                    var clientCompanyName = $('#company_name_' + create_id);
                    var grnInvoiceNoCell = $('#receivables_code_' + create_id);
                    var projectCodeCell = $('#project_code_' + create_id);
                    var createdAtCell = $('#created_at_' + create_id);
                    var totalAmountCell = $('#item_amount_' + create_id);
                    var vatAmountCell = $('#vat_amount_' + create_id);
                    var grossAmountCell = $('#total_amount_' + create_id);

                //     // Set the text values in the table cells
                    clientCompanyName.text(item.company_name);
                    grnInvoiceNoCell.text(item.receivables_code);
                    projectCodeCell.text(item.project_code);
                    createdAtCell.text(item.created_at);
                    totalAmountCell.text(item.item_amount);
                    vatAmountCell.text(item.vat_amount);
                    grossAmountCell.text(item.total_amount);

                // Calculate the sum
                    totalItemTotal3 += parseFloat(item.item_amount);
                    totalVatAmount3 += parseFloat(item.vat_amount);
                    totalTotalAmount3 += parseFloat(item.total_amount);

                    create_id++;
                        console.log("Total Item Total:", totalItemTotal);
                        console.log("Total Vat Amount:", totalVatAmount);
                        console.log("Total Total Amount:", totalTotalAmount);

            }
            let script3 ='<tr><td colspan="5" class="text-center font-weight-bold"><center>TOTAL AMOUNT OF FUJAIRAH</center></td>';
            script3 +='<td class="font-weight-bold">' + totalItemTotal3 + '</td>';
            script3 +='<td class="font-weight-bold">' + totalVatAmount3 + '</td>';
            script3 +='<td class="font-weight-bold">' + totalTotalAmount3 + '</td></tr>';
            $('#fujairah').append(script3);

            var totalItemTotal4 = 0;
            var totalVatAmount4 = 0;
            var totalTotalAmount4 = 0;
            for (const item of data.reports3) 
            {
                add_text('Ras Al Khaimah');
                console.log(data.reports3);

                // Find the corresponding table cells using the create_id_dubai variable
                    var clientCompanyName = $('#company_name_' + create_id);
                    var grnInvoiceNoCell = $('#receivables_code_' + create_id);
                    var projectCodeCell = $('#project_code_' + create_id);
                    var createdAtCell = $('#created_at_' + create_id);
                    var totalAmountCell = $('#item_amount_' + create_id);
                    var vatAmountCell = $('#vat_amount_' + create_id);
                    var grossAmountCell = $('#total_amount_' + create_id);

                //     // Set the text values in the table cells
                    clientCompanyName.text(item.company_name);
                    grnInvoiceNoCell.text(item.receivables_code);
                    projectCodeCell.text(item.project_code);
                    createdAtCell.text(item.created_at);
                    totalAmountCell.text(item.item_amount);
                    vatAmountCell.text(item.vat_amount);
                    grossAmountCell.text(item.total_amount);

                // Calculate the sum
                    totalItemTotal4 += parseFloat(item.item_amount);
                    totalVatAmount4 += parseFloat(item.vat_amount);
                    totalTotalAmount4 += parseFloat(item.total_amount);

                    create_id++;
                        console.log("Total Item Total:", totalItemTotal);
                        console.log("Total Vat Amount:", totalVatAmount);
                        console.log("Total Total Amount:", totalTotalAmount);

            }
            let script4 ='<tr><td colspan="5" class="text-center font-weight-bold"><center>TOTAL AMOUNT OF RAS AL KHAIMAH</center></td>';
            script4 +='<td class="font-weight-bold">' + totalItemTotal4 + '</td>';
            script4 +='<td class="font-weight-bold">' + totalVatAmount4 + '</td>';
            script4 +='<td class="font-weight-bold">' + totalTotalAmount4 + '</td></tr>';
            $('#ras_al_khaimah').append(script4);

            var totalItemTotal5 = 0;
            var totalVatAmount5 = 0;
            var totalTotalAmount5 = 0;
            for (const item of data.reports6) 
            {
                add_text('Sharjah');
                console.log(data.reports6);

                // Find the corresponding table cells using the create_id_dubai variable
                    var clientCompanyName = $('#company_name_' + create_id);
                    var grnInvoiceNoCell = $('#receivables_code_' + create_id);
                    var projectCodeCell = $('#project_code_' + create_id);
                    var createdAtCell = $('#created_at_' + create_id);
                    var totalAmountCell = $('#item_amount_' + create_id);
                    var vatAmountCell = $('#vat_amount_' + create_id);
                    var grossAmountCell = $('#total_amount_' + create_id);

                //     // Set the text values in the table cells
                    clientCompanyName.text(item.company_name);
                    grnInvoiceNoCell.text(item.receivables_code);
                    projectCodeCell.text(item.project_code);
                    createdAtCell.text(item.created_at);
                    totalAmountCell.text(item.item_amount);
                    vatAmountCell.text(item.vat_amount);
                    grossAmountCell.text(item.total_amount);

               // Calculate the sum
                    totalItemTotal5 += parseFloat(item.item_amount);
                    totalVatAmount5 += parseFloat(item.vat_amount);
                    totalTotalAmount5 += parseFloat(item.total_amount);

                    create_id++;
                        console.log("Total Item Total:", totalItemTotal);
                        console.log("Total Vat Amount:", totalVatAmount);
                        console.log("Total Total Amount:", totalTotalAmount);

            }
            let script5 ='<tr><td colspan="5" class="text-center font-weight-bold"><center>TOTAL AMOUNT OF SHARJAH</center></td>';
            script5 +='<td class="font-weight-bold">' + totalItemTotal5 + '</td>';
            script5 +='<td class="font-weight-bold">' + totalVatAmount5 + '</td>';
            script5 +='<td class="font-weight-bold">' + totalTotalAmount5 + '</td></tr>';
            $('#sharjah').append(script5);

            var totalItemTotal6 = 0;
            var totalVatAmount6 = 0;
            var totalTotalAmount6 = 0;
            for (const item of data.reports7) 
            {
                add_text('Umm Al Quwain');
                console.log(data.reports7);

                // Find the corresponding table cells using the create_id_dubai variable
                    var clientCompanyName = $('#company_name_' + create_id);
                    var grnInvoiceNoCell = $('#receivables_code_' + create_id);
                    var projectCodeCell = $('#project_code_' + create_id);
                    var createdAtCell = $('#created_at_' + create_id);
                    var totalAmountCell = $('#item_amount_' + create_id);
                    var vatAmountCell = $('#vat_amount_' + create_id);
                    var grossAmountCell = $('#total_amount_' + create_id);

                //     // Set the text values in the table cells
                    clientCompanyName.text(item.company_name);
                    grnInvoiceNoCell.text(item.receivables_code);
                    projectCodeCell.text(item.project_code);
                    createdAtCell.text(item.created_at);
                    totalAmountCell.text(item.item_amount);
                    vatAmountCell.text(item.vat_amount);
                    grossAmountCell.text(item.total_amount);

               // Calculate the sum
                    totalItemTotal6 += parseFloat(item.item_amount);
                    totalVatAmount6 += parseFloat(item.vat_amount);
                    totalTotalAmount6 += parseFloat(item.total_amount);

                    create_id++;
                        console.log("Total Item Total:", totalItemTotal);
                        console.log("Total Vat Amount:", totalVatAmount);
                        console.log("Total Total Amount:", totalTotalAmount);

            }
            let script6 ='<tr><td colspan="5" class="text-center font-weight-bold"><center>TOTAL AMOUNT OF UMM AL QUWAIN</center></td>';
            script6 +='<td class="font-weight-bold">' + totalItemTotal6 + '</td>';
            script6 +='<td class="font-weight-bold">' + totalVatAmount6 + '</td>';
            script6 +='<td class="font-weight-bold">' + totalTotalAmount6 + '</td></tr>';
            $('#umm_al_quwain').append(script6);

            grandItemTotal += totalItemTotal+totalItemTotal1+totalItemTotal2+totalItemTotal3+totalItemTotal4+totalItemTotal5+totalItemTotal6;
            grandVatTotal += totalVatAmount+totalVatAmount1+totalVatAmount2+totalVatAmount3+totalVatAmount4+totalVatAmount5+totalVatAmount6;
            grandTotalAmount += totalTotalAmount+totalTotalAmount1+totalTotalAmount2+totalTotalAmount3+totalTotalAmount4+totalTotalAmount5+totalTotalAmount6;

            console.log(grandItemTotal);
            let script7 ='<tr><td colspan="5" class="text-center font-weight-bold"><center>GRAND TOTAl</center></td>';
            script7 +='<td class="font-weight-bold">' + grandItemTotal + '</td>';
            script7 +='<td class="font-weight-bold">' + grandVatTotal + '</td>';
            script7 +='<td class="font-weight-bold">' + grandTotalAmount + '</td></tr>';
            $('#umm_al_quwain').append(script7);

            let script8 ='<tr>';
            script8 +='<td class="text-center">ABU DHABI</td>';
            script8 +='<td class="text-center">' + totalItemTotal + '</td>';
            script8 +='<td class="text-center">' + totalVatAmount + '</td>';
            script8 +='<td class="text-center">' + totalTotalAmount + '</td></tr>';
            $('#show_salesreport').append(script8);
            let script9 ='<tr>';
            script9 +='<td class="text-center">AJMAN</td>';
            script9 +='<td class="text-center">' + totalItemTotal1 + '</td>';
            script9 +='<td class="text-center">' + totalVatAmount1 + '</td>';
            script9 +='<td class="text-center">' + totalTotalAmount1 + '</td></tr>';
            $('#show_salesreport').append(script9);
            let script10 ='<tr>';
            script10 +='<td class="text-center">DUBAI</td>';
            script10 +='<td class="text-center">' + totalItemTotal2 + '</td>';
            script10 +='<td class="text-center">' + totalVatAmount2 + '</td>';
            script10 +='<td class="text-center">' + totalTotalAmount2 + '</td></tr>';
            $('#show_salesreport').append(script10);
            let Fujairah ='<tr>';
            Fujairah +='<td class="text-center">FUJAIRAH</td>';
            Fujairah +='<td class="text-center">' + totalItemTotal3 + '</td>';
            Fujairah +='<td class="text-center">' + totalVatAmount3 + '</td>';
            Fujairah +='<td class="text-center">' + totalTotalAmount3 + '</td></tr>';
            $('#show_salesreport').append(Fujairah);
            let Ras_Al_Khaimah ='<tr>';
            Ras_Al_Khaimah +='<td class="text-center">RAS AL KHAIMAH</td>';
            Ras_Al_Khaimah +='<td class="text-center">' + totalItemTotal4 + '</td>';
            Ras_Al_Khaimah +='<td class="text-center">' + totalVatAmount4 + '</td>';
            Ras_Al_Khaimah +='<td class="text-center">' + totalTotalAmount4 + '</td></tr>';
            $('#show_salesreport').append(Ras_Al_Khaimah);
            let Sharjah ='<tr>';
            Sharjah +='<td class="text-center">SHARJAH</td>';
            Sharjah +='<td class="text-center">' + totalItemTotal5 + '</td>';
            Sharjah +='<td class="text-center">' + totalVatAmount5 + '</td>';
            Sharjah +='<td class="text-center">' + totalTotalAmount5 + '</td></tr>';
            $('#show_salesreport').append(Sharjah);
            let Umm_Al_Quwain ='<tr>';
            Umm_Al_Quwain +='<td class="text-center">UMM AL QUWAIN</td>';
            Umm_Al_Quwain +='<td class="text-center">' + totalItemTotal6 + '</td>';
            Umm_Al_Quwain +='<td class="text-center">' + totalVatAmount6 + '</td>';
            Umm_Al_Quwain +='<td class="text-center">' + totalTotalAmount6 + '</td></tr>';
            $('#show_salesreport').append(Umm_Al_Quwain);
           
            let sale ='<tr>';
            sale +='<td class="text-center font-weight-bold">SALES GRAND TOTAl</td>';
            sale +='<td class="text-center font-weight-bold">' + grandItemTotal + '</td>';
            sale +='<td class="text-center font-weight-bold">' + grandVatTotal + '</td>';
            sale +='<td class="text-center font-weight-bold">' + grandTotalAmount + '</td></tr>';
            $('#show_salesreport').append(sale);


        },
        fail: function(xhr, textStatus, errorThrown)
            {
                alert(errorThrown);
            }
    });
});
</script>

@stop


