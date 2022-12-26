@extends('frontEnd.advisor.masterPage')
@section('mainPart')
<div class="page-body">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="{{ isset($create) ? 'col-8' : 'col-12' }}" >
                    <h5>{{ ucfirst( str_replace(['_','-'], ' ', $pageTitle) ) }}</h5>
                </div>
                @if( isset($create) && $create)
                    <div class="col-4 text-right">
                        <a class="ajax-click-page btn btn-primary btn-sm" href="{{ url($create) }}">Create new</a>
                    </div>
                @endif
            </div>
            
        </div>
        <div class="card-body">
            @if( isset($enable_trems_and_condition) && !$enable_trems_and_condition)
                <a href="{{ route('advisor.auction.terms_and_condition') }}" id="terms_and_condition_btn" class="ajax-click-page d-none">Show Terms & Condition</a>
            @endif
            <div class="dt-plugin-buttons row mt-2 mb-4">
                <div class="col-sm-4">
                    <label>Auction Status</label>
                    <select class="form-control status">
                        <option value="all" selected >All</option>
                        <option value="not_started">Not Started</option>
                        <option value="running">Running</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
            </div>
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
    <div class="modal-dialog modal-dialog-scrollable  {{ isset($modalSizeClass) && !empty($modalSizeClass) ? $modalSizeClass : 'modal-md'}}" role="document">
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
            ajax : {
                url : "{{ isset($dataTableUrl) && !empty($dataTableUrl) ? $dataTableUrl : URL::current() }}",
                data : function(d){
                    d.status = $('.status').val();
                }
            },
            columns: [
                @foreach($dataTableColumns as $column)
                    { data: '{{ $column }}', name: '{{ $column }}' },
                @endforeach                
            ],
            "lengthMenu": [[25, 50, 100, 500,1000, -1], [25, 50, 100, 500,1000, "All"]],
        });

        $(document).on('change', '.status', function(){
            refreshTable();
        });

        function refreshTable(){
            table.draw();
        }
        setInterval(refreshTable, 15000)
    });

    function loadTermsAndCondition(){
        $("#terms_and_condition_btn").click();
    }

    $(document).on("click", "#accept_auction_condition", function(){
        $.ajax({
            url : '{{ route('advisor.auction.accept_condition') }}',
            success : function(res){
                // console.log(res);
            }
        });
    });

    $(document).on("click", "#buy_out_btn", function(){
        if(confirm("Are you sure?")){
            $("#min_bid_price").val($(this).data('buy_out'));
            $("#buy_out").val(1);
            $("#submit_bid").click();
        }
    });
    
    @if( isset($enable_trems_and_condition) && !$enable_trems_and_condition)
        setTimeout(() => {
            loadTermsAndCondition()
        }, 2000);
    @endif
</script>
@endsection

