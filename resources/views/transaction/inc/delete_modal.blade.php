<div class="modal fade" id="delete_modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">SURE!!?</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <h5>Are you sure you want to delete this transaction?</h5>
            </div>
            <div class="modal-footer">
                <form action="{{config('app.url')}}/delete/transaction" method="POST">
                    @csrf
                    <input type = "hidden" name='id' value = "{{$transaction->id}}"/>
                    <button type="submit" class="btn btn-default" id="btn_delete" >Delete</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </form>
            </div>
            
        </div>
    </div>
</div>