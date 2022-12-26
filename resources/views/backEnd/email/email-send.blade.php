@extends('backEnd.masterPage')
@section('mainPart')
<div class="row justify-content-center">
    <div class="col-12 col-lg-12 mt-2 mb-2">
        @include('backEnd.includes.alert')
    </div>
    <div class="col-12 col-lg-12 mt-2 mb-2">
        <div class="card">
            <div class="card-header bg-info">
                {{ $title ?? ""}}
            </div>
            <div class="card-body">
                <form action="{{ $form_url }}" class="row form-horizontal" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="col-12 ">
                        <div class="form-group">
                            <label>Select Advisor <span class="text-danger">*</span></label>
                            <select name="advisor[]" class="form-control select2" required multiple>
                                <option value="">Select Advisor</option>
                                @foreach($advisors as $advisor)
                                    <option value="{{ $advisor->id }}">{{ $advisor->first_name }} {{ $advisor->last_name }}</option>  
                                @endforeach                              
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label>Email Subject</label>
                            <input type="text" name="subject" class="form-control" >
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="form-group">
                            <label>Email Body<span class="text-danger">*</span></label>
                            <textarea name="message" class="form-control editor" style="min-height: 200px;"></textarea>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"> Save </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection