<div class="modal-content">            
    <div class="modal-header">
        <h5 class="modal-title" > {{ isset($data->id) ? 'Edit Advisor Blog' : 'Add Advisor Blog' }} </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div> 
    {!! Form::open(['url'=> $form_url, 'method' => 'post', 'files' => 'true', 'class'=>'ajax-form']) !!}
        <div class="modal-body">
            <div class="row">
                <input type="hidden" name="id" value="{{ $data->id ?? 0 }}" >
                
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>Select Author <span class="text-danger">*</span> </label>
                        <select class="form-control select2" name="admin_id">
                            <option value="">Select Author</option>
                            @foreach($admins as $admin)
                            <option value="{{ $admin->id }}" {{ isset($data->admin_id) && $admin->id == $data->admin_id ? "selected" : null }}>{{ $admin->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>               

                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>Read Time <span class="text-danger">*</span> (Minute)</label>
                        <input type="number" min="0" name="read_time" value="{{  $data->read_time ?? null }}" class="form-control" required >
                    </div>
                </div> 

                <!-- Status -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>Status <span class="text-danger">*</span></label>
                        <select name="publication_status" class="form-control" required >
                            <option value="">Status</option>
                            <option value="1" {{ isset($data->publication_status) && $data->publication_status == "1" ? 'selected' : Null }} >Published</option>
                            <option value="0" {{ isset($data->publication_status) && $data->publication_status == "0" ? 'selected' : Null }} >Unpublished</option>
                        </select>     
                    </div>
                </div>  

                <!-- title -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" value="{{  $data->title ?? Null }}" class="form-control" required >
                    </div>
                </div> 

                <!-- Image -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-group"> 
                        <label>Image <span class="text-danger"> {{ isset($data->id) ? Null : '*' }} </span> </label><br>
                        <input type="file" name="image" accept="image/png,image/jpeg" {{ isset($data->id) ? Null : 'required' }} >
                    </div>
                </div>                 
                
                <!-- Description -->
                <div class="col-12">
                    <div class="form-group">
                        <label>Description </label>
                        <textarea class="form-control editor" name="description" >{{ $data->description ?? Null }}</textarea>
                    </div>
                </div>
                
                <!-- SEO Tag -->
                <div class="col-12 col-sm-12 col-md-6">
                    <div class="form-group">
                        <label>Meta Tag </label>
                        <input type="text"  name="meta_tag" value="{{ $data->meta_tag ?? Null }}" class="form-control" >
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-6">
                    <div class="form-group">
                        <label>Meta Description </label>
                        <input type="text" name="meta_description" value="{{ $data->meta_description ?? Null }}" class="form-control" >
                    </div>
                </div> 
                
                

                <div class="col-12 col-sm-6">
                    <label>Uploading</label>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"> 0% </div>
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