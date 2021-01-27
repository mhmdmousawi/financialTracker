<!-- Modal -->
<div class="modal fade" id="category_choosing_modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Categories</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <h5>Choose your category: </h5>
                <hr>

                @foreach($user->profile->categories as $category)
                    @if($category->type == "saving")
                        <div name="category_div" data-dismiss="modal" data-category-type = "saving">
                            <div class="col-xs-4">
                                <p class="col-xs-10">{{$category->title}} &nbsp;&nbsp;</p>
                                <span class="col-xs-2 {{$category->logo->class_name}}" style="font-size:30px"></span>
                                <input type='hidden' name='category_id' value="{{$category->id}}"/>
                            </div>
                        </div>
                    @endif
                @endforeach
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
            
        </div>
    </div>
</div>