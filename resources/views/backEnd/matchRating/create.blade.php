<div class="modal-content">            
    <div class="modal-header">
        <h5 class="modal-title" > {{ $title ?? "Create/Edit"}} </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div> 
    {!! Form::open(['url'=> $form_url, 'method' => 'post', 'files' => 'true','class'=>'ajax-form']) !!}
        <input type="hidden" name="id" value="{{ isset($data->id) ? $data->id : 0 }}" >                     
        <div class="modal-body">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Match Rating Type <span class="text-danger">*</span> </label>   
                        <select name="rating_type" id="rating_type" class="form-control select2" required >
                            <option value="">Select Match Rating Type</option>
                            <option value="specific" {{ isset($data->rating_type) && $data->rating_type == "specific" ? "selected" : Null }} >Specific</option>
                            <option value="non-specific" {{ isset($data->rating_type) && $data->rating_type == "non-specific" ? "selected" : Null }} >Non-specific</option>
                        </select>
                    </div>
                </div>

                <!-- Subscription Plan -->
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Subscription Plan <span class="text-danger">*</span></label>
                        <select name="subscription_plan_id" class="form-control select2" required >
                            <option value="">Select Subscription Plan</option>
                            @foreach($plans as $plan)
                                <option value="{{ $plan->id }}" {{ isset($data->id) && $data->subscription_plan_id == $plan->id ? 'selected' : Null }}>{{ $plan->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div> 

                <!-- no_of_question -->
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Number of Questions <span class="text-danger">*</span></label>
                        <input type="number" min="1" name="no_of_question" class="form-control" value="{{ $data->no_of_question ?? 1 }}" required >
                    </div>
                </div> 

                <!-- no_of_star -->
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Number of Stars <span class="text-danger">*</span></label>
                        <input type="number" min="1" name="no_of_star" class="form-control" value="{{ $data->no_of_star ?? 1 }}" required >
                    </div>
                </div> 

                <!-- Area of Advice -->
                <div class="col-12 specific d-none">
                    <div class="form-group">
                        <label>Areas of Advice <span class="text-danger">*</span></label>
                        <select name="service_offer_id" class="form-control select2" >
                            <option value="">Select Areas of Advice</option>
                            @foreach($service_offers as $service_offer)
                                <option value="{{ $service_offer->id }}" {{ isset($data->id) && $data->service_offer_id == $service_offer->id ? 'selected' : Null }}>{{ $service_offer->name }}</option>
                            @endforeach
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

<script>
    $(".select2").select2();
    $(document).ready(function(){
        $("#rating_type").change();
    });
    
    $(document).on("change", "#rating_type", function(){
        if($(this).val() == "specific"){
            $(".specific select").attr("required", "required");
            $(".specific").removeClass("d-none");
        }else{
            $(".specific select").removeAttr("required");
            $(".specific").addClass("d-none")
        }
    });
</script>