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
                <!-- Subject -->
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label>Email Subject<span class="text-danger">*</span> </label>
                        <input type="hidden" name="id" value="{{ isset($data->id) ? $data->id : Null }}" >                                
                        <input type="text"  name="subject" value="{{ $data->subject ?? Null }}" class="form-control" required >
                    </div>
                </div>
                <!-- Email Type / Category -->
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label>Email Type <span class="text-danger">*</span></label>
                        <select name="type" class="form-control select2" required >
                            <option value="">Select Email Type</option>
                            @foreach($types as $type)
                                <option value="{{ $type }}" {{ isset($data->type) && $data->type == $type ? "selected" : Null }} > {{ ucwords(str_replace("_", " ", $type)) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div> 

                <!-- send_email -->
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label>Send Email<span class="text-danger">*</span></label>
                        <select name="send_email" class="form-control" required >
                            <option value="">Select Email Sending Option</option>
                            <option value="1" {{ isset($data->id) && $data->send_email ? 'selected' : Null }}>ON</option>
                            <option value="0" {{ isset($data->id) && !$data->send_email ? 'selected' : Null }} >OFF</option>                           
                        </select>
                    </div>
                </div>
                
                <!-- send_email -->
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label>Send Email To CC<span class="text-danger">*</span></label>
                        <select name="send_to_cc" class="form-control" required >
                            <option value="">Select Email Sending Option</option>
                            <option value="1" {{ isset($data->id) && $data->send_to_cc ? 'selected' : Null }}>ON</option>
                            <option value="0" {{ isset($data->id) && !$data->send_to_cc ? 'selected' : Null }} >OFF</option>                           
                        </select>
                    </div>
                </div>

                <!-- third_party_email_send Permission -->
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label>Third Party CC<span class="text-danger">*</span></label>
                        <select name="third_party_email_send" class="form-control" required >
                            <option value="">Select Third Party CC</option>
                            <option value="1" {{ isset($data->id) && $data->third_party_email_send ? 'selected' : Null }}>ON</option>
                            <option value="0" {{ isset($data->id) && !$data->third_party_email_send ? 'selected' : Null }} >OFF</option>                           
                        </select>
                    </div>
                </div>

                <!-- third_party_email -->
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label>Third Party Email</label>                        
                        <input type="email"  name="third_party_email" value="{{ $data->third_party_email ?? Null }}" class="form-control" >
                    </div>
                </div>

                <!-- Body -->
                <div class="col-12">
                    <div class="form-group">
                        <label>Email Body </label> 
                        <textarea name="body" class="form-control editor" style="min-height: 100px" >{{ $data->body ?? Null }}</textarea>
                    </div>
                </div>

                <!-- Subject -->
                <div class="col-12">
                    <div class="form-group">
                        <label>Email Footer </label>                        
                        <input type="text"  name="footer" value="{{ $data->footer ?? Null }}" class="form-control" >
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
    $("select2").select2();
    ClassicEditor.create( document.querySelector( '.editor' ) );
</script>