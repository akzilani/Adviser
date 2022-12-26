@extends('frontEnd.advisor.masterPage')

@section('mainPart')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h4>Compare Your Match Rating</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Areas of Advice</th>
                                    <th>Your Match Rating</th>
                                    <th>Average Match Rating</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($service_offers as $offer)
                                    <tr>
                                        <td>{{ $offer->name }}</td>
                                        <td>
                                            @for($i = 1; $i <= 5; $i++)
                                                @if(isset($advisor->specific_rating[$offer->name]) && $i <= $advisor->specific_rating[$offer->name])
                                                    <i class="fas fa-star fa-lg text-warning"></i>
                                                @else
                                                    <i class="far fa-star fa-lg"></i>
                                                @endif
                                            @endfor
                                        </td>
                                        <td>
                                            @for ($i = 1; $i <= 5 ; $i++)
                                                @if(isset($specific_rating_arr[$offer->name]) && $i <= $specific_rating_arr[$offer->name])
                                                    <i class="fas fa-star fa-lg text-warning"></i>
                                                @else
                                                    <i class="far fa-star fa-lg"></i>
                                                @endif
                                            @endfor
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection