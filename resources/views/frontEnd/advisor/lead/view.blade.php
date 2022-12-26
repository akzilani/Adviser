<div class="modal-content">            
    <div class="modal-header">
        <h5 class="modal-title" >
            @if($data->advisor_id == Auth::user()->id)
                Congratulations! You just received a new lead
            @else
                Lead Details
            @endif
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div> 
    
    <div class="modal-body row">
        <div class="col-12 row mt-2">
            <div class="col-12 col-md-3 font-weight-bold"> Name </div>
            <div class="col-12 col-md-9 ">: {{ ucwords($data->name ?? "N/A") }}</div>
        </div>
        <div class="col-12 row mt-2">
            <div class="col-12 col-md-3 font-weight-bold"> Postcode </div>
            <div class="col-12 col-md-9 ">: {{ $data->post_code ?? "" }}</div>
        </div>

        {{-- <div class="col-12 row mt-2">
            <div class="col-12 col-md-3 font-weight-bold"> Email </div>
            <div class="col-12 col-md-9 ">: {{ $data->email ?? "" }}</div>
        </div> --}}

        <div class="col-12 row mt-2">
            <div class="col-12 col-md-3 font-weight-bold"> Question </div>
            <div class="col-12 col-md-9 ">: {{ $data->question ?? "" }}</div>
        </div>
        <div class="col-12 row mt-2">
            <div class="col-12 col-md-3 font-weight-bold"> Communication Type </div>
            <div class="col-12 col-md-9 ">: {{ $data->communication_type ?? "" }}</div>
        </div>
        <div class="col-12 row mt-2">
            <div class="col-12 col-md-3 font-weight-bold"> Telephone Number </div>
            <div class="col-12 col-md-9 ">: {{ $data->phone ?? "" }}</div>
        </div>
        <div class="col-12 row mt-2">
            <div class="col-12 col-md-3 font-weight-bold"> Lead Type </div>
            <div class="col-12 col-md-9 ">: {{ ucwords($data->type ?? "N/A") }}</div>
        </div>
        <div class="col-12 row mt-2">
            <div class="col-12 col-md-3 font-weight-bold"> Fund Size </div>
            <div class="col-12 col-md-9 ">: {{ ucfirst($data->fund_size->name ?? "N/A") }}</div>
        </div>
        <div class="col-12 row mt-2">
            <div class="col-12 col-md-3 font-weight-bold"> Areas of Advice </div>
            <div class="col-12 col-md-9 ">: {{ ucfirst($data->service_offered() ?? "N/A") }}</div>
        </div>

        <div class="col-12 row mt-2">
            <div class="col-12 col-md-3 font-weight-bold"> Lead Status </div>
            <div class="col-12 col-md-9 ">: {{ ucfirst( str_replace("_", " ", $data->status ?? "N/A")) }}</div>
        </div>

    </div>
                    
    <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-danger float-left" data-dismiss="modal">Close</button>
    </div>
</div>