@extends('frontEnd.masterPage')
@section('style')
    <style>
        .bg-custom{background-color: #eee !important;}
    </style>
@stop
@section('mainPart')
<div class="container-md">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 p-5 text-center">
            <img src="{{ asset('image/target.png') }}" class="img-fluid">
            <h2 class="mt-3">Thank you</h2>
            <p class="p-0 m-0">Your enquiry was sent successfully.</p>
            <p class="p-0 m-0">You can expect a response within 48 hours.</p>
        </div>
    </div>
</div>
@endsection