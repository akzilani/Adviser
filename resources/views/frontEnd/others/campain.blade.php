@extends('frontEnd.masterPage')
@section('title')
    Campaign ||
@stop
@section('style')
    <style>
        .form-control{height: 30px; border:1px solid #333;}
        .form-group{margin-bottom:.5px; }
        label{margin-bottom:0rem; }
        /* #footer, .open_side_navigation, .tips_and_guides{ display: none; } */
        /* .header-auth-button{display: none;} */
        .footer-plan{position: absolute; right: 40px; top:55px;}
    </style>
@stop
@section('mainPart')
    <section class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12" style="background-size: cover;background-repeat: no-repeat;background-position: top; background-image: url('{{ asset(isset($page->cover_image) && file_exists($page->cover_image) ? $page->cover_image : 'image/campain-full.jpg') }}')">
        <div class="container-lg">
            <div class="row justify-content-center mt-4 mb-4" >
                <div class="col-12">
                    @include('frontEnd.alert')
                </div>
                <div class="col-12 col-lg-7 col-md-7  mt-md-5 text-white">
                    @if( isset($page->heading_text) )
                        {!! $page->heading_text !!}
                    @else
                        <p class="text-white font-weight-bold" style="font-size:38px;padding-bottom:10px;">We’ve mastered </p>
                        <p class="text-white font-weight-bold" style="font-size:38px;padding-bottom:10px;">the right</p>
                        <p class="text-white font-weight-bold" style="font-size:38px;padding-bottom:10px;">approach...</p>
                        <br/><br/>
                        <p class="text-white font-weight-bold" style="font-size:22px;padding-bottom:5px;">Join hundreds of financial and mortgage</p>
                        <p class="text-white font-weight-bold" style="font-size:22px;padding-bottom:5px;">advisors bidding for leads  through</p>
                        <p class="text-white font-weight-bold" style="font-size:22px;padding-bottom:5px;">Regulated Advice.</p>
                    @endif
                </div>
                <div class="col-12 col-lg-4 col-md-4" style="margin-bottom: 8rem;">
                    <div class="p-2" style="background: #fff;">
                        <form action="{{ route('contact_us') }}" method="POST" style="border:1px solid #555;" class="p-2">
                            @csrf
                            <div class="form-group">
                                <h5>Enquiry Form</h5>
                            </div>
                            <div class="form-group">
                                <label class="font-12 font-weight-bold">Services Interested In <span class="text-danger font-12">*</span></label>
                                <select name="service_interest" class="form-control" required >
                                    <option value="">Select ...</option>
                                    <option value="Pension Leads">Pension Leads</option>
                                    <option value="Financial Advisor Leads">Financial Advisor Leads</option>
                                    <option value="Mortgage Leads">Mortgage Leads</option>
                                    <option value="Equity Release Leads">Equity Release Leads</option>
                                </select>
                                @if($errors->has('service_interest'))
                                    <span class="text-danger font-10" role="alert">
                                        <strong>{{ $errors->first('service_offer_id') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <!-- First Name -->
                            <div class="form-group">
                                <label class="font-12 font-weight-bold">First Name <span class="text-danger font-12">*</span></label>
                                <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" required >
                                @if($errors->has('first_name'))
                                    <span class="text-danger font-10" role="alert">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <!-- Last Name -->
                            <div class="form-group">
                                <label class="font-12 font-weight-bold">Last Name <span class="text-danger font-12">*</span></label>
                                <input type="text" name="last_name" class="form-control" required value="{{ old('last_name') }}">
                                @if($errors->has('last_name'))
                                    <span class="text-danger font-10" role="alert">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <!-- Company Name -->
                            <div class="form-group">
                                <label class="font-12 font-weight-bold">Company Name <span class="text-danger font-12">*</span></label>
                                <input type="text" name="company_name" class="form-control" value="{{ old('company_name') }}" required >
                                @if($errors->has('company_name'))
                                    <span class="text-danger font-10" role="alert">
                                        <strong>{{ $errors->first('company_name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <!-- Phone Number -->
                            <div class="form-group">
                                <label class="font-12 font-weight-bold">Phone Number <span class="text-danger font-12">*</span></label>
                                <input type="text" name="phone_number" class="form-control verify" data-verify_type="phone" value="{{ old('phone_number') }}" required >
                                @if($errors->has('phone_number'))
                                    <span class="text-danger font-10" role="alert">
                                        <strong>{{ $errors->first('phone_number') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <label class="font-12 font-weight-bold">Email <span class="text-danger font-12">*</span></label>
                                <input type="email" name="email" class="form-control verify" data-verify_type="email" value="{{ old('email') }}" required >
                                @if($errors->has('email'))
                                    <span class="text-danger font-10" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <!-- Postcode -->
                            <div class="form-group">
                                <label class="font-12 font-weight-bold">Postcode <span class="text-danger font-12">*</span></label>
                                <input type="text" name="post_code" class="form-control verify" data-verify_type="postcode" value="{{ old('post_code') }}" required >
                                @if($errors->has('post_code'))
                                    <span class="text-danger font-10" role="alert">
                                        <strong>{{ $errors->first('post_code') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group pb-0 mb-0">
                                <label class="font-12">
                                    <input type="checkbox" name="store_data" value="1" checked >
                                    Consent to store your data
                                </label>
                            </div>
                            <div class="form-group pb-0 mb-0">
                                <label class="font-12">
                                    <input type="checkbox" name="call_permission" value="1" checked >
                                    Permission to Phone
                                </label>
                            </div>
                            <div class="form-group pb-0 mb-0">
                                <label class="font-12">
                                    <input type="checkbox" name="email_permission" value="1" checked >
                                    Permission to Email
                                </label>
                            </div>

                            <div class="form-group pb-0 mb-0">
                                <label class="font-12">
                                    <input type="checkbox" name="text_permission" value="1" checked >
                                    Permission to Text
                                </label>
                            </div>
                            <div class="form-group">
                                <div class="text-justify font-13 line-heigh-16">
                                    Your Information will be used to contact you about the services we provide, through the contact methods you select above. Please call us to reply to any communication from us if you no longer consent to us storing your data or contacting you. *These fields are required for the form to be submitted.
                                </div>
                            </div>
                            <div class="form-group pt-2">
                                <br/>
                                <button type="submit" class="w-100 text-uppercase btn btn-secondary  pt-1 pb-1">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="d-none d-md-block col-md-1 text-center" align="center">
                    <img src="{{ asset('image/great_british_company.png') }}" class="" width="85px"> <br/><br/>
                     <!--<img src="{{ asset('image/Daco_1567024.png') }}" class="" width="85px">-->
                </div>
            </div>
        </div>
    </section>

    <section style="background: #fff;" class="pt-5 pb-5">
        <div class="container-lg">
            <div class="row">
                <div class="col-12">
                    <p class="text-theme m-0 font-13">DO A BRILLIANT JOB FOR YOUR CLIENTS</p>
                    <h3 class="text-theme">Regulated Advice bidding platform</h3>
                </div>
                <div class="col-12 ">
                     {!! $campain_page_1 !!}
                </div>
            </div>
        </div>
    </section>

    <br/>

    <!-- Image & Text -->
    <section class="pt-1 pb-1">
        <div class="container-lg">
            <div class="row">
                <div class="col-12 col-sm-6 text-center">
                    <img src="{{ asset('image/Top rated icons_300x180.png') }}" class="img-fluid">
                </div>
                <div class="col-12 col-sm-6">
                    <h3 class="text-theme">Powerful tools</h3>
                    <p>
                       {!! $campain_page_2 !!}
                    </p>
                </div>
            </div>

            <br/>

            <div class="row mt-4">
                <div class="col-12 col-sm-6">
                    <h3 class="text-theme">Auction Room</h3>
                    <p>
                        {!! $campain_page_3 !!}
                    </p>
                </div>
                <div class="col-12 col-sm-6 text-center">
                    <img src="{{ asset('image/auction-room.jpg') }}" class="img-fluid">
                </div>
            </div>

            <br/>

            <div class="row mt-4">
                <div class="col-12 col-sm-6 text-center">
                    <img src="{{ asset('image/campaign-match-rating.jpg') }}" class="img-fluid">
                </div>
                <div class="col-12 col-sm-6">
                    <h3 class="text-theme">5 star Match Rating ™</h3>
                    <p>
                        {!! $campain_page_4 !!}
                    </p>
                </div>
            </div>
            <br/>
            <div class="row mt-3">
                <div class="col-12 col-sm-6">
                    <h3 class="text-theme">Build your profile </h3>
                    <p>
                        {!! $campain_page_5 !!}
                </div>
                <div class="col-12 col-sm-6 text-center">
                    <video controls style="width: 100%;height:350px;" poster="{{ asset('video/profile.jpg') }}" style="border:1px solid #eee">
                        <source src="{{ asset('video/profile.mp4') }}" type="video/mp4">
                    </video>
                   <!--  <img src="{{ asset('image/profile.jpg') }}" class="img-fluid">-->
                </div>
            </div>
        </div>
    </section>

    <section style="background: #fff;" class="pt-4 pb-4">
        <div class="container-lg">
            <div class="row">
                <div class="col-12">
                    <p class="font-13 text-theme m-0">BECOME A MEMBER</p>
                    <h3 class="text-theme">How much does it cost?</h3>
                </div>
                <div class="col-12">
                     {!! $campain_page_6 !!}
                    <!--<p class="mb-0">You can become a member by simply choosing a plan that suits your needs. </p>
                    <p >The benefits of a plan are as follows:</p>

                    <p class="mb-0">1. Fully verified Regulated Advice profile</p>
                    <p class="mb-0">2. The ability to receive unlimited leads per month to a pre-set wealth criteria and fixed price</p>
                    <p class="mb-0">3. Minimal work required to ensure a 5-star Match Rating in your local area </p>
                    <p class="mb-0">4. Strong page one Google presence</p>
                    <p class="mb-0">5. Access to powerful tools that can help generate more prospects</p>-->
                </div>
            </div>
        </div>
    </section>

    <!-- Video -->
    <!--<section class="pt-0 pb-0">
        <div class="container-lg">
            <div class="row">
                <div class="col-12  col-md-6 mt-4">
                    <video controls style="width: 100%;height:400px;" poster="{{ asset('video/profile.jpg') }}" style="border:1px solid #eee">
                        <source src="{{ asset('video/profile.mp4') }}" type="video/mp4">
                    </video>
                </div>

                <div class="col-12 col-md-6 mt-4">
                    <video controls style="width: 100%;height:400px;" poster="{{ asset('video/auction_room.jpg') }}" style="border:1px solid #eee">
                        <source src="{{ asset('video/auction_room.mp4') }}" type="video/mp4">
                    </video>
                </div>
            </div>
        </div>
    </section>
    <br/>
    -->

    <br/><br/>

    <div class="copyright" style="background: url('{{ asset('image/footer.png') }}'); min-height:200px;background-size:cover;background-position:center">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-12">
                    <div class="text-center mt-4 mb-4">
                        @if( !empty($specific_footer_text) )
                            {!! $specific_footer_text !!}
                        @else
                            <h4 class="p-0 m-0 text-white font-18">Any Question? We'd love to hear from you</h3>
                            <h4 class="p-0 m-0 text-white font-18" >Call us on 020 3468 4215</h3>
                            <p class="p-0 m-0 text-white font-12" >Lines are open Mon-Fri:9AM-12PM, 1-4:30PM</p>
                            <p class="p-0 m-0 text-white font-12" >Use of the service is subject to our Terms & Condition and Privacy Policy</p>
                        @endif
                    </div>
                    <!--<div class="copyright-info font-12" style="font-style:bold;">
                        © 2016 – {{ date('Y') }} RMT Group (UK) Ltd. All Rights Reserved. </span>Developed by <a href="https://lamptechs.com" target="_blank"><u>Lamp Techs.</u></a>
                    </div>-->
                    <div class="copyright-info font-12" style="font-style:bold;">
                         {!! $footer_copyright !!}
                    </div>

                </div>
                <!--
                <div class="footer-plan">
                    <a href="{{ route('advisor.subscription_plan') }}" class="btn btn-warning no-radius" >Pricing</a>
                </div>
                -->
            </div><!-- Row end -->

            <div id="back-to-top" data-spy="affix" data-offset-top="10" class="back-to-top position-fixed">
                <button class="btn btn-primary" title="Back to Top">
                    <i class="fa fa-angle-double-up"></i>
                </button>
            </div>
        </div><!-- Container end -->
    </div><!-- Copyright end -->

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
