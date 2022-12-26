@extends('frontEnd.advisor.masterPage')
@section('mainPart')

    <div class="row justify-content-center">
        <div class="col-lg-10 col-md-12">
            <form action="{{ $form_url }}" id="profile-update" class="row form-horizontal" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="col-12 mt-10">
                    @include('frontEnd.advisor.include.alert')
                    <h3>Advisor Basic Information</h3>
                    <hr/>
                </div>

                <!--  Advisor Profession-->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>Advisor Profession <span class="text-danger">*</span></label>
                        <select class="form-control select2" name="profession_id">
                            <option value="">Select Advisor Profession</option>
                            @foreach($professions as $item)
                                <option value="{{ $item->id }}" {{ old('profession_id') && old('profession_id') == $item->id ? 'selected' : (isset($data->profession_id) && $data->profession_id == $item->id ? "selected" : Null) }}> {{ $item->name }} </option>     
                            @endforeach                           
                        </select>
                    </div>
                </div>

                <!-- Forst Name -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>First Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ old("first_name") ?? ($data->first_name ?? "")}}" required >
                        @if ($errors->has('first_name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('first_name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <!-- last Name -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>Last Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old("last_name") ?? ($data->last_name ?? "")}}"  required >
                        @if ($errors->has('last_name'))
                            <span class="invalid-feedback" role="alert">
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
                            <input type="email" class="form-control verify {{ $errors->has('email') ? 'is-invalid' : 'is-valid' }}" data-verify_type="email" name="email" value="{{ old("email") ?? ($data->email ?? "")}}" required readonly >
                        </div>
                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Phone Number -->
                <!--<div class="col-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>Phone Number <span class="text-danger">*</span> </label>                        
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                            <input type="text" maxlength="15" class="form-control {{ $errors->has('phone') ? ' is-invalid' : 'is-valid' }} verify" data-verify_type="phone" name="phone" value="{{ old("phone") ?? ($data->phone ?? "")}}" required >
                        </div>
                        @if ($errors->has('phone'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('phone') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>-->

                <!-- Telephone Number -->
                <!--<div class="col-12 col-sm-6 col-md-4 d-none">
                    <div class="form-group">
                        <label>Assigned Telephone Number</label>
                        <input type="text" maxlength="15" class="form-control{{ $errors->has('telephone') ? ' is-invalid' : '' }}" name="telephone" value="{{ old("telephone") ?? ($data->telephone ?? "")}}"  >
                        @if ($errors->has('telephone'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('telephone') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>-->

                <!-- Personal FCA Ref. Number -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>Personal FCA Ref. Number</label>
                        <input type="text" class="form-control{{ $errors->has('personal_fca_number') ? ' is-invalid' : '' }}" name="personal_fca_number" value="{{ old("personal_fca_number") ?? ($data->personal_fca_number ?? "")}}" >
                        @if ($errors->has('personal_fca_number'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('personal_fca_number') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                
                <!--  FCA Status Effective Date -->
                <!--<div class="col-12 col-sm-6 col-md-4" style="display: none;">
                    <div class="form-group">
                        <label>FCA Status Effective Date</label>
                        <input type="date" class="form-control{{ $errors->has('fca_status_date') ? ' is-invalid' : '' }}" name="fca_status_date" value="{{ old("fca_status_date") ?? ($data->fca_status_date ?? "")}}" >
                        @if ($errors->has('fca_status_date'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('fca_status_date') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>-->

                <!--  Address 1 -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>Address Line 1 <span class="text-danger">*</span></label>
                        <input type="text" class="form-control{{ $errors->has('address_line_one') ? ' is-invalid' : '' }}" name="address_line_one" value="{{ old("address_line_one") ?? ($data->address_line_one ?? "")}}"  required >
                        @if ($errors->has('address_line_one'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('address_line_one') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <!--  Address 2 -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>Address Line 2</label>
                        <input type="text" class="form-control{{ $errors->has('address_line_two') ? ' is-invalid' : '' }}" name="address_line_two" value="{{ old("address_line_two") ?? ($data->address_line_two ?? "")}}"  >
                        @if ($errors->has('address_line_two'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('address_line_two') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <!--  Town -->
                <div class="col-4">
                    <div class="form-group">
                        <label>Town <span class="text-danger">*</span></label>
                        <input type="text" class="form-control{{ $errors->has('town') ? ' is-invalid' : '' }}" name="town" value="{{ old("town") ?? ($data->town ?? "")}}"  required >
                        @if ($errors->has('town'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('town') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <!--  County -->
                <div class="col-4">
                    <div class="form-group">
                        <label>County <span class="text-danger">*</span></label>
                        <input type="text" class="form-control{{ $errors->has('country') ? ' is-invalid' : '' }}" name="country" value="{{ old("country") ?? ($data->country ?? "")}}" required >
                        @if ($errors->has('country'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('country') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <!--  Postcode -->
                <div class="col-4">
                    <div class="form-group">
                        <label>Postcode <span class="text-danger">*</span></label>
                        <input type="text" class="form-control{{ $errors->has('post_code') ? ' is-invalid' : ' is-valid' }} verify" data-verify_type="postcode" name="post_code" value="{{ old("post_code") ?? ($data->post_code ?? "")}}" required >
                        @if ($errors->has('post_code'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('post_code') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Type of Advisor -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>Fund / Mortgage Value <span class="text-danger">*</span></label>
                        <select class="form-control select2" name="fund_size_id" required >
                            <option value="">Select Fund / Mortgage Value</option>
                            @foreach ($fund_sizes as $item)
                                <option value="{{ $item->id }} " {{ old('fund_size_id') == $item->id ? "selected" : ( isset($data->fund_size_id) && $data->fund_size_id == $item->id ? "selected" : Null ) }} >{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!--  Longitude -->
                <div class="col-4">
                    <div class="form-group">
                        <label>Longitude </label>
                        <input type="text" class="form-control{{ $errors->has('longitude') ? ' is-invalid' : '' }}" name="longitude" value="{{ old("longitude") ?? ($data->longitude ?? "")}}">
                        @if ($errors->has('longitude'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('longitude') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                

                <!--  Latitude -->
                <div class="col-4">
                    <div class="form-group">
                        <label>Latitude </label>
                        <input type="text" class="form-control{{ $errors->has('latitude') ? ' is-invalid' : '' }}" name="latitude" value="{{ old("latitude") ?? ($data->latitude ?? "")}}">
                        @if ($errors->has('latitude'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('latitude') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Live Status -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label>Advisor Account Status<span class="text-danger">*</span></label>
                        <select class="form-control select2" name="is_live" required >
                            <option value=""> Advisor Status</option>
                            <option value="1" {{ old('is_live') == '1' ? "selected" : ( isset($data->is_live) && $data->is_live == '1' ? "selected" : Null ) }}>Active</option>
                            <option value="0" {{ old('is_live') == '0' ? "selected" : ( isset($data->is_live) && $data->is_live == '0' ? "selected" : Null ) }}>Pause</option>
                        </select>
                        @if($errors->has('is_live'))                                
                            <span class="text-danger font-10" role="alert">
                                <strong>{{ $errors->first('is_live') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Select Primary Region -->
                <!--<div class="col-12 col-sm-6 col-md-4 d-none">
                    <div class="form-group">
                        <label>Primary Region <span class="text-danger">*</span></label>
                        <select class="form-control select2" name="primary_region_id" required >
                            <option value="">Select Primary Region</option>
                            @foreach ($reasons as $reason)
                                <option value="{{ $reason->id }}" {{ old('primary_region_id') == $reason->id ? "selected" : ( isset($data->primary_region_id) && $data->primary_region_id == $reason->id ? "selected" : Null ) }} >{{ $reason->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>-->

                <!-- About Me -->
                <div class="col-12">
                    <div class="form-group">
                        <label>About Me </label>
                        <textarea name="profile_brief" class="form-control editor"  style="min-height: 150px">{{ old('profile_brief') ?? ($data->profile_brief ?? '') }}</textarea>
                    </div>
                </div>

                <!-- Service Offer -->
                <div class="col-12">
                    <div class="form-group">
                        <label>Areas of Advice <span class="text-danger">*</span></label>
                        <select class="form-control select2" multiple name="service_offered_id[]" required >
                            <option value="">Select Areas of Advice</option>
                            @foreach($service_offers as $type)
                                <option value="{{ $type->id }}" {{ old('service_offered_id') && is_array( old('service_offered_id') ) && in_array($type->id, old('service_offered_id')) ? 'selected' : ( isset($data->service_offered_id) && is_array($data->service_offered_id) && in_array($type->id, $data->service_offered_id) ? "selected" : Null ) }} >{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- Type of Advisor -->
                <div class="col-12  col-md-6">
                    <div class="form-group">
                        <label>Advisor Types <span class="text-danger">*</span></label><br>
                        @foreach($advisor_types as $type)
                            <label>
                                <input type="checkbox" class="advisor_type" name="advisor_type_id[]" value="{{ $type->id }}" {{ isset($data->advisor_type_id) && in_array($type->id, $data->advisor_type_id) ? 'checked' : Null }} >
                                {{ $type->name }}
                            </label><br>
                        @endforeach
                        <div class="text-danger" id="type_error"></div>
                    </div>
                </div>

                <div class="col-12">
                    <hr/>
                    <h3 class="font-weight-bold">Postcode Areas Covered</h3>
                    @foreach ($reasons as $reason)
                        <div class="col-12 mt-10 row reason">
                            <div class="col-12">

                                <h4 class="p-0 m-0 mt-2">
                                    <label class="font-weight-bold font-16">
                                        <input type="checkbox" class="select-all_reason"> {{$reason->name }}
                                    </label>
                                </h4>
                                <div class="line line-blue"></div>
                            </div>

                            @foreach ($reason->location_post_codes as $location)
                                <div class="col-6 col-sm-4 col-md-3 mt-1 location">
                                    <label> <input type="checkbox" value="{{ $location->id }}" name="location_postcode_id[]" {{ isset($data->location_postcode_id) && is_array($data->location_postcode_id) && in_array($location->id, $data->location_postcode_id) ? "checked" : Null }} > {{ $location->full_name }} </label>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>

                <!-- Advisor Image -->
                <div class="col-12 mt-3">
                    <label><b>Profile Picture</b></label><br>
                    <input type="file" name="image" accept="image/png, image/jpeg">
                </div>

                <!--submit -->
                <div class="col-12 mt-5">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Update </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
@stop
@section('script')
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

    $(document).on('submit', "#profile-update", function(e){
        let type_fillup = false;
        $(".advisor_type").each(function(index, checkbox){
            if($(checkbox).prop("checked") == true){
                type_fillup = true;
            }            
        });
        if(!type_fillup){
            e.preventDefault();
            $("#type_error").text("This field is required")
            $(".advisor_type").focus();
        }else{
            $("#type_error").text("");
        }
        
    });
</script>

@endsection