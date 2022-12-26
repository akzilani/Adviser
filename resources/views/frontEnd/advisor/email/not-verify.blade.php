@extends('frontEnd.advisor.masterPage')

@section('mainPart')
    <div class="container-fluid">    
        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-10 text-center">
                <div style="margin-top:50px;">
                    
                       <h3 class="text-info"> Congratulations! Your signup process was completed successfully. </h3> <br/>
                    
                        @if( Session::has('message') )
                            <div class="alert alert-info">{{Session::get('message')}}</div>
                        @endif

                        <h3>Dear {{$advisor->first_name.' '.$advisor->last_name }},</h3>
                        <h3 class="text-danger"> Email address is not verified. Please verify your email </h3>
                        <a href="{{ route('advisor.verify.email_send') }}" class="btn btn-link">Click here to resend verification email</a>
                    </h3>
                </div>
            </div>
        </div>
    </div>
@endsection