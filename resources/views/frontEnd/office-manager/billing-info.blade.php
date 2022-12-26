@extends('frontEnd.advisor.masterPage')
@section('mainPart')

    <div class="row justify-content-center">
        <div class="col-lg-10 col-md-12">
            <form action="{{ $form_url }}" class="row form-horizontal" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="col-12 mt-10">
                    @include('frontEnd.advisor.include.alert')
                    <h3>Office Manager Billing Info</h3>
                    <hr/>
                </div>

                <!--  Billing ID -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label class="font-weight-bold">Billing ID</label>
                        <input type="disabled" class="form-control"  value="{{ $billing_info->id }}" readonly >
                    </div>
                </div>

                <!-- Contact Name -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label class="font-weight-bold">Contact Name</label>
                        <input type="disabled" class="form-control"  value="{{ $billing_info->contact_name ?? 'N/A' }}" readonly >
                    </div>
                </div>

                <!-- Subscribe Plan -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label class="font-weight-bold">Subscription Plan</label>
                        <input type="disabled" class="form-control"  value="{{ $advisor->subscription_plan->name ?? 'N/A' }}" readonly >
                    </div>
                </div>
    
                <!--  Address 1 -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label class="font-weight-bold">Address Line 1 <span class="text-danger">*</span></label>
                        <input type="text" class="form-control{{ $errors->has('billing_address_line_one') ? ' is-invalid' : '' }}" name="billing_address_line_one" value="{{ old("billing_address_line_one") ?? ($billing_info->billing_address_line_one ?? ( $advisor->billing_address_line_one ?? "") )}}"  required readonly >
                        @if ($errors->has('billing_address_line_one'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('billing_address_line_one') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                
                <!--  Address 2 -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label class="font-weight-bold">Address Line 2</label>
                        <input type="text" class="form-control{{ $errors->has('billing_address_line_two') ? ' is-invalid' : '' }}" name="billing_address_line_two" value="{{ old("billing_address_line_two") ?? ($billing_info->billing_address_line_two ?? ($advisor->billing_address_line_two ?? "") )}}"  readonly >
                        @if ($errors->has('billing_address_line_two'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('billing_address_line_two') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
    
                <!--  Company Name -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label class="font-weight-bold">Company Name </label>
                        <input type="text" class="form-control{{ $errors->has('billing_company_name') ? ' is-invalid' : '' }}" name="billing_company_name" value="{{ old("billing_company_name") ?? ($billing_info->billing_company_name ?? ($advisor->firm_details->profile_name ?? "") )}}"  readonly >
                        @if ($errors->has('billing_company_name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('billing_company_name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
    
                <!--  Address 2 -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label class="font-weight-bold">Company Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control{{ $errors->has('billing_company_fca_number') ? ' is-invalid' : '' }}" name="billing_company_fca_number" value="{{ old("billing_company_fca_number") ?? ($billing_info->billing_company_fca_number ?? ($advisor->personal_fca_number ?? "") )}}"  readonly >
                        @if ($errors->has('billing_company_fca_number'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('billing_company_fca_number') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
    
                <!--  Town -->
                <div class="col-4">
                    <div class="form-group">
                        <label class="font-weight-bold">Town <span class="text-danger">*</span></label>
                        <input type="text" class="form-control{{ $errors->has('billing_town') ? ' is-invalid' : '' }}" name="billing_town" value="{{ old("billing_town") ?? ($billing_info->billing_town ?? ($advisor->town ?? "") )}}"  required  readonly >
                        @if ($errors->has('billing_town'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('billing_town') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
    
                <!--  County -->
                <div class="col-4">
                    <div class="form-group">
                        <label class="font-weight-bold">County <span class="text-danger">*</span></label>
                        <input type="text" class="form-control{{ $errors->has('billing_country') ? ' is-invalid' : '' }}" name="billing_country" value="{{ old("billing_country") ?? ($billing_info->billing_country ?? ($advisor->country ?? "") )}}" required readonly>
                        @if ($errors->has('billing_country'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('billing_country') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <!--  Postcode -->
                <div class="col-4">
                    <div class="form-group">
                        <label class="font-weight-bold">Postcode <span class="text-danger">*</span></label>
                        <input type="text" class="form-control{{ $errors->has('billing_post_code') ? ' is-invalid' : '' }}" name="billing_post_code" value="{{ old("billing_post_code") ?? ($billing_info->billing_post_code ?? ($advisor->post_code ?? ""))}}" required readonly >
                        @if ($errors->has('billing_post_code'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('billing_post_code') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <!--  Terms_and_condition_agree_date -->
                <div class="col-4">
                    <div class="form-group">
                        <label class="font-weight-bold">Date Agreeing to Terms and Conditions <span class="text-danger">*</span></label>
                        <input type="text" class="form-control{{ $errors->has('terms_and_condition_agree_date') ? ' is-invalid' : '' }}" name="terms_and_condition_agree_date" value="{{ old("terms_and_condition_agree_date") ?? $advisor->terms_and_condition_agree_date ?? "" }}" readonly >
                    </div>
                </div>

                <!--  No of_subscription_accounts -->
                <div class="col-4">
                    <div class="form-group">
                        <label class="font-weight-bold">Number of Subscription Accounts<span class="text-danger">*</span></label>
                        <input type="number" step="any" class="form-control{{ $errors->has('no_of_subscription_accounts') ? ' is-invalid' : '' }}" name="no_of_subscription_accounts" value="{{ old("no_of_subscription_accounts") ?? $advisor->no_of_subscription_accounts ?? ($advisor->subscription_plan->max_advisor ?? "0") }}" readonly >
                    </div>
                </div>

                <!-- PostCode cover Area-->
                <!--<div class="col-12">
                    <div class="form-group">
                        <label class="font-weight-bold">Postcode Areas Covered</label>
                        <textarea readonly class="form-control" style="min-height: 120px;">{{ $advisor->postcodesCovered() }}</textarea>
                    </div>
                </div>-->

                <!-- Subscribe Primary Location-->
                 <!-- <div class="col-12">
                    <div class="form-group">
                        <label class="font-weight-bold">Primary Subscription Locations </label>
                        <input readonly class="form-control" value="{{ $advisor->subscribe_primary_reason() }}">
                    </div>
                </div>-->
                
                <!-- Subscribe PostCode cover Area-->
                <!--<div class="col-12">
                    <div class="form-group">
                        <label class="font-weight-bold">Subscription Postcodes</label>
                        <textarea readonly class="form-control" style="min-height: 120px;">{{ $advisor->postcodesCovered(null, true) }}</textarea>
                    </div>
                </div>-->
    
                <!--submit -->
                <div class="col-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" style="display: none;">Save </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection