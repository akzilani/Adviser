@extends('frontEnd.advisor.masterPage')
@section('mainPart')

<div class="row">
    <div class="col-12">
        @include('frontEnd.advisor.include.alert')
    </div>
</div>

<!-- task, page, download counter  start -->
@if(!$office_namager_feature)
    <div class="row">
        <!-- first Block Start-->
        <div class="col-xl-3 col-md-3 col-sm-6 ">
            <div class="card update-card"  style="background-color:#FFCD7F !important">
                <div class="card-block">
                    <div class="row align-items-end">
                        <div class="col-8">
                            <h4 class="text-white"></h4>
                            <h6 class="text-white m-b-0">My Profile</h6>
                        </div>
                        <div class="col-4 text-right"><iframe class="chartjs-hidden-iframe" style="display: block; overflow: hidden; border: 0px none; margin: 0px; inset: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;" tabindex="-1" __idm_frm__="10737418263"></iframe>
                            <canvas id="update-chart-1" height="50" style="display: block; width: 45px; height: 50px;" width="45"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('advisor.profile_self') }}" target="_blank">View Profile</a>
                </div>
            </div>
        </div>
        <!-- first Block End-->
        <!-- Second Block Start-->
        <!-- Regulated advice color code #2c77b3 -->
        <div class="col-xl-3 col-md-3 col-sm-6">
            <div class="card update-card" style="background-color:#2c77b3 !important">
                <div class="card-block">
                    <div class="row align-items-end">
                        <div class="col-8">
                            <h4 class="text-white"></h4>
                            <h6 class="text-white m-b-0">Marketing Badges</h6>
                        </div>
                        <div class="col-4 text-right"><iframe class="chartjs-hidden-iframe" style="display: block; overflow: hidden; border: 0px none; margin: 0px; inset: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;" tabindex="-1" __idm_frm__="10737418265"></iframe>
                            <canvas id="update-chart-2" height="50" style="display: block; width: 45px; height: 50px;" width="45"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('advisor.marketing_profile') }}"> Download Marketing Badges</a>
                </div>
            </div>
        </div>
        
        <!-- Second Block End-->
        <!-- Third Block End-->
        
        <div class="col-xl-3 col-md-3 col-sm-6">
            <div class="card bg-c-pink update-card">
                <div class="card-block">
                    <div class="row align-items-end">
                        <div class="col-8">
                            <h6 class="text-white m-b-0">Billing Information</h6>
                        </div>
                        <div class="col-4 text-right"><iframe class="chartjs-hidden-iframe" style="display: block; overflow: hidden; border: 0px none; margin: 0px; inset: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;" tabindex="-1" __idm_frm__="10737418265"></iframe>
                            <canvas id="update-chart-2" height="50" style="display: block; width: 45px; height: 50px;" width="45"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('advisor.billing_info') }}"> View Billing Information</a>
                </div>
            </div>
        </div>
        
        <!-- Third Block End-->
        <!-- Fourth Block Start-->
        <div class="col-xl-3 col-md-3 col-sm-6">
            <div class="card update-card"  style="background-color:#FFCD7F !important">
                <div class="card-block">
                    <div class="row align-items-end">
                        <div class="col-8">
                            <h4 class="text-white"></h4>
                            <h6 class="text-white m-b-0">Match Rating</h6>
                        </div>
                        <div class="col-4 text-right"><iframe class="chartjs-hidden-iframe" style="display: block; overflow: hidden; border: 0px none; margin: 0px; inset: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;" tabindex="-1" __idm_frm__="10737418265"></iframe>
                            <canvas id="update-chart-2" height="50" style="display: block; width: 45px; height: 50px;" width="45"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('advisor.match_rating') }}">Compare Your Match Rating</a>
                </div>
            </div>
        </div> 
        
        
        <!-- 5h Block Start-->
        <!-- Regulated advice color code #2c77b3 -->
        <div class="col-xl-3 col-md-3 col-sm-6">
            <div class="card update-card" style="background-color:#2c77b3 !important">
                <div class="card-block">
                    <div class="row align-items-end">
                        <div class="col-8">
                            <h4 class="text-white">{{ $total_question ?? "" }}</h4>
                            <h6 class="text-white m-b-0">Questions</h6>
                        </div>
                        <div class="col-4 text-right"><iframe class="chartjs-hidden-iframe" style="display: block; overflow: hidden; border: 0px none; margin: 0px; inset: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;" tabindex="-1" __idm_frm__="10737418265"></iframe>
                            <canvas id="update-chart-2" height="50" style="display: block; width: 45px; height: 50px;" width="45"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('advisor.question.list') }}">View Questions</a>
                </div>
            </div>
        </div> 

        <!-- 6th Start -->
        <div class="col-xl-3 col-md-3 col-sm-6">
            <div class="card update-card bg-c-pink ">
                <div class="card-block">
                    <div class="row align-items-end">
                        <div class="col-8">
                            <h4 class="text-white">{{ $total_testimonial ?? "" }}</h4>
                            <h6 class="text-white m-b-0">Testimonials</h6>
                        </div>
                        <div class="col-4 text-right"><iframe class="chartjs-hidden-iframe" style="display: block; overflow: hidden; border: 0px none; margin: 0px; inset: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;" tabindex="-1" __idm_frm__="10737418265"></iframe>
                            <canvas id="update-chart-2" height="50" style="display: block; width: 45px; height: 50px;" width="45"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('advisor.testimonial.list') }}">View Testimonials</a>
                </div>
            </div>
        </div> 

        <!-- 7th Start -->
        <div class="col-xl-3 col-md-3 col-sm-6">
            <div class="card update-card"  style="background-color:#FFCD7F !important">
                <div class="card-block">
                    <div class="row align-items-end">
                        <div class="col-8">
                            <h4 class="text-white">{{ $total_leads ?? "" }}</h4>
                            <h6 class="text-white m-b-0">Leads</h6>
                        </div>
                        <div class="col-4 text-right"><iframe class="chartjs-hidden-iframe" style="display: block; overflow: hidden; border: 0px none; margin: 0px; inset: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;" tabindex="-1" __idm_frm__="10737418265"></iframe>
                            <canvas id="update-chart-2" height="50" style="display: block; width: 45px; height: 50px;" width="45"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('advisor.leads.list') }}">View Leads</a>
                </div>
            </div>
        </div> 

        <!-- 8th Start -->
        <!-- Regulated advice color code #2c77b3 -->
        <div class="col-xl-3 col-md-3 col-sm-6">
            <div class="card update-card" style="background-color:#2c77b3 !important">
                <div class="card-block">
                    <div class="row align-items-end">
                        <div class="col-8">
                            <h4 class="text-white">{{ $no_of_auction ?? "" }}</h4>
                            <h6 class="text-white m-b-0">Auction Room</h6>
                        </div>
                        <div class="col-4 text-right"><iframe class="chartjs-hidden-iframe" style="display: block; overflow: hidden; border: 0px none; margin: 0px; inset: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;" tabindex="-1" __idm_frm__="10737418265"></iframe>
                            <canvas id="update-chart-2" height="50" style="display: block; width: 45px; height: 50px;" width="45"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ Route('advisor.auction.list') }}">View Auction Room</a>
                </div>
            </div>
        </div> 

        <!-- 9th Part -->
        <div class="col-xl-3 col-md-3 col-sm-6">
            <div class="card bg-c-pink update-card">
                <div class="card-block">
                    <div class="row align-items-end">
                        <div class="col-8">
                            <h4 class="text-white">{{ $monthly_profile_visit}}</h4>
                            <h6 class="text-white m-b-0">Monthly Profile Page Views</h6>
                        </div>
                        <div class="col-4 text-right"><iframe class="chartjs-hidden-iframe" style="display: block; overflow: hidden; border: 0px none; margin: 0px; inset: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;" tabindex="-1" __idm_frm__="10737418265"></iframe>
                            <canvas id="update-chart-2" height="50" style="display: block; width: 45px; height: 50px;" width="45"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('advisor.visitor',['monthly']) }}">Monthly Profile Page Views</a>
                </div>
            </div>
        </div> 
 
        
    </div>
    <div class="row">
    <div class="col-12 mt-10">
        <div class="panel">
            <!-- Regulated advice color code #2c77b3 -->
            <div class="panel-heading bg-primary" style="background-color:#2c77b3 !important">
                <h3>Notes </h3>
            </div>
            <div class="panel-body p-5" style="box-shadow: 1px 5px 10px #aaa;">

                <div class="mb-5">
                    {!! $dashboard_profile_text !!}
                </div>

                <div class="bg-primary p-3 text-center" style="background-color:#2c77b3 !important">
                    Clients direct link to your profile:<br>
                    <a href="{{ $profile_link }}" class="btn btn-link text-white" target="_blank">{{ urldecode($profile_link) }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@else
    <div class="row">
    <!-- first Block Start-->
        <!--<div class="col-xl-3 col-md-3 col-sm-6 ">
            <div class="card bg-c-yellow update-card">
                <div class="card-block">
                    <div class="row align-items-end">
                        <div class="col-8">
                            <h4 class="text-white">{{ $my_advisors->count("id") ?? 0}}</h4>
                            <h6 class="text-white m-b-0">My Advisors</h6>
                        </div>
                        <div class="col-4 text-right"><iframe class="chartjs-hidden-iframe" style="display: block; overflow: hidden; border: 0px none; margin: 0px; inset: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;" tabindex="-1" __idm_frm__="10737418263"></iframe>
                            <canvas id="update-chart-1" height="50" style="display: block; width: 45px; height: 50px;" width="45"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('office_manager.advisor.list') }}" >My Advisors</a>
                </div>
            </div>
        </div>-->
        <div class="col-xl-3 col-md-3 col-sm-6">
            <div class="card bg-c-pink update-card">
                <div class="card-block">
                    <div class="row align-items-end">
                        <div class="col-8">
                            <h6 class="text-white m-b-0">Billing Information</h6>
                        </div>
                        <div class="col-4 text-right"><iframe class="chartjs-hidden-iframe" style="display: block; overflow: hidden; border: 0px none; margin: 0px; inset: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;" tabindex="-1" __idm_frm__="10737418265"></iframe>
                            <canvas id="update-chart-2" height="50" style="display: block; width: 45px; height: 50px;" width="45"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('office_manager.advisor.billing_info') }}"> View Billing Information</a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-3 col-sm-6">
            <div class="card update-card" style="background-color:#FFCD7F !important">
                <div class="card-block">
                    <div class="row align-items-end">
                        <div class="col-8">
                            <h4 class="text-white">{{ $no_of_auction ?? "" }}</h4>
                            <h6 class="text-white m-b-0">Auction Room</h6>
                        </div>
                        <div class="col-4 text-right"><iframe class="chartjs-hidden-iframe" style="display: block; overflow: hidden; border: 0px none; margin: 0px; inset: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;" tabindex="-1" __idm_frm__="10737418265"></iframe>
                            <canvas id="update-chart-2" height="50" style="display: block; width: 45px; height: 50px;" width="45"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ Route('advisor.auction.list') }}">View Auction Room</a>
                </div>
            </div>
        </div> 
    </div>

    <div class="row">
        @foreach($my_advisors as $advisor)
            <div class="col-xl-3 col-md-3 col-sm-6 mt-3">
                <div class="bg-theme text-center p-3" style="height: 250px;overflow: hidden;">
                    <center>
                        <img src="{{ asset(isset($advisor->image) && file_exists($advisor->image) ? $advisor->image : 'image/dummy_user.jpg') }}" class="img-fluid rounded-circle img-thumbnail" style="height: 120px; width:120px">
                    </center>
                    <p class="mt-3">
                        <!--<a class="text-white font-14" href="{{ route('advisor_profile',['profession' =>Str::slug($advisor->profession->name ?? 'N-A'), 'location' => str::slug($advisor->town ?? "N-A"), 'name_id' => $advisor->id .'-'.($advisor->first_name . '-' . $advisor->last_name)]) }}" target="_blank">-->
                        <a class="text-white font-14" href="{{ route('office_manager.advisor.view',[$advisor->id]) }}" target="_blank" >
                            {{$advisor->first_name }} {{$advisor->last_name }}
                        </a>
                    </p>
                    <h4 class="mt-3">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $advisor->non_specific_rating)
                                <i class="fas fa-star text-warning"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                    </h4>
                    @if($advisor->firm_details)
                        <p class="p-0 m-0 font-12 line-heigh-14">{{$advisor->firm_details->profile_name}}</p>
                    @endif
                    @if( ($advisor->testimonial->count() + $advisor->advisor_questions->count()) >= 2)
                        <p class="p-0 m-0 font-12 line-heigh-14"> {{  ($advisor->testimonial->count() + $advisor->advisor_questions->count()) }} Testimonials & Questions Answered</p>
                    @endif
                    
                </div>  
            </div>
        @endforeach
    </div>
@endif


@endsection
