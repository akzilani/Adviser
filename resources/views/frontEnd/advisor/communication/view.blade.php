<div class="modal-content">            
    <div class="modal-header">
        <h5 class="modal-title" > {{ $data->subject ?? "N/A" }} </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div> 
    
    <div class="modal-body row">
        <div class="col-12 row">
            <div class="col-12 col-md-3 "> Subject </div>
            <div class="col-12 col-md-9 "> {{ $data->subject ?? "" }}</div>
        </div>
        <div class="col-12 row mt-2">
            <div class="col-12 col-md-3 "> Message </div>
            <div class="col-12 col-md-9 ">
                @if(!$data->plain_text_message)
                    @foreach (json_decode($data->message, true) as $key => $value )
                        @if( $key == "updated_at" || $key == "created_at" || $key == "id" || $key == "publication_status" || $key == 'advisor_id')
                            @continue
                        @endif
                        @if( is_array($value))
                            <strong>Service Offer :</strong> {{ $data->getForeignData("service_offers", $value) }} <br>
                        @else
                            @if( $key == "fund_size_id")
                                <strong>Fund Size : </strong> {{ $data->getForeignData("fund_size", (array)$value) }} <br>
                            @else
                                <strong>{{ ucfirst(str_replace('_', ' ', $key)) }} :</strong> {{ str_replace('_', ' ', $value) }} <br>
                            @endif
                        @endif
                        
                    @endforeach
                @else  
                    {!! $data->message !!}
                @endif
               
            </div>
        </div>
        

        

        <div class="col-12"> <hr> </div>

        <div class="col-6 row">
            <div class="col-12 col-md-5"> Status </div>
            <div class="col-12 col-md-7"> {{ $data->publication_status ? 'Published' : 'Unpublished' }}</div>
        </div>

        <div class="col-6 row">
            <div class="col-12 col-md-5 "> Created By </div>
            <div class="col-12 col-md-7 "> {{ $data->createdBy->name ?? "N/A" }}</div>
        </div>
        <div class="col-6 row">
            <div class="col-12 col-md-5"> Created At </div>
            <div class="col-12 col-md-7"> {{ Carbon\carbon::parse($data->created_at)->format($system->date_format) }}</div>
        </div>

        <div class="col-6 row">
            <div class="col-12 col-md-5 "> Updated By </div>
            <div class="col-12 col-md-7 "> {{ $data->modifiedBy->name ?? "N/A" }}</div>
        </div>
        <div class="col-6 row">
            <div class="col-12 col-md-5"> Updated At </div>
            <div class="col-12 col-md-7"> {{ Carbon\carbon::parse($data->updated_at)->format($system->date_format) }}</div>
        </div>

    </div>
                    
    <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-danger float-left" data-dismiss="modal">Close</button>
    </div>
</div>