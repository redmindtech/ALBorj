@foreach ($datas as $value)
<div id="editModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-xl">
            <div class="modal-content ">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title"><b>Edit SiteMaster</b></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <form method="POST" id="editform" class="form-row" action="{{ route('sitemaster.update',$value->site_no) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group col-md-12">
                                    <label for="site_name" hidden  class="form-label fw-bold">Site Name<a style="text-decoration: none;color:red">*</a></label>
                                    <input type="text" hidden name="site_no" value="{{old('site_no',$value->site_no)}}" placeholder="site Name" class="form-control esite_no" id="esite_no">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="site_name"   class="form-label fw-bold">Site Name<a style="text-decoration: none;color:red">*</a></label>
                                    <input type="text"  readonly  value="{{old('site_no',$value->site_no)}}" placeholder="site Name" class="form-control update_esite_no" id="update_esite_no">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="site_name" class="form-label fw-bold">Site Name<a style="text-decoration: none;color:red">*</a></label>
                                    <input type="text" name="site_name" value="{{old('site_name',$value->site_name)}}" placeholder="site Name" class="form-control esite_name" id="esite_name">
                                    <span class="text-danger" id="esn"></span>
                                </div>
                                <div class="form-group col-md-6">
                                        <label class="form-label fw-bold" for="site_location">Location<a style="text-decoration: none;color:red">*</a></label>
                                            <div class="form-label">
                                                <select id="esite_location" name="site_location"  class="form-control esite_location" type="text" placeholder="Category">
                                                @foreach(trans('site_location') as $key => $label)
                                                <option @if(($value->site_location ?? old('site_location')) == $key) selected @endif value="{{ $key}}">{{$label}}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                            <span class="text-danger" id="esl"></span>
                                    </div>
                                <div class="form-group col-md-6">
                                    <label for="site_building" class="form-label fw-bold">Site Building<a style="text-decoration: none;color:red">*</a></label>
                                    <input type="text" id="esite_building "name="site_building" value="{{old('site_building',$value->site_building)}}" placeholder="Site Building" class="form-control esite_building">
                                    <span class="text-danger" id="esb"></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="site_floor" class="form-label fw-bold">Site Floor<a style="text-decoration: none;color:red">*</a></label>
                                    <input type="text" id="esite_floor" name="site_floor" value="{{old('site_floor',$value->site_floor)}}" placeholder="Site Floor" class="form-control esite_floor">
                                    <span class="text-danger" id="esf"></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="room_number" class="form-label fw-bold">Room Number<a style="text-decoration: none;color:red">*</a></label>
                                    <input type="text" id="eroom_number" name="room_number" value="{{old('room_number',$value->room_number)}}" placeholder="Name" class="form-control eroom_number">
                                    <span class="text-danger" id="esrn"></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="site_address" class="form-label fw-bold">Address<a style="text-decoration: none;color:red">*</a></label>
                                    <input type="text" id="esite_address" name="site_address" value="{{old('site_address',$value->site_address)}}" placeholder="Address" class="form-control esite_address">
                                    <span class="text-danger" id="esa"></span>
                                </div>
                                <div class="form-group col-md-6">
                                        <label class="form-label fw-bold" for="status">Status</label>
                                            <div class="form-label">
                                                <select id="esite_status" name="site_status"  class="form-control esite_status" type="text" placeholder="Category">
                                                @foreach(trans('site_status') as $key => $label)
                                                <option @if(($value->site_status ?? old('site_status')) == $key) selected @endif value="{{ $key}}">{{$label}}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                    </div>
                                <div class="form-group col-md-6">
                                    <label for="site_manager" class="form-label fw-bold">Site Manager<a style="text-decoration: none;color:red">*</a></label>
                                    <input type="text" id="esite_manager" name="site_manager" value="{{old('site_manager',$value->site_manager)}}" placeholder="Site Manager" class="form-control esite_manager">
                                    <span class="text-danger" id="esm"></span>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="description" class="form-label fw-bold">Description</label>
                                    <textarea name="description" id="edescription" value="{{old('description',$value->description)}}" placeholder="Description" rows="3" class="form-control edescription">{{$value->description}}</textarea>

                                </div>
                                <div class="form-group row ">
                                    <div class="col-md-8">
                                        <button type="submit" class="btn btn-primary update">
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
@endforeach
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
$(document).ready(function(){
    $(document).on("click",".edit", function(){
//    alert ($(this).attr("id"));
   $.ajax({
    url: "{{ route('data_edit') }}",
    type: "GET", // or "GET", "PUT", etc.
    data: {
        'id':$(this).attr("id")
    },
    dataType: "json", // the type of data you're expecting in response
    success: function(data) {
        console.log(data);

        $('#esite_no').val(data[0].site_no);
        $('#update_esite_no').val(data[0].site_no);
       $('#esite_name').val(data[0].site_name);
       $('.esite_location').val(data[0].site_location);
       $('#esite_building').val(data[0].site_building);
       $('.esite_floor').val(data[0].site_floor) ;
        $('.eroom_number').val(data[0].room_number) ;
        $('.esite_address').val(data[0].site_address) ;
         $('.esite_status').val(data[0].site_status) ;
        $('.esite_manager').val(data[0].site_manager) ;
        $('.edescription').val(data[0].description) ;


    },
    error: function(jqXHR, textStatus, errorThrown) {
        // handle error
    }
});
  });


          $('.update').prop('disabled', true);
           var name_reg=/^[a-zA-Z ]+$/;
 $(".esite_name").focusout(function(){

    if($(this).val()== ''){
    document.getElementById("esn").innerHTML="<span class='text-danger m-2'>This field is required</span>";
    $('.update').prop('disabled',true);
    }
 else if(name_reg.test($(this).val()) == true){
    document.getElementById("esn").innerHTML="";
    $('.update').prop('disabled',false);
        }
        else if(name_reg.test($(this).val()) == false){
            document.getElementById("esn").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
            $('.update').prop('disabled',true);
        }
 });
$(".esite_location").focusout(function(){
    if($(this).val()== ''){
    document.getElementById("esl").innerHTML="<span class='text-danger m-2'>This field is required</span>";
    $('.update').prop('disabled',true);
    }
    else  if($(this).val() != ''){
        document.getElementById("esl").innerHTML="";
        $('.update').prop('disabled',false);
    }
          });
$(".esite_building").focusout(function(){
    if($(this).val()== ''){
    document.getElementById("esb").innerHTML="<span class='text-danger m-2'>This field is required</span>";
    $('.update').prop('disabled',true);
}
    else  if($(this).val() != ''){
        document.getElementById("esb").innerHTML="";
        $('.update').prop('disabled',false);
    }
          });

$(".esite_floor").focusout(function(){
    if($(this).val()== ''){
    document.getElementById("esf").innerHTML="<span class='text-danger m-2'>This field is required</span>";
    $('.update').prop('disabled',true);
    }
    else  if($(this).val() != ''){
        document.getElementById("esf").innerHTML="";
        $('.update').prop('disabled',false);
    }
          });
$(".eroom_number").focusout(function(){
    if($(this).val()== ''){
    document.getElementById("esrn").innerHTML="<span class='text-danger m-2'>This field is required</span>";
    $('.update').prop('disabled',true);
    }
    else  if($(this).val() != ''){
        document.getElementById("esrn").innerHTML="";
        $('.update').prop('disabled',false);
    }
          });
$(".esite_address").focusout(function(){
    if($(this).val()== ''){
    document.getElementById("esa").innerHTML="<span class='text-danger m-2'>This field is required</span>";
    $('.update').prop('disabled',true);
    }
    else  if($(this).val() != ''){
        document.getElementById("esa").innerHTML="";
        $('.update').prop('disabled',false);
    }
          });
$(".esite_manager").focusout(function(){

    if($(this).val()== ''){
    document.getElementById("esm").innerHTML="<span class='text-danger m-2'>This field is required</span>";
    $('.update').prop('disabled',true);
    }
 else if(name_reg.test($(this).val()) == true){
    document.getElementById("esm").innerHTML="";
    $('.update').prop('disabled',false);
        }
        else if(name_reg.test($(this).val()) == false){
            document.getElementById("sm").innerHTML="<span class='text-danger m-2'>Please enter the valid data</span>";
            $('.update').prop('disabled',true);
        }
 });
});
 </script>


<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"></link>
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <script>
     var autocomplete,
     dlg = $("#myModal1");
     site = $("#esite_manager", dlg);

     $("#esite_manager").autocomplete(
      {

      source: function( request, response ) {
        $.ajax( {
        type:"GET",
          url: "{{ route('sitegetData') }}",
          dataType: "json",
          data:{
            'firstname':$("#esite_manager").val()
          },
          success: function( data ) {
            console.log(data);

            result = [];
            for(var i in data)
            {
              //console.log(data[i]["firstname"]);
              result.push(data[i]["firstname"]);
            }

             console.log(result);
             response(result);
          },fail: function(xhr, textStatus, errorThrown){
       alert(errorThrown);
    }
        } );
      },
      minLength:1,

     appendTo: "myModal1",
     open: function () {
        setTimeout(function () {
         $(this).css('zIndex', 10000);
        // $(this.domElement.style.zIndex, 9999) + 1;
    }, 1);
          autoComplete.zIndex(dlg.zIndex()+1);
 	 }

    } );
    autoComplete = $("#esite_manager").autocomplete("widget");
    // move the autocomplete element after the dialog in the DOM
 autoComplete.insertAfter(dlg.parent());
// });
 </script>
