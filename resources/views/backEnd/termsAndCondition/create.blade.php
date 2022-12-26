<div class="modal-content">            
    <div class="modal-header">
        <h5 class="modal-title" > {{ $title ?? "Create / Update" }} </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div> 
    {!! Form::open(['url'=> $form_url, 'method' => 'post', 'files' => 'true', 'class'=>'ajax-form']) !!}
        <div class="modal-body">
            <div class="row">
                <input type="hidden" name="id" value="{{ $data->id ?? 0 }}" >
                <!-- Type -->
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Type <span class="text-danger">*</span></label>
                        <select name="type" class="form-control" required >
                            <option value="">Select Type</option>
                            <!--@foreach ($page_type as $key => $type)
                            <option value="{{ $key }}" {{ isset($data->type) && $data->type == $key ? 'selected' : Null }} >{{ $type }}</option>
                            @endforeach -->
                            @foreach ($page_type as $type)
                            <option value="{{ $type }}" {{ isset($data->type) && $data->type == $type ? 'selected' : Null }} >{{ $type }}</option>
                            @endforeach
                        </select>     
                    </div>
                </div>
                <div class="col-12 ">
                    <div class="form-group">
                        <label>Page Content <span class="text-danger">*</span></label>
                        <textarea class="form-control editor {{ $errors->has('trems_and_condition') ? ' is-invalid' : '' }}" name="trems_and_condition" style="min-height: 300px;">{{ isset($data) ? $data->trems_and_condition : Null }}</textarea>
                        @if ($errors->has('trems_and_condition'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('trems_and_condition') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                

                <div class="col-12 col-sm-6 mb-2">
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