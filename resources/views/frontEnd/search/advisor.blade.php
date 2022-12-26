@foreach($advisors as $advisor)
    <div class="advisor-box" style="padding-top: 20px !important; padding-right: 20px !important; padding-bottom: 25px !important; padding-left: 20px !important;">
        <div class="row">
            <div class="col-md-5" style="line-height: 20px !important;">
                <h4 class="font-weight-bold">{{ $advisor->first_name ." ". $advisor->last_name }}</h4>
                @if($advisor->firm_details)
                    <h5 class="font-weight-light font-16 mb-0 pb-0">{{ $advisor->firm_details->profile_name }}</h5>
                @endif
                @if($advisor->profession)
                    <p class="m-0 p-0 font-13 line-heigh-14">{{ $advisor->profession->name }}</p>
                @endif
                
                @if( $advisor->view_telephone_no == true )                
                    @if( !empty($advisor->telephone) )
                        <p class="mb-0 font-13 line-heigh-14" style="margin-top:10px !important;">
                            <i class="fas fa-phone-alt text-success" style="padding-left:1px;"></i> {{ $advisor->telephone }}
                        </p>
                    @endif
                @endif

                @if( !empty($advisor->town) )
                    <p class="mt-2 font-13">                                    
                        <i class="fa fa-map-marker-alt text-success" style="padding:1px;" aria-hidden="true"> </i> <span >Based in {{$advisor->town}}</span>
                    </p>
                @endif
                @if( (isset($advisor->advisor_questions) && count($advisor->advisor_questions) > 0 ) || ( isset($advisor->testimonial) && count($advisor->testimonial) > 0) )
                    @php
                        $total_qs_testimonial = count($advisor->advisor_questions) + count($advisor->testimonial);
                    @endphp
                    @if($total_qs_testimonial >= 2)
                        <p class="font-13">
                            <div class="advisor_profile_img_icon font-13">
                                <img width="20" height="20" src="{{asset('icon/message.png')}}">                             
                                <span>                               
                                    ({{ $total_qs_testimonial }}) Testimonials & Questions Answered 
                                </span>
                            </div>
                        </p>
                    @endif
                @endif  
                @if ( isset($advisor->fca_status_date) )
                    <p class="font-13">
                        <i class="fa fa-address-card text-success" aria-hidden="true"></i> <span>Verified Since {{ Carbon\Carbon::parse($advisor->fca_status_date)->format('d M Y') }}</span>
                    </p>
                @endif
                
                @if ( isset($advisor->interviews) && count($advisor->interviews) > 0)
                    <p class="font-13">
                        <i class="fa fa-microphone text-success" aria-hidden="true"></i> <span>Interview with {{ $advisor->first_name }} {{ $advisor->last_name }} </span>
                    </p>
                @endif  
                @if ( isset($advisor->fund_size) )
                    <p class="font-13">
                        <i class="fa fa-briefcase text-success" aria-hidden="true"></i> <span>{{ $advisor->fund_size->name }}</span>
                    </p>
                @endif 
                @if( isset($advisor->travel_time) && !empty($advisor->travel_time))
                    <p class="font-13">
                        <span>
                            Travel Time: {{ $advisor->travel_time }}
                        </span>
                    </p>
                @endif             
            </div>

            <!-- View About Me & Service Offer -->
            <div class="col-md-3 p-0">
                
                
                
                @if(!empty($advisor->profile_brief))
                    <div class=" p-2 font-13 mt-2  profile-breef">
                        {!! substr($advisor->profile_brief, 0 , 100) !!}...<br>
                        <a href="{{ route('advisor_profile', ['profession' =>Str::slug($advisor->profession->name ?? 'N-A'), 'location' => str::slug($advisor->town ?? "N-A"), 'name_id' => $advisor->id .'-'.($advisor->first_name . '-' . $advisor->last_name)]) }}" target="_blank" class="btn btn-link font-12 pl-0">VIEW PROFILE</a>
                    </div>
                @endif

                <div class="p-2 font-13 mt-2 profile-breef">
                    <?php $more_service_offer = 0; ?>
                    @foreach($advisor->service_offered() as $offer)
                        @if($loop->iteration <= 2)
                            {{ $offer->name }},
                        @else
                            <?php  $more_service_offer++; ?>
                        @endif                        
                    @endforeach
                    <br>
                    @if($more_service_offer > 0)
                        <a href="{{ route('advisor_profile', ['profession' => Str::slug($advisor->profession->name ?? 'N-A'), 'location' => str::slug($advisor->town ?? "N-A"), 'name_id' => $advisor->id .'-'.($advisor->first_name . '-' . $advisor->last_name)]) }}" target="_blank" class="btn btn-link font-12 pl-0">+{{ $more_service_offer }} more</a>
                    @endif
                </div>
            </div>
            
            <div class="col-md-4  text-center">
                <img src="{{ asset( isset($advisor->image) && file_exists($advisor->image) && $advisor->image[strlen($advisor->image)-1] != '/' ? $advisor->image : 'image/dummy_profile.jpg' ) }}" class="img-fluid rounded-circle img-thumbnail profile-image" style="height: 200px; width: 200px;">
                <div class="mt-4 postion-relative">
                    <a href="{{ route('contact_advisor',[$advisor->id]) }}" class="btn btn-md btn-success no-radius">Contact</a>
                    <a href="{{ route('advisor_profile',['profession' =>Str::slug($advisor->profession->name ?? 'N-A'), 'location' => str::slug($advisor->town ?? "N-A"), 'name_id' => $advisor->id .'-'.($advisor->first_name . '-' . $advisor->last_name)]) }}" target="_blank" class="btn btn-md btn-success no-radius">Profile</a>
                </div>
                <div class="mt-4 text-center">
                    @if($show_match_rating)
                        <h4 style="line-height: 3px !important">Match Rating</h4>
                        @for($i = 0; $i < $advisor->rating; $i++)
                            <i class="fas fa-star text-warning fa-lg"></i>
                        @endfor
                        @for($i = 5; $i > $advisor->rating; $i--)
                        <i class="far fa-star fa-lg"></i>
                        @endfor
                    @else
                        &nbsp; 
                    @endif
                </div>
            </div>
        </div>
    </div>
@endforeach

<div class="text-right" id="advisor-pagination">
    {!! $advisors->links() !!}
</div>

<style>
    .pro-img{opacity: .75;}
    .pro-img:hover{opacity: 1;}
    .profile-breef p{font-size: 12px; margin-bottom: 0px; line-height: 20px;}
</style>

<!-- Global site tag (gtag.js) - Google Ads: 931329483 -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-931329483"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'AW-931329483');
    </script>