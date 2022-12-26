@extends('backEnd.masterPage')
@section("style")
    <style>
        .toggle_btn a{
            text-decoration: none;
            padding: 5px 15px;
            background: #ddd;
            border-radius: 15px;
            position: relative;
        }
        .toggle_btn a:nth-child(2).inactive{
            margin-left: -20px;
            padding-left: 20px;
        }

        .toggle_btn a:nth-child(2).active{
            margin-left: -20px;
        }
        .toggle_btn a:first-child.inactive{
            padding-right: 20px;
        }

        .toggle_btn .active{
            background: #555;
            color:#fff;
            z-index: 1;
        }
    </style>

@stop
@section('mainPart')
<div class="page-body">   
    <div class="card-header">
        <div class="row">
            <div class="col-8" >
                <h5>{{ ucfirst( str_replace(['_','-'], ' ', $pageTitle) ) }}</h5>
            </div>
            <div class="col-4 text-right">
                <button id="delete_log_btn" class="btn btn-sm btn-danger" >Delete Log</button>
            </div>
        </div>
    </div>

    <div class="card-body">
        @include('backEnd.includes.alert')
        <form class="row dt-responsive table-responsive">
            <div class="col-sm-6 col-md-4">
                <div class="input-group mb-3">
                    <input type="text" name="search" class="form-control" value="{{ request()->input('search') }}" placeholder="Search here" >
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-info btn-sm">Search</button>
                    </div>
                </div>
            </div>
        </form>
        <form method="post" action="{{ route('admin.activity_log_delete') }}" class="card" >
            @csrf
            <table id="table" class="table table-striped table-bordered nowrap">
                <thead class="{{ isset($tableStyleClass) ? $tableStyleClass : 'bg-primary'}}">
                    <tr>
                        <th>
                            <input type="checkbox" class="checked-all" >
                            SN.
                        </th>
                        <th>Activity</th>
                        <th>IP</th>
                        <th class="toggle_btn">
                            <a class="{{ request()->user_type != "advisor_admin" ? "active" : "inactive" }}" href="{{ URL::current() }}?user_type=admin">Admin</a>
                            <a class="{{ request()->user_type == "advisor_admin" ? "active" : "inactive" }}" href="{{ URL::current() }}?user_type=advisor_admin" >Advisor Admin</a>
                        </th>
                        <th>Date Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($activity_logs as $list)
                    <tr>
                        <td>
                            <input type="checkbox" name="ids[]" class="activity-checkbox" value="{{ $list->id }}" >
                            {{ $loop->iteration }}
                        </td>
                        <td>{!! $list->activity !!}</td>
                        <td>{{ $list->ip }}</td>
                        @if( request()->user_type == "advisor_admin")
                            <td>{{ $list->advisor->first_name ?? "N/A" }} {{ $list->advisor->last_name ?? ""}}</td>
                        @else
                            <td>{{ $list->admin->name ?? "N/A" }}</td>    
                        @endif
                        <td>{{ Carbon\Carbon::parse($list->created_at)->format($system->date_format. ' h:i A') }}</td>                            
                    </tr>   
                    @empty 
                    <tr>
                        <td colspan="7" style="text-align:center">No Data Found</td>
                    </tr>                            
                    @endforelse
                </tbody>
            </table>

            <div class="row mt-2">
                <div class="col-12 col-sm-6">
                    {!! $activity_logs->links() !!}
                </div>
                <div class="col-12 col-sm-6 text-right">
                    <button type="submit" id="delete_log_btn_submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete Log</button>
                </div>
            </div>
        </form>
    </div>

</div>  

<script>
    $(document).on("change", ".checked-all", function(){
        if( $(this).prop("checked") ){
            $(".activity-checkbox").each(function(index, list){
                $(list).prop("checked", true);
            });
        }else{
            $(".activity-checkbox").each(function(index, list){
                $(list).prop("checked", false);
            });
        }
    });

    $(document).on("click", ".pagination .page-link", function(e){
        e.preventDefault();
        let url = $(this).attr("href");
        window.location.href = url + "&user_type={{ request()->user_type}}";
    });

    $(document).on("click", "#delete_log_btn", function(){
        $("#delete_log_btn_submit").click();
    });
</script>
                                                  
@endsection

