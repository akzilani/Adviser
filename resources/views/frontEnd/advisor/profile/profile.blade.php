@extends('frontEnd.masterPage')
@section('title')
    Advisor Profile
@stop
@section('style')
    <style>
        /* .bg-custom{background-color: #eee !important;} */
        .box-shadow{box-shadow: -2px 7px 22px -12px rgba(0,0,0,0.75); background: #eee;}
        .service-btn{border-radius: 30px; border:2px solid #2c77b3;font-size: 9px;padding: 2px 7px;line-height: 15px;}
        .font-weight-normal{font-weight: normal;}
        .profile-layout{position: fixed;z-index:10000; background: rgb(38, 120, 189); width:22%; padding:15px;}
        
        @media only screen and (max-width: 2500px){.profile-layout{width:13%;}}
        @media only screen and (max-width: 2100px){.profile-layout{width:15%;}}
        @media screen and (max-width: 1900px){ .profile-layout{width:16%;} }
        @media screen and (max-width: 1650px){ .profile-layout{width:19%;} }
        @media screen and (max-width: 1199px){ .profile-layout{width:24%;} }
        @media screen and (max-width: 992px){ .profile-layout{width:30%;} }
        @media screen and (max-width: 767px){ .profile-layout{width:39%;} }
        @media screen and (max-width: 575px){ .profile-layout{position:unset; width:100%;} }
        .profile-layout .profile-image, .profile-img{ opacity: .8;}
        .profile-img:hover{opacity: 1;}

    </style>
@endsection
@section('script')
    <script>
        var scrollTop = 200;
        $(window).scroll(function(event){
            var cst = $(this).scrollTop();
            if (cst >= scrollTop){
                $('.profile-image').css("opacity", "1");
            } else {
                $('.profile-image').css("opacity", ".8");
            }
        });
    </script>
@endsection
@section('mainPart')
    <div class="container-lg mt-0 mb-4">
        <div class="row justify-content-center">
            <!-- Left Sidebar -->
            <div class="col-12 col-sm-5 col-md-4 mt-3 mt-md-0">
                <div class="profile-layout">
                    <div class="text-center">
                        <img src="{{ asset(file_exists($advisor->image) && $advisor->image[strlen($advisor->image)-1] != '/' ? $advisor->image : 'image/dummy_profile.jpg') }}" class="img-fluid rounded-circle img-thumbnail profile-image" style="height: 200px; width:200px;">
                    
                        <h3 class="mt-4 mb-0 text-white">{{ $advisor->first_name ?? "" }} {{ $advisor->last_name ?? "" }}</h3>
                        <h4 class="mt-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $advisor->non_specific_rating)
                                    <i class="fas fa-star text-warning"></i>
                                @else
                                    <i class="far fa-star text-white"></i>
                                @endif
                            @endfor
                        </h4>
                        
                        @if($advisor->firm_details)
                            <p class="pt-2 pb-2 text-white pb-0 m-0 font-weight-normal font-16">{{$advisor->firm_details->profile_name}}</p>
                        @endif
                        @if(($advisor->view_telephone_no) )
                            @if( isset($advisor->telephone) )
                                <h4 class="text-white pt-1 pb-0 m-0 font-weight-normal"><i class="fas fa-phone-alt"></i> {{ $advisor->telephone }}</h4>
                            @endif
                        @endif
                        <?php 
                            $total_question_tentimonial = ($advisor->testimonial->count() + $advisor->advisor_questions->count());
                        ?>
                        @if($total_question_tentimonial >= 2)
                            <p class="p-0 text-white m-0 font-13 line-heigh-14 pt-1"> {{  $total_question_tentimonial }} Testimonials & Case Studies Posted</p>
                        @endif
                        <a href="{{ route('contact_advisor',[$advisor->id]) }}" class="btn btn-success no-radius mt-3 mb-3 text-white">Contact {{ $advisor->first_name }}</a>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar -->
            <div class="col-12 col-sm-7 col-md-8 mt-3 mt-md-0">
                <div class="box-shadow p-3">
                    <div class="row">
                        <div class="col-sm-8">
                            <h2 class="pb-0 mb-0"> <b>{{ $advisor->first_name }} {{ $advisor->last_name }}</b></h2>
                            <h3 class="pb-0 mb-1 font-weight-normal">{{ $advisor->firm_details->profile_name }}</h3>
                            @foreach($advisor->advisor_types($advisor->advisor_type_id) as $types)
                                <button class="service-btn mb-2">{{ $types->name }}</button>
                            @endforeach
                            
                            @isset($advisor->town)
                                <div class="mt-4"> Based in {{$advisor->town}} </div>
                            @endisset
                            @isset($advisor->personal_fca_number)
                                <div>(FCA reference number {{$advisor->personal_fca_number}})</div>
                            @endisset
                            @isset($advisor->fca_status_date)
                                <div>Status Effective Date / Start Date {{ Carbon\Carbon::parse($advisor->fca_status_date)->format('d M Y') }}</div>
                            @endisset
                            
                            <br>
                            @isset($advisor->firm_details->firm_website_address)
                                <a href="{{ $advisor->firm_details->firm_website_address }}" target="_blank" title="{{ $advisor->firm_details->firm_website_address }}"> <i class="fa fa-globe fa-2x text-theme" style="color:green"></i> </a> &nbsp; 
                            @endif
                            @isset($advisor->firm_details->linkedin_id)
                                <a href="{{ $advisor->firm_details->linkedin_id }}" target="_blank" title="{{$advisor->firm_details->linkedin_id}}"> <i class="fab fa-linkedin-in fa-2x text-theme"></i> </a>
                            @endif

                        </div>
                        <div class="col-sm-4 text-center mt-4 mt-sm-0">
                            <img src="{{ asset(file_exists($advisor->image) && $advisor->image[strlen($advisor->image)-1] != '/' ? $advisor->image : 'image/dummy_profile.jpg') }}" class="img-fluid profile-img w-100">
                            <a href="{{ route('contact_advisor',[$advisor->id]) }}" class="btn btn-warning no-radius mt-4">Contact {{ $advisor->first_name }}</a>
                        </div>
                    </div>                
                </div>

                <div class="box-shadow p-3 mt-5 mb-5">
                    <!-- Abount Us -->
                    <div>
                        <h3><strong>About {{$advisor->first_name }} {{$advisor->last_name }}</strong></h3>
                        <p>{!! $advisor->profile_brief !!}</p>
                        <hr>
                    </div>  

                    <!-- About Firm -->
                    <div class="mt-5">
                        <h3><strong>About {{$advisor->firm_details->profile_name}}</strong></h3>
                        <p>{!! $advisor->firm_details->profile_details !!}</p>
                    </div> 
                    
                    <!-- Location -->
                    <div class="mt-5">
                        <h3><strong>Location</strong></h3>
                        <p>{{ $advisor->address_line_one ? $advisor->address_line_one . ',' : null}} {{ $advisor->address_line_two ? $advisor->address_line_two . ',':null }} {{$advisor->town}}, {{$advisor->country}}, {{$advisor->post_code}}</p>
                        @if( isset($advisor->latitude) && isset($advisor->longitude))
                            <div style="width: 100%; overflow: hidden; height: 300px;">
                                <iframe style="border:0; margin-top: -150px;"  width="100%" height="450" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q={{$advisor->latitude}},{{$advisor->longitude}} &hl=es;z=14&amp;output=embed" >
                                </iframe>
                            </div>
                        @endif
                    </div>

                    <!-- Postcode Cover Area -->
                    @if( is_array($advisor->location_postcode_id) )
                        <div class="mt-5">
                            <h3><strong>Postcode areas covered</strong></h3>                        
                            <p>{{ $advisor->postcodesCovered($advisor->location_postcode_id) }}</p>
                        </div>
                    @endif

                    <!-- Interview With Advisor -->
                    @if( count($advisor->interviews) > 0)
                        <div class="mt-5">
                            <h3><strong>Interview with {{$advisor->first_name }} {{$advisor->last_name }}</strong></h3>
                            <div class="accordion" id="accordion-interviews">
                                <div class="card">
                                    @foreach($advisor->interviews as $interview)
                                        <div class="card-header bg-theme" style="border-bottom: 2px solid #fff;">
                                            <h2 class="mb-0">
                                            <button class="btn btn-link btn-block text-left text-white" type="button" data-toggle="collapse" data-target="#interview-collapse-{{ $loop->iteration }}" aria-expanded="true" aria-controls="collapse{{ $loop->iteration }}">
                                                {{ $interview->interview_question->question }}
                                            </button>
                                            </h2>
                                        </div>
                                    
                                        <div id="interview-collapse-{{ $loop->iteration }}" class="collapse {{ $loop->iteration == 1 ? 'show' : Null}}" data-parent="#accordion-interviews">
                                            <div class="card-body">
                                                {{ $interview->answer }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif


                    <!-- Minimum savings / pension value -->
                    <div class="mt-5">
                        <h3><strong>Minimum savings / pension value</strong></h3>
                        <p>{{ $advisor->fund_size->name ?? "N/A" }} </p>
                    </div>

                    <!-- Compliance statement -->
                    @if(isset($advisor->compliance) && count($advisor->compliance) > 0 )
                        <div class="mt-5">
                            <h3><strong>Compliance statement</strong></h3>                        
                            @foreach($advisor->compliance as $compliance)
                                <p>{{ $compliance->compliance }}</p>
                            @endforeach
                        </div>
                    @endif

                    <!-- Broad areas of advice offered -->
                    @if($advisor->service_offered($advisor->service_offered_id))
                        <div class="mt-5 mb-5">
                            <h3><strong>Broad areas of advice offered</strong></h3>    
                            <div class="row">            
                                @foreach($advisor->service_offered($advisor->service_offered_id) as $offer)
                                <div class="col-md-4 col-6 mt-3 text-center">
                                    @if( file_exists($offer->image) )
                                        <img src="{{ asset($offer->image) }}" class="mb-1" style="height: 60px;"><br>
                                    @endif
                                    {{ $offer->name }}
                                </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Questions & answers -->
                    @if( count($advisor->approve_public_questions) > 0 )
                        <div class="mt-5">
                            <h3><strong>Case studies</strong></h3>
                            <div class="accordion" id="accordion-questions-answers">
                                <div class="card">
                                    @foreach($advisor->approve_public_questions as $question)
                                        <div class="card-header bg-theme" style="border-bottom: 2px solid #fff;">
                                            <h2 class="mb-0">
                                            <button class="btn btn-link btn-block text-left text-white" type="button" data-toggle="collapse" data-target="#collapse{{ $loop->iteration }}" aria-expanded="true" aria-controls="collapse{{ $loop->iteration }}">
                                                {!! $question->question !!}
                                            </button>
                                            </h2>
                                        </div>
                                    
                                        <div id="collapse{{ $loop->iteration }}" class="collapse" data-parent="#accordion-questions-answers">
                                            <div class="card-body">
                                                {!! $question->answer !!}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Testimonials -->
                    @if( count($advisor->published_testimonials) > 0 )
                        <div class="mt-5 pb-5">
                            <h3><strong>Testimonials</strong></h3>
                            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach($advisor->published_testimonials as $testimonial)
                                        <div class="carousel-item {{ $loop->iteration ==1 ? 'active' : Null }}">
                                            <h4 class="text-center m-0 p-0">{{ $testimonial->name }}</h4>
                                            <h4 class="text-center m-0 p-0">{{ $testimonial->location }}</h4>
                                            <div class="text-left" style="width:65%; margin:0px auto;">
                                                {!! $testimonial->description !!}
                                            </div>
                                        </div>
                                    @endforeach                               
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection