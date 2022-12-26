@extends('frontEnd.masterPage')
@section('style')
    <style>
        .bg-custom{background-color: #eee !important;}
        .switch {position: relative; display: inline-block; width: 60px; height: 34px;}
        .slider{background-color: #ccc; -webkit-transition: .4s;transition: .4s; left: 5px; height: 20px;}
        .slider:before { background-color: white; bottom: 3px;}
        input:checked + .slider { background-color: #2196F3;}
        input:focus + .slider { box-shadow: 0 0 1px #2196F3;}
        .hide_by_filter{display: none;}
        .plan-type .plan-type-btn{border:1px solid #aaa; padding:10px 15px;background: #fff;color:#000; box-shadow: 1px 2px 2px #aaa; margin-right: 5px;}
        .plan-type .active{background: #000; color:#fff; font-weight:bold;}
        .faq .card-header{background: #fff; transition: all .7s;}
        .faq .btn-link{ color:#000; text-decoration: none;}
        .faq .card-header:hover{background: #ddd;}
        .faq .card-body{ background: rgb(240, 235, 235)}
        .faq .card-body p{margin: 0px; background: transparent !important; }
        .bg-custom, .mobile-menu{display: none !important;}
        .faq-answer p{ font-size: 14px;}
        .faq-answer table, .faq-answer figure, .faq-answer .table{width: 100%; overflow-x: auto;}


        @media only screen and (max-width: 2000px){
            .subscrip_section{padding: 30px 0px}
        }

        @media only screen and (min-width: 600px){
        .plus{margin-left:9.5em;margin-top:-2em;}
        .faq .card-body p{ margin-left:-1em;}
        .bill_part .slider{font-size: 20px;}
        }

        @media only screen and (max-width: 320px){
            .plus{margin-left:9.5em;margin-top:-2em;}
            .faq .card-body p{ margin-left:-1em;}
            .bill_part b{font-size: 13px;}
            .slider{left: -10px;}
            .subscrip_section{padding: 0px 0px}
        }
    </style>
@endsection
@section('script')
    <script>
        $(document).ready(function(){
            $('.package-filter').change();
            $('.plan-type .active').click();
        });
        $(document).on('change','.package-filter', function(){
            if(!$(this).prop("checked")){
                $('.view-year').addClass('d-none');
                $('.view-month').removeClass('d-none');
            }else{
                $('.view-year').removeClass('d-none');
                $('.view-month').addClass('d-none');
            }
        });

        $(document).on("click", ".plan-type-btn", function(){
            $.each($(".plan-type-btn"), function(){
                $(this).removeClass("active");
            });
            $(this).addClass("active");
            var type_name = $(this).data("type_name");
            var type_plans = $("."+type_name);
            var all_plans = $(".subscription_plans");
            $.each(all_plans, function(){
                $(this).addClass("hide_by_filter");
            });
            $.each(type_plans, function(){
                $(this).removeClass("hide_by_filter");
            });
        });
    </script>
@stop
@section('mainPart')
    <div class="row">
        <div class="col-sm-12">
            <section id="main-container" class="main-container subscrip_section">
                <div class="container">
                    <div class="row text-center">
                        <div class="col-12 mb-5 d-none d-ms-block">
                            <h3 class="m-0 p-0">Three simple steps to generating fees</h3>
                        </div>
                        <!-- Grid Section -->
                        <div class="col-sm-6 col-md-4 mt-3 mt-md-0 d-none d-md-block">
                            <img src="{{ asset('image/question-mark-icon.png') }}" height="100">
                            <h4> Register your plan</h4>
                        </div>
                        <div class="col-sm-6 col-md-4 mt-3 mt-md-0 d-none d-md-block">
                            <img src="{{ asset('image/clipboard.png') }}" height="100">
                            <h4> Build your profile</h4>
                        </div>
                        <div class="col-sm-6 col-md-4 mt-3 mt-md-0 d-none d-md-block">
                            <img src="{{ asset('image/advisoricon.png') }}" height="100">
                            <h4>Engage with clients</h4>
                        </div>
                    </div>
                    <!-- Title row end -->
                    <div class="row">
                        <div class="col-12 text-center">
                            <h3>Our plans</h3>
                            {{-- <p>
                                Our plans are open to all types of Financial Advisors including both<br>
                                Independent Financial Advisors and Restricted Advisors.
                            </p> --}}
                            <div class="plan-type">
                                @foreach($plan_types as $type)
                                    <button class="plan-type-btn mt-2 mt-col-0 {{ $loop->iteration == 1 ? "active" : null }}" data-type_name = "{{ str_replace(" ", "_", $type->profession_name) }}" >{{ $type->profession_name }}</button>
                                @endforeach
                            </div>
                            <div class="font-12">
                                Prices shown are exclusive of VAT
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-md-fluid">
                    <div class=" bill_part  row justify-content-center">
                        <div class=" col-5 col-md-5 col-lg-5 mt-3 mb-3 text-right " ; style="color:#000;"><b>Billed monthly</b></div>
                        <div class="col-2 col-md-2 col-lg-2 mt-3 mb-3 text-center ">
                            <label class="switch">
                                <input type="checkbox" class="d-none package-filter">
                                <span class="slider round" style="background-color:#28a745"></span>
                            </label>
                        </div>
                        <div class="col-5 col-md-5 col-lg-5 mt-3 mb-3 text-left" style="color:#000;"><b>Billed yearly</b></div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        @foreach ($plans as $plan)
                            <div class="col-lg-4 col-md-6 subscription_plans {{ strpos($plan->duration_type, 'year') ? 'view-year' : 'view-month' }} {{ str_replace(" ", "_", $plan->profession->name ?? "") }}">
                                <div class="ts-pricing-box {{ $loop->iteration % 2 == 0 ? 'ts-pricing-featured' : Null }} ">
                                    <div class="ts-pricing-header {{ $loop->iteration % 3 == 0 ? 'bg-success' : Null }}">
                                    <h2 class="ts-pricing-name ">{{ $plan->name }}</h2>
                                    <h2 class="ts-pricing-price">
                                        <span class="currency">{{ $system->currency_symbol }}</span><strong> {{ $plan->price }}</strong><small> {!! $plan->duration_type ? '/ '. $plan->duration_type : '&nbsp;' !!}</small>
                                    </h2>
                                    </div><!-- Pricing header -->
                                    <div class="ts-pricing-features">
                                        <ul class="list-unstyled">
                                            @if($plan->price == 0)
                                                <li style="height:120px">
                                                    <h3>Free</h3>
                                                </li>
                                            @else
                                                <li style="height:120px">
                                                    <h3>{{ $system->currency_symbol }}{{ $plan->price }} / {{ $plan->duration_type }} {{ $plan->charge_type }}</h3>
                                                </li>
                                            @endif

                                            @foreach($plan->subscription_plan_active_options as $option)
                                                <li>
                                                    <i class="fas fa-check text-success"></i>
                                                    {{ $option->text }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div><!-- Features end -->
                                    <div class="plan-action">
                                    <a href="{{ route('advisor.subscription_plan_choose', [$plan->id]) }}" class="btn btn-md {{ $loop->iteration % 2 == 0 ? 'btn-warning' : ($loop->iteration % 3 == 0 ? 'btn-success' : 'btn-dark') }}" style="padding:10px !important">Start Now!</a>
                                    </div>
                                </div><!-- Plan 1 end -->
                            </div><!-- Col end -->
                        @endforeach
                    </div> <!--/ Content row end -->
                </div>

                <!-- FAQ -->
                @if( count($faqs) > 0)
                    <section class="pb-5 pt-5 mt-5" >
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <h3 class="text-theme ">Frequently asked questions</h3>
                                </div>
                                <div class="col-12">
                                    <div id="accordion" class="faq">
                                        @foreach($faqs as $faq)
                                            <div class="card mt-1">
                                                <div class="card-header pb-2 pt-2" >
                                                    <div class="row">
                                                        <div class="col-sm-11 col-11">
                                                            <a href="javascript::;" class="btn-link question" data-toggle="collapse" data-target="#collapse{{$faq->id}}" aria-expanded="true" aria-controls="collapse{{$faq->id}}">
                                                                <p class="mb-0 font-14 font-weight-bold">{{ $faq->question }}</p>
                                                            </a>
                                                        </div>
                                                        <div class="col-sm-1 col-1 text-right">
                                                            <button class="btn btn-link font-30 p-0 plus" data-toggle="collapse" data-target="#collapse{{$faq->id}}" aria-expanded="true" aria-controls="collapse{{$faq->id}}">+</button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="collapse{{$faq->id}}" class="collapse" data-parent="#accordion">
                                                    <div style="background-color:#f9f9f9" class="card-body pt-2 pb-2">
                                                        <div class="row">
                                                            <div class="col-12 col-md-12 font-14 faq-answer" style="color:#212529;background-color:#f9f9f9 !important">
                                                                {!! $faq->answer !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                @endif

                <!-- Advisor Blog -->
                <div class="container" >
                    <div class="row">
                        <div class="col-12 mt-5">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h3 class="text-theme" >Articles</h3>
                                </div>
                                @foreach ($advisor_blogs as $blog)
                                    <?php
                                        $advisor = $blog->advisor;
                                    ?>
                                    <div class="col-md-4 mt-2">
                                        <div class="card">

                                            <div class="row">
                                                <div class="col-12">
                                                    <img src="{{ asset($blog->image ?? 'image/not-found.png') }}" class="card-img-top" alt="Image" style="height:180px">
                                                    <!--<div class="card-body"  > -->
                                                    <div class="card-body" style="height: 332px">
                                                        <h4 class="text-theme">
                                                            <a href="{{ route('view_advisor_blog',[$blog->slug]) }}">{{ $blog->title }}</a>
                                                        </h4>
                                                        <?php
                                                            $stop_count = 220;
                                                            try{
                                                                $stop_count = strpos($blog->description, ' ', 220);
                                                            }catch(Exception $e){
                                                                //
                                                            }
                                                        ?>
                                                        <p class="card-text mb-0 pb-0">
                                                            {!! strip_tags(substr($blog->description, 0, $stop_count)) !!} ...
                                                        </p>
                                                        <a href="{{ route('view_advisor_blog',[$blog->slug]) }}" class="btn btn-link pl-0 float-right" style="color:black !important">Read More</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-sm-12 mt-2 text-right">
                                {!! $advisor_blogs->links() !!}
                            </div>
                        </div>
                    </div>
                </div><!-- Conatiner end -->

            </section><!-- Main container end -->
        </div>
    </div>
@endsection
