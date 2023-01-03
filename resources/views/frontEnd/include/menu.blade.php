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
    height: 100%;
    width:60%;
    text-align: center;
    margin: auto;
    display: block;
    padding-top: 20px;
    }
    .navbar_link_part a{
    font-size: 13px;
    color:#FFFFFF;
    padding: 7px;
    font-weight: 600;
        /* font-family:'Times New Roman', Times, serif */
    }
   .navbar_link_part a:hover{
    font-size: 13px;
    color:#000000;
    padding: 7px;
    font-weight: 600;
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
@media all and (max-width: 600px) {
.img_part{
    display: none;
}
}
@media all and (max-width: 320px) {
.img_part{
    display: none;
}
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
        <div class="img_part">
            <div class="container">
                <div class="row">
                    <div style="height: 100px;width:100%" class="header_part">
                        <div class="">
                            <div class="row">
                                <div class="col-sm-12 col-md-4 col-lg-4 p-0">

                                    <a class="d-block" href="{{ url('/') }}">
                                        {{-- <img loading="lazy" src="{{ asset($system->logo ?? "image/logo.png") }}" alt="{{ config('app.name') }}" class="img-fluid"> --}}
                                     <img style="" class="header_logo " src="{{asset('image/logo.png')}}" alt="">
                                    </a>

                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-5 pl-0 pr-0 pt-4">
                                    <nav class="navbar-expand-lg pl-0 pr-0">
                                        <div class="">
                                          <div class="navbar-nav navbar_link_part">
                                            <a class="" href="#case_studies_part">Case Studies</a>
                                            <a class="" href="{{ route('tips_and_guides') }}">Tips & guides</a>
                                            <a class="" href="{{ route('search_advisor', ['Mortgage-Advisor']) }}">Find advisor</a>
                                            <a class="" href="{{ route('campain') }}">Campain</a>
                                            <a class="" href="{{route('blogs')}}">Blogs</a>
                                          </div>
                                        </div>
                                    </nav>
                                </div>
                                <div class="col-sm-12 col-md-2 col-lg-2 p-0">
                                    <div class="text-left header-auth-button pt-2">
                                        <strong>Are you an advisor?</strong> <br>
                                        <a href="{{ route('login') }}" class="btn btn-md font-weight-bold" style="background-color:#ffffff;color:#0396A6;">Log in</a>
                                        <a href="{{ route('register') }}" class="btn btn-md font-weight-bold" style="background-color:#ffffff;color:#0396A6;">Sign up</a>
                                    </div>
                                </div>
                                <div class="col-sm-1 text-right mt-3 open_side_navigation pt-3">
                                    <a href="javascript::;" id="open_side_navigation" class="font-weight-bold pl-3 pr-4 pr-xl-0"><i class="fa-2x fas fa-bars" style="color:#ffffff"></i></a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>


        <nav class="navbar navbar-expand-md navbar-light bg-theme d-md-none mobile-menu">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('image/logo_mobile.png') }}" alt="{{ config('app.name') }}" class="img-fluid" style="height: 55px;">
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
                    </li>
                </ul>
            </div>
        </nav>
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
