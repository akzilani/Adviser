
    <footer id="footer" class="footer">
        <div class="copyright bg-dark" style="height:120px;padding:15px;">
            <div class="container">
                <div class="row">
                    <div class="col-6">
                        <a href="{{ url('/') }}">
                            <img src="{{ asset('/image/logo-white.png') }}" class="img-fluid">
                        </a>
                    </div>
                    <div class="col-6 text-right">
                        <div class="footer-menu pt-4">
                            <ul class="list-unstyled font-10">
                                @foreach($social_medias as $social_media)
                                    <li><a href="{{ $social_media->link }}" target="_blank" title="{{$social_media->link}}">{!! $social_media->icon !!}</a></li>
                                @endforeach
                            </ul>
                            </div>
                    </div>
                </div><!-- Row end -->
            </div><!-- Container end -->
        </div>

        <div class="pt-4 pt-md-5 pb-4 pt-md-5">
            <div class="container">
                <div class="row justify-content-between">
                    <div class="col-sm-12 font-13" style="line-height:20px;">
                        {!! isset($specific_footer) && !empty($specific_footer) ? $specific_footer : $footer_text !!}
                    </div>

                    <div class="col-sm-12 row font-12 mt-2 mt-md-4">
                        <div class="col-md-4">
                            Are you an advisor? <br>
                            <a href="{{ route('login') }}" class="btn btn-md  pl-3 pr-3 no-radius" style="background-color:#FFCD7F;color:#000000;">Log in</a>
                            <a href="{{ route('register') }}" class="btn btn-md  pl-3 pr-3 no-radius" style="background-color:#FFCD7F;color:#000000;">Sign up</a>
                        </div>
                        <div class="col-md-8 row mt-2 mt-sm-0">
                            <div class="col-md-4 col-sm-6 footer-nav-menu mt-3 mt-md-0 font-13">
                                <ul>
                                    <li><a href="javascript::;" class="no-link" ><b>Find an advisor</b></a></li>
                                    <li><a href="{{ route('search_advisor', ['Financial-Advisor']) }}">IFA’s / Financial Advisors</a></li>
                                    <li><a href="{{ route('search_advisor', ['Mortgage-Advisor']) }}">Mortgage Advisors</a></li>
                                </ul>
                            </div>
                            <div class="col-md-4 col-sm-6 footer-nav-menu  mt-3 mt-md-0 font-13">
                                <ul>
                                    <li><a href="javascript::;" class="no-link" ><b>Company</b></a></li>
                                    <li><a href="{{ route('about_us') }}">About us</a></li>
                                    <li><a href="{{route('tips_and_guides') }}">Tips & guides</a></li>
                                    <li><a href="{{ route('contact_us') }}">Contact us</a></li>
                                    <li><a href="{{ route('campain') }}">Campaign</a></li>
                                </ul>
                            </div>
                            <div class="col-md-4 col-sm-6 footer-nav-menu  mt-3 mt-md-0 font-13">
                                <ul>
                                    <li><a href="javascript::;" class="no-link" ><b>Legal stuff</b></a></li>
                                    {{-- <li><a href="{{ route('legal_stuff') }}">Legal stuff</a></li> --}}
                                    <li><a href="{{ route('terms_and_condition') }}">Terms & Conditions</a></li>
                                    <li><a href="{{ route('privacy_policy') }}">Privacy Policy</a></li>

                                </ul>
                            </div>

                        </div>
                    </div>



                    <div class="col-sm-12 col-md-12" style="font-style:bold;">
                        <div class="copyright-info font-12" >
                                <!-- © 2016 – {{ date('Y') }} RMT Group (UK) Ltd. All Rights Reserved. </span>Developed by <a href="https://lamptechs.com" target="_blank"><u>Lamp Techs.</u></a>-->
                            {!! $copy_right !!}
                        </div>
                    </div>

                </div><!-- Row end -->
            </div><!-- Container end -->
        </div><!-- Footer main end -->





    </footer><!-- Footer end -->


        <!-- Javascript Fileklsd,s
        ================================================== -->

        <!-- initialize jQuery Library -->
        <script src="{{ asset('frontEnd/plugins/jQuery/jquery.min.js') }}"></script>

        <!-- Bootstrap jQuery -->
        <script src="{{ asset('frontEnd/plugins/bootstrap/bootstrap.min.js') }}" defer></script>
        <!-- Slick Carousel -->
        <script src="{{ asset('frontEnd/plugins/slick/slick.min.js') }}"></script>
        <script src="{{ asset('frontEnd/plugins/slick/slick-animation.min.js') }}"></script>
        <!-- Color box -->
        <script src="{{ asset('frontEnd/plugins/colorbox/jquery.colorbox.js') }}"></script>
        <!-- shuffle -->
        <script src="{{ asset('frontEnd/plugins/shuffle/shuffle.min.js') }}" defer></script>


        <!-- Google Map API Key-->
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcABaamniA6OL5YvYSpB3pFMNrXwXnLwU" defer></script>
        <!-- Google Map Plugin-->
        <script src="{{ asset('frontEnd/plugins/google-map/map.js') }}" defer></script>

        <!-- Template custom -->
        <script src="{{ asset('frontEnd/js/script.js') }}?v=12.14"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.select2').select2();
            });
        </script>
        <!-- Owl carousel Library -->
        <script src="{{ asset('owlcarousel/owl.carousel.js') }}"></script>
        @yield('script')
    </div><!-- Body inner end -->
  </body>

</html>
