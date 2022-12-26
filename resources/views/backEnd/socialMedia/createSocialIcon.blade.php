<div class="modal-content">
  <div class="modal-header">
    <h5 class="modal-title">{{ isset($data->id) ? 'Edit' : 'Add' }} Social Media Icon</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  {!! Form::Open(['route'=>'social_media.create','method'=>'post','class'=>'form-horizontal ajax-form'])!!}
  <div class="modal-body row">            
      <div class="form-group col-sm-6">
          <label>Select Icon <span class="text-danger">*</span></label>
          <select class="form-control" name="icon" required>
              <option value="" selected="">Select an Icon</option>
              <option value="fab fa-facebook-f" {{isset($data->id) && $data->icon == 'fab fa-facebook-f'?'selected':''}} > Facebook </option>
              <option value="fab fa-twitter" {{isset($data->id) && $data->icon == 'fab fa-twitter'?'selected':''}} > Twitter </option>
              <option value="fab fa-youtube" {{isset($data->id) && $data->icon == 'fab fa-youtube'?'selected':''}} > Youtube </option>
              <option value="fab fa-instagram" {{isset($data->id) && $data->icon == 'fab fa-instagram'?'selected':''}} > Instagram </option>
              <option value="fab fa-pinterest-p" {{isset($data->id) && $data->icon == 'fab fa-pinterest-p'?'selected':''}} > Pinterest </option>
              <option value="fab fa-google-plus-g" {{isset($data->id) && $data->icon == 'fab fa-google-plus-g'?'selected':''}} > Google-plus </option>
              <option value="fab fa-linkedin-in" {{isset($data->id) && $data->icon == 'fab fa-linkedin-in'?'selected':''}} > linkedin </option>
              <option value="fab fa-flickr" {{isset($data->id) && $data->icon == 'fab fa-flickr'?'selected':''}} > Flickr </option>
              <option value="fab fa-vimeo-v" {{isset($data->id) && $data->icon == 'fab fa-vimeo-v'?'selected':''}} > Vimeo </option>
              <option value="fab fa-tumblr" {{isset($data->id) && $data->icon == 'fab fa-tumblr'?'selected':''}} > Tumblr </option>
              <option value="fab fa-spotify" {{isset($data->id) && $data->icon == 'fab fa-spotify'?'selected':''}} > Spotify </option>
          </select>                
      </div>
      <div class="form-group col-sm-6">
          <label>Icon Link <span class="text-danger">*</span></label>
          <input type="hidden" name="id" value="{{isset($data->id)?$data->id:'0'}}">
          <input type="url" name="link" value="{{isset($data->id)?$data->link:''}}" required class="form-control" placeholder="example: https://www.facebook.com">
      </div>
      <div class="form-group col-sm-6">
          <label>Position <span class="text-danger">*</span></label>
          <input type="number" name="position" value="{{isset($data->id)?$data->position:''}}" required min="1" class="form-control" placeholder="View position">
      </div>
      <div class="form-group col-sm-6">
          <label>Select Publication Status <span class="text-danger">*</span></label>
          <select class="form-control" name="publication_status" required>
              <option value="">===== Select Publication Status ====== </option>
              <option value="1" selected>Published</option>
              <option value="0" {{isset($data->id) && $data->publication_status == 0?'selected':''}}>Unpublished</option>
          </select>
      </div>
  </div>
  <div class="modal-footer">
      <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
      <button type="submit" class="btn btn-primary btn-sm ">Save Information</button>
  </div>
  {!! Form::close()!!}
</div>