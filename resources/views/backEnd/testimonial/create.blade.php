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

                <!-- Advisor List -->
                <div class="col-12 ">
                    <div class="form-group">
                        <label>Select Advisor<span class="text-danger">*</span> </label>   
                        <input type="hidden" name="id" value="{{ isset($data->id) ? $data->id : 0 }}" >                            
                        <select name="advisor_id" class="form-control select2" required >
                            <option>Select Advisor</option>
                            @foreach($advisors as $advisor)
                                <option value="{{ $advisor->id }}" {{ isset($data->id) && $data->advisor_id == $advisor->id ? 'selected' : Null }}>{{ $advisor->first_name }} - {{ $advisor->last_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Name -->
                <div class="col-12">
                    <div class="form-group">
                        <label>Name<span class="text-danger">*</span> </label>
                        <input type="text" name="name" value="{{ $data->name ?? "" }}" class="form-control" required >
                    </div>
                </div>

                <!-- Publication Status -->
                <div class="col-12">
                    <div class="form-group">
                        <label>Publication Status <span class="text-danger">*</span></label>
                        <select name="publication_status" class="form-control" required >
                            <option>Select Publication Status</option>
                            <option value="1" {{ isset($data->id) && $data->publication_status ? 'selected' : Null }}>Published</option>
                            <option value="0" {{ isset($data->id) && !$data->publication_status ? 'selected' : Null }} >Unpublished</option>                           
                        </select>
                    </div>
                </div> 

                <!-- Description -->
                <div class="col-12">
                    <div class="form-group">
                        <label>Description<span class="text-danger">*</span> </label>
                        <textarea name="description" class="form-control" required >{{ $data->description ?? Null }}</textarea>
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