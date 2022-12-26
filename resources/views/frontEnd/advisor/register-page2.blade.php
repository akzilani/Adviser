@extends('frontEnd.masterPage')
@section('style')
    <style>
        .heading-box{border: 1px solid blue;}
        .input-grid{background: #eee; border-radius: 3px;}
        .select2-container .select2-selection--single{ height: 44px !important; border-radius: 0px; border:1px solid #333; }
        .select2-container--default .select2-selection--multiple{min-height: 44px !important; border-radius: 0px; border:1px solid #333; }
        .select2-container--default .select2-selection--single .select2-selection__rendered{line-height: 40px;}
        .form-control{border:1px solid #333; color: #333;}
        label{color:#333}
        .location{font-size:13px;}
        .line{ width: 100%; height: 2px; }
        .line-blue{background: blue; }
        .reason h4{padding-bottom: 0px;margin-top: 15px;}
        .bg-custom, .footer, .mobile-menu{display: none !important;}  

    </style>
@endsection
@section('mainPart')

    <div class="row justify-content-center mt-5">
        <div class="col-lg-8 col-md-6 col-sm-12">
            @include('frontEnd.advisor.include.alert')
        </div>
        <div class="col-lg-8 col-md-6 col-sm-12">
            <h3 class="text-left">Required Location  & Billing Information Details</h3>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-6 col-sm-12">
            <form action="{{ $form_url }}" class="row form-horizontal" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- First Part -->
                <div class="col-md-6 mt-5">
                    <div class="p-3 input-grid">
                        <div class="row">
                            <div class="col-12">
                                <div class="heading-box p-2">
                                    <span class="badge badge-primary">3</span>
                                    Location 
                                </div>
                            </div>
                            <div class="col-12 text-danger pb-2">
                                * Indicates mandatory field
                            </div>

                            <!-- Select Primary Region -->
                            {{-- <div class="col-12">
                                <div class="form-group">
                                    <label>Primary Region <span class="text-danger">*</span></label>
                                    <select class="form-control select2" name="primary_region_id" required>
                                        <option value="">Select Primary Region</option>
                                        @foreach ($reasons as $reason)
                                            <option value="{{ $reason->id }}" {{ old('primary_region_id') == $reason->id ? "selected" : ( isset($advisor->primary_region_id) && $advisor->primary_region_id == $reason->id ? "selected" : Null ) }} >{{ $reason->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}

                            <div class="col-12 mt-10">
                                <label class="font-weight-bold">
                                    <input type="checkbox" class="all-reason"> UK
                                </label>
                            </div>
                            @foreach ($reasons as $reason)
                                <div class="col-12 mt-10 row reason">
                                    <div class="col-12">
                                        <h4>
                                            <label> <input type="checkbox" class="select-all_reason"> <b>{{$reason->name }} </b></label>
                                        </h4>
                                        <div class="line line-blue"></div>
                                    </div>

                                    @foreach ($reason->location_post_codes as $location)
                                        <div class="col-6 mt-1 location">
                                            <label> <input type="checkbox" value="{{ $location->id }}" name="location_postcode_id[]" {{ isset($advisor->location_postcode_id) && is_array($advisor->location_postcode_id) && in_array($location->id, $advisor->location_postcode_id) ? "checked" : Null }} > {{ $location->full_name }} </label>
                                        </div>
                                    @endforeach
                                </div>                       
                            @endforeach
                            
                        </div>
                    </div>                    
                </div>

                <!-- Second Part -->
                <div class="col-md-6 mt-5">
                    <div class="p-3 input-grid">
                        <div class="row">
                            <div class="col-12">
                                <div class="heading-box p-2">
                                    <span class="badge badge-primary">4</span>
                                    Services Offered
                                </div>
                            </div>
                            <div class="col-12 text-danger pb-2">
                                * Indicates mandatory field
                            </div>  

                            <!-- Service Offer -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Services Offered <span class="text-danger">*</span></label>
                                    <select class="form-control select2" multiple name="service_offered_id[]">
                                        <option value="">Select Service Offers</option>
                                        @foreach($service_offers as $type)
                                            <option value="{{ $type->id }}" {{ old('service_offered_id') && is_array( old('service_offered_id') ) && in_array($type->id, old('service_offered_id')) ? 'selected' : ( isset($advisor->service_offered_id) && is_array($advisor->service_offered_id) && in_array($type->id, $advisor->service_offered_id) ? "selected" : Null ) }} >{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Fund Size -->
                            <div class="col-12">
                                <h4>Minimum Fund Size </h4>
                            </div>                            
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Fund Size <span class="text-danger">*</span></label>
                                    <select class="form-control select2" name="fund_size_id" required >
                                        <option value="">Select Fund Size</option>
                                        @foreach ($fund_sizes as $item)
                                            <option value="{{ $item->id }} " {{ old('fund_size_id') == $item->id ? "selected" : ( isset($advisor->fund_size_id) && $advisor->fund_size_id == $item->id ? "selected" : Null ) }} >{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Fund Size -->
                            <div class="col-12">
                                <h4>Billing Information </h4>
                            </div> 
                            <!-- Contact Name -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Contact Name  <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ ($advisor->first_name ?? '').' '.($advisor->last_name ?? '')}}" name="contact_name" class="form-control" required />
                                </div>
                            </div>
                            <!--  Company Name -->
                            <div class="col-12 ">
                                <div class="form-group">
                                    <label>Company Name </label>
                                    <input type="text" class="form-control{{ $errors->has('billing_company_name') ? ' is-invalid' : '' }}" name="billing_company_name" value="{{ old("billing_company_name") ?? ($advisor->billing_info->billing_company_name ?? "")}}"  >
                                    @if ($errors->has('billing_company_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('billing_company_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <!--  Company Number / Personal FCA Number -->
                            <div class="col-12 ">
                                <div class="form-group">
                                    <label>Company Number (if applicable) </label>
                                    <input type="text" class="form-control{{ $errors->has('billing_company_fca_number') ? ' is-invalid' : '' }}" name="billing_company_fca_number" value="{{ old("billing_company_fca_number") ?? ($advisor->billing_info->billing_company_fca_number ?? ($advisor->personal_fca_number ?? ""))}}"  >
                                    @if ($errors->has('billing_company_fca_number'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('billing_company_fca_number') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!--  Address 1 -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Address Line 1 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control{{ $errors->has('billing_address_line_one') ? ' is-invalid' : '' }}" name="billing_address_line_one" value="{{ old("billing_address_line_one") ?? ($advisor->billing_info->billing_address_line_one ?? ($advisor->address_line_one ?? ""))}}" required >
                                    @if ($errors->has('billing_address_line_one'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('billing_address_line_one') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!--  Address 2 -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Address Line 2</label>
                                    <input type="text" class="form-control{{ $errors->has('billing_address_line_two') ? ' is-invalid' : '' }}" name="billing_address_line_two" value="{{ old("billing_address_line_two") ?? ($advisor->billing_info->billing_address_line_two ?? ($advisor->address_line_two ?? ""))}}"  >
                                    @if ($errors->has('billing_address_line_two'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('billing_address_line_two') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            

                            <!--  Town -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Town <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control{{ $errors->has('billing_town') ? ' is-invalid' : '' }}" name="billing_town" value="{{ old("billing_town") ?? ($advisor->billing_info->billing_town ?? ($advisor->town))}}"  required >
                                    @if ($errors->has('billing_town'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('billing_town') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!--  Country -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label>County <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control{{ $errors->has('billing_country') ? ' is-invalid' : '' }}" name="billing_country" value="{{ old("billing_country") ?? ($advisor->billing_info->billing_country ?? ($advisor->country ?? ''))}}"  required >
                                    @if ($errors->has('billing_country'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('billing_country') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <!--  Postcode -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Postcode <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control{{ $errors->has('billing_post_code') ? ' is-invalid' : '' }}" name="billing_post_code" value="{{ old("billing_post_code") ?? ($advisor->billing_info->billing_post_code ?? ($advisor->post_code ?? ''))}}"  required >
                                    @if ($errors->has('billing_post_code'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('billing_post_code') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!--submit -->
                            <div class="col-12 mt-2 text-right">
                                <div class="form-group ">
                                    <button type="submit" class="btn btn-info">Save </button>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
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

    $(document).on('change', '.all-reason', function(){
        let reason = $('.reason input[type="checkbox"]');
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

</script>
@endsection
