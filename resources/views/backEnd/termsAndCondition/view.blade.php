<div class="modal-content">            
    <div class="modal-header">
        <h5 class="modal-title" > {{ str_replace("_", " ", $data->type) }} </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>     
    <div class="modal-body">  
        <div class="row">
            <div class="col-12">
                {!! $data->trems_and_condition !!} 
            </div>
        </div>                     
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-danger float-left" data-dismiss="modal">Close</button>
    </div>
   
</div>