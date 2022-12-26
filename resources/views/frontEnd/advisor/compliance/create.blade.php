<div class="modal-content">            
    <div class="modal-header">
        <h5 class="modal-title" > {{ $title ?? "Create/Edit"}} Statements</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div> 
    {!! Form::open(['url'=> $form_url, 'method' => 'post', 'files' => 'true','class'=>'ajax-form']) !!}
        <div class="modal-body">
            <div class="row">
                <input type="hidden" name="id" value="{{ $data->id ?? 0 }}">
                <!-- Name -->
                <div class="col-12">
                    <div class="form-group">
                        <h3 class="p-0 m-0">Write your compliance statements</h3>
                        <p>You can add multiple separate paragraphs for all necessary compliance requirements. </p>
                    </div>
                </div>

                 <!-- Compliance -->
                 <div class="col-12">
                    <div class="form-group">
                        <textarea class="form-control" name="compliance" required>{!! $data->compliance ?? "" !!}</textarea>
                    </div>
                </div>                

                <div class="col-12 col-sm-6">
                    <label>Loading</label>
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