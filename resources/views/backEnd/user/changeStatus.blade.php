<div class="modal-content">            
    <div class="modal-header">
        <h5 class="modal-title" > Change User Status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div> 
    <form method="POST" class="ajax-form" action="{{ route('user.status_update',['id'=> $data->id ]) }}">
        @csrf
        <input type="hidden" name="id" value="{{ isset($data->id) ? $data->id : 0 }}" >   
        <div class="modal-body">
            <!-- Fourth Page-->
            <div class="page">
                <div class="row">                                        

                    <!-- Status -->
                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span> </label>                                                        
                            <select name="user_status" required class="form-control">
                                <option value="1" {{ isset($data->id) && $data->user_status == 1 ? 'selected' : Null }} > Active </option>
                                <option value="0" {{ isset($data->id) && !$data->user_status ? 'selected' : Null }} > Dective </option>
                                <option value="2" {{ isset($data->id) && $data->user_status == 2 ? 'selected' : Null }} > Verified </option>
                                <option value="3" {{ isset($data->id) && $data->user_status == 3 ? 'selected' : Null }} > Unverified </option>
                            </select>
                        </div>
                    </div> 

                    <div class="col-4">
                        <div class="form-group">
                            <label>Comments</label> 
                            <textarea name="comments" class="form-control">{!! $data->comments !!}</textarea>                       
                        </div>
                    </div>
                    <!-- Email Validation -->
                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="email_verified_at" value="1" {{ !empty($data->email_verified_at) ? 'checked' : Null }} >
                                Email Validation
                            </label>
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
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-end">
                            <li class="page-item">
                                <button type="button" class="btn btn-sm btn-danger float-left" data-dismiss="modal">Close</button>
                            </li>
                            <li class="page-item">
                                <button type="submit" class="page-link btn-primary">Save</button>
                            </li>
                        </ul>
                    </nav>
                </div>   
            </div>

            
        </div>
    {!! Form::close() !!}
</div>
