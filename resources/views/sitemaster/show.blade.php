@foreach ($datas as $value)

<div id="view_{{$value->site_no}}" class="modal fade" role="dialog">
        <div class="modal-dialog modal-xl">
            <div class="modal-content ">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title"><b>Show Site</b></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>
<div class="modal-body">
                        <div class="card-body ">
                                                <table class="table table-bordered table-striped">
                                                    <tr><th>Site Number</th><td>{{"SM00".$value->site_no}}</td></tr>
                                                    <tr><th>Site Name</th><td>{{$value->site_name}}</td></tr>
                                                    <tr><th>Location</th><td>{{$value->site_location}}</td></tr>
                                                    <tr><th>Site Building</th><td>{{$value->site_building}}</td></tr>
                                                    <tr><th>Floor</th><td>{{$value->site_floor}}</td></tr>
                                                    <tr><th>Room Number</th><td>{{$value->room_number}}</td></tr>
                                                    <tr><th>Site Manager</th><td>{{$value->site_manager}}</td></tr>
                                                    <tr><th>Status</th><td>{{$value->site_status}}</td></tr>
                                                    <tr><th>Address</th><td>{{$value->site_address}}</td></tr>
                                                    <tr><th>Description</th><td>{{$value->description}}</td></tr>
                                                </table>











                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    @endforeach
