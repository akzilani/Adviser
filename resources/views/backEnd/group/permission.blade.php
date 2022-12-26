@extends('backEnd.masterPage')

@section('mainPart')
    <!-- Alert Message-->
    <div class="row">
        <div class="col-12 mt-2 mb-2">
            @include('backEnd.includes.alert')
        </div>
    </div>

    <form class="row" action="{{ $form_url }}" method="POST">
        @csrf

        <div class="col-12 mt-2 mb-2 row">
            <div class="col-7">
                <h3 class="text-danger">Permission Access for {{ $group ->name ?? ""}}</h3>
            </div>
            <div class="col-5 text-right">
                <button type="button" class="btn btn-warning btn-sm all-check"> <i class="fas fa-check"></i> Check All</button>
                <button type="button" class="btn btn-danger btn-sm all-uncheck"> <i class="fas fa-times"></i> Uncheck All</button>
                <button type="submit" class="btn btn-success btn-sm">Save Permission</button>
            </div>
        </div>
        @foreach($accesses as $access)
            <div class="col-12 mt-2 ml-3">
                <h6><i class="fas fa-angle-double-right"></i> {{ $access[1] }}</h6>
                @if( isset($access['access']) && is_array($access['access']) && count($access['access']) > 0 )
                    @foreach ($access['access'] as $item)
                        <label class="ml-5 bold">
                            <input type="checkbox" name="permission[]" value="{{ $item[0] }}" {{ is_array($permissions) && in_array( $item[0], $permissions) ? "checked" : Null }} > {{ $item[1] }}
                        </label><br>
                    @endforeach
                @endif
            </div>
        @endforeach

        <div class="col-12 mt-2 ml-3 text-center">
            <hr/>
            <button type="submit" class="btn btn-success">Save Permission</button>
        </div>
       
    </form>

@endsection

@section('script')
    <script>
        $(document).on("click", '.all-check', function(){
            let all_checkbox = $("form input[type='checkbox']");
            all_checkbox.each(function(i, list){
                $(list).prop("checked", true);
            });
        });
        $(document).on("click", '.all-uncheck', function(){
            let all_checkbox = $("form input[type='checkbox']");
            all_checkbox.each(function(i, list){
                $(list).prop("checked", false);
            });
        });
    </script>
@endsection
