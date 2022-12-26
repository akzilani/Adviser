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
                <div class="col-12 col-sm-4">
                    <div class="form-group">
                        <label>Package Name <span class="text-danger">*</span></label>
                        <input type="hidden" name="id" value="{{ $data->id ?? 0 }}">
                        <input type="text"  name="name" value="{{ $data->name ?? "" }}" class="form-control" required >
                    </div>
                </div>
                <div class="col-12 col-sm-4">
                    <div class="form-group">
                        <label>Select Profession</label>
                        <select name="profession_id" class="form-control select2">
                            <option value="">Select Profession</option>
                            @foreach($professions as $profession)
                            <option value="{{ $profession->id }}" {{ isset($data->id) && $data->profession_id ==  $profession->id ? "selected" : null }} >{{ $profession->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-12 col-sm-4">
                    <div class="form-group">
                        <label>Profile Listing / Showing Star </label>
                        <input type="number" step="any" min="0" max="5" name="profile_listing_star" value="{{ $data->profile_listing_star ?? "2" }}" class="form-control" >
                    </div>
                </div>

                <!-- Publication Status -->
                <div class="col-12 col-sm-4">
                    <div class="form-group">
                        <label>Package Publication Status <span class="text-danger">*</span></label>
                        <select name="publication_status" class="form-control" required >
                            <option>Select Publication Status</option>
                            <option value="1" {{ isset($data->id) && $data->publication_status == 1 ? 'selected' : Null }}>Published</option>
                            <option value="0" {{ isset($data->id) && $data->publication_status == 0 ? 'selected' : Null }} >Unpublished</option>                           
                        </select>
                    </div>
                </div> 
            
                <!-- Price -->
                <div class="col-12 col-sm-4">
                    <div class="form-group">
                        <label>Price<span class="text-danger">*</span></label>
                        <input type="number" step="any" min="0" name="price" value="{{ $data->price ?? "1" }}" class="form-control" >
                    </div>
                </div>

                <!-- duration_type -->
                <div class="col-12 col-sm-4">
                    <div class="form-group">
                        <label>Package Duration Type <span class="text-danger">*</span></label>
                        <select name="duration_type" class="form-control" required >
                            <option>Select Publication Status</option>
                            <option value="per year" {{ isset($data->id) && $data->duration_type == "per year" ? 'selected' : Null }}>Per Year</option>
                            <option value="per month" {{ isset($data->id) && $data->duration_type == "per month" ? 'selected' : Null }} >Per Month</option>                           
                        </select>
                    </div>
                </div> 
                <!-- charge_type -->
                <div class="col-12 col-sm-4">
                    <div class="form-group">
                        <label>Charge Type <span class="text-danger">*</span></label>
                        <select name="charge_type" class="form-control" required >
                            <option>Select Charge Type</option>
                            <option value="per account" {{ isset($data->id) && $data->charge_type ? 'selected' : Null }}>Per Account</option>
                            <option value="per profile" {{ isset($data->id) && $data->charge_type ? 'selected' : Null }} >Per Profile</option>
                        </select>
                    </div>
                </div>

                <!-- Office Manager Feature -->
                <div class="col-12 col-sm-4">
                    <div class="form-group">
                        <label>Enable Manager Feature <span class="text-danger">*</span></label>
                        <select name="office_manager" class="form-control" required >
                            <option>Select Office Manager Feature</option>
                            <option value="1" {{ isset($data->id) && $data->office_manager == 1 ? 'selected' : Null }}>Yes</option>
                            <option value="0" {{ isset($data->id) && $data->office_manager == 0 ? 'selected' : Null }} >No</option>                           
                        </select>
                    </div>
                </div> 

                <!-- max_advisor -->
                <div class="col-12 col-sm-4">
                    <div class="form-group">
                        <label>Max Advisor Account<span class="text-danger">*</span></label>
                        <input type="number" step="any" min="1"  name="max_advisor" value="{{ $data->max_advisor ?? "1" }}" class="form-control" >
                    </div>
                </div>
            </div> 

            @include('backEnd.subscription.subscription-options')

                {{-- 

                <!-- auction_room_access -->
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Auction Access Room<span class="text-danger">*</span></label>
                        <select name="auction_room_access" class="form-control" required >
                            <option>Select Access</option>
                            <option value="1" {{ isset($data->id) && $data->auction_room_access ? 'selected' : Null }}>Yes</option>
                            <option value="0" {{ isset($data->id) && !$data->auction_room_access ? 'selected' : Null }} >No</option>                           
                        </select>
                    </div>
                </div>

                <!-- qualified_leads -->
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Qualified leads<span class="text-danger">*</span></label>
                        <select name="qualified_leads" class="form-control" required >
                            <option>Have Qualified Leads</option>
                            <option value="1" {{ isset($data->id) && $data->qualified_leads ? 'selected' : Null }}>Yes</option>
                            <option value="0" {{ isset($data->id) && !$data->qualified_leads ? 'selected' : Null }} >No</option>                           
                        </select>
                    </div>
                </div>

                <!-- per_lead_tbc -->
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Qualified leads<span class="text-danger">*</span></label>
                        <select name="per_lead_tbc" class="form-control" required >
                            <option>Have Lead per TBC</option>
                            <option value="1" {{ isset($data->id) && $data->per_lead_tbc ? 'selected' : Null }}>Yes</option>
                            <option value="0" {{ isset($data->id) && !$data->per_lead_tbc ? 'selected' : Null }} >No</option>                           
                        </select>
                    </div>
                </div>

                <!-- per_lead_tbc -->
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Qualified leads<span class="text-danger">*</span></label>
                        <select name="per_lead_tbc" class="form-control" required >
                            <option>Have Lead per TBC</option>
                            <option value="1" {{ isset($data->id) && $data->per_lead_tbc ? 'selected' : Null }}>Yes</option>
                            <option value="0" {{ isset($data->id) && !$data->per_lead_tbc ? 'selected' : Null }} >No</option>                           
                        </select>
                    </div>
                </div>

                <!-- account_manager -->
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Account Manage<span class="text-danger">*</span></label>
                        <select name="account_manager" class="form-control" required >
                            <option>Have Account Management</option>
                            <option value="1" {{ isset($data->id) && $data->account_manager ? 'selected' : Null }}>Yes</option>
                            <option value="0" {{ isset($data->id) && !$data->account_manager ? 'selected' : Null }} >No</option>                           
                        </select>
                    </div>
                </div>

                <!-- max_qualified_leads_per_month -->
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Max Lead per Month <span class="text-danger">*</span></label>
                        <input type="number" step="any" min="1" name="max_qualified_leads_per_month" value="{{ $data->max_qualified_leads_per_month ?? "2" }}" class="form-control" >
                    </div>
                </div>

                
                --}}
                
                
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