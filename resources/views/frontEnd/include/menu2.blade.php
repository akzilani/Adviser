<style>

</style>
<body>
    <!-- Header start -->
    <header class="header" id="header">

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
</body>
