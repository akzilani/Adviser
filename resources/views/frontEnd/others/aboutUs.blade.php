@extends('frontEnd.masterPage')
@section('title')
    About Us ||
@stop
@section('mainPart')
    <section class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12" style="background-size: cover;background-repeat: no-repeat;background-position: center; background-image: url('{{ asset( isset($page->cover_image) && file_exists($page->cover_image) ? $page->cover_image : 'image/financial.jpg') }}')">
    <!--<section class="question-section pt-2 pb-2" style="background-image: url('{{ asset( isset($page->cover_image) && file_exists($page->cover_image) ? $page->cover_image : 'image/regmainimage.jpg') }}')">
    <section style="background-size: cover;background-repeat: no-repeat;background-position: center; background-image: url('{{ asset( isset($page->cover_image) && file_exists($page->cover_image) ? $page->cover_image : 'image/financial.jpg') }}'')">  -->
        <div class="container-fluid">
            <div class="row justify-content-center" style="min-height: 250px">
            </div>
        </div>
    </section>

    <div class="container-lg bg-white mb-5" style="margin-top: -60px; position: relative;">
        <div class="row justify-content-center" >
            <div class="col-12 col-md-10">
                <br/>
                <p class="text-theme font-13 m-0">ABOUT REGULATED ADVICE</p>
                <h3 class="text-theme">Regulated Advice</h3>
            </div>
            <div class="col-12 col-md-10">
                <p class="m-0" >
                    {!! $about_us_about_regulated !!}
                </p>
            </div>
            
            <!--<div class="col-6 col-md-5 mt-2 text-center">-->
            <!--    <br/>            -->
            <!--    <img src="{{ asset('image/ekomi-single.png') }}" class="img-fluid">-->
            <!--</div>-->
            <!--<div class="col-6 col-md-5 mt-2 text-center">-->
            <!--    <br/>-->
            <!--    <img src="{{ asset('image/five stars.png') }}" class="img-fluid">-->
            <!--</div>-->
        </div>
        <!--<div class="row justify-content-center" >-->
        <!--    <div class="col-6 col-md-5 mt-2">-->
        <!--        <p class="text-theme font-13 m-0" >POWERED BY EKOMI</p>-->
        <!--        <h3 class="m-0 text-theme">Unbiased reviews</h3>-->
        <!--        <div class="text-left">-->
        <!--            <p class="m-0">{!! $about_us_unbiased_reviews !!}</p>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--    <div class="col-6 col-md-5 mt-2">-->
        <!--        <p class="text-theme font-13 m-0" >SEARCH FOR 5 STAR RATED ADVISORS</p>-->
        <!--        <h3 class="m-0 text-theme">Use our unique Match Rating™</h3>-->
        <!--        <div class="text-left">-->
        <!--            <p>{!! $about_us_match_rating !!}</p>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->
        
        
        <div class="row justify-content-center" >
            <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                <br/>
                <img src="{{ asset('image/ekomi-single.png') }}" class="img-fluid m-auto d-block">
                
                <p class="text-theme font-13 m-0" >POWERED BY EKOMI</p>
                <h3 class="m-0 text-theme">Unbiased reviews</h3>
                <div class="text-left ">
                    <p class="m-0">{!! $about_us_unbiased_reviews !!}</p>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                <br/>
                <img src="{{ asset('image/five stars.png') }}" class="img-fluid m-auto d-block">
                
                <p class="text-theme font-13 m-0 " >SEARCH FOR 5 STAR RATED ADVISORS</p>
                <h3 class="m-0 text-theme ">Use our unique Match Rating™</h3>
                <div class="text-left">
                    <p>{!! $about_us_match_rating !!}</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center" >
            <!--<div class="col-6 col-md-10 mt-5">
                <br/>
                <p class="text-theme font-13 m-0">3  WAYS TO FIND AN ADVISOR</p>
                <h3 class="text-theme m-0">How to find a Financial Advisor</h3>
            </div>
            <div class="col-6 col-md-10 text-center">
                <br/>
                <img src="{{ asset('image/aboutus.jpg') }}" class="img-fluid">
            </div>-->
            <!--<div class="col-6 col-md-10 mt-5">-->
            <!--    <div class="text-theme font-13 m-0" >OUR SERVICE IS FREE</div>-->
            <!--    <h3 class="text-theme mt-0">How does Regulated Advice make money?</h3>-->
            <!--    <div>-->
            <!--        <p class="m-0">{!! $about_us_regulated_make_money !!}</p>-->
            <!--    </div>-->
            <!--</div>-->
            
            <div class="col-lg-12 col-md-12 col-sm-12 mt-5">
                <div class="text-theme font-13 m-0" >OUR SERVICE IS FREE</div>
                <h3 class="text-theme mt-0">How does Regulated Advice make money?</h3>
                <div>
                    <p class="m-0 text-center">{!! $about_us_regulated_make_money !!}</p>
                </div>
            </div>
        </div>
        <br/><br/>
    </div>

    <!-- Custom Popup -->
    @if( !empty($dynamic_popup) )
        <div class="custom-popup d-none center" style="text-align:center">
            <div class="row">
                <div class="col-12 text-right">
                    <button class="btn btn-default close-popup" title="Close"><i class="far fa-times-circle" style="font-size:36px;color:red;"></i></button>
                </div>                
            </div>
            <div class="container-md">
                <div class="row">
                    <div class="col-12 mt-0 mb-5">
                        {!! $dynamic_popup !!}
                        <a href="{{ route('search_advisor', ['Financial-Advisor']) }}" class="btn btn-warning btn-md no-radius">Search</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection