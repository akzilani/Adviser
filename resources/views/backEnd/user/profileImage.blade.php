<div class="modal-content">            
    <div class="modal-header">
        <h5 class="modal-title" >User Images</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div> 

    {!! Form::open([ 'route' => ['user.image_update', 'id'=> $data->id ],'method' => 'post', 'class' => 'ajax-form', 'files' => true ]) !!}
        @csrf
        <input type="hidden" name="id" value="{{ isset($data->id) ? $data->id : 0 }}" >   
        <div class="modal-body">
            <!-- Fourth Page-->
            <div class="page">
                <div class="row"> 
                    <!-- Profile Image -->
                    <div class="col-10 col-sm-6 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label>Profile Pic</label><br>                                                  
                            <img src="{{ isset($data->profilePic->image_path) && file_exists($data->profilePic->image_path) ? asset($data->profilePic->image_path) : asset('dummy_user.jpg') }}" class="img-fluid"><br>  
                        </div>
                    </div>
                    <div class="col-2 col-sm-6 col-md-4 col-lg-3">
                        <label>Change Profile Pic</label><br> 
                        <input type="file" name="image_path" accept="image/png,image/jpeg">
                    </div>
                    <div class="col-12">
                        <hr/>
                    </div>
                </div>

                <!-- Multiple Image -->
                <div class="row">
                    <div class="col-12">
                        <h4>Upload Images</h4>
                    </div>
                    @if( count($data->userImages) > 0 )
                        @foreach($data->userImages as $image)
                            <div class="col-12 col-sm-4 col-lg-3 mt-2">
                                <img src="{{ file_exists($image->image_path) ? asset($image->image_path) : asset('dummy_user.jpg') }}" class="img-fluid">
                                <div style="position: absolute; z-index:100;top:0px; right:15px;">
                                    <a href="{{ route('user.pic_rotate',['id' => $image->id ]) }}" title="click to rotate Now" class="ajax-click btn btn-warning btn-sm" ><i class="fas fa-undo"></i></a>
                                <a href="{{ route('user.pic_delete',['id' => $image->id ]) }}" title="click to remove" class="ajax-click btn btn-danger btn-sm" >X</a>                                
                                </div>
                                                           
                            </div>
                        @endforeach
                    @endif
                    
                </div>

                <div class="row">
                    <div class="col-6 mt-5">
                        <label class="font-weight-bold">Upload Images</label><br> 
                        <input type="file" name="multi_profile_image[]" multiple accept="image/png,image/jpeg">
                    </div>   
                    <div class="col-12"><hr></div>                 
                </div>

                <div class="row">
                    <div class="col-12">
                        <h4>Upload Documents</h4>
                    </div>  
                    <div class="col-12 col-sm-4 col-lg-3">
                        <label>NID Image</label>
                        @if( file_exists($data->nid_image) )
                        <a href="{{ asset($data->nid_image) }}" target="_blank">
                            <img src="{{ asset($data->nid_image) }}" class="img-fluid">
                        </a><br><br>                     
                        @endif
                        <input type="file" name="nid_image" accept="image/png,image/jpeg">
                    </div>
                    
                    <div class="col-12 col-sm-4 col-lg-3">
                        <label>Passport Image</label>
                        @if( file_exists($data->passport_image) )
                        <a href="{{ asset($data->passport_image) }}" target="_blank">
                            <img src="{{ asset($data->passport_image) }}" class="img-fluid">
                        </a><br><br>
                        @endif
                        <input type="file" name="passport_image" accept="image/png,image/jpeg">
                    </div>

                    <div class="col-12 col-sm-4 col-lg-3">
                        <label>BIO Data</label><br>
                        @if( file_exists($data->user_bio_data_path) )
                            <a href="{{ asset($data->user_bio_data_path) }}" target="_blank"><i class="far fa-4x fa-file-pdf"></i></a>
                            <br><br>
                        @endif
                        <input type="file" name="user_bio_data_path">
                    </div>
                    
                    <div class="col-6 mt-3 mb-3">                        
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
