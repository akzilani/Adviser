@extends('frontEnd.masterPage')
@section('mainPart')
<section class="main-container" style="background: #eee;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="error-page text-center">
                    <div class="error-code">
                        <h2><strong>503</strong></h2>
                    </div>
                    <div class="error-message">
                        <h3>Sorry! System is under Maintenance</h3>
                        <p>Please Try Again Later</p>
                    </div>
                </div>
            </div>
        </div><!-- Content row -->
    </div><!-- Conatiner end -->
</section><!-- Main container end -->
@endsection