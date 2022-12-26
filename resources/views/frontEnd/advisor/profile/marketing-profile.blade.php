@extends('frontEnd.advisor.masterPage')

@section('mainPart')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 100%; text-transform:unset;">
                        Areas of Advice
                    </button>
                    <div class="dropdown-menu"  style="width: 100%;">
                        @foreach($service_offers as $service_offer)
                            <a class="dropdown-item" href="{{ route('advisor.marketing_profile', $service_offer->name) }}">{{ $service_offer->name }}</a>
                        @endforeach
                    </div>
                  </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h4> Download Marketing Badges</h4>
                    </div>
                    <div class="card-body" style="background: #f2dede;">
                        <div class="row">
                            @foreach($advisor_marketings as $marketing)
                                <div class="col-md-6 col-lg-4 mt-5">
                                    <div class="text-center p-2" style="background: #fff;">
                                        <a href="{{ asset($marketing->image) }}" download="myimage">
                                            <img src="{{ asset($marketing->image) }}" class="img-fluid">
                                        </a>
                                        <br/><br>
                                        <a href="{{ asset($marketing->image) }}" download="myimage">
                                            Download Marketing Badge
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection