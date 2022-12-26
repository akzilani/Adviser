@extends('frontEnd.masterPage')
@section('title')
    Terms & Conditions ||
@stop
@section('mainPart')
    <!--<section style="background-size: cover;background-repeat: no-repeat;background-position: center; background-image: url('{{ asset('image/financial.jpg') }}')"> -->
    <section class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12" style="background-size: cover;background-repeat: no-repeat;background-position: center; background-image: url('{{ asset(isset($page->cover_image) && file_exists($page->cover_image) ? $page->cover_image : 'image/financial.jpg') }}')">
        <div class="container-fluid">
            <div class="row justify-content-center" style="min-height: 250px">
            </div>
        </div>
    </section>
    <div class="container-lg bg-white mb-5" style="margin-top: -60px; position: relative;">
        <div class="row justify-content-center" >
            <div class="col-12 col-md-10 mt-5">
                <div class="row">                    
                    <div class="col-12 col-md-9">
                        <div>
                            <h3 class="m-0 text-theme">Terms & Conditions</h3>      
                            
                        </div>

                        <div class="mt-5">                            
                            {!! $data->trems_and_condition ?? '' !!}
                        </div>

                    </div>
                
                    <div class="col-12 col-md-3 mt-4">
                        <h3 class="text-theme">Quick links</h3>
                        <div class="list-group font-12">                            
                            @foreach($quick_links as $link)
                                <a href="{{ route('view_quick_link',[$link->slug]) }}" class="list-group-item list-group-item-action">{{ $link->title }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection