
    <div class="modal fade" id="edit">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title" align="center"><b>Edit Item</b></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location.reload();">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <form method="POST" id="edit-form" class="form-row" action="{{ route('itemmaster.update',$item->id) }}"enctype="multipar/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group col-md-12">
                                    <label for="id"hidden class="form-label fw-bold">Item Id</label>
                                    <input type="text" name="id" id="update_id"   value="{{old('id',$item->id)}}" hidden  class="form-control update_id" >


                                </div>
                                <div class="form-group col-md-12">
                                    <label for="id" class="form-label fw-bold">Item Id</label>
                                    <input type="text" name="update_id" id="eid"   value="{{old('eid',$item->id)}}" placeholder="Item Id" class="form-control eid" readonly>


                                </div>

                                <div class="form-group col-md-6">
                                    <label for="item_name" class="form-label fw-bold">Item Name</label>
                                    <input type="text" name="item_name" id="eitem_name"  value="{{old('item_name',$item->item_name)}}"placeholder="Item Name" class="form-control eitem_name">
                                    <span class="text-danger" id="i0"></span>

                                </div>
                                <div class="form-group col-md-6">
                                    <label for="item_category" class="form-label fw-bold" >Item Category</label>
                                    <div class="form-label">
                                        <select id="eitem_category" name="item_category"  class="form-control eitem_category"type="text" placeholder="Item Category">
                                        <option value=''>Select option</option>
                                            @foreach(trans('item_category') as $value => $label)
                                                <option @if(($item->item_category ?? old('item_category')) == $value) selected @endif value="{{ $value }}">{{$label}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span class="text-danger" id="i1"></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="stock_type" class="form-label fw-bold" >Stock Type</label>
                                    <div class="form-label">
                                        <select id="estock_type" name="stock_type"  class="form-control estock_type" type="text" placeholder="Stock Type">
                                        <option value=''>Select option</option>
                                            @foreach(trans('stock_type') as $value => $label)
                                                <option @if(($item->stock_type ?? old('stock_type')) == $value) selected @endif value="{{ $value }}">{{$label}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span class="text-danger" id="i2"></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="item_type" class="form-label fw-bold" >Item Type</label>
                                        <div class="form-label">
                                            <select id="eitem_type" name="item_type"  class="form-control eitem_type" type="text" placeholder="Item Type">
                                            <option value=''>Select option</option>
                                                @foreach(trans('item_type') as $value => $label)
                                                    <option @if(($item->item_type ?? old('item_type')) == $value) selected @endif value="{{ $value }}">{{$label}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <span class="text-danger" id="i3"></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="supplier_name" class="form-label fw-bold">Supplier Name</label>
                                    <input type="text" name="supplier_name" id="esupplier_name" value="{{old('supplier_name',$item->supplier_name)}}" placeholder="supplier_name" class="form-control esupplier_name">
                                    <span class="text-danger" id="i4"></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="supplier_code" class="form-label fw-bold">Supplier code</label>
                                    <input type="text" name="supplier_code" id="esupplier_code" readonly value="{{old('supplier_code',$item->supplier_code)}}" placeholder="supplier_code" class="form-control esupplier_code">
                                    <span class="text-danger" id="i5"></span>
                                </div>
                                <div class="form-group row ">
                                    <div class="col-md-8">
                                        <button type="submit" id="edit_button" class="btn btn-primary ">
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
    $(document).on("click",".edit", function(){
//    alert ($(this).attr("id"));
   $.ajax({
    url: "{{ route('edit_data') }}",
    type: "GET", // or "GET", "PUT", etc.
    data: {
        'id':$(this).attr("id")
    },
    dataType: "json", // the type of data you're expecting in response
    success: function(data) {
        // the data argument contains the response from the server
        // console.log(data[0].id);

       $('#eid').val("IM00"+data[0].id);
       $('.eitem_name').val(data[0].item_name);

       $('#update_id').val(data[0].id);
       $('.eitem_category').val(data[0].item_category) ;
        $('.estock_type').val(data[0].stock_type) ;
        $('.eitem_type').val(data[0].item_type) ;
         $('.esupplier_name').val(data[0].supplier_name) ;
        $('.esupplier_code').val(data[0].supplier_code) ;



    },
    error: function(jqXHR, textStatus, errorThrown) {
        // handle error
    }
});

  });

        //   $('#edit_button').prop('disabled', true);
           var name_reg=/^[a-zA-Z ]+$/;
 $("#eitem_name").focusout(function(){
// alert($(this).val());
    if($(this).val()== ''){
    document.getElementById("i0").innerHTML="<span class='text-danger m-2'>This field is required</span>";
     $('#edit_button').prop('disabled',true);
    }
    else if(name_reg.test($(this).val()) == true){
    document.getElementById("i0").innerHTML="";
     $('#edit_button').prop('disabled',false);
        }
        else if(name_reg.test($(this).val()) == false ){
            document.getElementById("i0").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
             $('#edit_button').prop('disabled',true);
        }
 });
 $("#eitem_category").focusout(function(){
    if($(this).val()== ''){
    document.getElementById("i1").innerHTML="<span class='text-danger m-2'>This field is required</span>";
     $('#edit_button').prop('disabled',true);
    }
    else  if($(this).val() != ''){
        document.getElementById("i1").innerHTML="";
         $('#edit_button').prop('disabled',false);
    }
          });
 $(".estock_type").focusout(function(){
    if($(this).val()== ''){
    document.getElementById("i2").innerHTML="<span class='text-danger m-2'>This field is required</span>";
     $('#edit_button').prop('disabled',true);
}
    else  if($(this).val() != ''){
        document.getElementById("i2").innerHTML="";
         $('#edit_button').prop('disabled',false);
    }
          });
$(".eitem_type").focusout(function(){
    if($(this).val()== ''){
    document.getElementById("i3").innerHTML="<span class='text-danger m-2'>This field is required</span>";
     $('#edit_button').prop('disabled',true);
    }
    else  if($(this).val() != ''){
        document.getElementById("i3").innerHTML="";
        $('#edit_button').prop('disabled',false);
    }
          });
 $(".esupplier_name").focusout(function(){

if($(this).val()== ''){
document.getElementById("i4").innerHTML="<span class='text-danger m-2'>This field is required</span>";
 $('#edit_button').prop('disabled',true);
}
else if(name_reg.test($(this).val()) == true){
document.getElementById("i4").innerHTML="";
 $('#edit_button').prop('disabled',false);
    }
    else if(name_reg.test($(this).val()) == false){
        document.getElementById("i4").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
     $('#add_button').prop('disabled',true);
    }
});
$(".esupplier_name").change(function(){

if($(".esupplier_code").val()== '' ){
document.getElementById("i5").innerHTML="<span class='text-danger m-2'>This field is required</span>";
 $('#edit_button').prop('disabled',true);
}
else if($(".esupplier_code").val()!= '' ){
    document.getElementById("i5").innerHTML="";
         $('#edit_button').prop('disabled',false);
    }
 });
 });

</script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"></link>
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
    $("#create").hide();
        var autocomplete,
      dlg1 = $("#edit");
     sup1 = $(".esupplier_name", dlg1);

     $("#esupplier_name").autocomplete(
      {

      source: function( request, response ) {
        $.ajax( {
        type:"GET",
          url: "{{ route('getData') }}",
          dataType: "json",
          data:{
            'name':$(".esupplier_name").val()
          },
          success: function( data ) {
             console.log(data);
if(data == ""){
    $('.esupplier_code').val("");
}
    else{
            result = [];
            for(var i in data)
            {
               result.push(data[i]["name"]);
               console.log(result);
            }
            response(result);
    }
          },fail: function(xhr, textStatus, errorThrown){
       alert(errorThrown);
    }
        } );

      },
      minLength:1,

     appendTo: "#edit",
     open: function () {
        setTimeout(function () {
         $(this).css('zIndex', 10000);

    }, 1);
          autoComplete.zIndex(dlg1.zIndex()+1);
 	 }

    } );
     autoComplete = $("#esupplier_name").autocomplete("widget");
 autoComplete.insertAfter(dlg1.parent());



$(".esupplier_name").on('change',function(){
   var code= $(this).val();
    if(code ==""){
        $('.esupplier_code').val("");
    }
    else{
   $.ajax( {
        type:"GET",
          url: "{{ route('getData') }}",
          dataType: "json",
          data:{
            'name':$(this).val()
          },
          success: function( data ) {

            result = [];
            for(var i in data)
            {
             result.push(data[i]["name"]);
              $('.esupplier_code').val(data[i]["supplier_no"]);
            }
          },fail: function(xhr, textStatus, errorThrown){
       alert(errorThrown);
    }
        } );
    }
});
 </script>
