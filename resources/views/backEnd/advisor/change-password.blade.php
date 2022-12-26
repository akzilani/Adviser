<div class="modal-content">            
    <div class="modal-header">
        <h5 class="modal-title" > {{ $title ?? "Change Password"}} </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div> 
    {!! Form::open(['url'=> $form_url, 'method' => 'post', 'files' => 'true','class'=>'ajax-form']) !!}
        <input type="hidden" name="id" value="{{ isset($data->id) ? $data->id : 0 }}" >

        <div class="modal-body">
            <div class="row">
                <!-- Password -->
                <div class="col-12">
                    <div class="form-group">
                        <label>Password <span class="text-danger">*</span></label>                                
                        <input type="password" name="password" class="form-control" required  autocomplete="off">
                    </div>                        
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label>Retype Password <span class="text-danger">*</span></label>                                
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
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
                <button type="submit" name="btn" class="btn btn-sm btn-primary"> Update </button>
            </div>
        </div>
    {!! Form::close() !!}
</div>

            

