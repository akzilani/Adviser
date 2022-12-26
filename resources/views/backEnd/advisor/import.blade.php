@extends('backEnd.masterPage')
@section('mainPart')
<div class="row ">
    <div class="col-12 col-lg-12 mt-2 mb-2">
        @include('backEnd.includes.alert')
    </div>
    <div class="col-12 col-md-6 mt-2 mb-2">
        <div class="card">
            <div class="card-header bg-info">
                {{ $title ?? ""}}
            </div>
            <div class="card-body">
                <form action="{{ $form_url }}" class="row form-horizontal" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="col-12">
                        <div class="form-group">
                            <label>Select File <span class="text-danger">*</span></label> <br>
                            <input type="file" name="file" required accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                        </div>
                    </div>
                    <!--submit -->
                    <div class="col-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-info">Import Now </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@stop
@section("script")

@endsection

