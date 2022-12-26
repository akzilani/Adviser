<div class="modal-content">            
    <div class="modal-header">
        <h5 class="modal-title" > {{ $advisor->first_name ?? "N/A" }} - {{ $advisor->last_name ?? Null }} </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div> 
    
    <div class="modal-body row">
        <div class="col-12 row">
            <div class="col-3 font-weight-bold "> Postcode Cover Area </div>
            <div class="col-1 text-center d-none d-sm-block">:</div>
            <div class="col-8 "> {!! $advisor->postcodesCovered() !!}</div>
        </div>
        <div class="col-12 row mt-3">
            <div class="col-3 font-weight-bold "> Subscribe Postcode </div>
            <div class="col-1 text-center d-none d-sm-block">:</div>
            <div class="col-8 "> {!! $advisor->postcodesCovered(null, true) !!}</div>
        </div>

        <div class="col-12"> <hr> </div>
        <div class="col-12 row">
            <div class="col-5 "> Created By </div>
            <div class="col-12 col-md-7 "> {{ $advisor->createdBy->name ?? "N/A" }}</div>
        </div>
        <div class="col-12 row">
            <div class="col-12 col-md-5"> Created At </div>
            <div class="col-12 col-md-7"> {{ Carbon\carbon::parse($advisor->created_at)->format($system->date_format) }}</div>
        </div>

        <div class="col-12 row">
            <div class="col-12 col-md-5"> Updated At </div>
            <div class="col-12 col-md-7"> {{ Carbon\carbon::parse($advisor->updated_at)->format($system->date_format) }}</div>
        </div>

    </div>
                    
    <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-danger float-left" data-dismiss="modal">Close</button>
    </div>
</div>