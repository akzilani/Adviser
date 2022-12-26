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
                <div class="col-12 col-sm-6 mt-2">
                    <label class="font-weight-bold">Name</label>
                    <div class="form-control">{{ ucwords($data->name ?? "N/A") }}</div>                    
                </div>
                <div class="col-12 col-sm-6 mt-2">
                    <label class="font-weight-bold">Postcode</label>
                    <div class="form-control text-uppercase">{{ $data->post_code ?? "N/A" }}</div>                    
                </div>
                
                <div class="col-12 col-sm-6 mt-2">
                    <label class="font-weight-bold">Question</label>
                    <textarea class="form-control" readonly > {!! $data->question ?? "N/A" !!} </textarea>                
                </div>
                <div class="col-12 col-sm-6 mt-2">
                    <label class="font-weight-bold">Communication Type</label>
                    <div class="form-control">{{ $data->communication_type ?? "N/A" }}</div>                    
                </div>

                <div class="col-12 col-sm-6 mt-2">
                    <label class="font-weight-bold">Telephone Number</label>
                    <div class="form-control">{{ $data->phone ?? "N/A" }}</div>                    
                </div>

                <div class="col-12 col-sm-6 mt-2">
                    <label class="font-weight-bold">Lead Type</label>
                    <!--<div class="form-control">{{ $data->type ?? "N/A" }}</div> -->
                    <div class="form-control">{{ ucwords($data->type ?? "N/A") }}</div>  
                </div>
        
                
                <div class="col-12 col-sm-6 mt-2">
                    <label class="font-weight-bold">Fund Size</label>
                    <div class="form-control">{{ $data->fund_size->name ?? "N/A" }}</div>
                </div>
                <div class="col-12 col-sm-6 mt-2">
                    <label class="font-weight-bold">Areas of Advice</label>
                    <div class="form-control">{{ ucfirst($data->service_offered() ?? "N/A") }}</div>
                </div>


                <div class="col-6 col-sm-6 mt-2">
                    <div class="form-group">
                        <label>Lead Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control" required >
                            <option value="">Select Lead Status</option>
                            @foreach ($lead_status as $key => $status)
                                <option value="{{$key}}" {{ isset($data->id) && $data->status == $key ? 'selected' : Null }}>{{ $status }}</option>
                            @endforeach
                           
                        </select>
                    </div>
                </div>
                

                <div class="col-12 col-sm-6 mt-2">
                    <label>Uploading</label>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"> 0% </div>
                    </div>
                </div>
            </div>            
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-danger float-left" data-dismiss="modal">Close</button>
                <button type="submit" name="btn" class="btn btn-sm btn-primary"> Update </button>
            </div>
        </div>
    {!! Form::close() !!}
</div>