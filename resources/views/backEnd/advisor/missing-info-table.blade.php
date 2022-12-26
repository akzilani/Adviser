@extends('backEnd.masterPage')
@section('mainPart')
<div class="page-body">
    <div class="col-12">
        @include('backEnd.includes.alert')
    </div>
    
    
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="{{ isset($create) ? 'col-8' : 'col-12' }}" >
                    <h5>{{ ucfirst( str_replace(['_','-'], ' ', $pageTitle) ) }}</h5>
                </div>
                @if( isset($create) )
                    <div class="col-4 text-right">
                        <a class="btn btn-primary btn-sm" href="{{ url($create) }}">Create new</a>
                    </div>
                @endif
            </div>
            
        </div>
        <div class="card-body">
            <div class="dt-plugin-buttons"></div>
            <div class="dt-responsive">
                <table id="missing_info_advisor" class="table table-striped table-bordered nowrap table-responsive">
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
                                                  
<script>
    let table;
    $(function() {
        table = $('#missing_info_advisor').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ isset($dataTableUrl) && !empty($dataTableUrl) ? $dataTableUrl : URL::current() }}',
            columns: [
                @foreach($dataTableColumns as $column)
                    { data: '{{ $column }}', name: '{{ $column }}' },
                @endforeach                
            ],
            "lengthMenu": [[15, 50, 100, 500,1000, -1], [15, 50, 100, 500,1000, "All"]],
        });

    });

</script>
@endsection

