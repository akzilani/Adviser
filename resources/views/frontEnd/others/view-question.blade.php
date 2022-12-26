@extends('frontEnd.masterPage')
@section('title')
    {{ $service_offer->name }} ||
@stop
@section('style')
    <style>
        .service-heading{font-size: 20px; font-weight: bold}
        .question-section{background-size: cover; background-repeat: no-repeat; background-position: center;}
        .question-box{border: 15px solid #2c77b3; border-radius: 20px;}
        .question-section .card{background-color: transparent;}
        .question-section .card-body{background: #fff;border: 10px solid #2c77b3;border-bottom: 20px solid #2c77b3 ; border-radius: 20px;}
        .no-border, .no-border:focus, no-border:active{border: 0px;}
        .active-advisor{ background: #2c77b3; width: 100%; color:#fff; padding-top: 10px;}
        .question-box .card-body{padding: 0px;}
        .question-box .question{padding: 20px 30px;}
        .question-right-box{background: rgba(43, 44, 44, 0.8); margin-bottom: 45px;}
        .question-right-box ol{margin-top: 60px; padding-left: 15px;}
        .question-right-box ol li{color:#fff; font-size: 16px; margin-top:15px;}
        .question-bottom-box{background: rgba(43, 44, 44, 0.8);}
        .banner{margin-top: -50px; background-color: #fff; position: relative;}
        .banner .row{padding:3px;}
    </style>
@stop
@section('mainPart')

    <section class="pb-4 pt-4" style="padding: 13px !important;">
        <div class="container-lg">
            <div class="row justify-content-center">
                <div class="col-12">
                    <p class="text-theme font-13 m-0">SEARCH PREVIOSULY POSTED CASE STUDIES</p>
                    <h3 class="text-theme">Recent case studies</h3>
                </div>
            </div>
        </div>
    </section>

    <section style="padding: 13px !important;background: #fff;">
        <div class="container-lg">
            <div class="row">
                <div class="col-sm-4 select-h-40">
                    <label class="font-weight-bold font-18 text-uppercase"> Search by categories</label>
                    <select class="form-control " id="service-offer" >
                        <option value="">Select Categories</option>
                        @foreach($service_offers as $offer)
                            <option value="{{ $offer->id }}" {{ $service_offer->id == $offer->id ? 'selected' : Null }} >{{ $offer->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </section>

    <!-- Recent Question & Answer -->
    <section style="padding: 13px !important;background: #fff;">
        <div class="container-lg">
            <div class="row">
                <!-- Question list -->
                <div class="col-sm-12 col-md-12" >                    
                    <div class="accordion" id="accordionExample">
                        @if(isset($open_question) && !empty($advisor = $open_question->advisor))
                            <div class="card">
                                <div class="card-header" >
                                    <h2 class="mb-0">
                                        <button  class="btn text-left"  type="button" data-toggle="collapse" data-target="#collapse" aria-expanded="true" aria-controls="collapse">
                                            @if($open_question->visibility == "public")
                                                <a style="text-decoration:none;color:#000 !important;" href="{{ route('advisor_profile',['profession' =>Str::slug($advisor->profession->name ?? 'N-A'), 'location' => str::slug($advisor->town ?? "N-A"), 'name_id' => $advisor->id .'-'.($advisor->first_name . '-' . $advisor->last_name)]) }}" target="_blank" >
                                                        <img src="{{ asset(file_exists($advisor->image) && $advisor->image[strlen($advisor->image)-1] != '/' ? $advisor->image : 'image/dummy_profile.jpg') }}" class="img-fluid rounded-circle img-thumbnail" style="height: 45px; width:45px;">
                                                </a>
                                            @endif
                                          <span style="width:95%;float:right; padding-top:10px;">{{ $open_question->question }}</span> 
                                        </button>
                                    </h2>
                                    <small class="float-right position-absolute" style="top:2px; right:10px;">{{ Carbon\Carbon::parse($open_question->created_at)->format('d-m-y') }}</small>
                                </div>
                        
                                <div id="collapse" class="collapse show" data-parent="#accordionExample">
                                    <div class="card-body" style="padding-left:75px;"> 
                                        {!! $open_question->answer !!}
                                        {{-- <ul class="nav mt-3">
                                            <li class="pr-3"><b>Share </b></li>
                                            <li class="pr-3"><a href="https://www.facebook.com/sharer/sharer.php?u={{ url('/') }}" title="Share with Facebook"><i class="fab fa-facebook fa-2x text-primary"></i></a></li>
                                            <li class="pr-3"><a href="https://twitter.com/intent/tweet?text={{$open_question->question}}&amp;url={{ url('/') }}" title="Share with Twitter"><i class="fab fa-twitter fa-2x text-primary"></i></a></li>
                                            <li class="pr-3"><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{ url('/') }}&amp;title={{$open_question->question}}&amp;summary={{$open_question->answer}}" title="Share with linkedin"><i class="fab fa-linkedin fa-2x text-primary"></i></a></li>
                                        </ul> --}}
                                    </div>
                                </div>
                            </div>
                            
                        @endif
                        @foreach($all_questions as $question)
                            @if( !empty($advisor = $question->advisor) )
                                <div class="card">
                                    <div class="card-header">
                                        <h2 class="mb-0" >                                        
                                            <button style="text-decoration:none; color:black" class="btn btn-link btn-block text-left p-0 pr-5" type="button" data-toggle="collapse" data-target="#collapse{{ $loop->iteration }}" aria-expanded="true" aria-controls="collapse{{ $loop->iteration }}">
                                                @if($question->visibility == "public" && !empty($advisor))
                                                    <a   href="{{ route('advisor_profile',['profession' =>Str::slug($advisor->profession->name ?? 'N-A'), 'location' => str::slug($advisor->town ?? "N-A"), 'name_id' => $advisor->id .'-'.($advisor->first_name . '-' . $advisor->last_name)]) }}" target="_blank" >
                                                        <!--<img src="{{ asset(file_exists($advisor->image) ? $advisor->image : "image/dummy_user.jpg") }}" class="img-fluid rounded-circle mr-1 img-thumbnail" style="height: 45px;width:45px">-->
                                                        <img src="{{ asset(file_exists($advisor->image) && $advisor->image[strlen($advisor->image)-1] != '/' ? $advisor->image : 'image/dummy_profile.jpg') }}" class="img-fluid rounded-circle img-thumbnail" style="height: 45px; width:45px;">
                                                    </a>
                                                @endif
                                                
                                                <span style="width:95%;float:right;padding-top:10px;">{{ $question->question }}</span>
                                            
                                            
                                            </button>
                                        </h2>
                                        <small class="float-right position-absolute" style="top:2px; right:10px;">{{ Carbon\Carbon::parse($question->created_at)->format('d-M-Y') }}</small>
                                    </div>
                            
                                    <div id="collapse{{ $loop->iteration }}" class="collapse {{ !isset($open_question) && $loop->iteration == 1 ? 'show' : Null }}" data-parent="#accordionExample">
                                        <div class="card-body"style="padding-left:75px;"> 
                                            {!! $question->answer !!}

                                            {{-- <ul class="nav mt-3">
                                                <li class="pr-3"><b>Share </b></li>
                                                <li class="pr-3"><a href="https://www.facebook.com/sharer/sharer.php?u={{ url('/') }}" title="Share with Facebook"><i class="fab fa-facebook fa-2x text-primary"></i></a></li>
                                                <li class="pr-3"><a href="https://twitter.com/intent/tweet?text={{$question->question}}&amp;url={{ url('/') }}" title="Share with Twitter"><i class="fab fa-twitter fa-2x text-primary"></i></a></li>
                                                <li class="pr-3"><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{ url('/') }}&amp;title={{$question->question}}&amp;summary={{$question->answer}}" title="Share with linkedin"><i class="fab fa-linkedin fa-2x text-primary"></i></a></li>
                                            </ul> --}}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>  
                    <div class="mt-5 mb-5">
                        {!! $all_questions->links() !!}
                    </div>                  
                </div>
                
                <!-- Ask Now Question Box 
                <div class="col-sm-12 col-md-5">
                    <div class="question-box">
                        <div class="card" style="border: 0px; ">
                            <div class="card-headder bg-theme pb-3">
                                <div class="row">
                                    <div class="col-5 text-white pl-5">
                                        <b>Quick Response</b>
                                    </div>
                                    <div class="col-1 text-center text-white">
                                        <b>|</b>
                                    </div>
                                    <div class="col-6 text-right text-white pr-5">
                                        <b>100% Confidential</b>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" >
                                @if($errors->first())
                                    <div class="container mt-4">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="alert alert-danger">
                                                    {{ $errors->first() }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <form class="container question" action="{{ route('quick_question') }}" method="post">
                                    @csrf                                    
                                    <div class="row question-part-1">
                                        <div class="col-12 p-0">
                                            <textarea name="question" id="question" class="form-control" minlength="5" placeholder="Type Your Question" style="min-height: 250px;" required >{{ old('question') }}</textarea>
                                        </div>
                                        <div class="col-12 text-center mt-3">
                                            <button class="btn btn-success no-radius"  id="ask-now" type="button">Ask Now</button>
                                        </div>
                                    </div>
                                    <div class="row question-part-2 d-none">
                                        <div class="col-6">
                                            <input name="first_name" value="{{ old('first_name') }}" class="form-control" minlength="2" placeholder="First Name" required >
                                        </div>
                                        <div class="col-6">
                                            <input name="last_name" value="{{ old('last_name') }}" class="form-control" placeholder="Last Name">
                                        </div>
                                        <div class="col-12 mt-3">
                                            <input type="text" name="phone" value="{{ old('phone') }}" class="form-control" minlength="9" maxlength="13" placeholder="Telephone" required >
                                        </div>
                                        <div class="col-12 mt-3">
                                            <input type="text" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email" required minlength="4">
                                        </div>
                                        <div class="col-12 mt-3">
                                            <input type="text" name="post_code" value="{{ old('post_code') }}" class="form-control" placeholder="Postcode" required minlength="4" maxlength="8">
                                        </div>
                                        <div class="col-12 text-center mt-3">
                                            <button class="btn btn-success no-radius" id="question-submit" type="submit"> >> Select My Advisor >> </button>
                                            <input type="hidden" id="mortgage_only" name="mortgage_only" value="0">
                                        </div>
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-12 text-right font-14">
                                        <div class="active-advisor pt-2">
                                            <i aria-hidden="true" class="fa fa-circle text-success"></i>
                                            {{ $active_advisor }} active advisors
                                        </div>                                    
                                    </div>
                                </div>                              
                            </div>
                        </div>
                    </div>
                    <div class="p-0">
                        <div class="question-bottom-box text-white ml-0 ml-md-3 mr-0 mr-md-3 p-4 mb-3">
                            <i class="fas fa-lock text-success"></i> <strong>GDPR Compliant.</strong>
                            Please view our <a href="{{ route('privacy_policy') }}" target="_blank">Privacy Policy</a> <br/>
                            By submitting your details, you agree to be connected with a Financial Advisor
                            <br/>
                            <b>Disclaimer:</b> {!! $disclaimer ?? "" !!} 
                        </div>
                    </div>
                </div>
                -->
            </div>
        
            <div class="row">
                <div class="col-sm-12 col-md-12" >
                    <b>DISCLAIMER</b> {!! $disclaimer ?? "" !!} 
                </div>
            </div>
            
        </div>
    </section>
@endsection
@section("script")
    <script>
        $('#ask-now').click(function(){
            if($('#question').val().length >= 5){
                $(".question-part-1").addClass("d-none");
                $(".question-part-2").removeClass("d-none");
            }else{
                $("#question-submit").click();
            }
        });

        $(document).on('change', '#all_advisor', function(){
            if( $(this).prop("checked") ){
                $('#mortgage_only').val(1);
            }else{
                $('#mortgage_only').val(0);
            }
        });

        $('#service-offer').change(function(){
            var url = "{{ route('service_view_all_questions',['id','name']) }}";
            url= url.replace("id", $(this).val());
            url = url.replace("name", $(this).find(":selected").text() );
            window.location.href = url;
        });
    </script>
    
@endsection