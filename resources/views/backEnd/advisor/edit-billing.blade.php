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
                
                <!-- Contact Name -->
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Contact Name <span class="text-danger">*</span></label>
                        <input type="text"  name="contact_name" value="{{  $data->contact_name ?? Null }}" class="form-control" required >
                    </div>
                </div>  
                <!-- Company Name -->
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Company Name <span class="text-danger">*</span></label>
                        <input type="text"  name="billing_company_name" value="{{  $data->billing_company_name ?? Null }}" class="form-control" required >
                    </div>
                </div>  
                <!-- Company FCA  Number-->
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Company Number </label>
                        <input type="text"  name="billing_company_fca_number" value="{{  $data->billing_company_fca_number ?? Null }}" class="form-control" >
                    </div>
                </div>
                <!-- Town -->
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Town </label>
                        <input type="text"  name="billing_town" value="{{  $data->billing_town ?? Null }}" class="form-control" >
                    </div>
                </div> 
                <!-- Postcode -->
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Postcode </label>
                        <input type="text"  name="billing_post_code" value="{{  $data->billing_post_code ?? Null }}" class="form-control" >
                    </div>
                </div> 

                <!-- Country -->
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>County </label>
                        <input type="text"  name="billing_country" value="{{  $data->billing_country ?? Null }}" class="form-control" >
                    </div>
                </div> 

                <!-- billing address line One -->
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Address Line 1</label>
                        <input type="text"  name="billing_address_line_one" value="{{  $data->billing_address_line_one ?? Null }}" class="form-control" >
                    </div>
                </div> 

                <!-- billing address line Two -->
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Address Line 2</label>
                        <input type="text"  name="billing_address_line_two" value="{{  $data->billing_address_line_two ?? Null }}" class="form-control" >
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