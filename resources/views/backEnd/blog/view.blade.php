<div class="modal-content">            
    <div class="modal-header">
        <h5 class="modal-title" > {{ $data->title }} </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div> 
    
    <div class="modal-body row">
        <div class="col-12 row">
            <div class="col-12 col-md-3 "> Category Name </div>
          <div class="col-12 col-md-9 "> {{ $data->blogCategory->name ?? "" }}</div>
        </div> 
        <div class="col-12 row">
            <div class="col-12 col-md-3 "> Description </div>
            <div class="col-12 col-md-9 "> {{ strip_tags($data->description) }}</div>
        </div>
        <div class="col-12 row mt-2">
            <div class="col-12 col-md-3 "> Image </div>
            <div class="col-12 col-md-9 ">
                <img src="{{ asset($data->image_path) }}" height="200">
            </div>
        </div>
        

        

        <div class="col-12"> <hr> </div>

        <div class="col-6 row">
            <div class="col-12 col-md-5"> Publication Status </div>
            <div class="col-12 col-md-7"> {{ ucfirst($data->status) }}</div>
        </div>

        <div class="col-6 row">
            <div class="col-12 col-md-5"> Status </div>
            <div class="col-12 col-md-7"> {{ $data->deleted_at ? 'Deleted' : 'Active' }}</div>
        </div>

        <div class="col-6 row">
            <div class="col-12 col-md-5 "> Created By </div>
            <div class="col-12 col-md-7 "> {{ $data->createdBy->name }}</div>
        </div>
        <div class="col-6 row">
            <div class="col-12 col-md-5"> Created At </div>
            <div class="col-12 col-md-7"> {{ Carbon\carbon::parse($data->created_at)->format($system->date_format) }}</div>
        </div>

        <div class="col-6 row">
            <div class="col-12 col-md-5 "> Updated By </div>
            <div class="col-12 col-md-7 "> {{ empty($data->modified_by) ? 'N/A' : $data->modifiedBy->name }}</div>
        </div>
        <div class="col-6 row">
            <div class="col-12 col-md-5"> Updated At </div>
            <div class="col-12 col-md-7"> {{ Carbon\carbon::parse($data->updated_at)->format($system->date_format) }}</div>
        </div>

    </div>
                    
    <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-danger float-left" data-dismiss="modal">Close</button>
    </div>
</div>