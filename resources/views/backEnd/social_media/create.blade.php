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
                        <label>Name <span class="text-danger">*</span> </label>   
                        <input type="text" name="name" class="form-control" value="{{ old("name") ?? ($data->name ?? "") }}" required >
                    </div>
                </div>
                
                <div class="col-12 col-sm-6 col-md-4 ">
                    <div class="form-group">
                        <label>Icon <span class="text-danger">*</span></label>   
                        <input type="text" name="icon" class="form-control" value="{{ old("icon") ?? ($data->icon ?? "") }}" required >
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-4 ">
                    <div class="form-group">
                        <label>Link <span class="text-danger">*</span></label>   
                        <input type="text" name="link" class="form-control" value="{{ old("link") ?? ($data->link ?? "") }}" required >
                    </div>
                </div>

                <!-- Publication Status -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>Publication Status <span class="text-danger">*</span></label>
                        <select name="publication_status" class="form-control" required >
                            <option>Select Publication Status</option>
                            <option value="1" {{ isset($data->id) && $data->publication_status ? 'selected' : Null }}>Published</option>
                            <option value="0" {{ isset($data->id) && !$data->publication_status ? 'selected' : Null }} >Unpublished</option>                           
                        </select>
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