<div class="repeter row">
    <div class="col-12">
        <hr/>
    </div>
    @if( isset($data->subscription_plan_options) && count($data->subscription_plan_options) > 0 )
        @foreach($data->subscription_plan_options as $option)
            <div class="col-12 option-repeter">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Key Name <span class="text-danger">*</span></label>
                            <input type="text" name="key[]"  class="form-control" required value="{{ $option->key }}" >
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Show / View Text <span class="text-danger">*</span></label>
                            <input type="text" name="text[]" class="form-control" required value="{{ $option->text }}" >
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select name="status[]" class="form-control" required >
                                <option value="">Select Status</option>
                                <option value="active" {{ $option->status == 'active' ? 'selected' : Null }} >Active</option>
                                <option value="inactive" {{ $option->status == 'inactive' ? 'selected' : Null }} >Inactive</option>
                            </select>                            
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Position <span class="text-danger">*</span></label>
                            <input type="number" step="any" min="1" name="position[]" class="form-control" required value="{{ $option->position }}">
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <div class="form-group">
                            <label></label><br>
                            <button type="button" class="btn btn-danger btn-sm remove-repeter" title="Remove"> X </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="col-12 option-repeter">
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Key Name <span class="text-danger">*</span></label>
                        <input type="text" name="key[]"  class="form-control" required >
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Show / View Text <span class="text-danger">*</span></label>
                        <input type="text" name="text[]" class="form-control" required>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Select Status <span class="text-danger">*</span></label>
                        <select name="status[]" class="form-control" required >
                            <option value="">Select Status</option>
                            <option value="active" >Active</option>
                            <option value="inactive" >Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Position <span class="text-danger">*</span></label>
                        <input type="number" step="any" min="1" name="position[]" class="form-control" required value="1">
                    </div>
                </div>
                <div class="col-sm-1">
                    <div class="form-group">
                        <label></label><br>
                        <button type="button" class="btn btn-danger btn-sm remove-repeter" title="Remove"> X </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
<div class="row">
    <div class="col-12 text-right">
        <button class="btn btn-sm btn-success add-new-repeter" type="button" >Add New Option</button>
    </div>
</div>

