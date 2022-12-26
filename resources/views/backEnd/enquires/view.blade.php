<div class="modal-content">            
    <div class="modal-header">
        <h5 class="modal-title" > View Enquires / Contact Us Message </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div> 
    
    <div class="modal-body row">
        <div class="col-12 row">
            <div class="col-12 col-md-3 font-weight-bold"> Name </div>
            <div class="col-12 col-md-9 "> {{ $data->first_name . ' ' . $data->last_name }}</div>
        </div>
        <div class="col-12 row">
            <div class="col-12 col-md-3 font-weight-bold"> Service Offer </div>
            <div class="col-12 col-md-9 "> {{ $data->service_interest ?? "N/A" }}</div>
        </div>
        <div class="col-12 row">
            <div class="col-12 col-md-3 font-weight-bold"> Email </div>
            <div class="col-12 col-md-9 "> {{ $data->email ?? "N/A" }}</div>
        </div>
        <div class="col-12 row">
            <div class="col-12 col-md-3 font-weight-bold"> Company Name </div>
            <div class="col-12 col-md-9 "> {{ $data->company_name ?? "N/A" }}</div>
        </div>
        <div class="col-12 row">
            <div class="col-12 col-md-3 font-weight-bold"> Phone Number </div>
            <div class="col-12 col-md-9 "> {{ $data->phone_number ?? "N/A" }}</div>
        </div>
        <div class="col-12 row">
            <div class="col-12 col-md-3 font-weight-bold"> Postcode </div>
            <div class="col-12 col-md-9 "> {{ $data->post_code ?? "N/A" }}</div>
        </div>

        <div class="col-12 row mt-2">
            <div class="col-12">
                <h3>Permissions</h3>
            </div>
        </div>

        <div class="col-12 row">
            <div class="col-12 col-md-3 font-weight-bold"> Data Store Permission</div>
            <div class="col-12 col-md-9 "> {{ $data->store_data ? "Yes" : 'No' }}</div>
        </div>
        <div class="col-12 row">
            <div class="col-12 col-md-3 font-weight-bold"> Call Permission</div>
            <div class="col-12 col-md-9 "> {{ $data->call_permission ? "Yes" : 'No' }}</div>
        </div>
        <div class="col-12 row">
            <div class="col-12 col-md-3 font-weight-bold"> Email Permission</div>
            <div class="col-12 col-md-9 "> {{ $data->email_permission ? "Yes" : 'No' }}</div>
        </div>
        <div class="col-12 row">
            <div class="col-12 col-md-3 font-weight-bold"> Text Permission</div>
            <div class="col-12 col-md-9 "> {{ $data->text_permission ? "Yes" : 'No' }}</div>
        </div>

        <div class="col-12"> <hr> </div>

        <div class="col-6 row">
            <div class="col-12 col-md-5 font-weight-bold"> Created At </div>
            <div class="col-12 col-md-7"> {{ Carbon\carbon::parse($data->created_at)->format($system->date_format . ' H:i:s A') }}</div>
        </div>
        @if($data->is_seen)
        <div class="col-6 row">
            <div class="col-12 col-md-5 font-weight-bold"> Seen At </div>
            <div class="col-12 col-md-7"> {{ Carbon\carbon::parse($data->updated_at)->format($system->date_format. ' H:i:s A') }}</div>
        </div>
        @endif
    </div>
                    
    <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-danger float-left" data-dismiss="modal">Close</button>
    </div>
</div>