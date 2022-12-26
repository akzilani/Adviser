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
                <div class="col-12 ">
                    <div class="form-group">
                        <label>Case Study Summary <span class="text-danger">*</span> </label>   
                        <input type="hidden" name="id" value="{{ isset($data->id) ? $data->id : 0 }}" >                     
                        <input type="text" name="question" class="form-control" value="{{ $data->question ?? Null }}" required >
                    </div>
                </div>

                <!-- Advisor -->
                <div class="col-12 ">
                    <div class="form-group">
                        <label>Advisor <span class="text-danger">*</span></label>
                        <select name="advisor_id" class="form-control select2" >
                            <option>Select Advidor</option>
                            @foreach($advisors as $advisor)
                                <option value="{{ $advisor->id }}" {{ isset($data->id) && $data->advisor_id == $advisor->id ? 'selected' : Null }}>{{ $advisor->first_name }}  {{ $advisor->last_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-12 ">
                    <div class="form-group">
                        <label>Service Offer / Type <span class="text-danger">*</span> </label>                        
                        <select name="service_offer_id" class="form-control select2" required >
                            <option>Select Service Offer / Type</option>
                            @foreach($service_offer as $service)
                                <option value="{{ $service->id }}" {{ isset($data->id) && $data->service_offer_id == $service->id ? 'selected' : Null }}>{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-12 col-sm-12">
                    <div class="form-group">
                        <label>Detail</label>
                        <textarea name="answer" rows="8"  class="form-control editor" >{{ $data->answer ?? null }}</textarea>
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
                
                <!-- Visibility -->
                <div class="col-12">
                    <div class="form-group">
                        <label>Case Study Visibility <span class="text-danger">*</span></label>
                        <select name="visibility" class="form-control" required >
                            <option>Select visibility</option>
                            <option value="public" {{ isset($data->id) && $data->visibility == "public" ? 'selected' : Null }}>Public (appears in all areas including your profile page)</option>
                            <option value="private" {{ isset($data->id) && $data->visibility == "private" ? 'selected' : Null }} >Private (appears anonymously only in the case studies page)</option>                           
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
        
        <script>
            ClassicEditor.create( document.querySelector( '.editor' ) );
        </script>
    {!! Form::close() !!}
</div>