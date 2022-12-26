<div class="modal-content">            
    <div class="modal-header">
        <h5 class="modal-title" > {{ $title ?? "Create/Edit"}} </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div> 
    {!! Form::open(['url'=> $form_url, 'method' => 'post', 'files' => 'true','class'=>'ajax-form']) !!}
        <input type="hidden" name="id" value="{{ $data->id ?? 0 }}">
        <div class="modal-body">
            <div class="row">
                <div class="col-12 col-sm-6 col-md-4 ">
                    <div class="form-group">
                        <label>Page Selection</label>
                       <select class="form-control select2" name="page">
                            <option value="">Select Page</option>
                            <option value="home" {{ isset($data->page) && $data->page == "home" ? "selected" : null }}>Home Page</option>
                            <option value="signup" {{ isset($data->page) && $data->page == "signup" ? "selected" : null }}>Signup Page</option>
                            <option value="search" {{ isset($data->page) && $data->page == "search" ? "selected" : null }}>Search Page</option>
                            <option value="contact" {{ isset($data->page) && $data->page == "contact" ? "selected" : null }}>Contact Page</option>
                       </select>
                    </div>
                </div>               
                

                <!-- Publication Status -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control" required >
                            <option>Select Status</option>
                            <option value="1" {{ isset($data->id) && $data->status ? 'selected' : Null }}>Active</option>
                            <option value="0" {{ isset($data->id) && !$data->status ? 'selected' : Null }} >Inactive</option>                           
                        </select>
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