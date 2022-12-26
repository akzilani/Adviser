<div class="modal-content">            
    <div class="modal-header">
        <h5 class="modal-title" > {{ $title ?? "Add / Update"}} </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div> 
    {!! Form::open(['url'=> $form_url, 'method' => 'post', 'files' => 'true', 'class'=>'ajax-form']) !!}
        <div class="modal-body">
            <div class="row">
                <input type="hidden" name="id" value="{{ $data->id ?? 0 }}" >
                
                <!-- Advisor -->
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Select Advisor<span class="text-danger">*</span></label>
                        <select name="advisor_id" class="select2 form-control" required >
                            <option value="">Select Advisor</option>
                            @foreach($advisors as $advisor)
                                <option value="{{ $advisor->id }}" {{isset($data->advisor_id) && $data->advisor_id == $advisor->id ? 'selected' : Null }}>{{ $advisor->first_name }} {{ $advisor->last_name }} - {{ $advisor->email }} - {{ $advisor->phone }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>  
                <!-- Position -->
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>View Position <span class="text-danger">*</span></label>
                        <input type="number" min="1" name="position" value="{{  $data->position ?? Null }}" class="form-control" required >
                    </div>
                </div>  
                <!-- Status -->
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Publication Status <span class="text-danger">*</span></label>
                        <select name="publication_status" class="form-control" required >
                            <option value="">Status</option>
                            <option value="1" {{ isset($data->publication_status) && $data->publication_status == "1" ? 'selected' : Null }} >Published</option>
                            <option value="0" {{ isset($data->publication_status) && $data->publication_status == "0" ? 'selected' : Null }} >Unpublished</option>
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