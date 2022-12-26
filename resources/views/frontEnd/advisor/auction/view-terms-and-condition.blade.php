<div class="modal-content">            
    <div class="modal-header">
        <h5 class="modal-title" > {{ $title ?? "Auction Terms and Conditions"}} </h5>
    </div> 

    <div class="modal-body">
        <!-- Terms and Conditions -->
        <div class="row">
            <div class="col-12">
                <p>
                    {!! $trems_and_condition->trems_and_condition ?? "Accept Auction Terms and Conditions" !!}
                </p>                
            </div>
        </div> 

        <div class="modal-footer">
            <button type="button" id="accept_auction_condition" class="btn btn-sm btn-primary float-left" data-dismiss="modal">Accept</button>
        </div>
    </div>
    
</div>

