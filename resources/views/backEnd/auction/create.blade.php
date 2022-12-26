<div class="modal-content">            
    <div class="modal-header">
        <h5 class="modal-title" > {{ $title ?? "Create/Edit"}} </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div> 
    {!! Form::open(['url'=> $form_url, 'method' => 'post', 'files' => 'true','class'=>'ajax-form']) !!}
        <input type="hidden" name="id" value="{{ isset($data->id) ? $data->id : 0 }}" >
        <input type="hidden" name="mail_send" value="{{ isset($mail_send) ? $mail_send : (!isset($data->id) ? 1 : 0) }}" >

        <div class="modal-body">
            <div class="row">
                <!-- postCode -->
                <div class="col-12 col-sm-3">
                    <div class="form-group">
                        <label>Postcode <span class="text-danger">*</span></label>                                
                        <input type="text" name="post_code" class="form-control" value="{{ $data->post_code ??  null }}" required  >
                    </div>                        
                </div>
                <!-- Select Primary Region -->
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Primary Region <span class="text-danger">*</span></label>
                        <select class="form-control select2" name="primary_region_id[]" multiple required>
                            <option value="" disabled >Select Primary Region</option>
                            @foreach ($reasons as $reason)
                                <option value="{{ $reason->id }}" {{ old('primary_region_id') && is_array( old('primary_region_id') ) && in_array($reason->id, old('primary_region_id')) ? 'selected' : ( isset($data->primary_region_id) && is_array($data->primary_region_id) && in_array($reason->id, $data->primary_region_id) ? "selected" : Null ) }} >{{ $reason->name }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('primary_region_id'))                                
                            <span class="text-danger font-10" role="alert">
                                <strong>{{ $errors->first('primary_region_id') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Select Profession -->
                <div class="col-12 col-sm-3">
                    <div class="form-group">
                        <label>Advisor Profession <span class="text-danger">*</span></label>
                        <select class="form-control select2" name="profession_id"  required>
                            <option value="" >Select Profession</option>
                            @foreach ($professions as $profession)
                                <option value="{{ $profession->id }}" {{ old('profession_id') == $profession->id ? 'selected' : ( isset($data->profession_id) && $data->profession_id ==  $profession->id ? "selected" : Null ) }} >{{ $profession->name }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('profession_id'))                                
                            <span class="text-danger font-10" role="alert">
                                <strong>{{ $errors->first('profession_id') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="col-12 col-sm-3">
                    <div class="form-group">
                        <label>Fund Size <span class="text-danger">*</span></label>                        
                        <select name="fund_size_id" class="form-control select2" required>
                            <option value="">Select Fund Size</option>
                            @foreach($fund_sizes as $fund)
                                <option value="{{ $fund->id }}" {{ isset($data->fund_size_id) && $data->fund_size_id == $fund->id ? 'selected' : Null }}>{{ $fund->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Communication Type -->
                <div class="col-6 col-sm-3 ">
                    <div class="form-group">
                        <label>Communication Type </label>
                        <select name="communication_type" class="form-control" >
                            <option value="">Select Communication Type</option>
                            <option value="Face to face" {{ isset($data->id) && $data->communication_type == "Face to face" ? 'selected' : Null }}>Face to face</option>
                            <option value="Over the phone" {{ isset($data->id) && !$data->communication_type == "Over the phone" ? 'selected' : Null }} >Over the phone</option>                           
                            <option value="Online" {{ isset($data->id) && !$data->communication_type == "Online" ? 'selected' : Null }} >Online</option>                           
                            <option value="Others" {{ isset($data->id) && !$data->communication_type == "Others" ? 'selected' : Null }} >Others</option>                           
                        </select>
                    </div>
                </div>

                <!-- Auction Start Date -->
                <div class="col-6 col-sm-3">
                    <div class="form-group">
                        <label>Auction Start Date<span class="text-danger">*</span></label>                                
                        <input type="date" name="start_date" class="form-control"  value="{{ isset($data->start_time) ? Carbon\Carbon::parse($data->start_time)->format('Y-m-d') : date('Y-m-d') }}" required >
                    </div>                        
                </div>
                
                <!-- Auction Start Time -->
                <div class="col-6 col-sm-3">
                    <div class="form-group">
                        <label>Auction Start Time<span class="text-danger">*</span></label>                                
                        <input type="time" name="start_time" class="form-control"  value="{{ isset($data->start_time) ? Carbon\Carbon::parse($data->start_time)->format('h:i') : now()->format('H:i') }}"  required >
                    </div>                        
                </div>                

                <!-- Auction End Time -->
                <div class="col-6 col-sm-3">
                    <div class="form-group">
                        <label>Auction End Time<span class="text-danger">*</span></label>  
                        <select class="form-control select2" name="end_time" required >
                            <option value="">Select Auction Time</option>
                            <option value="20 min" {{ isset($data->start_time) && Carbon\Carbon::parse($data->start_time)->diffInMinutes($data->end_time) == 20 ? 'selected' : null }} >20 mins</option>
                            <option value="40 min" {{ isset($data->start_time) && Carbon\Carbon::parse($data->start_time)->diffInMinutes($data->end_time) == 40 ? 'selected' : null }} >40 mins</option>
                            <option value="60 min" {{ isset($data->start_time) && Carbon\Carbon::parse($data->start_time)->diffInMinutes($data->end_time) == 60 ? 'selected' : null }} >60 mins</option>
                            <option value="2 hours" {{ isset($data->start_time) && Carbon\Carbon::parse($data->start_time)->diffInHours($data->end_time) == 2 ? 'selected' : null }} >2 hours</option>
                            <option value="3 hours" {{ isset($data->start_time) && Carbon\Carbon::parse($data->start_time)->diffInHours($data->end_time) == 3 ? 'selected' : null }} >3 hours</option>
                            <option value="4 hours" {{ isset($data->start_time) && Carbon\Carbon::parse($data->start_time)->diffInHours($data->end_time) == 4 ? 'selected' : null }} >4 hours</option>
                            <option value="5 hours" {{ isset($data->start_time) && Carbon\Carbon::parse($data->start_time)->diffInHours($data->end_time) == 5 ? 'selected' : null }} >5 hours</option>
                            <option value="6 hours" {{ isset($data->start_time) && Carbon\Carbon::parse($data->start_time)->diffInHours($data->end_time) == 6 ? 'selected' : null }} >6 hours</option>
                            <option value="7 hours" {{ isset($data->start_time) && Carbon\Carbon::parse($data->start_time)->diffInHours($data->end_time) == 7 ? 'selected' : null }} >7 hours</option>
                            <option value="8 hours" {{ isset($data->start_time) && Carbon\Carbon::parse($data->start_time)->diffInHours($data->end_time) == 8 ? 'selected' : null }} >8 hours</option>
                            <option value="9 hours" {{ isset($data->start_time) && Carbon\Carbon::parse($data->start_time)->diffInHours($data->end_time) == 9 ? 'selected' : null }} >9 hours</option>
                            <option value="10 hours" {{ isset($data->start_time) && Carbon\Carbon::parse($data->start_time)->diffInHours($data->end_time) == 10 ? 'selected' : null }} >10 hours</option>
                            <option value="11 hours" {{ isset($data->start_time) && Carbon\Carbon::parse($data->start_time)->diffInHours($data->end_time) == 11 ? 'selected' : null }} >11 hours</option>
                            <option value="12 hours" {{ isset($data->start_time) && Carbon\Carbon::parse($data->start_time)->diffInHours($data->end_time) == 12 ? 'selected' : null }} >12 hours</option>
                            <option value="24 hours" {{ isset($data->start_time) && Carbon\Carbon::parse($data->start_time)->diffInHours($data->end_time) == 24 ? 'selected' : null }} >24 hours</option>
                            <option value="48 hours" {{ isset($data->start_time) && Carbon\Carbon::parse($data->start_time)->diffInHours($data->end_time) == 48 ? 'selected' : null }} >48 hours</option>
                            <option value="72 hours" {{ isset($data->start_time) && Carbon\Carbon::parse($data->start_time)->diffInHours($data->end_time) == 72 ? 'selected' : null }} >72 hours</option>
                            <option value="No max time" {{ isset($data->start_time) && Carbon\Carbon::parse($data->start_time)->diffInYears($data->end_time) >= 99 ? 'selected' : null }} >No max time</option>
                        </select>
                    </div>                        
                </div>

                <!-- Base Price -->
                <div class="col-12 col-sm-3">
                    <div class="form-group">
                        <label>Reserve Price <span class="text-danger">*</span></label>                                
                        <input type="number" min="0" step="any" name="base_price" class="form-control" value="{{ $data->base_price ?? 1 }}" required  >
                    </div>                        
                </div>

                <!-- Buy Out Price -->
                <div class="col-12 col-sm-3 ">
                    <div class="form-group">
                        <label>Buy Out Price <span class="text-danger">*</span></label>                                
                        <input type="number" min="0" step="any" name="buy_out_price" class="form-control"  required value="{{ $data->buy_out_price ?? 0 }}" >
                    </div>                        
                </div>

                <!-- Min Bid Price -->
                <div class="col-12 col-sm-3 d-none">
                    <div class="form-group">
                        <label>Minimum Bid Price<span class="text-danger">*</span></label>                                
                        <input type="number" min="0" step="any" name="min_bid_price" class="form-control"  required value="{{ $data->min_bid_price ?? 1 }}" >
                    </div>                        
                </div>                

                <!-- Min Increment Price -->
                <div class="col-12 col-sm-3">
                    <div class="form-group">
                        <label>Minimum Bid Increment<span class="text-danger">*</span></label>                                
                        <input type="number" min="0" step="any" name="bid_increment" class="form-control"  required value="{{ $data->bid_increment ?? 1 }}" >
                    </div>                        
                </div>

                <!-- Status -->
                <div class="col-6 col-sm-3 ">
                    <div class="form-group">
                        <label>Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control" required >
                            <option value="">Select Status</option>
                            <option value="not_started" {{ isset($data->id) && $data->status == 'not_started' ? 'selected' : Null }}>Not Started</option>
                            <option value="running" {{ isset($data->id) && $data->status == 'running' ? 'selected' : Null }} >Running</option>                           
                            <option value="completed" {{ isset($data->id) && $data->status == 'completed' ? 'selected' : Null }} >Completed</option>                           
                            <option value="cancelled" {{ isset($data->id) && $data->status == 'cancelled' ? 'selected' : Null }} >Cancelled </option>                           
                        </select>
                    </div>
                </div>

                <!-- Type -->
                <div class="col-6 col-sm-3 ">
                    <div class="form-group">
                        <label>Type <span class="text-danger">*</span></label>
                        <select name="type" class="form-control" required >
                            <option value="">Select Type</option>
                            <option value="match me" {{ isset($data->id) && $data->type == 'match me' ? 'selected' : Null }}>Match Me</option>
                            <option value="search local" {{ isset($data->id) && $data->type == 'search local' ? 'selected' : Null }} >Search Local</option>
                        </select>
                    </div>
                </div> 

                <!-- Service Offer || Area of advice -->
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Areas of Advice <span class="text-danger">*</span> </label>                        
                        <select name="service_offer_id[]" class="form-control select2" multiple required >
                            <option value="">Select Areas of Advice</option>
                            @foreach($service_offer as $service)
                                <option value="{{ $service->id }}" {{ isset($data->service_offer_id) && is_array($data->service_offer_id) && in_array($service->id, $data->service_offer_id) ? 'selected' : Null }}>{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Question -->
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Question <span class="text-danger">*</span></label>                                
                        <textarea name="question" class="form-control"  required>{{ $data->question ?? null }}</textarea>
                    </div>                        
                </div>

                <div class="col-12 col-sm-6">
                    <label>Uploading</label>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"> 0% </div>
                    </div>
                </div>
            </div>            
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-danger float-left" data-dismiss="modal">Close</button>
                <button type="submit" name="btn" class="btn btn-sm btn-primary"> Save </button>
            </div>
        </div>
    {!! Form::close() !!}
</div>

<script>
    $('.select2').select2();
</script>


