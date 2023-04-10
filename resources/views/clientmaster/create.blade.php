<div id="myModal1" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content ">
            <div class="modal-header bg-primary">
                <h4 class="modal-title ">Add Client</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="card-body ">
                    <form method="POST" class="form-row" id="myform" action="{{ route('clientmaster.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group col-md-6">
                            <label for="name" class="form-label fw-bold">Name</label>
                            <input type="text" name="name" id="name" value="{{old("name")}}" placeholder="Name" required class="form-control cname">
                            <span class='text-danger m-2' id="c1"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="company_name" class="form-label fw-bold">Company Name<a style="text-decoration: none;color:red">*</a></label>
                            <input type="text" name="company_name" id="company_name" value="{{old("company_name")}}" placeholder="Company Name" required class="form-control company">
                            <span class='text-danger m-2' id="c2"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="contact_number" class="form-label fw-bold">Contact Number<a style="text-decoration: none;color:red">*</a></label>
                            <input type="text"  name="contact_number" maxlength="10" id="contact_number" value="{{old("contact_number")}}" placeholder="Contact Number" required class="form-control contact">
                            <span class='text-danger m-2' id="c3"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="address" class="form-label fw-bold">Address<a style="text-decoration: none;color:red">*</a></label>
                            <input type="text" name="address" id="address" value="{{old("address")}}" placeholder="Address" required class="form-control caddress">
                            <span class='text-danger m-2' id="c4"></span>
                        </div>

                        <div class="form-group row ">
                            <div class="col-md-8">
                                <button type="submit" id="add_button" class="btn btn-primary ">{{ __('Add') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
