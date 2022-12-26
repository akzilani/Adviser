<div class="modal-content">            
    <div class="modal-header">
        <h5 class="modal-title" > {{ $title ?? "Create/Edit"}} </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div> 
    {!! Form::open(['url'=> $form_url, 'method' => 'post', 'files' => 'true','class'=>'ajax-form']) !!}
        <div class="modal-body">
            <div class="row">
                <!-- Name -->
                <div class="col-12 col-sm-4 ">
                    <div class="form-group">
                        <label> First Name <span class="text-danger">*</span> </label>
                        <input type="hidden" name="id" value="{{ isset($data->id) ? $data->id : 0 }}" >                                
                        <input type="text"  name="name" value="{{ $data->name ?? Null }}" class="form-control" required >
                    </div>
                </div>

                <!--Last Name -->
                <div class="col-12 col-sm-4 ">
                    <div class="form-group">
                        <label>Last Name <span class="text-danger">*</span> </label>                       
                        <input type="text"  name="last_name" value="{{ $data->last_name ?? Null }}" class="form-control" required >
                    </div>
                </div>

                <!-- Email -->
                <div class="col-12 col-sm-4 ">
                    <div class="form-group">
                        <label>Email <span class="text-danger">*</span> </label>
                        <input type="text"  name="email" value="{{ $data->email ?? Null }}" class="form-control" required >
                    </div>
                </div>

                <!-- Telephone Number  -->
                <div class="col-12 col-sm-6 ">
                    <div class="form-group">
                        <label>Telephone Number <span class="text-danger">*</span> </label>
                        <input type="text" minlength="11" maxlength="13" name="phone" value="{{ $data->phone ?? Null }}" class="form-control" required >
                    </div>
                </div>

                 <!-- Postcode  -->
                 <div class="col-12 col-sm-6 ">
                    <div class="form-group">
                        <label>Postcode<span class="text-danger">*</span> </label>
                        <input type="text" minlength="4" maxlength="8"  name="post_code" value="{{ $data->post_code ?? Null }}" class="form-control" required >
                    </div>
                </div>

                <!-- Advisor -->
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Assigned Advisor</label>
                        <input type="hidden" name="id" value="{{ isset($data->id) ? $data->id : 0 }}" >                                
                        <select name="advisor_id" class="form-control select2" >
                            <option value="" >Select Assigned Advisor</option>
                            @foreach($advisors as $advisor)
                                <option value="{{ $advisor->id }}" {{ isset($data->id) && $data->advisor_id == $advisor->id ? 'selected' : Null }}>{{ $advisor->first_name }}  {{ $advisor->last_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Fund / Mortgage Value <span class="text-danger">*</span> </label>                        
                        <select name="fund_size_id" class="form-control select2" required >
                            <option value="">Select Fund Size</option>
                            @foreach($fund_sizes as $fund)
                                <option value="{{ $fund->id }}" {{ isset($data->id) && $data->fund_size_id == $fund->id ? 'selected' : Null }}>{{ $fund->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Date  -->
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Date <span class="text-danger">*</span> </label>
                        <input type="date" name="date" max="{{date('Y-m-d')}}" value="{{ $data->date ?? Null }}" class="form-control" required >
                    </div>
                </div>

                <!-- Communication Type -->
                <div class="col-6 col-sm-6 ">
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
                
                <!-- Question -->
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Question <span class="text-danger">*</span></label>                                
                        <textarea name="question" class="form-control"  required>{{ $data->question ?? null }}</textarea>
                    </div>                        
                </div>

                <!-- Service Offer -->
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Areas of Advice {!! isset($data->id) ? '<span class="text-danger">*</span>' : null !!}</label>                        
                        <select name="service_offer_id[]" class="form-control select2" multiple {{ isset($data->id) ? 'required' : null }} >
                            <option value="">Select Areas of Advice</option>
                            @foreach($service_offer as $service)
                                <option value="{{ $service->id }}" {{ isset($data->service_offer_id) && is_array($data->service_offer_id) && in_array($service->id, $data->service_offer_id) ? 'selected' : Null }}>{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                {{-- <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Chosen Advisor</label>                                
                        <select name="invite_advisors" class="form-control select2" >
                            <option value="" >Select Chosen Advisor</option>
                            @foreach($advisors as $advisor)
                                <option value="{{ $advisor->id }}" {{ isset($data->invite_advisors) && is_array($data->invite_advisors) &&  in_array($advisor->id, $data->invite_advisors) ? 'selected' : Null }}>{{ $advisor->first_name }} {{ $advisor->last_name }}</option>
                            @endforeach
                        </select>
                    </div>                        
                </div> --}}
                
                <!-- Lead Status -->
                <div class="col-6 col-sm-6 ">
                    <div class="form-group">
                        <label>Lead Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control" required >
                            <option value="">Select Lead Status</option>
                            @foreach ($status as $key => $status_data)
                                <option value="{{$key}}" {{ isset($data->id) && $data->status == $key ? 'selected' : Null }}>{{ $status_data }}</option>
                            @endforeach
                           
                        </select>
                    </div>
                </div>

                <!-- Publication Status -->
                <div class="col-6 col-sm-6 ">
                    <div class="form-group">
                        <label>Publication Status <span class="text-danger">*</span></label>
                        <select name="publication_status" class="form-control" required >
                            <option>Select Publication Status</option>
                            <option value="1" {{ isset($data->id) && $data->publication_status ? 'selected' : Null }}>Published</option>
                            <option value="0" {{ isset($data->id) && !$data->publication_status ? 'selected' : Null }} >Unpublished</option>                           
                        </select>
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