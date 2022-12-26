@extends('backEnd.masterPage')
@section('mainPart')
<div class="row justify-content-center">
    <div class="col-12 col-lg-12 mt-2 mb-2">
        @include('backEnd.includes.alert')
    </div>
    <div class="col-12 col-lg-12 mt-2 mb-2">
        <div class="card">
            <div class="card-header bg-info">
                {{ $title ?? ""}}
            </div>
            <div class="card-body">
                <form action="{{ $form_url }}" class="row form-horizontal" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="col-12 mt-10">
                        <h3>Advisor Basic Information</h3>
                        <input type="hidden" name="id" value="{{ $data->id ?? 0 }}">
                        <hr/>
                    </div>                    

                    <!-- First Name -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>First Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" id="first_name" value="{{ old("first_name") ?? ($data->first_name ?? "")}}"  required >
                            @if ($errors->has('first_name'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- last Name -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>Last Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" id="last_name" value="{{ old("last_name") ?? ($data->last_name ?? "")}}"  required >
                            @if ($errors->has('last_name'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    

                    <!-- Email -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>Email <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="far fa-envelope"></i></span>
                                <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} verify" name="email" value="{{ old("email") ?? ($data->email ?? "")}}" data-verify_type="email"  required >
                            </div>
                            @if ($errors->has('email'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                     <!-- Password -->
                     <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>Password @if(!isset($data)) <span class="text-danger">*</span> @endif</label>
                            <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" minlength="3" name="password" value="{{ !isset($data->id) ? Str::random(6) : ''}}"  autocomplete="off" {{ isset($data->id) ? null : 'required'}}>
                            @if ($errors->has('password'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Phone Number -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>Phone Number <span class="text-danger">*</span> </label>                            
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                                <input type="text" maxlength="11" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }} verify" data-verify_type="phone" name="phone" value="{{ old("phone") ?? ($data->phone ?? "")}}"  required >
                            </div>
                            @if ($errors->has('phone'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <!--  Address 1 -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>Address Line 1 <span class="text-danger">*</span></label>
                            <input type="text" class="form-control{{ $errors->has('address_line_one') ? ' is-invalid' : '' }}" name="address_line_one" id="address_line_one" value="{{ old("address_line_one") ?? ($data->address_line_one ?? "")}}" required >
                            @if ($errors->has('address_line_one'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('address_line_one') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <!--  Address 2 -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>Address Line 2</label>
                            <input type="text" class="form-control{{ $errors->has('address_line_two') ? ' is-invalid' : '' }}" name="address_line_two" id="address_line_two" value="{{ old("address_line_two") ?? ($data->address_line_two ?? "")}}"  >
                            @if ($errors->has('address_line_two'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('address_line_two') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <!--  Town -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>Town <span class="text-danger">*</span></label>
                            <input type="text" class="form-control{{ $errors->has('town') ? ' is-invalid' : '' }}" name="town" id="town" value="{{ old("town") ?? ($data->town ?? "")}}" required >
                            @if ($errors->has('town'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('town') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <!--  County -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>County <span class="text-danger">*</span></label>
                            <input type="text" class="form-control{{ $errors->has('country') ? ' is-invalid' : '' }}" name="country" id="country" value="{{ old("country") ?? ($data->country ?? "")}}" required >
                            @if ($errors->has('country'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('country') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <!--  Postcode -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>Postcode <span class="text-danger">*</span></label>
                            <input type="text" class="form-control{{ $errors->has('post_code') ? ' is-invalid' : '' }} verify" data-verify_type="postcode" name="post_code" id="post_code" value="{{ old("post_code") ?? ($data->post_code ?? "")}}" required >
                            @if ($errors->has('post_code'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('post_code') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Subscription Plan -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>Subscription Plan <span class="text-danger">*</span></label>
                            <select class="form-control select2" name="subscription_plan_id" required>
                                <option value="">Select Subscription Plan</option>
                                @foreach ($subscription_plans as $item)
                                    <option value="{{$item->id}}" {{ old('subscription_plan_id') == $item->id ? "selected" : ( isset($data->subscription_plan_id) && $data->subscription_plan_id == $item->id ? "selected" : Null ) }} >{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('subscription_plan_id'))                                
                                <span class="text-danger font-10" role="alert">
                                    <strong>{{ $errors->first('subscription_plan_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>    
                    
                    <!-- Number of Subscription Accounts -->
                     <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>Number of Subscription Accounts <span class="text-danger">*</span></label>
                            <input type="number" step="any" min="0" name="no_of_subscription_accounts" class="form-control" value="{{ $data->no_of_subscription_accounts ?? 0  }}" required >
                        </div>
                    </div>
                    
                    <!-- Date Agree of Trems & condition -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>Date Agreeing to Terms and Conditions</label>
                            <input type="date" name="terms_and_condition_agree_date" class="form-control" value="{{ isset($data->terms_and_condition_agree_date) ? $data->terms_and_condition_agree_date : Carbon\Carbon::parse($data->created_at ?? now())->format('Y-m-d') }}" >
                        </div>
                    </div>

                    
                    @if(!$edit)
                    <div class="col-12 mt-5">
                        <h3>Firm Details</h3>
                        <hr/>
                    </div>
                     
                    <!-- Firm Profile Name -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>Firm Name {!! $edit ? '<span class="text-danger">*</span>' : ''!!}</label>
                            <input type="text" class="form-control{{ $errors->has('profile_name') ? ' is-invalid' : '' }}" name="profile_name" value="{{ old("profile_name") ?? ($data->firm_details->profile_name ?? "")}}" {{ $edit ? 'required' : Null }}>
                            @if ($errors->has('profile_name'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('profile_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    

                    <!-- Firm FCA Ref. Number -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>Firm FCA Ref. Number {!! $edit ? '<span class="text-danger">*</span>' : ''!!}</label>
                            <input type="text" class="form-control{{ $errors->has('firm_fca_number') ? ' is-invalid' : '' }}" name="firm_fca_number" value="{{ old("firm_fca_number") ?? ($data->firm_details->firm_fca_number ?? "")}}" {{ $edit ? 'required' : null }}>
                            @if ($errors->has('firm_fca_number'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('firm_fca_number') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Firm Website URL -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>Firm Website URL {!! $edit ? '<span class="text-danger">*</span>' : ''!!}</label>
                            <input type="url" class="form-control{{ $errors->has('firm_website_address') ? ' is-invalid' : '' }}" name="firm_website_address" value="{{ old("firm_website_address") ?? ($data->firm_details->firm_website_address ?? "")}}" {{ $edit ? 'required' : null }} >
                            @if ($errors->has('firm_website_address'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('firm_website_address') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Linkedin URL -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>Linkedin URL</label>
                            <input type="url" class="form-control{{ $errors->has('linkedin_id') ? ' is-invalid' : '' }}" name="linkedin_id" value="{{ old("linkedin_id") ?? ($data->firm_details->linkedin_id ?? "")}}" >
                            @if ($errors->has('linkedin_id'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('linkedin_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Firm profile_details -->
                    <div class="col-12 col-sm-6 col-md-4 d-none"> 
                        <div class="form-group">
                            <label>Firm Details </label>                            
                            <textarea class="form-control{{ $errors->has('profile_details') ? ' is-invalid' : '' }}" name="profile_details" >{{ old("profile_details") ?? ($data->firm_details->profile_details ?? "")}}</textarea>
                            @if ($errors->has('profile_details'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('profile_details') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    @endif

                                 
                    <div class="col-12 mt-5">
                        <h3>Advisor Billing Info</h3>
                        <hr/>
                    </div>

                    <!-- Contact Name -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>Contact Name  <span class="text-danger">*</span></label>
                            <input type="text" value="{{ old('contact_name') ?? ($data->billing_info->contact_name ?? '') }}" name="contact_name" class="form-control" required />
                        </div>
                    </div>

                    <!--  Address 1 -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>Address Line 1 <span class="text-danger">*</span></label>
                            <input type="text" class="form-control{{ $errors->has('billing_address_line_one') ? ' is-invalid' : '' }}" name="billing_address_line_one" id="billing_address_line_one" value="{{ old("billing_address_line_one") ?? ($data->billing_info->billing_address_line_one ?? "")}}" required >
                            @if ($errors->has('billing_address_line_one'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('billing_address_line_one') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <!--  Address 2 -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>Address Line 2</label>
                            <input type="text" class="form-control{{ $errors->has('billing_address_line_two') ? ' is-invalid' : '' }}" name="billing_address_line_two" id="billing_address_line_two" value="{{ old("billing_address_line_two") ?? ($data->billing_info->billing_address_line_two ?? "")}}" >
                            @if ($errors->has('billing_address_line_two'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('billing_address_line_two') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <!--  Company name -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>Company Name</label>
                            <input type="text" class="form-control{{ $errors->has('billing_company_name') ? ' is-invalid' : '' }}" name="billing_company_name" id="billing_company_name" value="{{ old("billing_company_name") ?? ($data->billing_info->billing_company_name ?? "")}}" >
                            @if ($errors->has('billing_company_name'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('billing_company_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <!--  Company FCA Number -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>Company Number</label>
                            <input type="text" class="form-control{{ $errors->has('billing_company_fca_number') ? ' is-invalid' : '' }}" name="billing_company_fca_number" id="billing_company_fca_number" value="{{ old("billing_company_fca_number") ?? ($data->billing_info->billing_company_fca_number ?? "")}}"  >
                            @if ($errors->has('billing_company_fca_number'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('billing_company_fca_number') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    

                    <!--  Town -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>Town</label>
                            <input type="text" class="form-control{{ $errors->has('billing_town') ? ' is-invalid' : '' }}" name="billing_town" id="billing_town" value="{{ old("billing_town") ?? ($data->billing_info->billing_town ?? "")}}"  >
                            @if ($errors->has('billing_town'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('billing_town') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <!--  County -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>County <span class="text-danger">*</span></label>
                            <input type="text" class="form-control{{ $errors->has('billing_country') ? ' is-invalid' : '' }}" name="billing_country" value="{{ old("billing_country") ?? ($data->billing_info->billing_country ?? "")}}" id="billing_country" required >
                            @if ($errors->has('billing_country'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('billing_country') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <!--  Postcode -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-group">
                            <label>Postcode <span class="text-danger">*</span></label>
                            <input type="text" class="form-control{{ $errors->has('billing_post_code') ? ' is-invalid' : '' }}" name="billing_post_code" id="billing_post_code" value="{{ old("billing_post_code") ?? ($data->billing_info->billing_post_code ?? "")}}" required >
                            @if ($errors->has('billing_post_code'))
                                <span class="text-danger" role="alert">
                                    <strong>{{ $errors->first('billing_post_code') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <!--submit -->
                    <div class="col-12 text-right">
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-info">submit </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@stop
@section("script")
<script>
    $(document).on("click", ".select-all_reason", function(){
        let reason = $(this).parents(".reason").find('.location input[type="checkbox"]');
        if($(this).prop("checked")){
            reason.each(function(i, input){
                $(input).prop('checked', true);
            });
        }else{
            reason.each(function(i, input){
                $(input).prop('checked', false);
            });
        }
    });

    $(document).on("change", ".advisor_type", function(){
        let next_child;
        if( $(this).val() == 1){
            next_child = $('.advisor_type')[1];
            $(next_child).prop("checked", false);
        }
        if( $(this).val() == 2){
            next_child = $('.advisor_type')[0];
            $(next_child).prop("checked", false);
        }
        if( $(this).val() == 3){
            next_child = $('.advisor_type')[3];
            $(next_child).prop("checked", false);
        }
        if( $(this).val() == 4){
            next_child = $('.advisor_type')[2];
            $(next_child).prop("checked", false);
        }
    });

    // Town
    $('#town').keyup(function (e) { 
        $("#billing_town").val($(this).val());
    });
    // Country
    $('#country').keyup(function (e) { 
        $("#billing_country").val($(this).val());
    });
    // Postcode
    $('#post_code').keyup(function (e) { 
        $("#billing_post_code").val($(this).val());
    });
    // FCA Number
    $('#personal_fca_number').keyup(function (e) { 
        $("#billing_company_fca_number").val($(this).val());
    });
    // Name
    $('#first_name, #last_name').keyup(function (e) { 
        $("#billing_company_name").val( $("#first_name").val() + " " + $("#last_name").val());
    });
    // Address One 
    $('#address_line_one').keyup(function (e) { 
        $("#billing_address_line_one").val($(this).val());
    });
    // Address Two 
    $('#address_line_two').keyup(function (e) { 
        $("#billing_address_line_two").val($(this).val());
    });

</script>
@endsection

