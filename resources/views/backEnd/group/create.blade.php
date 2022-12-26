<div class="modal-content">            
    <div class="modal-header">
        <h5 class="modal-title" > {{ $title }} </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div> 
    {!! Form::open(['url'=> $form_url, 'method' => 'post', 'files' => 'true', 'class'=>'ajax-form']) !!}
        <div class="modal-body">
            <div class="row">
                <input type="hidden" name="id" value="{{ $data->id ?? 0 }}" >

                <!-- name -->
                <div class="col-12 col-sm-12">
                    <div class="form-group">
                        <label>Group Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{ $data->name ?? Null }}" class="form-control" required >
                    </div>
                </div>

                <!-- name -->
                
               @if(Auth::user()->group->is_admin)
                <div class="col-12 col-sm-12">
                    <div class="form-group">
                        <label>Access Level</label>
                        <select name="is_admin" class="form-control">
                            <option>Select Access Type</option>
                            <option value="1" {{ isset($data->is_admin) && $data->is_admin ? "selected" : Null }} >Admin</option>
                            <option value="0" {{ isset($data->is_admin) && !$data->is_admin ? "selected" : Null }} >Others</option>
                        </select>
                    </div>
                </div>
                @endif
                <!-- Description -->
                <div class="col-12">
                    <div class="form-group">
                        <label>Description </label>
                        <textarea class="form-control editor" name="description" >{{ isset($data->id) ? $data->description : Null }}</textarea>
                    </div>
                </div>
            </div>            
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-danger float-left" data-dismiss="modal">Close</button>
                <button type="submit" name="btn" class="btn btn-sm btn-primary"> Save </button>
            </div>
        </div>
    {!! Form::close() !!}
</div>
<script>
    ClassicEditor.create( document.querySelector( '.editor' ) );    
</script>