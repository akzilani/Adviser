@extends('backEnd.masterPage')
@section('mainPart')
<div class="page-body">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="{{ isset($create) ? 'col-8' : 'col-12' }}" >
                    <h5>{{ ucfirst( str_replace(['_','-'], ' ', $pageTitle) ) }}</h5>
                </div>
                @if( isset($create) && $create )
                    <div class="col-4 text-right">
                        <a class="ajax-click-page btn btn-primary btn-sm" href="{{ url($create) }}">Create new</a>
                    </div>
                @endif
            </div>
            
        </div>
        <div class="card-body">
            <div class="dt-plugin-buttons"></div>
                <div class="dt-responsive {{ !isset($table_responsive) ? 'table-responsive' : Null }}">
                    <table id="table" class="table table-striped table-bordered nowrap {{ $table_responsive ?? "" }}">
                        <thead class="{{ isset($tableStyleClass) ? $tableStyleClass : 'bg-primary'}}">
                            <tr>
                                @foreach($tableColumns as $column)
                                    <th> @lang('table.'.$column)</th>
                                @endforeach                                
                            </tr>
                        </thead>
                    </table>
                </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" keyboard="false" data-backdrop="static" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog  {{ isset($modalSizeClass) && !empty($modalSizeClass) ? $modalSizeClass : 'modal-md'}}" role="document">
      <div class="modal-content">            
            <div class="modal-header">
                <h5 class="modal-title" > Loading... <img src="{{ asset('loading.svg') }}" width="50"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div> 
      </div>
    </div>
</div>
  
  
                                                  
<script>
    let table, table2;
    $(function() {
        table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ isset($dataTableUrl) && !empty($dataTableUrl) ? $dataTableUrl : URL::current() }}',
            columns: [
                @foreach($dataTableColumns as $column)
                    { data: '{{ $column }}', name: '{{ $column }}' },
                @endforeach                
            ],
            "lengthMenu": [[5, 25,50, 100, 500, -1], [5, 25, 50, 100, 500, "All"]],
        });
    });
</script>

<script>
    $(document).on('click', '.add-new-repeter, #add-new-repeter', function(){
        let repeter = `<div class="col-12 option-repeter">
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
        </div>`;
        $('.repeter').append(repeter);
    });

    $(document).on('click', '.remove-repeter', function(){
        if(confirm("Are you Sure to Remove it ?")){
            $(this).parents('.option-repeter').remove();
        }
    });
</script>

@endsection

