@extends('frontEnd.advisor.masterPage')
@section('mainPart')
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-8 col-md-12">
            <form action="{{ $form_url }}" class="row form-horizontal" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="col-12 mt-10">
                    @include('frontEnd.advisor.include.alert')
                    <h3>Firm Information</h3>
                    <hr/>
                </div>
                 
                <!-- Firm Profile Name -->
                <div class="col-12 col-sm-6 ">
                    <div class="form-group">
                        <label>Profile Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control{{ $errors->has('profile_name') ? ' is-invalid' : '' }}" name="profile_name" value="{{ old("profile_name") ?? ($firm_details->profile_name ?? "")}}"  required >
                        @if ($errors->has('profile_name'))
                            <span class="text-danger" role="alert">
                                <strong>{{ $errors->first('profile_name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                
                 <!--  Address 1 -->
                 <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Address Line 1 <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" value="{{ $advisor->address_line_one ?? "" }}" required {{ $readonly ?? "readonly" }} >
                    </div>
                </div>

                <!--  Address 2 -->
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Address Line 2 </label>
                        <input type="text" class="form-control"  value="{{ $advisor->address_line_two ?? "" }}" {{ $readonly ?? "readonly" }}>
                    </div>
                </div>

                <!--  Town -->
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Town <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="firm_town" value="{{ $advisor->town ?? "" }}" {{ $readonly ?? "readonly" }} required >
                    </div>
                </div>

                <!--  County -->
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>County <span class="text-danger">*</span></label>
                        <input type="text" class="form-control"  value="{{ $advisor->country ?? "" }}" {{ $readonly ?? "readonly" }} required >
                        @if ($errors->has('firm_country'))
                            <span class="text-danger" role="alert">
                                <strong>{{ $errors->first('firm_country') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Firm FCA Ref. Number -->
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Firm FCA Ref. Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control{{ $errors->has('firm_fca_number') ? ' is-invalid' : '' }}" name="firm_fca_number" value="{{ old("firm_fca_number") ?? ($firm_details->firm_fca_number ?? "")}}"  required >
                        @if ($errors->has('firm_fca_number'))
                            <span class="text-danger" role="alert">
                                <strong>{{ $errors->first('firm_fca_number') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Firm Website URL -->
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Firm Website URL <span class="text-danger">*</span></label>
                        <input type="url" class="form-control{{ $errors->has('firm_website_address') ? ' is-invalid' : '' }}" name="firm_website_address" value="{{ old("firm_website_address") ?? ($firm_details->firm_website_address ?? "")}}" required >
                        @if ($errors->has('firm_website_address'))
                            <span class="text-danger" role="alert">
                                <strong>{{ $errors->first('firm_website_address') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Linkedin URL -->
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Linkedin URL</label>
                        <input type="url" class="form-control{{ $errors->has('linkedin_id') ? ' is-invalid' : '' }}" name="linkedin_id" value="{{ old("linkedin_id") ?? ($firm_details->linkedin_id ?? "")}}" >
                        @if ($errors->has('linkedin_id'))
                            <span class="text-danger" role="alert">
                                <strong>{{ $errors->first('linkedin_id') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
               
                <!-- Firm profile_details -->
                <div class="col-12">
                    <div class="form-group">
                        <label>About Firm </label>
                        <textarea class="form-control editor {{ $errors->has('profile_details') ? ' is-invalid' : '' }}"  name="profile_details" >
                            {{ old("profile_details") ?? ($firm_details->profile_details ?? "")}}
                        </textarea>
                        <!--
                        @if ($errors->has('profile_details'))
                            <span class="text-danger" role="alert">
                                <strong>{{ $errors->first('profile_details') }}</strong>
                            </span>
                        @endif
                        -->
                    </div>
                </div>

                

                <!-- Post Code Cover Area -->
                <div class="col-12">
                    <div class="form-group">
                        <label>Postcode Areas Covered</label>
                        <textarea class="form-control" readonly style="min-height:150px;" >{{ $advisor->postcodesCovered($advisor->location_postcode_id) }}</textarea>
                        <!--
                        @if ($errors->has('profile_details'))
                            <span class="text-danger" role="alert">
                                <strong>{{ $errors->first('profile_details') }}</strong>
                            </span>
                        @endif
                        -->
                    </div>
                </div>

                 <!--submit -->
                 <div class="col-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Update </button>
                    </div>
                </div>
                

            </form>
        </div>
    </div>

    <script>
        $(document).on("submit", "form", function(e){
            var invalid_input = false;
            var inputs = $("form input");
            inputs.each(function(index, input){
                if($(input).val() == "tbc" || $(input).val() == "TBC"){
                    invalid_input = true;                 
                }
            });
            if(invalid_input){
                e.preventDefault();
                alert("Please Fillup All Fields.")
            }
        });
    </script>
@endsection