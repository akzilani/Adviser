@extends('frontEnd.masterPage')
@section('style')
    <style>
        .heading-box{border: 1px solid blue;}
        .input-grid{background: #eee; border-radius: 3px;box-shadow: 0px 7px 10px #aaa;}
        .select2-container .select2-selection--single, .select2-container--default .select2-selection--multiple{ height: 44px !important; border-radius: 0px; border:1px solid #333; }
        .select2-container--default .select2-selection--single .select2-selection__rendered{line-height: 40px;}
        .form-control, .input-group-text{border:1px solid #333; color: #333; border-radius: 0px;}
        label{color:#333}
        .btn-sm{padding: 0.20rem .5rem;}
        .bg-custom, .footer, .mobile-menu{display: none !important;}  
        .register-page-header{text-align: left;}
        @media only screen and (max-width: 767px){
            .register-page-header{text-align: center;}
        }
    </style>
@endsection
@section('mainPart')
    <div class="row justify-content-center mt-4 mt-lg-5">
        <div class="col-sm-10 col-md-8">
            @include('frontEnd.advisor.include.alert')
        </div>
        <div class="col-sm-10 col-md-10">
            <h3 class="register-page-header">Required Basic Information & Address Details</h3>
        </div>
    </div>
    
    <div class="row justify-content-center mb-5">
        <div class="col-lg-10 col-sm-12">
            <form action="{{ $form_url }}" class="row form-horizontal" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="office_manager_id" value="{{$subscription_plan->id}}">
                <!-- First Part -->
                <div class="col-md-6 mt-3 mt-lg-4">
                    <div class="p-3 input-grid">
                        <div class="row">
                            <div class="col-12">
                                <div class="heading-box p-2">
                                    <span class="badge badge-primary">1</span>
                                    Basic Information 
                                </div>
                            </div>
                            <div class="col-12 text-danger pb-2">
                                * Indicates mandatory field
                            </div>
                            <!-- First Name -->
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label>First Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ old("first_name") ?? ($data->first_name ?? "")}}"  required >
                                    @if ($errors->has('first_name'))
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $errors->first('first_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <!-- last Name -->
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label>Last Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old("last_name") ?? ($data->last_name ?? "")}}"  required >
                                    @if ($errors->has('last_name'))
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $errors->first('last_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Telephone Number -->
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label>Mobile Number <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                                        <input type="text" name="phone" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }} verify" data-verify_type="phone" data-page="signup" value="{{ old("phone") ?? ($data->phone ?? "")}}" required >
                                    </div>
                                   
                                    @if ($errors->has('phone'))
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>                            
                            
                            <!-- Password -->
                            <div class="col-12 col-sm-6">
                                <label>Password <span class="text-danger">*</span></label>
                                <div class="input-group">                                    
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required >
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <button type="button" class="btn btn-sm" id="view-password"><i class="far fa-eye fa-lg"></i></button>
                                        </span>
                                    </div>
                                    @if ($errors->has('password'))
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-12 col-sm-12">
                                <div class="form-group">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="far fa-envelope"></i></span>
                                        <input type="email" class="form-control verify {{ $errors->has('email') ? ' is-invalid' : '' }}" data-verify_type="email" data-page="signup" name="email" value="{{ old("email") ?? ($data->email ?? "")}}" required >
                                    </div>
                                    
                                    @if ($errors->has('email'))
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Subscription Plan -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Subscription Plan <span class="text-danger">*</span></label>
                                    <select class="form-control" name="subscription_plan_id" required>
                                        <option value="">Select Subscription Plan</option>
                                        <option value="{{$subscription_plan->id}}" {{ old('subscription_plan_id') == $subscription_plan->id ? "selected" : ( Session::get('subscription_plan_id') == $subscription_plan->id ? "selected" : Null ) }} >{{ $subscription_plan->name }}</option>
                                    </select>
                                </div>
                            </div>
                            
                        </div>
                    </div>                    
                </div>

                <!-- Second Part -->
                <div class="col-md-6 mt-4 mt-lg-4">
                    <div class="p-3 input-grid">
                        <div class="row">
                            <div class="col-12">
                                <div class="heading-box p-2">
                                    <span class="badge badge-primary">2</span>
                                    Address & Firm Details 
                                </div>
                            </div>
                            <div class="col-12 text-danger pb-2">
                                * Indicates mandatory field
                            </div>
                            <div class="col-12">
                                <h4>Firm Address</h4>
                            </div>

                            
                            <!--  Address 1 -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Address Line 1 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control{{ $errors->has('address_line_one') ? ' is-invalid' : '' }}" name="address_line_one" value="{{ old("address_line_one") ?? ($data->address_line_one ?? "")}}" required >
                                    @if ($errors->has('address_line_one'))
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $errors->first('address_line_one') }}</strong>
                                        </span>
                                    @endif
                                </div>                            
                            </div>
                            <!--  Address 2 -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Address Line 2</label>
                                    <input type="text" class="form-control{{ $errors->has('address_line_two') ? ' is-invalid' : '' }}" name="address_line_two" value="{{ old("address_line_two") ?? ($data->address_line_two ?? "")}}" >
                                    @if ($errors->has('address_line_two'))
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $errors->first('address_line_two') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <!--  Town -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Town <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control{{ $errors->has('town') ? ' is-invalid' : '' }}" name="town" value="{{ old("town") ?? ($data->town ?? "")}}" required >
                                    @if ($errors->has('town'))
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $errors->first('town') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <!--  County -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>County <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control{{ $errors->has('country') ? ' is-invalid' : '' }}" name="country" value="{{ old("country") ?? ($data->country ?? "")}}"  required >
                                    @if ($errors->has('country'))
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $errors->first('country') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!--  Postcode -->
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Postcode <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control {{ $errors->has('post_code') ? ' is-invalid' : '' }} verify" data-verify_type="postcode" data-page="signup" name="post_code" value="{{ old("post_code") ?? ($data->post_code ?? "")}}" required >
                                    @if ($errors->has('post_code'))
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $errors->first('post_code') }}</strong>
                                        </span>
                                    @endif
                                    @if(Session::has('false_postcode'))
                                        <span class="text-danger" role="alert">
                                            <strong>{{ Session::get('false_postcode') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Firm Info -->
                            <div class="col-12">
                                <h4>Firm Information </h4>
                            </div>

                            
                            <!-- Firm Profile Details -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Firm Name <span class="text-danger">*</span></label>
                                    <input type="text"  class="form-control{{ $errors->has('firm_name') ? ' is-invalid' : '' }}" name="firm_name" value="{{ old("firm_name") ?? ($data->firm_details->profile_name ?? "")}}" required >
                                    @if ($errors->has('firm_name'))
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $errors->first('firm_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Firm profile_details -->
                            <div class="col-12 d-none">
                                <div class="form-group">
                                    <label>Firm Details</label>
                                    <input type="text" class="form-control{{ $errors->has('firm_details') ? ' is-invalid' : '' }}" name="firm_details" value="{{ old("firm_details") ?? ($data->firm_details->profile_details ?? "")}}"  >
                                    @if ($errors->has('firm_details'))
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $errors->first('firm_details') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Firm FCA Ref. Number -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Firm FCA Ref. Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control{{ $errors->has('firm_fca_number') ? ' is-invalid' : '' }}" name="firm_fca_number" value="{{ old("firm_fca_number") ?? ($data->firm_details->firm_fca_number ?? "")}}" required >
                                    @if ($errors->has('firm_fca_number'))
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $errors->first('firm_fca_number') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Firm Website URL -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Firm Website URL <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control{{ $errors->has('firm_website_address') ? ' is-invalid' : '' }}" name="firm_website_address" value="{{ old("firm_website_address") ?? ($data->firm_details->firm_website_address ?? "")}}" required >
                                    @if ($errors->has('firm_website_address'))
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $errors->first('firm_website_address') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Linkedin URL -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Linkedin URL </label>
                                    <input type="url" class="form-control{{ $errors->has('linkedin_id') ? ' is-invalid' : '' }}" name="linkedin_id" value="{{ old("linkedin_id") ?? ($data->firm_details->linkedin_id ?? "")}}" >
                                    @if ($errors->has('linkedin_id'))
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $errors->first('linkedin_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label> <input type="checkbox" id="i-agree" required > Please read our Terms & Conditions </label>
                                </div>
                            </div>
                            <!--submit -->
                            <div class="col-12 mt-2 text-right">
                                <div class="form-group submit-button invisible">
                                    <button type="submit" class="btn btn-info">Submit</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" keyboard="false" data-backdrop="static" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Terms & Conditions</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! $trems_and_condition->trems_and_condition ?? "" !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger dis-agree">Close</button>
                    <button type="button" class="btn btn-success agree">I Agree</button>                    
                  </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        $(document).on('click', '#i-agree', function(){
            $(this).prop('checked', false);
            $('.modal').modal('show');
        });

        $(document).on('click', '.agree', function(){
            $('#i-agree').prop('checked', true);
            $('.submit-button').removeClass('invisible');
            $('.modal').modal('hide');
        });
        $(document).on('click', '.dis-agree', function(){
            $('#i-agree').prop('checked', false);
            $('.submit-button').addClass('invisible');
            $('.modal').modal('hide');
        });


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