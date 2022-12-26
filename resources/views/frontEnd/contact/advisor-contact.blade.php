@extends('frontEnd.masterPage')
@section('style')
    <style>
        .bg-custom{border-bottom: 1px solid #eee;}
        .form-control{height: 40px;}
        label{margin-bottom: 0px;}
    </style>
@stop
@section('script')
    <script>
        $(document).on('click', '.submit-form', function(e){
            e.preventDefault();
            let form_submit = false;
            $('.service_offer').each(function(index, input){
                if($(input).prop("checked")){
                    form_submit = true;
                }
            });
            if(form_submit){
                $('.service-error').addClass('d-none');
                $('.contact-form').submit();
            }else{
                $('.service-error').removeClass('d-none');
            }
        });
    </script>
@stop
@section('mainPart')
    <div class="container-md">    
        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-10 mt-5 mb-5">
                {!! Form::open(["url" => $form_url, "class" => "contact-form row"]) !!}
                    <div class="col-md-5">
                        <div class="border p-3" style="border-radius: 5px;">
                            <h4 class="mt-2 mb-2">What would you like advice on? <span class="text-danger">*</span></h4>
                            <div class="service-error text-danger font-13 d-none">Areas of advice required</div>
                            @foreach ($service_offers as $service_offer)
                                <label>
                                    <input type="checkbox" name="service_offer_id[]" class="service_offer" value="{{ $service_offer->id }}"
                                    @if(!empty($lead) && is_array($lead->service_offer_id) && in_array($service_offer->id, $lead->service_offer_id))
                                        checked
                                    @endif >
                                    {{ $service_offer->name }}
                                </label><br>
                            @endforeach
                        </div> 
                        
                    </div>
                    <div class="col-md-7 mt-4 mt-md-0">
                        <div class="card" style="border-top-right-radius: 20px;border-top-left-radius: 20px;">
                            <div class="card-header text-white" style="background: #2c77b3; border-top-right-radius: 20px;border-top-left-radius: 20px;border-bottom:0px;"><h4 class="mb-0" style="color:#fff" >Nearly done! Now we can put you in touch...</h4></div>
                            <div class="card-body" style="border:15px solid #2c77b3;" >
                                @if(empty($lead))
                                    <div class="p-1">
                                        <label>First name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control"  required value="{{ old('name') }}">
                                        @if($errors->has('name'))
                                            <div class="text-danger font-13">
                                                <strong>{{ $errors->first('name') }} </strong>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="p-1">
                                        <label>Last name <span class="text-danger">*</span></label>
                                        <input type="text" name="last_name" class="form-control"  value="{{ old('last_name') }}" required>
                                        @if($errors->has('last_name'))
                                            <div class="text-danger font-13">
                                                <strong>{{ $errors->first('last_name') }} </strong>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="p-1">
                                        <label>Email address <span class="text-danger">*</span></label>
                                       <input type="text" name="email" class="form-control verify" data-verify_type="email" data-page="search" required value="{{ old('email') }}">
                                        @if($errors->has('email'))
                                            <div class="text-danger font-13">
                                                <strong>{{ $errors->first('email') }} </strong>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="p-1">
                                        <label>Telephone number <span class="text-danger">*</span></label>
                                        <input type="text" name="phone" class="form-control verify" data-verify_type="phone" data-page="search"  required value="{{ old('phone') }}">
                                        @if($errors->has('phone'))
                                            <div class="text-danger font-13">
                                                <strong>{{ $errors->first('phone') }} </strong>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="p-1">
                                        <label>Enter full postcode <span class="text-danger">*</span></label>
                                        <input type="text" name="post_code" class="form-control verify" data-verify_type="postcode" data-page="search"  value="{{ old('post_code') }}" >
                                        @if ($errors->has('post_code'))
                                            <div class="text-danger font-13">
                                                <strong>{{ $errors->first('post_code') }} </strong>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="p-2">
                                        <label>Type your question <span class="text-danger">*</span></label>
                                        <!--<input type="text" name="question" style="height:90px;" class="form-control break-word" value="{{ old('question') }}" required>-->
                                        <textarea type="text" name="question" style="min-height:150px;" class="form-control" value="{{ old('question') }}" required></textarea>
                                    </div>
                                    @if ($errors->has('question'))
                                        <div class="text-danger font-13">
                                            <strong>{{ $errors->first('question') }} </strong>
                                        </div>
                                    @endif
                                @endif
                                <div class="border p-2 pl-3 mt-3 ml-1">
                                    <h4 class="mb-0">Your fund / mortgage value <span class="text-danger">*</span> </h4>
 
                                    @foreach($fund_sizes->sortBy('min_fund') as $fund)
                                        <label>
                                            <input type="radio" name="fund_size_id" {{ isset($lead->fund_size_id) && $lead->fund_size_id == $fund->id ? 'checked' : null }} value="{{ $fund->id }}" required > {{ $fund->name }} 
                                        </label><br>
                                    @endforeach
                                    @if ($errors->has('fund_size_id'))
                                        <div class="text-danger font-13">
                                            <strong>{{ $errors->first('fund_size_id') }} </strong>
                                        </div>
                                    @endif
                                </div>

                                <div class="border p-2 pl-3 mt-3 ml-1">
                                    <h4 class="mb-0">I would like to receive my advice <span class="text-danger">*</span></h4>
                                    <label>
                                        <input type="radio" name="communication_type" value="Face to face" required {{ old('communication_type') == "Face to face" ? 'checked' : null }}> Face to face
                                    </label><br>
                                    <label>
                                        <input type="radio" name="communication_type" value="Over the phone" required {{ old('communication_type') == "Over the phone" ? 'checked' : null }}> Over the phone
                                    </label><br>
                                    <label>
                                        <input type="radio" name="communication_type" value="Online" required {{ old('communication_type') == "Online" ? 'checked' : null }}> Online
                                    </label><br>
                                    @if ($errors->has('communication_type'))
                                        <div class="text-danger font-13">
                                            <strong>{{ $errors->first('communication_type') }} </strong>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-1 mt-2">
                                    <button type="button" class="btn btn-md btn-success submit-form no-radius">Submit</button>
                                </div>                                
                            </div>
                            <!-- Advisor panel -->
                            <div style="position: absolute; bottom: -20px; background: #2c77b3; width:100%; padding:5px 15px 5px 0px;border-bottom-left-radius: 20px; border-bottom-right-radius: 20px; " class="text-right text-white">
                                <i aria-hidden="true" class="fa fa-circle text-success"></i> {{ $total_advisor }} active advisors.
                            </div>
                        </div>                        
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection