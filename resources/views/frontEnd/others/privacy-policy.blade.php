@extends('frontEnd.masterPage')
@section('title')
    Privacy policy ||
@stop
@section('mainPart')
    <!-- <section style="background-size: cover;background-repeat: no-repeat;background-position: center; background-image: url('{{ asset('image/financial.jpg') }}')"> -->
        <section class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12" style="background-size: cover;background-repeat: no-repeat;background-position: center; background-image: url('{{ asset(isset($page->cover_image) && file_exists($page->cover_image) ? $page->cover_image : 'image/financial.jpg') }}')">
        <div class="container-fluid">
            <div class="row justify-content-center" style="min-height: 250px">
            </div>
        </div>
    </section>
    <div class="container-lg bg-white mb-5" style="margin-top: -60px; position: relative;">
        <div class="row justify-content-center" >
            <div class="col-12 col-md-10 mt-5">
                {!! $data->trems_and_condition ?? '' !!}
            </div>
        </div>
    </div>
    
    {{-- <div class="row">                    
        <div class="col-12 col-md-9">
            <div>
                <h3 class="m-0 text-theme">Privacy policy</h3>      
                <p class="font-16 mt-2">
                    Looking for our Privacy and Cookie Policy? Well you've come to the right place. We've set it all out in black and white. 
                </p>
            </div>

            <div class="mt-5">                            
                <p >Note: We have recently changed our Privacy and Cookie Policy. We adhere to the requirements of UK data protection legislation, and this has changed as part of the General Data Protection Regulation (GDPR for short). </p>
            </div>

            <div class="mt-5">
                <p class="font-weight-bold p-0 m-0">Privacy Policy</p>
                <p >
                    RMT Group (UK) Ltd will be the data controller for the data that you provide us or we collect in relation to the provision of our services to you. RMT Group (UK) Ltd are committed to maintaining the trust and confidence of our visitors to our website. We want you to know that RMT Group (UK) Ltd is not in the business of selling, renting or trading email lists with other companies and businesses for marketing purposes. We just don't do that sort of thing. This Privacy Policy, provides information on when and why we collect your personal information, how we use it, and the limited conditions under which we may disclose it to others. By visiting www.regulatedadvice.co.uk and using our services you are accepting and consenting to the practices described in this Privacy Policy. The data controller of your information is RMT Group (UK) Ltd of 40 Gracechurch Street, Iplan, London, EC3V 0BT.<br>
                    Our data controller registration number is: ZA007824.
                </p>
            </div>

            <div class="mt-5">
                <p class="font-weight-bold p-0 m-0">Collection and Use of Personal Information</p>
                <p >
                    Personal information means any information that may be used to identify you, such as, your name, phone number, email address, areas of financial advice you’re interested in including investment and pension fund sizes. In general, you can browse our website without giving us any personal information. We do not tie a specific visit to a specific IP address. There are activities on our site that require you to be registered, for example, to speak to or to arrange an appointment with a Financial Advisor. As part of the registration process, we collect personal information. We pass on this personal information to RMT Group (UK) Ltd and to Financial Advisors listed here: https://www.regulatedadvice.co.uk/index2.php#. The listings includes a link to their website and its Privacy Policy; we also send you a profile of the Financial Advisor that we send your personal information to; this information is disclosed to the Financial Advisor to maintain a business relationship with you as a client; to contact you if we need to obtain or provide additional information; to check our records are right and to check every now and then that you're happy and satisfied. All telecommunications are recorded and we use the recordings for training and verification purposes. We may also share your information with the following sub-processors: 
                </p>
            </div>

            <div class="mt-5">
                <p class="font-weight-bold p-0 m-0">3. Links to Other Websites</p>
                <p >
                    elecommunications - Voice and Data Storage: Phoenix Solutions S.L (Spain),<br>
                    Antheus Telecom Ltd (UK);<br>
                    Cloud Data Storage: Google, Inc. (USA);<br>
                    Data Flow: FLG Software Limited (UK);<br>
                    Client Relationship Management: FLG Business Technology Limited (UK);<br>
                    Client Reviews: eKomi Ltd (Germany);<br>
                    Web Hosting, Email and Data Servers: Namecheap, Inc. (USA), Instapage Inc. (USA). <br>
                </p>
            </div>

            <div class="mt-5">
                <p class="font-weight-bold p-0 m-0">Use of Cookies</p>
                <p >
                    Our websites use cookies to distinguish you from other users of our website for the purpose of visitor tracking via the Google Analytics platform. A cookie is a small file of letters and numbers that we store on your browser or the hard drive of your computer or device if you agree. Cookies contain information that is transferred to your computer or device. We use the following cookie(s): 
                </p>
            </div>

            <div class="mt-5">
                <p >
                    Google analytical/performance cookie. This allows us to recognise and count the number of visitors and to see how visitors move around our website when they are using it, which helps us to improve the way our website works, for example, by ensuring that users are finding what they are looking for easily. You can find more information about the cookie here: https://developers.google.com/analytics/devguides/collection/analyticsjs/cookie-usage. You can block cookies by activating the setting on your browser that allows you to refuse the setting of all or some cookies. However, if you block cookies you may not be able to access all or parts of our website. 
                </p>
            </div>

            <div class="mt-5">
                <p class="font-weight-bold p-0 m-0">Access to your Personal Information</p>
                <p >
                    To view, amend, or delete any of the personal information that we hold by completing the form here: https://www.rmt-group.com/group-privacy-policy-form.
                </p>
            </div>

            <div class="mt-5">
                <p class="font-weight-bold p-0 m-0">And Finally....</p>
                <p >
                    To make sure we're always at the top of our game, we reserve our right to make any changes and updates to the privacy policy without giving you notice as and when we need to. We'll always make sure that the most up to date privacy policy is posted on our website, though, so you can check it out whenever you like. This was last updated during May 2018. 
                </p>
            </div>

        </div>
    
        <div class="col-12 col-md-3 mt-4">
            <h3 class="text-theme">Quick links</h3>
            <div class="list-group font-12">                            
                @foreach($quick_links as $link)
                    <a href="{{ route('view_quick_link',[$link->slug]) }}" class="list-group-item list-group-item-action">{{ $link->title }}</a>
                @endforeach
            </div>
        </div>
    </div> --}}
@endsection