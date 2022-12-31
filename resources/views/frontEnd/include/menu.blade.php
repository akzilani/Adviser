<style>
    .header_part{
        margin: 0px;
        padding: 0px;
    }
    .img_part{
    background-image: url("{{ asset('frontEnd/images/header_logo.jpg') }}");
    background-repeat: no-repeat;
    /* background-position: cover; */
    background-size: 100% 100%;
    width: 100%;
    height: 100%;
    margin: 0px;
    padding: 0px;
    }
    .header_logo{
    height: 70%;
    width:50%;
    text-align: center;
    margin: auto;
    display: block;
    padding-top: 20px;
    }
    .buttonlogin {
    position: relative;
    background-color: #04AA6D;
    border: none;
    font-size: 28px;
    color: #FFFFFF;
    padding: 20px;
    width: 200px;
    text-align: center;
    -webkit-transition-duration: 0.4s;
    transition-duration: 0.4s;
    text-decoration: none;
    overflow: hidden;
    cursor: pointer;
    }

    .buttonlogin:after {
    content: "";
    background: #90EE90;
    display: block;
    position: absolute;
    padding-top: 300%;
    padding-left: 350%;
    margin-left: -20px!important;
    margin-top: -120%;
    opacity: 0;
    transition: all 0.8s
    }

    .buttonlogin:active:after {
    padding: 0;
    margin: 0;
    opacity: 1;
    transition: 0s
    }
</style>


<body class="" >

    <!-- Header start -->
    <header id="header">
        {{-- <div class="bg-white d-none d-md-block bg-custom">
            <div class="container-xl">
                <div class="pt-2 pb-2">
                    <div class="row align-items-center">
                        <div class="col-md-3 mb-3 mb-md-5 mb-lg-0">
                            <a class="d-block" href="{{ url('/') }}">
                                <img loading="lazy" src="{{ asset($system->logo ?? "image/logo.png") }}" alt="{{ config('app.name') }}" class="img-fluid">
                            </a>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-sm-4 text-left header-auth-button ">
                                    <strong>Are you an advisor?</strong> <br>
                                    <a href="{{ route('login') }}" class="btn btn-md  pl-3 pr-3 " style="background-color:#0396A6;color:#ffffff;">Log in</a>
                                    <a href="{{ route('register') }}" class="btn btn-md pl-3 pr-3 " style="background-color:#0396A6;color:#ffffff;">Sign up</a>
                                </div>
                                <div class="col-sm-7 text-right mt-3 p-xl-0 tips_and_guides">
                                    <a href="{{ route('tips_and_guides') }}" style="color:#000000;font-weight: bold;font-size:18px;">Tips & guides</a>

                                </div>
                                <div class="col-sm-1 text-right mt-3 p-xl-0 open_side_navigation">
                                    <a href="javascript::;" id="open_side_navigation" class="font-weight-bold pl-3 pr-4 pr-xl-0"><i class="fa-2x fas fa-bars" style="color:#000000"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div> --}}
        <div style="height: 100px;width:100%" class="header_part">
            <div class="img_part">
                {{-- <img style="width: 100%" src="{{asset('frontEnd/images/header_logo.jpg')}}" alt=""> --}}
                <div class="row">
                    <div class="col-sm-12 col-md-5 col-lg-5 pl-0">
                        <img style="" class="header_logo " src="{{asset('image/logo.png')}}" alt="">

                    </div>
                    <div class="col-sm-12 col-md-5 col-lg-5">
                        <nav class="nav">

                        </nav>


                    </div>
                </div>

            </div>
        </div>

        <nav class="navbar navbar-expand-md navbar-light bg-theme d-md-none mobile-menu">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('image/logo-white.png') }}" alt="{{ config('app.name') }}" class="img-fluid" style="height: 55px;">
            </a>
            <button class="navbar-toggler bg-theme" type="button" data-toggle="collapse" data-target="#navigation_menu" aria-controls="navigation_menu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navigation_menu" style="border-top:1px solid cornsilk;">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('login') }}">Log in</a>
                        <a class="nav-link text-white" href="{{ route('register') }}">Sign up</a>
                        <a class="nav-link text-white" href="{{ route('tips_and_guides') }}">Tips & guides</a>
                        <a class="nav-link text-white" href="{{ route('about_us') }}">About us </a>
                        <a class="nav-link text-white" href="{{ route('contact_us') }}">Contact us </a>
                        <a class="nav-link text-white" href="{{ route('privacy_policy') }}">Privacy policy</a>
                        <!-- <a class="nav-link text-white" href="{{ route('advisor.subscription_plan') }}">Our plans</a> -->
                        <!-- <a class="nav-link text-white" href="{{ route('legal_stuff') }}">Legal stuff</a> -->


                    </li>
                </ul>
            </div>
          </nav>
        <!-- Navigation end -->
    </header>
    <!-- Header end -->

    <!-- Side Navigation -->
    <div id="side_navigation" class="d-none">
        <div class="col-12 row p-0 m-0">
            <div class="col-10">
                <a href="{{ url('/') }}">
                    <img src="{{ asset($system->logo ?? "image/logo.png") }}" class="img-fluid">
                </a>
            </div>
            <div class="col-2 text-right">
                <a href="javascript::;" id="close_side_navigation" title="Close">
                    <i class="fas fa-times-circle text-danger fa-2x"></i>
                </a>
            </div>
        </div>
        <div class="col-12 mt-2">
            <h4>Important Links</h4>
        </div>
        <div class="col-12 mt-2">
            <ul class="nav flex-column">
                <li class="nav-item">
                  <a class="nav-link font-weight-bold pl-0" href="{{ route('login') }}">Log in</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link font-weight-bold pl-0" href="{{ route('register') }}">Sign up</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link font-weight-bold pl-0" href="{{ route('campain') }}">Campaign</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link font-weight-bold pl-0" href="{{ route('about_us') }}">About us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-weight-bold pl-0" href="{{ route('tips_and_guides') }}">Tips & guides</a>
                </li>
            </ul>
        </div>
    </div>
</body>
