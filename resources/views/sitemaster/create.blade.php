
<div id="myModal1" class="modal fade myModal1" role="dialog">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content ">
                        <div class="modal-header bg-primary">
                            <h4 class="modal-title ">
                            Add SiteMaster</h4>
                            <button type="button" class="close" data-dismiss="modal" href="{{ route('sitemaster.create')}}">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="card-body ">
  <form enctype="multipart/form-data" class="form-row" method="POST"  action="{{ route('sitemaster.store')}}" >
                            @csrf
                            <div class="form-group col-md-6">
                                        <label for="site_name" class="form-label fw-bold">Site Name<a style="text-decoration: none;color:red">*</a></label>
                                        <input type="text" name="site_name" value="{{old('site_name')}}" placeholder="Site Name" class="form-control sname">
                                        <span class="text-danger" id="sn"></span>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label fw-bold" for="site_location">Location<a style="text-decoration: none;color:red">*</a></label>
                                            <div class="form-label">
                                                <select id="site_location" name="site_location"  class="form-control slocation" type="text">
                                                    <option value=''>Select option</option>
                                                @foreach(trans('site_location') as $key => $label)
                                                <option @if(old('site_location') == $key) selected @endif value="{{ $key }}">{{ $label }}</option>
                                                 @endforeach
                                                </select>
                                            </div>
                                            <span class="text-danger" id="sl"></span>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for='site_building' class="form-label fw-bold">Site Building<a style="text-decoration: none;color:red">*</a></label>
                                        <input type="text" name='site_building' value="{{old('site_building')}}" placeholder="Site Building" class="form-control sbuilding">
                                        <span class="text-danger" id="sb"></span>
                                    </div>
                                    <div class="form-group col-md-6 ">
                                        <label for="site_floor" class="form-label fw-bold">Site Floor<a style="text-decoration: none;color:red">*</a></label>
                                        <input type="text" name="site_floor" value="{{old('site_floor')}}" placeholder="site floor" class="form-control sfloor">
                                        <span class="text-danger" id="sf"></span>
                                    </div>
                                    <div class="form-group col-md-6 ">
                                        <label for="room_number" class="form-label fw-bold">Room Number<a style="text-decoration: none;color:red">*</a></label>
                                        <input type="text" name="room_number" value="{{old('room_number')}}" placeholder="Room Number" class="form-control srnumber">
                                        <span class="text-danger" id="srn"></span>
                                    </div>
                                    <div class="form-group col-md-6 ">
                                        <label for="site_address" class="form-label fw-bold">Site Address<a style="text-decoration: none;color:red">*</a></label>
                                        <input type="text" name="site_address" value="{{old('site_address')}}" placeholder="Site Address" class="form-control saddress">
                                        <span class="text-danger" id="sa"></span>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label fw-bold" for="status">Status</label>
                                            <div class="form-label">
                                                <select id="status" name="site_status"  class="form-control" type="text" placeholder="status">
                                                @foreach(trans('site_status') as $key => $label)
                                                <option @if(old('site_status') == $key) selected @endif value="{{ $key }}">{{ $label }}</option>
                                                 @endforeach
                                                </select>
                                            </div>
                                    </div>

                                    <div class="form-group col-md-6 ">
                                        <label for="site_manager" class="form-label fw-bold">Site Manager<a style="text-decoration: none;color:red">*</a></label>
                                         <input id="site_manager" name="site_manager" value="{{old('site_manager')}}" class="form-control sitemanager">
                                         <span class="text-danger" id="sm"></span>
                                    </div>

                                       <div class="form-group col-md-12">
                                        <label for="description" class="form-label fw-bold">Description</label>
                                        <textarea name="description" value="{{old('description')}}" placeholder="Description" rows="3" class="form-control"></textarea>
                                        <!-- <input type="text" name="description" value="{{old('description')}}" placeholder="Description" class="form-control"> -->
                                    </div>
                                    <div class="form-group row ">
                                        <div class="col-md-8">
                                            <button type="submit" class="btn btn-primary add">
                                                {{ __('Add') }}
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
    </div>



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

$(".edit").hide();
     dlgc = $("#myModal1");
     site = $("#site_manager", dlgc);

     $("#site_manager").autocomplete(
      {

      source: function( request, response ) {
        $.ajax( {
        type:"GET",
          url: "{{ route('sitegetData') }}",
          dataType: "json",
          data:{
            'firstname':$("#site_manager").val()
          },
          success: function( data ) {

            result = [];
            for(var i in data)
            {
              result.push(data[i]["firstname"]);
            }

             response(result);
          },fail: function(xhr, textStatus, errorThrown){
       alert(errorThrown);
    }
        } );
      },
      minLength:1,

      appendTo: "#myModal1",
      open: function () {
        setTimeout(function () {
         $(this).css('zIndex', 2147483647);

    }, 0);
          autocomplete.zIndex(dlgc.zIndex()+1);
 	 }

    } );
    autocomplete = $("#site_manager").autocomplete("widget").insertAfter(dlgc.parent());
    // move the autocomplete element after the dialog in the DOM

 </script>


  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"></link>
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
     $(document).ready(function() {
          $('.add').prop('disabled', true);
           var name_reg=/^[a-zA-Z ]+$/;
 $(".sname").focusout(function(){

    if($(this).val()== ''){
    document.getElementById("sn").innerHTML="<span class='text-danger m-2'>This field is required</span>";
    $('.add').prop('disabled',true);
    }
 else if(name_reg.test($(this).val()) == true){
    document.getElementById("sn").innerHTML="";
    $('.add').prop('disabled',false);
        }
        else if(name_reg.test($(this).val()) == false){
            document.getElementById("sn").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
            $('.add').prop('disabled',true);
        }
 });
$(".slocation").focusout(function(){
    if($(this).val()== ''){
    document.getElementById("sl").innerHTML="<span class='text-danger m-2'>This field is required</span>";
    $('.add').prop('disabled',true);
    }
    else  if($(this).val() != ''){
        document.getElementById("sl").innerHTML="";
        $('.add').prop('disabled',false);
    }
          });
$(".sbuilding").focusout(function(){
    if($(this).val()== ''){
    document.getElementById("sb").innerHTML="<span class='text-danger m-2'>This field is required</span>";
    $('.add').prop('disabled',true);
}
    else  if($(this).val() != ''){
        document.getElementById("sb").innerHTML="";
        $('.add').prop('disabled',false);
    }
          });

$(".sfloor").focusout(function(){
    if($(this).val()== ''){
    document.getElementById("sf").innerHTML="<span class='text-danger m-2'>This field is required</span>";
    $('.add').prop('disabled',true);
    }
    else  if($(this).val() != ''){
        document.getElementById("sf").innerHTML="";
        $('.add').prop('disabled',false);
    }
          });
$(".srnumber").focusout(function(){
    if($(this).val()== ''){
    document.getElementById("srn").innerHTML="<span class='text-danger m-2'>This field is required</span>";
    $('.add').prop('disabled',true);
    }
    else  if($(this).val() != ''){
        document.getElementById("srn").innerHTML="";
        $('.add').prop('disabled',false);
    }
          });
$(".saddress").focusout(function(){
    if($(this).val()== ''){
    document.getElementById("sa").innerHTML="<span class='text-danger m-2'>This field is required</span>";
    $('.add').prop('disabled',true);
    }
    else  if($(this).val() != ''){
        document.getElementById("sa").innerHTML="";
        $('.add').prop('disabled',false);
    }
          });
$(".sitemanager").focusout(function(){

    if($(this).val()== ''){
    document.getElementById("sm").innerHTML="<span class='text-danger m-2'>This field is required</span>";
    $('.add').prop('disabled',true);
    }
 else if(name_reg.test($(this).val()) == true){
    document.getElementById("sm").innerHTML="";
    $('.add').prop('disabled',false);
        }
        else if(name_reg.test($(this).val()) == false){
            document.getElementById("sm").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
            $('.add').prop('disabled',true);
        }
 });

         });
        </script>
