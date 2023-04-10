<div class="modal fade" id="edit_suppliermaster">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title" align="center"><b>Edit Supplier</b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form method="POST" class="form-row" action="{{ route('suppliermaster.update',$supplier->supplier_no) }}"enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                        <div class="form-group col-md-6" hidden>
                            <label for="name" class="form-label fw-bold " hidden>Supplier No</label>
                            <input type="text" name="supplier_no" hidden value="{{old("name",$supplier->supplier_no)}}"placeholder="Supplier No" class="form-control u_no " id="u_no" required>

                        </div>
                        <div class="form-group col-md-6">
                            <label for="name" class="form-label fw-bold">Supplier Name</label>
                            <input type="text" name="name" value="{{old("name",$supplier->name)}}"placeholder="Supplier Name" class="form-control suppliername" id="u_name" required>
                            <span id="u_name_val"></span>

                        </div>
                        <div class="form-group col-md-6">
                            <label for="company_name" class="form-label fw-bold">Company Name</label>
                            <input type="text" name="company_name" value="{{old("company_name",$supplier->company_name)}}"placeholder="Company Name" class="form-control companyname" id="u_company_name" required>
                            <span id="u_company_name_val"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="code" class="form-label fw-bold">Supplier Code</label>
                            <input type="text" name="code" value="{{old("supplier_no",$supplier->supplier_no)}}" placeholder="SupplierCode" class="form-control  supplierno" disabled id="u_code" required>


                        </div>
                        <div class="form-group col-md-6">
                            <label for="address" class="form-label fw-bold">Address</label>
                            <input type="text" name="address" value="{{old("address",$supplier->address)}}"placeholder="Address" class="form-control" id="u_address" required>
                            <span id="u_address_val"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="contact_number" class="form-label fw-bold">Contact Number</label>
                            <input type="text" name="contact_number" maxlength="10" value="{{old("contact_number",$supplier->contact_number)}}" placeholder="Contact number" class="form-control contactno" id="u_contact_number" required>
                            <span id="u_contact_number_val"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="mail_id" class="form-label fw-bold">Email Id</label>
                            <input type="text" name="mail_id" value="{{old("mail_id",$supplier->mail_id)}}" placeholder="Contact number" class="form-control mailid" id="u_mail_id" required>
                            <span id="u_email_val"></span>
                        </div>
                        <div class="form-group row ">
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-primary" id="edit-info-btn">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script>
$(document).ready(function(){
  $(".edit").on("click", function(){
   alert ($(this).attr("id"));
   $.ajax({
    url: "{{ route('supplier_edit_data') }}",
    type: "GET", // or "GET", "PUT", etc.
    data: {
        'id':$(this).attr("id")
    },
    dataType: "json", // the type of data you're expecting in response
    success: function(data) {
        // the data argument contains the response from the server
        // console.log(data[0].id);
        console.log(data[0].supplier_no);
        console.log(data[0].name);
        console.log(data[0].company_name);
        // console.log(data[0].code);
        console.log(data[0].address);
        console.log(data[0].contact_number);
        console.log(data[0].mail_id);


       $('.u_no').val(data[0].supplier_no);
       $('.supplierno').val("SUP00"+data[0].supplier_no);

       $('.suppliername').val(data[0].name) ;
        $('.companyname').val(data[0].company_name) ;
        $('.suppliercode').val(data[0].code) ;
         $('.address').val(data[0].address) ;
        $('.contactno').val(data[0].contact_number) ;
        $('.mailid').val(data[0].mail_id) ;



    },
    error: function(jqXHR, textStatus, errorThrown) {
        // handle error
    }
});

  });
});
</script>
