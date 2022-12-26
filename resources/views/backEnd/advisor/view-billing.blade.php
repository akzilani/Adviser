<div class="modal-content">            
    <div class="modal-header">
        <h5 class="modal-title" > {{ $data->advisor->first_name ?? "N/A" }} - {{ $data->advisor->last_name ?? Null }} </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div> 
    
    <div class="modal-body row">
        <div class="col-12 row">
            <div class="col-5 font-weight-bold "> Contact Name </div>
            <div class="col-1 text-center d-none d-sm-block">:</div>
            <div class="col-6 "> {{ $data->contact_name ?? "" }}</div>
        </div>
        <div class="col-12 row">
            <div class="col-5 font-weight-bold "> Company Name </div>
            <div class="col-1 text-center d-none d-sm-block">:</div>
            <div class="col-6 "> {{ $data->billing_company_name ?? "" }}</div>
        </div>
        <div class="col-12 row">
            <div class="col-5 font-weight-bold "> Company Number </div>
            <div class="col-1 text-center d-none d-sm-block">:</div>
            <div class="col-6 "> {{ $data->billing_company_fca_number ?? "" }}</div>
        </div>
         <div class="col-12 row">
            <div class="col-5 font-weight-bold "> Address </div>
            <div class="col-1 text-center d-none d-sm-block">:</div>
            <div class="col-6 "> {{ $data->billing_address_line_one ?? "" }} {{ $data->billing_address_line_two ?? "" }}</div>
        </div>
        <div class="col-12 row">
            <div class="col-5 font-weight-bold "> Town </div>
            <div class="col-1 text-center d-none d-sm-block">:</div>
            <div class="col-6 "> {{ $data->billing_town ?? "" }}</div>
        </div>
        <div class="col-12 row">
            <div class="col-5 font-weight-bold "> Postcode </div>
            <div class="col-1 text-center d-none d-sm-block">:</div>
            <div class="col-6 "> {{ $data->billing_post_code ?? "" }}</div>
        </div>
        <div class="col-12 row">
            <div class="col-5 font-weight-bold"> County </div>
            <div class="col-1 text-center d-none d-sm-block">:</div>
            <div class="col-6 "> {{ $data->billing_country ?? "" }}</div>
        </div>

        

        <div class="col-12"> <hr> </div>
        <div class="col-12 row">
            <div class="col-5 "> Created By </div>
            <div class="col-12 col-md-7 "> {{ $data->createdBy->name ?? "N/A" }}</div>
        </div>
        <div class="col-12 row">
            <div class="col-12 col-md-5"> Created At </div>
            <div class="col-12 col-md-7"> {{ Carbon\carbon::parse($data->created_at)->format($system->date_format) }}</div>
        </div>

        <div class="col-12 row">
            <div class="col-12 col-md-5"> Updated At </div>
            <div class="col-12 col-md-7"> {{ Carbon\carbon::parse($data->updated_at)->format($system->date_format) }}</div>
        </div>

    </div>
                    
    <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-danger float-left" data-dismiss="modal">Close</button>
    </div>
</div>