<div class="modal-content">            
    <div class="modal-header">
        <h5 class="modal-title" > {{ $title ?? "Auction Details"}} </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div> 

    <div class="modal-body">
        <div class="row">
            <div class="col-12 col-sm-6">
                <p>
                    <strong>Primary Region </strong> : {{ $auction->primary_reason() }}
                </p>
                <p>
                    <strong>Postcode</strong> : {{ $auction->post_code }}
                </p>
                
            </div>
            <div class="col-12 col-sm-6">
                <p>
                    <strong>Fund Size</strong> : {{ $auction->fund_size->name }}
                </p>
                <p>
                    <strong>Areas of Advice </strong> : {{ $auction->service_offered() }}
                </p>
            </div>
        </div>
        <div class="row">

            <div class="col-12 col-sm-6">
                <p>
                    <strong>Communication Type</strong> : {{ $auction->communication_type }}
                </p>
            </div>
            <div class="col-12 col-sm-6">
                <p>
                    <strong>Auction Type</strong> : {{ ucwords($auction->type) }}
                </p>
            </div>
        </div>
        <div class="row">      
            
            <div class="col-12 col-sm-6">
                <p>
                    <strong>Reserve Price</strong> : 
                    @if($auction->base_price > 0)
                    {{ $system->currency_symbol }}{{ number_format($auction->base_price, 2) }} 
                    @else
                        No reserve price
                    @endif
                </p>
                <p>
                    @if($auction->status != "completed")
                        <strong>Minimum Bid Price</strong> : {{ $system->currency_symbol }}{{ number_format($auction->min_bid_price, 2) }} 
                    @else
                        <strong>Final Bid Price</strong> : {{ $system->currency_symbol }}{{ number_format($auction->bid_win->bid_price ?? 0, 2) }} 
                    @endif
                </p>
                <p>                    
                    <strong>Buy Out Price</strong> : {{ $system->currency_symbol }}{{ number_format($auction->buy_out_price ?? 0, 2) }}                    
                </p>
            </div>
            <div class="col-12 col-sm-6">
                <p>
                    <strong>Auction Status</strong> :
                    <span class="badge badge-info">
                        {{ Str::ucfirst(str_replace('_', ' ', $auction->status)) }}
                    </span>
                </p>
                <p class="{{ $auction->status == "cancelled" ? "d-none" : Null }}">
                    <strong>Remaining Time</strong> : 
                    <strong><span id="remain_time_text"></span></strong>
                </p>
            </div>
            <div class="col-12 col-sm-6 col-md-4" align="center">
                <p>
                    <strong>Top Bidder</strong><br>
                    @if( $advisor && !empty($advisor) )
                    <div class="bg-theme text-center p-3" style="height: 280px;overflow: hidden;">
                        <center>
                            <img src="{{ asset(isset($advisor->image) && file_exists($advisor->image) ? $advisor->image : 'image/dummy_user.jpg') }}" class="img-fluid rounded-circle img-thumbnail" style="height: 120px; width:120px">
                        </center>
                        <div class="mt-3 text-white">
                            <a href="{{ route('advisor_profile',['profession' =>Str::slug($advisor->profession->name ?? 'N-A'), 'location' => str::slug($advisor->town ?? "N-A"), 'name_id' => $advisor->id .'-'.($advisor->first_name . '-' . $advisor->last_name)]) }}" target="_blank" style="font-size:14px;color:#fff;">
                                {{$advisor->first_name }} {{$advisor->last_name }}
                            </a>
                        </div>
                        <h4 class="mt-3">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $advisor->approve_advisor_questions->count())
                                    <i class="fas fa-star text-warning"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                        </h4>
                        @if($advisor->firm_details)
                            <p class="p-0 m-0 font-12 line-heigh-14">{{$advisor->firm_details->profile_name}}</p>
                        @endif
                        @if( ($advisor->testimonial->count() + $advisor->advisor_questions->count()) >= 2)
                            <p class="p-0 m-0 font-12 line-heigh-14"> {{  ($advisor->testimonial->count() + $advisor->advisor_questions->count()) }} Testimonials & Questions Answered</p>
                        @endif
                        
                    </div>   
                    @else
                        N/A
                    @endif
                </p>
            </div>
        </div> 

        <div class="row">
            <div class="col-12">
                <h3>Bidding History</h3>
            </div>
            <div class="col-12">
                <table class="table table-striped">
                    <tr>
                        <td>Advisor Name</td>
                        <td>Bid History</td>
                        <td>Bidding Time</td>
                    </tr>
                    @foreach($auction->bids as $bid)
                    <tr>
                        <td>{{ ($bid->advisor->first_name ?? 'N/A') . ' ' . $bid->advisor->last_name ?? 'N/A' }}</td>
                        <td>{{ $system->currency_symbol }}{{ number_format($bid->bid_price, 2) }} </td>
                        <td>{{ Carbon\Carbon::parse($bid->created_at)->format($system->date_format . ' H:i A') }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-danger float-left" data-dismiss="modal">Close</button>
        </div>
    </div>
    
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

