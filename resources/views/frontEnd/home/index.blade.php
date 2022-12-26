@extends('frontEnd.masterPage')
@section('style')
    <style>
        .service-heading{font-size: 20px; font-weight: bold}
        .question-section{background-size: cover; background-repeat: no-repeat; background-position: center;}
        .question-box{background: #2c77b3; border-radius: 29px;}
        .question-section .card{background-color: transparent;}
        .question-section .card-body{background: #fff; border: 10px solid #2c77b3; border-bottom: 20px solid #2c77b3 ; border-radius: 22px;}
        .no-border, .no-border:focus, no-border:active{border: 0px;}
        .active-advisor{ background: #2c77b3; width: 100%; color:#fff; padding-top: 10px;}
        .question-box .card-body{padding: 0px; }
        .question-box .question{padding: 5px 30px 20px 30px;}
        .question-box .question .form-control{ background: #fff;}
        .question-right-box{background: rgba(43, 44, 44, 0.85); margin-bottom: 45px; border-top-right-radius: 40px;border-bottom-right-radius: 40px;}
        .question-right-box ol{margin-top: 15px; padding-left: 15px;}
        .question-right-box ol li{color:#fff; font-size: 16px; margin-top:15px;}
        .question-bottom-box{background: rgba(43, 44, 44, 0.85); border-bottom-left-radius: 40px; border-bottom-right-radius: 40px;}
        .banner{margin-top: -25px; background-color: #fff; position: relative;}
        .banner .row{padding:30px;}
        .owl-nav .owl-prev{position: absolute; left: -35px; top:170px; }
        .owl-nav .owl-next{position: absolute; right: -35px;top:170px; }
        .owl-nav.disabled { display: block !important; }
        .ask-now{ color:#FFFFFF; font-weight: bold; padding:10px 40px; width: 100%; height: 75px;font-size: 24px;  background-color:rgb(245, 122, 5); transition: all .5s; border: 3px solid #ffffff;}
        .ask-now_2{ color:#FFFFFF; font-weight: bold; padding:10px 40px; width: 100%; height: 75px;font-size: 24px;  background-color:rgb(245, 122, 5); transition: all .5s; border: 3px solid #ffffff;}
        .ask-now:hover, #question-submit:hover{ background-color: #2ECC71 !important; color:#fff;}
        #question-submit{color:#FDFEFE; font-weight: bold; font-size:24px; width: 358px; height: 71px; background-color:#2ECC71; transition: all .2s; border: 2px solid #ffffff;}
        #question-submit:hover{background-color:rgb(245, 122, 5);}
        .ask-now_2:hover, #question-submit:hover{ background-color: #2ECC71 !important; color:#fff;}
        #question-submit{color:#FDFEFE; font-weight: bold; font-size:24px; width: 358px; height: 71px; background-color:#2ECC71; transition: all .2s; border: 2px solid #ffffff;}
        .ask-now-progress .progress{height: .5rem;}
        .card-headder .slider{left: 0px;}
        .card-headder .active-advisor{padding-top: 0px; background: none;}
        .number_counter{color:#F96E4E;}
        .font-50{font-size: 50px;}
        .right-border{border-right: 2px solid #aaa;}
        p{line-height: 22px;}
        .question-section .heading_text, question-section .heading_text h1, .heading_text h2, .heading_text *{line-height: 0px; font-size:42px;}
        .blog-card{height: 420px;}

        /*@media only screen and (max-width: 320px){*/
        /*.ask-now, #question-submit{width: 100%;height:55px; font-size: 21px; padding: 10px;}*/
        /*.question-box{width: 90%;margin-left: 15px;margin-bottom:0px;}*/

        /*.quick-response{margin-left:-1.3em;}*/
        /*.quick-response b{font-size: 10px}*/
        /*.question-box .question .form-control{ font-size:13px;}*/

        /*}*/
        /*@media only screen and (max-width: 600px){*/
        /*    .ask-now, #question-submit{width: 100%; font-size: 18px; padding: 0px;}*/
        /*    .question-box{width: 91%;margin-left: 15px;margin-bottom:0px;}*/

        /*    .quick-response{margin-left:-1.5em;}*/



        /*}*/
        /*@media only screen and (max-width: 767px){*/
        /*    .question-right-box, .question-bottom-box{border-radius: 0px;}*/
        /*    .question-section .heading_text, .heading_text h1, .heading_text h2, .heading_text h3{text-align: center; line-height:45px;}  */
        /*    .question-section{background-image:unset !important; }*/
        /*    .blog-card{height: 350px;}*/
        /*}*/

         @media only screen and (max-width: 2700px){
        .question-right-box, .question-bottom-box{border-radius: 0px;}
        .question-section .heading_text, .heading_text h1, .heading_text h2, .heading_text h3{text-align: center; line-height:45px;}
        .blog-card{height: 350px;}
        .question-box{width: 90%;margin-left: 110px;margin-bottom:7em;}
        .question-right-box{border-top-right-radius: 40px;border-bottom-right-radius: 40px;margin-bottom: 11rem}
        .heading_text_2{ display:block;font-size:28px;padding-top: 1rem;margin-left:23px;}
        }
         @media only screen and (max-width: 1600px){
        .question-right-box, .question-bottom-box{border-radius: 0px;}
        .question-section .heading_text, .heading_text h1, .heading_text h2, .heading_text h3{text-align: center; line-height:45px;}
        .blog-card{height: 350px;}
        .question-box{width: 90%;margin-left: 110px;margin-bottom:7em;}
        .question-right-box{border-top-right-radius: 40px;border-bottom-right-radius: 40px;margin-bottom: 11rem}
        .heading_text_2{ display:block;font-size:28px;padding-top: 1rem;margin-left:23px;}
        .question-part-3{ padding-top: 30px;}
        }

        /* @media only screen and (max-width: 2000px){*/

        /*.question-right-box, .question-bottom-box{border-radius: 0px;}*/
        /*.question-section .heading_text, .heading_text h1, .heading_text h2, .heading_text h3{text-align: center; line-height:45px;}*/
        /*.blog-card{height: 350px;}*/
        /*.question-box{width: 90%;margin-left: 110px;margin-bottom:7em;}*/
        /*.question-right-box{border-top-right-radius: 40px;border-bottom-right-radius: 40px;margin-bottom: 11rem}*/
        /*.heading_text_2{ display:block;font-size:38px;margin-bottom: 8px; padding-top: 1.5rem;margin-left: 20px;}*/
        /*}*/

        @media only screen and (max-width: 992px){
        .question-right-box, .question-bottom-box{border-radius: 0px;}
        .question-section .heading_text, .heading_text h1, .heading_text h2, .heading_text h3{text-align: center; line-height:45px;}
        .blog-card{height: 350px;}
        .question-box{width: 90%;margin-left: 40px;margin-bottom:7em;}
        .question-right-box{border-top-right-radius: 40px;border-bottom-right-radius: 40px;margin-bottom: 11rem}
        .heading_text_2{font-size:28px;}
        }

        @media only screen and (max-width: 767px){
        .question-right-box, .question-bottom-box{border-radius: 0px;}
        .question-section .heading_text, .heading_text h1, .heading_text h2, .heading_text h3{text-align: center; line-height:45px;}
        .blog-card{height: 350px;}
        .question-box{width: 90%;margin-left: 0px;margin-bottom:0em;}
        .heading_text_2{font-size:28px;margin: auto;text-align: center}
        .question-right-box{margin-bottom: 11rem}
        .question-section{background-image:unset !important; }
        }

        @media only screen and (max-width: 600px){
        .ask-now, #question-submit{width: 100%;height:55px; font-size: 21px; padding: 10px;}
        .ask-now_2, #question-submit{width: 100%;height:55px; font-size: 17px; padding: 10px;}
        .question-box{width: 100%;margin-left: 0px;margin-bottom:0em;}
        .quick-response{margin-left:-1.3em;}
        .quick-response b{font-size: 10px}
        .question-box .question .form-control{ font-size:13px;}
        .heading_text_2{display:block;text-align:center;font-size:28px;padding-top: 0rem;margin:auto;}
        .question-section{background-image:unset !important; }
        .question-right-box{margin-bottom: 3rem}
        .question-part-3{ padding-top: 50px;}
        .question_p_2{padding-bottom: 50px}
        }

        @media only screen and (max-width: 320px){
        .ask-now, #question-submit{width: 100%;height:55px; font-size: 13px; padding: 10px;}
        .ask-now_2, #question-submit{width: 100%;height:55px; font-size: 13px; padding: 10px;}
        .question-box{width: 100%;margin-left: 0px;margin-bottom:0em;}
        .quick-response{margin-left:-1.3em;}
        .quick-response b{font-size: 10px}
        .question-box .question .form-control{ font-size:13px;}
        /*.heading_text_2{display:block;text-align:center;font-size:28px;padding-top: 0rem; padding-top: 0rem;margin-bottom: 0px;color: #000000;letter-spacing:0.5px;}*/
        .heading_text_2{display:block;text-align:center;font-size:20px;padding-top: 0rem; padding-top: 0rem;margin-bottom: 0px;color: #000000}
        .question-section{background-image:unset !important; }
        .question_p_2{padding: 0px}
        .question-part-3{ padding-top: 90px;}
        }
    </style>
@endsection

@section('mainPart')

    <!-- Ask Question Here -->
    <section class="question-section pt-2 pb-2 col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12" style="background-image: url('{{ asset( isset($page->cover_image) && file_exists($page->cover_image) ? $page->cover_image : 'image/regmainimage.jpg') }}')">
        <div class="container-lg">
            <div class="row">
                <div class="col-12 offset-md-1">
                    <div class="col-12"  >
                        <!--{!! $page->heading_text ?? "Your Financial Questions Answered" !!}-->
                        <!--<strong class=" heading_text_2">Your Financial Questions Answered</strong>-->
                        <span class="heading_text_2">{!! $page->heading_text ?? "Your Financial Questions Answered" !!}</span>
                    </div>
                </div>
                <div class="col-sm-12 col-md-7 col-lg-5 offset-md-1 question-box" style="margin-top: 25px !important;  padding-right: 8px !important; padding-left: 8px !important;">
                    <div class="">
                        <div class="card" style="border: 0px; ">
                            <div class="card-headder pt-2 pb-1">
                                <div class="row">
                                    <div class="col-5 text-white quick-response pl-5 pt-2" >
                                        <b>Quick Response</b>
                                    </div>
                                    <div class="col-1 text-center text-white  pt-2" >
                                        <b>|</b>
                                    </div>
                                    <div class="col-6 text-center text-white active-advisor pr-3 pl-0 mt-2">
                                        {{-- <b>100% Confidential</b> --}}
                                        <div class="row font-14">
                                            <div class="col-3 p-0 font-13"> All </div>
                                            <div class="col-3 p-0 font-13 text-center">
                                                <label class="switch">
                                                    <input type="checkbox" id="all_advisor">
                                                    <span class="slider round" style="background-color:#FFCD7F"></span>

                                                </label>
                                            </div>
                                            <div class="col-6 p-0 font-12">Mortgage only</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" >
                               <!-- @if($errors->first())
                                    <div class="container mt-4">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="alert alert-danger">
                                                    {{ $errors->first() }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif -->
                                <!--<form class="container question" action="{{ route('quick_question') }}" method="post">-->
                                <!--    @csrf -->
                                <!--    <div class="row mb-2 ask-now-progress">-->
                                <!--        <div class="col-12 p-0">-->
                                <!--            <span class="progress-text" style="font-weight: bold;">0%</span>-->
                                <!--            <div class="progress">-->
                                <!--                <div class="progress-bar" role="progressbar" style="width: 2%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>-->
                                <!--            </div>-->
                                <!--            <div class="text-right font-13" >-->
                                <!--                Find your ideal financial advisor-->
                                <!--            </div> -->
                                <!--        </div>-->
                                <!--    </div>                                  -->
                                <!--    <div class="row question-part-1">-->
                                <!--        <div class="col-12 p-0 ">-->
                                <!--            <textarea name="question" id="question" class="form-control" minlength="5" placeholder="Ask your question or describe your issue here..." style="min-height: 150px;" required >{{ old('question') }}</textarea>-->
                                <!--        </div>-->
                                <!--        <div class="col-12 p-0 mt-2">-->
                                <!--            <select name="service_offer_id" id="service_offer_id" required class="form-control" oninvalid="this.setCustomValidity('Please select an item from the list')">-->
                                <!--                <option value="" >Areas of advice</option>-->
                                <!--                @foreach($service_offers as $service_offer)-->
                                <!--                <option value="{{ $service_offer->id }}" {{ old("service_offer_id") == $service_offer->id ? "selected" : null }} >{{ $service_offer->name }}</option>-->
                                <!--                @endforeach-->
                                <!--            </select>-->
                                <!--        </div>-->

                                <!--        <div class="col-12 mt-3 p-0">-->
                                <!--            <button class="btn no-radius ask-now" id="ask-now" type="button" style="background-color:#F96E4E">-->
                                <!--                Ask now-->
                                <!--            </button>-->
                                <!--        </div>-->
                                <!--    </div>-->
                                <!--    <div class="row question-part-2 d-none ">-->
                                <!--         First Name -->
                                <!--        <div class="col-12 p-0 mt-2">-->
                                <!--            <input name="first_name" id="first_name" value="{{ old('first_name') }}" class="form-control" minlength="2" placeholder="First name" required oninvalid="this.setCustomValidity('First name is required')">-->
                                <!--            @error("first_name")-->
                                <!--                <div class="text-danger">{{$message}}</div>-->
                                <!--            @enderror-->
                                <!--        </div>-->

                                <!--         Last Name -->
                                <!--        <div class="col-12 p-0 mt-2">-->
                                <!--            <input name="last_name" value="{{ old('last_name') }}" class="form-control" placeholder="Last name" required oninvalid="this.setCustomValidity('Lase name is required')">-->
                                <!--        </div>-->

                                <!--         Email -->
                                <!--        <div class="col-12 p-0 mt-2">-->
                                <!--            <div class="input-group">-->
                                <!--                {{-- <span class="input-group-text"><i class="far fa-envelope"></i></span> --}}-->
                                <!--                <input type="text" name="email" id="email" value="{{ old('email') }}" class="form-control verify" data-verify_type="email" data-page="home" placeholder="Email address" required minlength="4" oninvalid="this.setCustomValidity('Email is required')">-->
                                <!--            </div>-->
                                <!--            @error("email")-->
                                <!--                <div class="text-danger">{{$message}}</div>-->
                                <!--            @enderror-->
                                <!--        </div>-->

                                <!--         Phone No -->
                                <!--        <div class="col-12 p-0 mt-2">-->
                                <!--            <div class="input-group">-->
                                <!--                {{-- <span class="input-group-text"><i class="fas fa-phone-alt"></i></span> --}}-->
                                <!--                <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="form-control verify" data-verify_type="phone" data-page="home"  minlength="9" maxlength="15" placeholder="Telephone number" required oninvalid="this.setCustomValidity('Phone number is required')"> -->
                                <!--                <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="form-control verify" data-verify_type="phone" data-page="home"  placeholder="Telephone number">-->
                                <!--            </div>-->
                                <!--            @error("phone")-->
                                <!--                <div class="text-danger">{{$message}}</div>-->
                                <!--            @enderror-->
                                <!--        </div>-->

                                <!--         Postcode -->
                                <!--        <div class="col-12 p-0 mt-2">-->
                                <!--            <input type="text" name="post_code"value="{{ old('post_code') }}" id="post_code" class="form-control verify" data-verify_type="postcode" data-page="home"  placeholder="Enter full postcode" required minlength="4" maxlength="8" oninvalid="this.setCustomValidity('Postcode is required')">-->
                                <!--            <input type="text" name="post_code"value="{{ old('post_code') }}" id="post_code" class="form-control verify" data-verify_type="postcode" data-page="home"  placeholder="Enter full postcode">-->
                                <!--            @error("post_code")-->
                                <!--                <div class="text-danger">{{$message}}</div>-->
                                <!--            @enderror-->
                                <!--        </div>-->

                                <!--         Fund Size -->
                                <!--        <div class="col-12 p-0 mt-2">-->
                                <!--            <select name="fund_size_id" id="fund_size_id" class="form-control" required oninvalid="this.setCustomValidity('Fund size is required')">-->
                                <!--            <select name="fund_size_id" id="fund_size_id" class="form-control">-->
                                <!--                <option value="">Your fund / mortgage value</option>-->
                                <!--                @foreach ($fund_sizes as $fund_size)-->
                                <!--                <option value="{{ $fund_size->id }}" {{ old('fund_size_id') == $fund_size->id }}>{{ $fund_size->name }} </option>-->
                                <!--                @endforeach-->
                                <!--            </select>-->
                                <!--            @error("fund_size_id")-->
                                <!--                <div class="text-danger">{{$message}}</div>-->
                                <!--            @enderror-->
                                <!--        </div>-->

                                <!--        <div class="col-12 text-center mt-3 question_p_2">-->
                                <!--            <button class="btn no-radius" id="question-submit" type="submit" style="background-color:#F96E4E">-->
                                <!--                >> Find local advisor-->
                                <!--            </button>-->
                                <!--            <input type="hidden" id="mortgage_only" name="mortgage_only" value="0">-->
                                <!--        </div>-->
                                <!--    </div>-->

                                <!--</form>-->

                                <!--editing part start-->
                                <form class="container question" action="{{ route('quick_question') }}" method="post">
                                    @csrf
                                    <div class="row mb-2 ask-now-progress">
                                        <div class="col-12 p-0">
                                            <span class="progress-text" style="font-weight: bold;">0%</span>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: 2%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="text-right font-13">
                                                Find your ideal financial advisor
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row question-part-1">
                                        <div class="col-12 p-0 ">
                                            <textarea name="question" id="question" class="form-control" minlength="5" placeholder="Ask your question or describe your issue here..." style="min-height: 150px;" required >{{ old('question') }}</textarea>
                                        </div>
                                        <div class="col-12 p-0 mt-2">
                                            <select name="service_offer_id" id="service_offer_id" required class="form-control" oninvalid="this.setCustomValidity('Please select an item from the list')">
                                                <option value="" >Areas of advice</option>
                                                @foreach($service_offers as $service_offer)
                                                <option value="{{ $service_offer->id }}" {{ old("service_offer_id") == $service_offer->id ? "selected" : null }} >{{ $service_offer->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-12 mt-3 p-0">
                                            <button class="btn no-radius ask-now" id="ask-now" type="button" style="background-color:#F96E4E">
                                               Find local advisor
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row question-part-2 d-none ">
                                        <!-- First Name -->
                                        <div class="col-12 p-0 mt-2">
                                            <input name="first_name" id="first_name" value="{{ old('first_name') }}" class="form-control" minlength="2" placeholder="First name" required oninvalid="this.setCustomValidity('First name is required')">
                                            @error("first_name")
                                                <div class="text-danger">{{$message}}</div>
                                            @enderror
                                        </div>

                                        <!-- Last Name -->
                                        <div class="col-12 p-0 mt-2">
                                            <input name="last_name" value="{{ old('last_name') }}" class="form-control" placeholder="Last name" required oninvalid="this.setCustomValidity('Lase name is required')">
                                        </div>

                                        <!-- Email -->
                                        <div class="col-12 p-0 mt-2">
                                            <div class="input-group">
                                                {{-- <span class="input-group-text"><i class="far fa-envelope"></i></span> --}}
                                                <input type="text" name="email" id="email" value="{{ old('email') }}" class="form-control verify" data-verify_type="email" data-page="home" placeholder="Email address" required minlength="4" oninvalid="this.setCustomValidity('Email is required')">
                                            </div>
                                            @error("email")
                                                <div class="text-danger">{{$message}}</div>
                                            @enderror
                                        </div>

                                        <!-- Phone No -->
                                        <div class="col-12 p-0 mt-2">
                                            <div class="input-group">
                                                {{-- <span class="input-group-text"><i class="fas fa-phone-alt"></i></span> --}}
                                                <!--<input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="form-control verify" data-verify_type="phone" data-page="home"  minlength="9" maxlength="15" placeholder="Telephone number" required oninvalid="this.setCustomValidity('Phone number is required')"> -->
                                                <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="form-control verify" data-verify_type="phone" data-page="home"  placeholder="Telephone number">
                                            </div>
                                            @error("phone")
                                                <div class="text-danger">{{$message}}</div>
                                            @enderror
                                        </div>

                                        <!-- Postcode -->
                                        {{-- <div class="col-12 p-0 mt-2">
                                            <input type="text" name="post_code"value="{{ old('post_code') }}" id="post_code" class="form-control verify" data-verify_type="postcode" data-page="home"  placeholder="Enter full postcode">
                                            @error("post_code")
                                                <div class="text-danger">{{$message}}</div>
                                            @enderror
                                        </div> --}}

                                        <!-- Fund Size -->
                                        {{-- <div class="col-12 p-0 mt-2">
                                            <select name="fund_size_id" id="fund_size_id" class="form-control">
                                                <option value="">Your fund / mortgage value</option>
                                                @foreach ($fund_sizes as $fund_size)
                                                <option value="{{ $fund_size->id }}" {{ old('fund_size_id') == $fund_size->id }}>{{ $fund_size->name }} </option>
                                                @endforeach
                                            </select>
                                            @error("fund_size_id")
                                                <div class="text-danger">{{$message}}</div>
                                            @enderror
                                        </div> --}}

                                        {{-- <div class="col-12 text-center mt-3 question_p_2">
                                            <button class="btn no-radius" id="question-submit" type="submit" style="background-color:#F96E4E">
                                                >> Find local advisor
                                            </button>
                                            <input type="hidden" id="mortgage_only" name="mortgage_only" value="0">
                                        </div> --}}
                                        <div class="col-12 mt-3 p-0">
                                            <button class="btn no-radius ask-now_2" id="ask-now_2" type="button" style="background-color:#F96E4E">
                                              Match me to my advisor
                                            </button>
                                        </div>
                                    </div>

                                    <div class="row question-part-3 d-none ">

                                        <!-- Postcode -->
                                        <div class="col-12 p-0 mt-2">
                                            <input type="text" name="post_code"value="{{ old('post_code') }}" id="post_code" class="form-control verify" data-verify_type="postcode" data-page="home"  placeholder="Enter full postcode">
                                            @error("post_code")
                                                <div class="text-danger">{{$message}}</div>
                                            @enderror
                                        </div>

                                        <!-- Fund Size -->
                                        <div class="col-12 p-0 mt-2">
                                            <select name="fund_size_id" id="fund_size_id" class="form-control">
                                                <option value="">Your fund / mortgage value</option>
                                                @foreach ($fund_sizes as $fund_size)
                                                <option value="{{ $fund_size->id }}" {{ old('fund_size_id') == $fund_size->id }}>{{ $fund_size->name }} </option>
                                                @endforeach
                                            </select>
                                            @error("fund_size_id")
                                                <div class="text-danger">{{$message}}</div>
                                            @enderror
                                        </div>

                                        <div class="col-12 text-center mt-3 question_p_2">
                                            <button class="btn no-radius" id="question-submit" type="submit" style="background-color:#F96E4E">
                                                Complete
                                            </button>
                                            <input type="hidden" id="mortgage_only" name="mortgage_only" value="0">
                                        </div>
                                    </div>
                                </form>
                                <!--edditing part end-->


                                <div class="row">
                                    {{-- <div class="col-8 col-sm-7 active-advisor">
                                        <div class="row font-14">
                                            <div class="col-7 p-0 font-13">
                                                All advisors
                                                <label class="switch">
                                                    <input type="checkbox" id="all_advisor">
                                                    <span class="slider round font-14"></span>
                                                </label>
                                            </div>
                                            <span class="col-5 font-13 p-0">Mortgage only</span>
                                        </div>
                                    </div> --}}
                                    <div class="col-12 active-advisor text-right font-13">
                                        <i aria-hidden="true" class="fa fa-circle text-success"></i>
                                        <input type="hidden" id="all_active_advisor" value="{{ $active_advisor }}">
                                        <input type="hidden" id="all_mortgage_advisor" value="{{ $total_mortgage_advisor }}">
                                        <span id="active-advisor">{{ $active_advisor }}</span> active advisors
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-3 ml-0 question-right-box mt-5 mt-md-5 mt-md-5">
                    <ol>
                        <li><b>Ask Your Question</b></li>
                        <li><b>Enter Your Contact Details</b> <br/> A financial advisor usually responds in minutes.</li>
                        <li><b>Select Your Local Expert</b> <br/> Refine your search using our unique Match Rating ™ tool or simply let us match you.
                        <br> </br>
                        <b><i class="fas fa-lock text-success"></i> <strong>GDPR Compliant.</strong></b> <br/> Please view our <a href="{{ route('privacy_policy') }}" target="_blank">Privacy Policy</a> <br>
                        By submitting your details, you agree to be connected with a financial advisor. </li>
                    </ol>
                </div>
                <!--<div class="col-sm-12 col-md-7 col-lg-5 offset-md-1 p-0 mb-2">
                    <div class="question-bottom-box text-white ml-0 ml-md-3 mr-0 mr-md-3 p-4 mb-5">
                        <i class="fas fa-lock text-success"></i> <strong>GDPR Compliant.</strong>
                        Please view our <a href="{{ route('privacy_policy') }}" target="_blank">Privacy Policy</a> <br>
                        By submitting your details, you agree to be connected with a Financial Advisor.

                    </div>
                </div> -->
            </div>
        </div>
    </section>

    <!-- Ekomi -->
    <div class="container-lg banner" style="margin-top:-60px !important">
        <div class="row">
            <div class="col-md-2 text-center">
                <a href="https://www.ekomi.co.uk/review-regulatedadvicecouk.html">
                    <img src="{{ asset('/image/ekomi-single.png') }}" class="img-fluid">
                </a>
            </div>
            <div class="col-md-10 widgetreview">
                <div id="widget-container" class="ekomi-widget-container ekomi-widget-sf957305c54637c4cb89"></div>
            </div>
        </div>
    </div>

    <!-- Services -->
    <section class="pb-4 pt-4">
        <div class="container-lg">
            <div class="row justify-content-center">
                <div class="col-12" style="text-align:center !important">
                    <p class="text-theme font-13 m-0">SEARCH PREVIOSULY POSTED CASE STUDIES</p>
                    <h3 class="text-theme">Recent case studies</h3>
                </div>
                <div class="col-12">
                    <div id="accordion">
                        @foreach($service_offers as $offer)
                            <div class="card mt-1">
                                <div class="card-header bg-theme" >
                                    <div class="row">
                                        <div class="col-sm-7 col-12">
                                            {{-- <h3 class="text-white">
                                                {{-- <button class="btn btn-link text-white font-24 p-0" data-toggle="collapse" data-target="#collapse{{$offer->id}}" aria-expanded="true" aria-controls="collapse{{$offer->id}}">{{ $offer->name }}</button> --}}
                                                {{-- {{ $offer->name }}
                                            </h3> --}}
                                            <a href="javascript::;" class="btn-link text-white" data-toggle="collapse" data-target="#collapse{{$offer->id}}" aria-expanded="true" aria-controls="collapse{{$offer->id}}">
                                                <p class="text-white mb-0 font-18">{{ $offer->name }}</p>
                                            </a>
                                        </div>
                                        <div class="col-sm-4 col-11 font-12 text-right d-none d-sm-block">{{ $offer->ans_questions->count() }} case studies</div>
                                        <div class="col-sm-4 col-10 font-12 d-sm-none">{{ $offer->ans_questions->count() }} case studies</div>
                                        <div class="col-sm-1 col-1 text-right">
                                            <button class="btn btn-link text-white font-20 p-0" data-toggle="collapse" data-target="#collapse{{$offer->id}}" aria-expanded="true" aria-controls="collapse{{$offer->id}}">+</button>
                                        </div>
                                    </div>
                                </div>

                                <div id="collapse{{$offer->id}}" class="collapse" data-parent="#accordion">
                                    <div class="card-body row">
                                        <div class="col-12 col-md-12">
                                            <div class="row">
                                                <div class="col-1">
                                                    <img src="{{ asset($offer->image ?? "image/not-found.png") }}" height="75px" width="75px" class="img-fluid">
                                                </div>
                                                <div class="col-11  font-14">
                                                    <a href="{{ route('service_view_all_questions',['id' => $offer->id, 'service' => Str::slug($offer->name)]) }}" class="btn-link">
                                                        <h3 class="text-theme mb-0">{{ $offer->name }}</h3>
                                                    </a>
                                                    <p class="font-weight-bold font-14">
                                                        {{ $offer->description }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        @foreach($offer->ans_questions as $question)
                                            <div class="col-12 col-md-12">
                                                <div class="bg-light p-2 mt-2">
                                                    <a href="{{ route('service_view_question',['question_id' => $question->id, 'service' => Str::slug($offer->name)]) }}" >{{ $question->question}}</a> <small class="float-right">{{ Carbon\Carbon::parse($question->created_at)->format($system->date_format) }}</small>
                                                </div>
                                            </div>
                                            @if($loop->iteration >= 25)
                                                @break
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Advisor List -->
    <section class="pb-4 pt-4" >
        <div class="container-lg">
            <div class="row">
                <div class="col-12" style="text-align:center !important">
                    <!--<p class="text-theme font-13 m-0">QUICK LINK TO SOME OF THE UK’S MOST TRUSTED ADVISOR</p>-->
                    <p class="text-theme font-13 m-0">QUICK LINK TO SOME OF THE UK’S MOST TRUSTED ADVISORS</p>
                    <h3 class="text-theme">Meet some of Regulated Advice biggest contributors</h3>
                </div>
                @if( count($advisors) > 0 )
                    <div class="col-12" id="advisor-owl-carousel" >
                        <!-- Set up your HTML -->
                        <div class="owl-carousel">
                            @foreach($advisors as $advisor)
                                <div class="bg-theme text-center p-3" style="height: 375px;overflow: hidden;">
                                    <center>
                                        <img src="{{ asset(isset($advisor->image) && file_exists($advisor->image) ? $advisor->image : 'image/dummy_user.jpg') }}" class="img-fluid rounded-circle img-thumbnail" style="height: 120px; width:120px">
                                    </center>
                                    <h4 class="mt-3 text-white">
                                        <a href="{{ route('advisor_profile',['profession' =>Str::slug($advisor->profession->name ?? 'N-A'), 'location' => str::slug($advisor->town ?? "N-A"), 'name_id' => $advisor->id .'-'.($advisor->first_name . '-' . $advisor->last_name)]) }}" target="_blank">
                                            {{$advisor->first_name }} {{$advisor->last_name }}
                                        </a>
                                    </h4>
                                    <h4 class="mt-3">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $advisor->non_specific_rating)
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
                                        <p class="p-0 m-0 font-12 line-heigh-14"> {{  ($advisor->testimonial->count() + $advisor->advisor_questions->count()) }} Testimonials & Case Studies Posted</p>
                                    @endif
                                    <a href="{{ route('advisor_profile',['profession' =>Str::slug($advisor->profession->name ?? 'N-A'), 'location' => str::slug($advisor->town ?? "N-A"), 'name_id' => $advisor->id .'-'.($advisor->first_name . '-' . $advisor->last_name)]) }}" target="_blank" class="btn btn-success mt-4 no-radius" >Contact {{ $advisor->first_name }}</a>
                                    {{-- <a href="{{ route('contact_advisor',[$advisor->id]) }}" class="btn btn-md mt-4 no-radius" style="background-color:#2ECC71;color:#FDFEFE;font-size:15px;">Email {{ $advisor->first_name }}</a>                                     --}}
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!--We Give you -->
    <section class="pb-4 pt-4" id="number_counter">
        <div class="container-lg">
            <div class="row">
                <div class="col-12" style="text-align:center !important">
                    <p class="text-theme font-13 m-0">OUR CURRENT STATUS</p>
                    <h3 class="text-theme">We give you...</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-12 row">
                    <div class="col-6 col-md-3 text-center right-border">
                        <h3 class="p-0 m-0 number_counter font-50" style="color:#000000 !important" count="{{ $total_advisor ?? 0 }}" >0</h3>
                        Active advisors
                    </div>
                    <div class="col-6 col-md-3 text-center right-border">
                        <h3 class="p-0 m-0 number_counter font-50" style="color:#000000 !important" count="{{ $total_5_rating ?? 0 }}" >0</h3>
                        5 star match ratings
                    </div>
                    <div class="col-6 col-md-3 text-center right-border">
                        <h3 class="p-0 m-0 number_counter font-50" style="color:#000000 !important" count="{{ $total_question ?? 0 }}">0</h3>
                        Case studies
                    </div>
                    <div class="col-6 col-md-3 text-center">
                        <h3 class="p-0 m-0 number_counter font-50" style="color:#000000 !important" count="{{ $total_testimonial ?? 0 }}">0</h3>
                        Testimonials posted
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Blogs -->
    <section class="pb-4 pt-4">
        <div class="container-lg">
            <div class="row">
                <div class="col-sm-12" style="text-align:center !important">
                    <p class="text-theme font-13 m-0">EXPLORE OUR TREASURY OF TIPS & GUIDES FOR EVERY STAGE OF LIFE</p>
                    <h3 class="text-theme m-0"><b>Blogs</b></h3>
                </div>
            </div>
            <div class="row mt-3">
                @foreach($blogs as $blog)
                <?php
                    $admin = $blog->createdBy;
                ?>
                <div class="col-sm-6 col-md-4 col-lg-3 mt-2">
                    <div class="card blog-card">
                        <div class="row">
                            <div class="col-12">
                                <img src="{{ asset($blog->image ?? 'image/not-found.png') }}" class="card-img-top" alt="Image" style="height:180px;">
                                <div class="card-body pl-2 pr-2" style="height: 320px;">
                                    <h4 class="text-theme font-18">
                                        <a href="{{ route('view_blog',[$blog->slug]) }}">{{ $blog->title }}</a>
                                    </h4>
                                    <p class="card-text ">
                                        <?php
                                            $text_length =  strlen($blog->description) < 100 ? strlen($blog->description) : strpos($blog->description, ' ', 90);
                                        ?>
                                        {!! strip_tags(substr($blog->description, 0, $text_length )) !!} ...
                                    </p>
                                    <a href="{{ route('view_blog',[$blog->slug]) }}" class="btn btn-link pl-0 float-right" style="color:black !important">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                <div class="col-sm-12 mt-3 text-center">
                    <a href="{{ route('blogs') }}" class="btn btn-md no-radius" style="background-color:#FFCD7F;color:#000000;font-size:15px;">Read more blogs</a>&nbsp;&nbsp; <a class="btn btn-md no-radius" style="background-color:#FFCD7F;color:#000000;font-size:15px;" href="{{ route('about_us') }}">About us</a>
                </div>
            </div>
        </div>
    </section>

    <!-- cookies Section -->
    @if( !empty($cookies) )
    <div class="cookie">
        <div class="row justify-content-center pt-4 pb-4 pl-4 pr-4">
            <div class="col-12 col-lg-12">
                {!! $cookies->trems_and_condition ?? "" !!}
            </div>
            <!--<div class="col-12 col-lg-5">
                We use cookies to give you the best online experience.
            </div>-->
            <div class="col-12 col-lg-7 text-right">
                <button type="button" class="btn btn-default text-uppercase hide-cookie">I do not accept cookies</button>
                <button type="button" class="btn btn-primary text-uppercase hide-cookie" style="background: #2E86C1;" >Yes, I accept cookies</button>
            </div>
        </div>
    </div>
    @endif

@stop
@section("script")
    <script>
        // @if($errors->has("phone") || $errors->has("email") || $errors->has("post_code") || $errors->has("first_name") || $errors->has("ast_name"))
        //     $(document).ready(function(){
        //         $('#ask-now').click();
        //     });
        // @endif
        // $('#ask-now').click(function(){
        //     if($('#question').val().length >= 5){
        //         $(".question-part-1").addClass("d-none");
        //         $(".question-part-2").removeClass("d-none");
        //     }else{
        //         $("#question-submit").click();
        //     }
        // });

        // editing start
         @if($errors->has("phone") || $errors->has("email") || $errors->has("post_code") || $errors->has("first_name") || $errors->has("last_name"))
            $(document).ready(function(){
                $('#ask-now').click();
            });

            // $(document).ready(function(){
            //     $('#ask-now_2').click();
            // });
        @endif
        $('#ask-now').click(function(){
            if($('#question').val().length >= 5){
                $(".question-part-1").addClass("d-none");
                $(".question-part-2").removeClass("d-none");
            }else{
                $("#question-submit").click();
            }
        });
        $('#ask-now_2').click(function(){
            if($('#question').val().length >= 5){
                $(".question-part-1").addClass("d-none");
                $(".question-part-2").addClass("d-none");
                $(".question-part-3").removeClass("d-none");
            }else{
                $("#question-submit").click();
            }
        });
        // editing end

        $(document).on("keyup", "#question, #email, #post_code, #first_name, #phone", function(){
            $("#question").change();
            $("#email").change();
            $("#post_code").change();
        });
        $(document).on("change", "#service_offer_id, #question, #email, #post_code, #fund_size_id, #first_name, #phone", function(){
            let = progress = 0;
            let = progress_text = "";
            if(($("#service_offer_id").val()).length > 0){
                progress = 25;
            }
            if( ($("#question").val()).length >= 8){
                progress += 25;
            }
            if( ($("#first_name").val()).length >= 3){
                progress += 10;
            }
            if( ($("#phone").val()).length >= 8){
                progress += 10;
            }
            if( ($("#email").val()).length >= 4){
                progress += 10;
            }
            if( ($("#post_code").val()).length >= 6){
                progress += 10;
            }
            if( ($("#fund_size_id").val()).length >= 1){
                progress += 10;
            }

            progress_text = progress + "%";
            $(".progress-text").html(progress_text);
            $(".ask-now-progress .progress-bar").css("width", progress_text);
        });

        $(document).on('change', '#all_advisor', function(){
            if( $(this).prop("checked") ){
                $('#mortgage_only').val(1);
                $("#active-advisor").text($('#all_mortgage_advisor').val());
            }else{
                $('#mortgage_only').val(0);
                $("#active-advisor").text($('#all_active_advisor').val());
            }
        });

        $(document).on("click", ".hide-cookie", function(){
            $(".cookie").addClass("d-none");
        });

        $(document).ready(function(){
            $("#advisor-owl-carousel .owl-carousel").owlCarousel({
                loop:true,
                nav: true,
                navText:['<i class="fas fa-arrow-circle-left text-theme fa-2x"></i>', '<i class="fas fa-arrow-circle-right text-theme fa-2x"></i>'],
                margin:10,
                autoplay:true,
                autoplayTimeout:2500,
                responsiveClass:true,
                responsive:{
                    0:{
                        items:1,
                    },
                    576:{
                        items:2,
                    },
                    860:{
                        items:3,
                    },
                    992:{
                        items:4,
                    },
                    1120:{
                        items:5,
                    }
                },
            });
        });

    </script>
    <script type="text/javascript">

        (function (w) {
            w['_ekomiWidgetsServerUrl'] = (document.location.protocol == 'https:' ? 'https:' : 'http:') + '//widgets.ekomi.com';
            w['_customerId'] = 95730;
            w['_ekomiDraftMode'] = true;
            w['_language'] = 'en';

            if(typeof(w['_ekomiWidgetTokens']) !== 'undefined'){
                w['_ekomiWidgetTokens'][w['_ekomiWidgetTokens'].length] = 'sf957305c54637c4cb89';
            } else {
                w['_ekomiWidgetTokens'] = new Array('sf957305c54637c4cb89');
            }

            if(typeof(ekomiWidgetJs) == 'undefined') {
                ekomiWidgetJs = true;

                            var scr = document.createElement('script');
                            scr.src = 'https://sw-assets.ekomiapps.de/static_resources/widget.js';
                var head = document.getElementsByTagName('head')[0];head.appendChild(scr);
                        }
        })(window);
    </script>
@endsection
