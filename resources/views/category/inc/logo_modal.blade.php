<!-- Modal -->
<div class="modal fade" id="logo_choosing_modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Logos</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <h5>Choose the logo you like: </h5>
                <hr>

                @foreach($logos as $logo)
                    <div name="logo_div" data-dismiss="modal" >
                        <div class="col-xs-4">
                            {{-- <p class="col-xs-10">{{$category->title}} &nbsp;&nbsp;</p> --}}
                            <span class="col-xs-12 {{$logo->class_name}}" style="font-size:30px"></span>
                            <input type='hidden' name='logo_id' value="{{$logo->id}}"/>
                        </div>
                    </div>
                @endforeach
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
            
        </div>
    </div>
</div>