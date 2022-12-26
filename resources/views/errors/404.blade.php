@extends('frontEnd.masterPage')
@section('mainPart')
<section class="main-container" style="background: #eee;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="error-page text-center">
                    <div class="error-code">
                        <h2><strong>404</strong></h2>
                    </div>
                    <div class="error-message">
                        <h3>Oops... Page Not Found!</h3>
                    </div>
                    <div class="error-body">
                        Try using the button below to go to main page of the site <br>
                        <a href="{{ url('/') }}" class="btn btn-theme">Back to Home Page</a>
                    </div>
                </div>
            </div>

        </div><!-- Content row -->
    </div><!-- Conatiner end -->
</section><!-- Main container end -->
@endsection