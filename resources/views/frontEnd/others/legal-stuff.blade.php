@extends('frontEnd.masterPage')
@section('title')
    Legal stuff ||
@stop
@section('mainPart')
    <section style="background-size: cover;background-repeat: no-repeat;background-position: center; background-image: url('{{ asset('image/financial.jpg') }}')">
        <div class="container-fluid">
            <div class="row justify-content-center" style="min-height: 250px">
            </div>
        </div>
    </section>
    <div class="container-lg bg-white mb-5" style="margin-top: -60px; position: relative;">
        <div class="row justify-content-center" >
            <div class="col-12 col-md-10 mt-5">
                <div class="row">                    
                    <div class="col-12 col-md-9">
                        <div>
                            <h3 class="p-0 m-0 text-theme font-24"><b>Legal stuff</b></h3>      
                            <p class="mt-2">
                                Looking for our terms and conditions? Well you've come to the right place. We've set it all out in black and white.
                                <b>Our Privacy Policy can be found <a href="{{ route('privacy_policy') }}" class="btn-link p-0 m-0 pl-1">here.</a></b>
                            </p>
                        </div>

                        <div class="mt-5">
                            <p class="font-weight-bold p-0 m-0">Website Terms of Use</p>
                            <p>This agreement applies between you, the User of this Website and RMT Group (UK) Ltd, the owner of this Website. Your agreement to comply with and be bound by these terms and conditions is deemed to occur upon your first use of the Website. If you do not agree to be bound by these terms and conditions, you should stop using the Website immediately. </p>
                        </div>

                        <div class="mt-5">
                            <p class="font-weight-bold p-0 m-0">1. Definitions and Interpretation</p>
                            <p>
                                In this Agreement the following terms shall have the following meanings: “Content” means any text, graphics, images, audio, video, software, data compilations and any other form of information capable of being stored in a computer that appears on or forms part of this Website; “RMT Group (UK) Ltd” means RMT Group (UK) Ltd 40 Gracechurch Street, Iplan, London EC3V 0BT, a company registered in England & Wales number 08452090; “Service” means collectively any online facilities, tools, services or information that RMT Group (UK) Ltd makes available through the Website either now or in the future; “System” means any online communications infrastructure that RMT Group (UK) Ltd makes available through the Website either now or in the future. This includes, but is not limited to, web-based email, message boards, live chat facilities and email links; “User” / “Users” means any third party that accesses the Website and is not employed by RMT Group (UK) Ltd and acting in the course of their employment; and “Website” means the website that you are currently using (www.rmt-group.com) and any sub-domains of this site unless expressly excluded by their own terms and conditions.
                            </p>
                        </div>

                        <div class="mt-5">
                            <p class="font-weight-bold p-0 m-0">2. Intellectual Property</p>
                            <p>
                                2.1 All Content included on the Website, unless uploaded by Users, including, but not limited to, text, graphics, logos, icons, images, sound clips, video clips, data compilations, page layout, underlying code and software is the property of RMT Group (UK) Ltd our affiliates or other relevant third parties. By continuing to use the Website you acknowledge that such material is protected by applicable United Kingdom and International intellectual property and other relevant laws. 2.2 Subject to sub-clause 2.3 you may not reproduce, copy, distribute, store or in any other fashion re-use material from the Website unless otherwise indicated on the Website or unless given express written permission to do so by RMT Group (UK) Ltd.
                                2.3 Material from the Website may be re-used without written permission where any of the exceptions detailed in Chapter III of the Copyright Designs and Patents Act 1988 apply. 
                            </p>
                        </div>

                        <div class="mt-5">
                            <p class="font-weight-bold p-0 m-0">3. Links to Other Websites</p>
                            <p>
                                This Website may contain links to other sites. Unless expressly stated, these sites are not under the control of RMT Group (UK) Ltd or that of our affiliates. We assume no responsibility for the content of such Websites and disclaim liability for any and all forms of loss or damage arising out of the use of them. The inclusion of a link to another site on this Website does not imply any endorsement of the sites themselves or of those in control of them. 
                            </p>
                        </div>

                        <div class="mt-5">
                            <p class="font-weight-bold p-0 m-0">4. Links to this Website</p>
                            <p>
                                Those wishing to place a link to this Website on other sites may do so only to the home page of the site <a href="{{ route('index') }}" class="btn-link">{{ route('index') }}</a> without prior permission. Deep linking (i.e. links to specific pages within the site) requires the express permission of RMT Group (UK) Ltd. To find out more please contact us by email at <a href="{{ route('contact_us') }}" class="btn-link">{{ route('contact_us') }}</a> 
                            </p>
                        </div>

                        <div class="mt-5">
                            <p class="font-weight-bold p-0 m-0">5. Disclaimers</p>
                            <p>
                                5.1 RMT Group (UK) Ltd makes no warranty or representation that the Website will meet your requirements, that it will be of satisfactory quality, that it will be fit for a particular purpose, that it will not infringe the rights of third parties, that it will be compatible with all systems, that it will be secure and that all information provided will be accurate. We make no guarantee of any specific results from the use of our Service.<br>
                                5.2 No part of this Website is intended to constitute advice and the Content of this Website should not be relied upon when making any decisions or taking any action of any kind.<br>
                                5.3 Whilst RMT Group (UK) Ltd uses reasonable endeavours to ensure that the Website is secure and free of errors, viruses and other malware, all Users are advised to take responsibility for their own security, that of their personal details and their computers. 
                            </p>
                        </div>

                        <div class="mt-5">
                            <p class="font-weight-bold p-0 m-0">6. Availability of the Website and Modifications</p>
                            <p>
                                6.1 The Service is provided “as is” and on an “as available” basis. We give no warranty that the Service will be free of defects and / or faults. To the maximum extent permitted by the law we provide no warranties (express or implied) of fitness for a particular purpose, accuracy of information, compatibility and satisfactory quality.<br>
                                6.2 RMT Group (UK) Ltd accepts no liability for any disruption or non-availability of the Website resulting from external causes including, but not limited to, ISP equipment failure, host equipment failure, communications network failure, power failure, natural events, acts of war or legal restrictions and censorship.<br>
                                6.3 RMT Group (UK) Ltd reserves the right to alter, suspend or discontinue any part (or the whole of) the Website including, but not limited to, the products and/or services available. These Terms and Conditions shall continue to apply to any modified version of the Website unless it is expressly stated otherwise. 
                            </p>
                        </div>

                        <div class="mt-5">
                            <p class="font-weight-bold p-0 m-0">7. Limitation of Liability</p>
                            <p>
                                7.1 To the maximum extent permitted by law, RMT Group (UK) Ltd accepts no liability for any direct or indirect loss or damage, foreseeable or otherwise, including any indirect, consequential, special or exemplary damages arising from the use of the Website or any information contained therein. Users should be aware that they use the Website and it's Content at their own risk.<br>
                                7.2 Nothing in these terms and conditions excludes or restricts RMT Group (UK) Ltd’s liability for death or personal injury resulting from any negligence or fraud on the part of RMT Group (UK) Ltd.<br>
                                7.3 Every effort has been made to ensure that these terms and conditions adhere strictly with the relevant provisions of the Unfair Contract Terms Act 1977. However, in the event that any of these terms are found to be unlawful, invalid or otherwise unenforceable, that term is to be deemed severed from these terms and conditions and shall not affect the validity and enforceability of the remaining terms and conditions. This term shall apply only within jurisdictions where a particular term is illegal.
                            </p>
                        </div>

                        <div class="mt-5">
                            <p class="font-weight-bold p-0 m-0">8. No Waiver</p>
                            <p>
                                In the event that any party to these Terms and Conditions fails to exercise any right or remedy contained herein, this shall not be construed as a waiver of that right or remedy. 
                            </p>
                        </div>

                        <div class="mt-5">
                            <p class="font-weight-bold p-0 m-0">9. Previous Terms and Condition</p>
                            <p>
                                In the event of any conflict between these Terms and Conditions and any prior versions thereof, the provisions of these Terms and Conditions shall prevail unless it is expressly stated otherwise. 
                            </p>
                        </div>

                        <div class="mt-5">
                            <p class="font-weight-bold p-0 m-0">10. Third Party Rights</p>
                            <p>
                                Nothing in these Terms and Conditions shall confer any rights upon any third party. The agreement created by these Terms and Conditions is between you and RMT Group (UK) Ltd. 
                            </p>
                        </div>

                        <div class="mt-5">
                            <p class="font-weight-bold p-0 m-0">11. Communications</p>
                            <p>
                                11.1 All notices / communications shall be sent to us either by post to our Premises (see address above). Such notice will be deemed received 3 days after posting if sent by first class post, the day of sending if the email is received in full on a business day and on the next business day if the email is sent on a weekend or public holiday.<br>
                                11.2 RMT Group (UK) Ltd may from time to time send you information about our products and/or services. 
                            </p>
                        </div>

                        <div class="mt-5">
                            <p class="font-weight-bold p-0 m-0">12. Law and Jurisdiction</p>
                            <p>
                                These terms and conditions and the relationship between you and RMT Group (UK) Ltd shall be governed by and construed in accordance with the Laws of England & Wales and RMT Group (UK) Ltd and you agree to submit to the exclusive jurisdiction of the courts of England & Wales. 
                            </p>
                        </div>

                        <div class="mt-5">
                            <p class="font-weight-bold p-0 m-0">Website Disclaimer</p>
                            <p>
                                {!! $disclaimer ?? "" !!}
                            </p>
                        </div>

                        <div class="mt-5">
                            <p class="font-weight-bold p-0 m-0">Copyright Notice</p>
                            <p>
                                © 2016 - 2018 RMT Group (UK) Ltd. All Rights Reserved. The content of this website is protected by the copyright laws of England and Wales and by international laws and conventions. No content from this website may be copied, reproduced or revised without the prior written consent of RMT Group (UK) Ltd. Copies of content may be saved and/or printed for personal use only. 
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
                </div>
            </div>
        </div>
    </div>

@endsection