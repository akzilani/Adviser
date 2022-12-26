<div class="modal-content">            
    <div class="modal-header">
        <h5 class="modal-title" > {{ $title ?? "Place your bid"}} </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div> 
    {!! Form::open(['url'=> $form_url, 'method' => 'post', 'files' => 'true','class'=>'ajax-form']) !!}
        <div class="modal-body">
            @if($auction)
            <div class="row">
                <!-- Auction Start Time -->
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Reserve Price : </label> 
                            @if($auction->base_price > 0)
                                {{ $system->currency_symbol }} {{ number_format($auction->base_price, 2) }}                                 
                            @else
                                No reserve price
                            @endif
                            <br>
                            @if($auction->buy_out_price > 0)
                                <p>                    
                                    <strong>Buy Out Price</strong> : {{ $system->currency_symbol }}{{ number_format($auction->buy_out_price ?? 0, 2) }}                    
                                    <button type="button" class="btn btn-sm btn-info" data-buy_out="{{ $auction->buy_out_price }}" id="buy_out_btn" >Buy Out</button>
                                    <input type="hidden" name="buy_out" id="buy_out" value="0" >
                                </p>
                            @endif
                    </div>                        
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label class="font-weight-bold">Remaining Time : </label>  <strong><span id="remain_time_text"></span></strong><br>
                        <label class="font-weight-bold">Minimum Bid Price: </label> {{ $system->currency_symbol}} {{ number_format($auction->min_bid_price, 2) }} <br>
                        @if( !empty($advisor) )
                            <label class="font-weight-bold">Top Bidder: </label> 
                            <a href="{{ route('advisor_profile', ['profession' =>Str::slug($advisor->profession->name ?? 'N-A'), 'location' => str::slug($advisor->town ?? "N-A"), 'name_id' => $advisor->id .'-'.($advisor->first_name . '-' . $advisor->last_name)]) }}" target="_blank" title="{{ $advisor->first_name }}">{{ $advisor->first_name }} </a> <br>
                        @endif
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Minimum Bid Price <span>*</span></label>
                        <?php
                            $min_bid_price = $auction->base_price > $auction->min_bid_price ? ($auction->base_price) : ($auction->min_bid_price)
                        ?>
                        <input type="number" step="any" name="min_bid_price" id="min_bid_price" class="form-control" min="{{ $min_bid_price  }}" value="{{ $min_bid_price }}" required >
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <label>Uploading</label>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"> 0% </div>
                    </div>
                </div>
            </div>
            @else
                <div class="row">
                    <div class="col-sm-12 text-danger">
                        <h3>Sorry! This Auction's bid time has been expired. Due to time expired you are not allowed for bidding</h3>
                    </div>
                </div> 
            @endif           
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-danger float-left" data-dismiss="modal">Close</button>
                @if($auction)
                    <button type="submit" id="submit_bid" name="btn" class="btn btn-sm btn-primary"> Save </button>
                @endif
                
            </div>
        </div>
    {!! Form::close() !!}
</div>

<script>
    var countDownDate = new Date('{{ $auction->end_time }}').getTime(); // Already in UTC Format
    var x = setInterval(function() {
        var now = new Date(new Date().toLocaleString('en-US', { timeZone: "{{ $system->time_zone ?? 'UTC' }}" })).getTime();
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        // Output the result in an element with id="demo"
        document.getElementById("remain_time_text").innerHTML = days + "d " + hours + "h "
        + minutes + "m " + seconds + "s ";
        
        // If the count down is over, write some text 
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("remain_time_text").innerHTML = "EXPIRED";
        }
    }, 1000);
</script>
    
