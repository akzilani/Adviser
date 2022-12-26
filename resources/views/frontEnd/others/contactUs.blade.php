@extends('frontEnd.masterPage')
@section('title')
    Contact us ||
@stop
@section('style')
    <style>
        .form-control{height: 30px; border:1px solid #333;}
        .form-group{margin-bottom:.5px; }
        label{margin-bottom:0rem; }
    </style>
@stop

@section('mainPart')
    <section class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12" style="background-size: cover;background-repeat: no-repeat;background-position: center; background-image: url('{{ asset( isset($page->cover_image) && file_exists($page->cover_image) ? $page->cover_image : 'image/hill.jpg') }}')">
        <div class="container-fluid">
            <div class="row justify-content-center" style="min-height: 250px">
                <div class="col-12 text-center">
                    <div class="text-white font-36" style="line-height: 200px;">
                        {!! $page->heading_text ?? "Where ever you are, LET’S TALK!" !!} 
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container-lg bg-white mb-5" style="margin-top: -60px; position: relative;">
        <div class="row p-0 col-lg-10 col-col-md-10 col-sm-12 m-auto">
            <div class="" style="padding-top:45px;">
                <p class="m-0 text-theme font-15">HELP & ADVICE</p>
                <h3 class="m-0 text-theme">Contact us</h4>
                <div class="mt-3 mb-5">
                    You can contact any of our advisors for free, simply by searching for an advisor. If you are an advisor and would like to contact Regulated Advice directly please use the Enquiry Form below to submit your  enquiry. 
                </div>
            </div>
            <div class=" row" style="padding-top:1px;">
                <div class="col-12">
                    @include('frontEnd.alert')
                </div>
                <!-- Left Part -->
                <div class="col-12 col-sm-7 col-md-8 ">
                    <div>
                        <p class="font-15 text-theme m-0">LEGAL INFORMATION</p>
                        <h3 class="text-theme m-0">Registered office</h3>
                        RMT Group (UK) Ltd <br>
                        5th floor<br>
                        22 Eastcheap<br>
                        London <br>
                        EC3M 1EU
                    </div>
                    <div  class="mt-4">
                        <h3 class="text-theme m-0">Luton office</h3>
                        RMT Group<br>
                        Suite 1<br>
                        Crystal House<br>
                        New Bedford Road <br>
                        Luton <br>
                        LU11HS
                    </div>
                    <div class="mt-4">
                        <p class="font-15 text-theme m-0">MON-FRI 9 AM-12 PM, 1 PM-4:30 PM</p>
                        <h3 class="text-theme m-0">Telephone</h3>
                        02034 684215
                    </div>
                </div>
                <!-- Right part -- Contact Form -->
                <div class="col-12 col-sm-5 col-md-4">
                    <div class="p-3" style="border:1px solid #555">
                        <form action="{{ route('contact_us') }}" method="POST">
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

                            <!-- First NAme -->
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
                                <input type="text" name="last_name" required class="form-control" value="{{ old('last_name') }}">
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
                            <br/>
                            <div class="form-group">
                                <button type="submit" class="w-100 text-uppercase btn-secondary pt-1 pb-1" >Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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