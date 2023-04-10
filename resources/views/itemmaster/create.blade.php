<div id="create" class="modal fade" role="dialog">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content ">
                                <div class="modal-header bg-primary">
                                    <h4 class="modal-title ">Add Item</h4>
                                    <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload();">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <div class="card-body ">
                                        <form method="POST" class="form-row" action="{{ route('itemmaster.store') }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group col-md-6">
                                                <label for="item_name" class="form-label fw-bold">Item Name<a style="text-decoration: none;color:red">*</a></label>
                                                <input type="text" name="item_name" id="item_name" value="{{old("item_name")}}" placeholder="Item Name" required class="form-control">
                                                <span class="text-danger" id="s1"></span>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="item_category" class="form-label fw-bold">Item category<a style="text-decoration: none;color:red">*</a></label>
                                                <div class="form-label">
                                                    <select id="item_category" name="item_category" type="text" required placeholder="Item Category" class="form-control">
                                                        <option value=''>Select option</option>
                                                        @foreach(trans('item_category') as $value => $label)
                                                            <option @if(old('item_category') == $value) selected @endif value="{{ $value }}">{{ $label }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <span class="text-danger" id="s2"></span>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="stock_type" class="form-label fw-bold">Stock Type<a style="text-decoration: none;color:red">*</a></label>
                                                <div class="form-label">
                                                    <select id="stock_type" name="stock_type" type="text"  required placeholder="Stock Type" class="form-control">
                                                    <option value=''>Select option</option>
                                                    @foreach(trans('stock_type') as $value => $label)
                                                            <option @if(old('stock_type') == $value) selected @endif value="{{ $value }}">{{ $label }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <span class="text-danger" id="s3"></span>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="item_type" class="form-label fw-bold">Item Type<a style="text-decoration: none;color:red">*</a></label>
                                                <div class="form-label">
                                                    <select id="item_type" name="item_type"  class="form-control"  required type="text" placeholder="Item Type">
                                                    <option value=''>Select option</option>
                                                    @foreach(trans('item_type') as $value => $label)
                                                            <option @if(old('item_type') == $value) selected @endif value="{{ $value }}">{{ $label }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <span class="text-danger" id="s4"></span>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="supplier_name" class="form-label fw-bold">Supplier Name<a style="text-decoration: none;color:red">*</a></label>
                                                <input type="text" name="supplier_name" id="supplier_name" required value="{{old("supplier_name")}}" placeholder="Supplier Name"
                                                class="form-control supplier_name ">
                                                <span class="text-danger" id="s5"></span>
                                            </div>
                                            <div class="form-group col-md-6 ">
                                                <label for="supplier_code" class="form-label fw-bold">Supplier Code<a style="text-decoration: none;color:red">*</a></label>
                                                <input type="text" name="supplier_code" id="supplier_code" value="{{old("supplier_code")}}" placeholder="Supplier Code" class="form-control" readonly>
                                                <span class="text-danger" id="s6"></span>

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
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"></link>
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
     $(document).ready(function() {
          $('#add_button').prop('disabled', true);
           var name_reg=/^[a-zA-Z ]+$/;
 $("#item_name").focusout(function(){

    if($(this).val()== ''){
    document.getElementById("s1").innerHTML="<span class='text-danger m-2'>This field is required</span>";
    $('#add_button').prop('disabled',true);
    }
 else if(name_reg.test($(this).val()) == true){
    document.getElementById("s1").innerHTML="";
    $('#add_button').prop('disabled',false);
        }
        else if(name_reg.test($(this).val()) == false){
            document.getElementById("s1").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
            $('#add_button').prop('disabled',true);
        }
 });
$("#item_category").focusout(function(){
    if($(this).val()== ''){
    document.getElementById("s2").innerHTML="<span class='text-danger m-2'>This field is required</span>";
    $('#add_button').prop('disabled',true);
    }
    else  if($(this).val() != ''){
        document.getElementById("s2").innerHTML="";
        $('#add_button').prop('disabled',false);
    }
          });
          $("#stock_type").focusout(function(){
    if($(this).val()== ''){
    document.getElementById("s3").innerHTML="<span class='text-danger m-2'>This field is required</span>";
    $('#add_button').prop('disabled',true);
}
    else  if($(this).val() != ''){
        document.getElementById("s3").innerHTML="";
        $('#add_button').prop('disabled',false);
    }
          });

          $("#item_type").focusout(function(){
    if($(this).val()== ''){
    document.getElementById("s4").innerHTML="<span class='text-danger m-2'>This field is required</span>";
    $('#add_button').prop('disabled',true);
    }
    else  if($(this).val() != ''){
        document.getElementById("s4").innerHTML="";
        $('#add_button').prop('disabled',false);
    }
          });
$("#supplier_name").focusout(function(){

    if($(this).val()== ''){
    document.getElementById("s5").innerHTML="<span class='text-danger m-2'>This field is required</span>";
    $('#add_button').prop('disabled',true);
    }
 else if(name_reg.test($(this).val()) == true){
    document.getElementById("s5").innerHTML="";
    $('#add_button').prop('disabled',false);
        }
        else if(name_reg.test($(this).val()) == false){
            document.getElementById("s5").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
            $('#add_button').prop('disabled',true);
        }
 });
 $("#supplier_code").focusout(function(){

if($(this).val()== ''){
document.getElementById("s6").innerHTML="<span class='text-danger m-2'>This field is required</span>";
$('#add_button').prop('disabled',false);
}
else if($(this).val()!= ''){
    document.getElementById("s6").innerHTML="";
        $('#add_button').prop('disabled',false);
    }
 });

        });
        </script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"></link>
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>

    function init(){
    var autoSuggestion = document.getElementsByClassName('ui-autocomplete');
    if(autoSuggestion.length > 0){
        autoSuggestion[0].style.zIndex = 1051;
    }
}

$("#edit").hide();
     dlgc = $("#create"); //modal
     supc = $("#supplier_name", dlgc); //

     $(".supplier_name").autocomplete(
      {

      source: function( request, response ) {
        $.ajax( {
        type:"GET",
          url: "{{ route('getData') }}",
          dataType: "json",
          data:{
            'name':$("#supplier_name").val()
          },
          success: function( data ) {

            result = [];
            for(var i in data)
            {
              result.push(data[i]["name"]);
            }
// alert($("#supplier_name").val());
             response(result);

          },fail: function(xhr, textStatus, errorThrown){
       alert(errorThrown);
    }
        } );
      },
      minLength:1,

      appendTo: "#create",
      open: function () {
        setTimeout(function () {
         $(this).css('zIndex', 2147483647);

    }, 0);
          autocomplete.zIndex(dlgc.zIndex()+1);
 	 }

    } );
    autocomplete = $("#supplier_name").autocomplete("widget").insertAfter(dlgc.parent());
$("#supplier_name").on('change',function(){
   var code= $(this).val();

   $.ajax( {
        type:"GET",
          url: "{{ route('getData') }}",
          dataType: "json",
          data:{
            'name':$(this).val()
          },
          success: function( data ) {
            console.log(data);
// alert(data);
alert(code);
            result = [];
            for(var i in data)
            {
              $('#supplier_code').val(data[i]["supplier_no"]);
            }
             console.log(result);
          },fail: function(xhr, textStatus, errorThrown){
       alert(errorThrown);
    }
        } );
});

 </script>
