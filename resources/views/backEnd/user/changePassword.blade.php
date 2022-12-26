<div class="modal-content">            
    <div class="modal-header">
        <h5 class="modal-title" > Change Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div> 
    <form method="POST" class="ajax-form" action="{{ route('user.password_update',['id'=> $data->id ]) }}">
        @csrf
        <input type="hidden" name="id" value="{{ isset($data->id) ? $data->id : 0 }}" >   
        <div class="modal-body">
            <!-- Fourth Page-->
            <div class="page">
                <div class="row">                    
                    <!-- Email Validation -->
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>New Password <span class="text-danger">*</span></label>
                        <input type="text" name="password" class="form-control" minlength="6" maxlength="20" required autocomplete="off" autofocus value="{{ Str::random(6) }}">
                        </div>
                    </div>

                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label>Comments</label> 
                            <textarea name="comments" class="form-control">{!! $data->comments !!}</textarea>                       
                        </div>
                    </div>
                   
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger float-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-primary">Change Password</button>                    
                </div>   
            </div>

            
        </div>
    {!! Form::close() !!}
</div>
