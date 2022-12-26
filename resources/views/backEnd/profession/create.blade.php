<div class="modal-content">            
    <div class="modal-header">
        <h5 class="modal-title" > {{ $title ?? "Create/Edit"}} </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div> 
    {!! Form::open(['url'=> $form_url, 'method' => 'post', 'files' => 'true','class'=>'ajax-form']) !!}
        <div class="modal-body">
            <div class="row">
                <!-- First Name -->
                <div class="col-12 col-sm-6 ">
                    <div class="form-group">
                        <label>Name <span class="text-danger">*</span> </label>
                        <input type="hidden" name="id" value="{{ isset($data->id) ? $data->id : 0 }}" >                                
                        <input type="text"  name="name" value="{{ $data->name ?? Null }}" class="form-control" required >
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <!-- Publication Status -->
                <div class="col-6 col-sm-6 ">
                    <div class="form-group">
                        <label>Publication Status <span class="text-danger">*</span></label>
                        <select name="publication_status" class="form-control" required >
                            <option value="">Select Publication Status</option>
                            <option value="1" {{ isset($data->id) && $data->publication_status ? 'selected' : Null }}>Published</option>
                            <option value="0" {{ isset($data->id) && !$data->publication_status ? 'selected' : Null }} >Unpublished</option>                           
                        </select>
                    </div>
                </div> 

                <div class="col-12 col-sm-12">
                    <div class="form-group">
                        <label>Description</label>                                
                        <textarea name="description" class="form-control" >{{ $data->description ?? null }}</textarea>
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