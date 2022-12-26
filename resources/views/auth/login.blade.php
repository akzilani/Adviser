@extends('frontEnd.masterPage')

@section("style")
    <style>
        .login-panel-left{
            height: 100vh;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-image: url('{{asset('image/login-bg.png')}}');
        }
        .learn-button{text-align: center; border:1px solid #fff; padding: 10px 15px; color: #fff;}
        .bg-custom, .footer, .mobile-menu{display: none !important;}        
        
    </style>
@stop
@section("vendor_script")
    {!! ReCaptcha::htmlScriptTagJsApi() !!}
@stop
@section('mainPart')


<div class="container-fluid" style="background: #eee;">
    <div class="row h-100 align-items-center">
        <div class="col-md-6 login-panel-left" >
            <a href="{{ url('') }}" >
                <img src="{{ asset("image/logo-white.png") }}" class="img img-fluid mt-3">
            </a>
            <p class="mt-5 text-center text-white">AVAILABLE ON BASIC PLAN</p>
            <h2 class="text-center text-white p-5">Introducing The Auction Room Conversion Cloud</h2>
            <h4 class="text-center text-white p-3">Bid on the postcode. Bid on the portfolio size. Improve your digital advertising ROI.</h4>
            <div class="text-center m-5">
                <a class="learn-button" target="_blank" href="https://www.rmtdirect.com">LEARN MORE</a>                
            </div>
            <p class="text-center text-white p-5" >Driving conversions for Leading Financial Advisor Brands</p>
        </div>
        <div class="col-md-6 justify-content-center mt-5">
            <div class="col-md-12 col-lg-10 col-xl-8">
                <div class="card no-border">
                    <div class="card-header no-border pb-0">
                        <div class="row">
                            <div class="col-6 text-center" style="background-color:#2E86C1;color:#FDFEFE;font-weight: bold;font-size:17px;height:30px;">Log in</div>
                            <div class="col-6 text-center" style="background-color:#2ECC71;color:#FDFEFE;font-weight: bold;font-size:17px;height:30px;">
                                <a class="" href="{{ route('register') }}">Sign up</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">                        
                            @csrf

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="example@gmail.com" >
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="******" >
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <button type="button" class="btn btn-sm" id="view-password"><i class="far fa-eye fa-lg"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Rechapcha --->
                            <div class="form-group">
                                <div class="col-md-12 p-0">    
                                    {!! htmlFormSnippet() !!}
                                    @if ($errors->has('g-recaptcha-response'))    
                                        <span class="text-danger">    
                                            {{ $errors->first('g-recaptcha-response') }}
                                        </span>
                                    @endif    
                                </div>    
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label font-14" for="remember">
                                            {{ __('Remember me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            

                            <div class="form-group row mb-0">
                                <div class="col-md-12">
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link pl-0 font-14 " style="font-weight: bold;" href="{{ route('password.request') }}">
                                            {{ __('Forgot password?') }}
                                        </a>
                                    @endif
                                    
                                    <br/>

                                    <button type="submit" class="btn  no-radius " style="background-color:#2E86C1;color:#FDFEFE;font-weight: bold;width:100%;">
                                        {{ __('Login') }}
                                    </button>

                                    
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
            </div>            
        </div>
        
    </div>
</div>
@stop
@section("script")
<script>
	let view_password = false;
	$(document).on("click", "#view-password", function(){
		if(!view_password){
			$("#password").attr("type", "text");
			$(this).html(`<i class="far fa-eye-slash fa-lg"></i>`);
			view_password = true;
		}else{
			$("#password").attr("type", "password");
			$(this).html(`<i class="far fa-eye fa-lg"></i>`);
			view_password = false;
		}
	});
</script>
@endsection
