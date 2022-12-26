<div class="modal-content">            
    <div class="modal-header">
        <h5 class="modal-title" > {{ $title ?? "Add / Update" }} </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div> 
    {!! Form::open(['url'=> $form_url, 'method' => 'post', 'files' => 'true', 'class'=>'ajax-form']) !!}
        <div class="modal-body">
            <div class="row">
                <input type="hidden" name="id" value="{{ $data->id ?? 0 }}" >
                
                <!-- title -->
                <div class="col-12">
                    <div class="form-group">
                        <label>Select Page <span class="text-danger">*</span></label>
                        <select name="page_name" class="form-control select2" required >
                            <option value="">Select Page</option>
                            @foreach($pages as $key => $name)
                            <option value="{{ $key }}" {{ isset($data->page_name) && $data->page_name == $key ? "selected" : null }} > {{ $name }} </option>
                            @endforeach
                        </select>
                    </div>
                </div>                

                <!-- Text -->
                <div class="col-12 col-sm-12">
                    <div class="form-group">
                        <label>Text <span class="text-danger">*</span></label>
                        <textarea name="heading_text" class="form-control editor" >{{ $data->heading_text ?? Null }}</textarea>
                    </div>
                </div>
                
                <!-- Image -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-group"> 
                        <label>Cover Image <span class="text-danger"> </label><br>
                        <input type="file" name="cover_image" accept="image/png,image/jpeg" >
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