@extends('frontEnd.masterPage')
@section('title')
    Blog Post
@stop
@section('style')
    <style>
        .blog-post-list .card-body{
            height: 180px;
        }
        @media only screen and (max-width: 335px){
            .blog-post-list .card-body{
                height: 200px;
            }
        }
    </style>
@endsection
@section('mainPart')
    <!-- <section style="background-size: cover;background-repeat: no-repeat;background-position: center; background-image: url('{{ asset('image/financial.jpg') }}')"> -->
        <section style="background-size: cover;background-repeat: no-repeat;background-position: center; background-image: url('{{ asset( isset($page->cover_image) && file_exists($page->cover_image) ? $page->cover_image : 'image/financial.jpg') }}')">
        <div class="container-fluid">
            <div class="row justify-content-center" style="min-height: 250px">
            </div>
        </div>
    </section>
    <div class="container-lg bg-white mb-5" style="margin-top: -60px; position: relative;">
        <div class="row justify-content-center blog-post-list" >
            <div class="col-12 col-md-11">
                <div class="row">
                    <div class="col-12 col-md-9 mt-5">
                        <div class="row">
                            <div class="col-sm-12">
                                <h3 class="text-theme">Blog</h3>
                            </div>
                            @foreach ($blogs as $blog)
                                <?php 
                                    $admin = $blog->createdBy;
                                ?>
                                <div class="col-lg-6 mt-2">
                                    <div class="card">
                                        
                                        <!--
                                        <div class="row">
                                            <div class="col-9 col-md-9 row mb-2 pr-0">
                                                <div class="col-4 pl-3 mt-1">
                                                    <img src="{{ asset(file_exists($admin->image) ? $admin->image : 'image/dummy_user.jpg') }}" class="img-fluid rounded-circle ml-1 img-thumbnail" style="height: 65px;width:65px">
                                                </div>
                                                <div class="col-8 pl-0 font-12">
                                                    <h4 class="font-13 p-0 m-0 mt-1">{{ $admin->name }}</h4>
                                                    
                                                    <p class="font-12">{{ $admin->group->name ?? "" }} </p>
                                                </div>
                                            </div>
                                            <div class="col-3 col-md-3 text-right p-0">
                                                <p class="font-12 p-0 m-0 mt-1">{{ Carbon\Carbon::parse($blog->created_at)->format("d M Y") }}</p>
                                            </div>
                                        </div>
                                        
                                        -->
                                        <div class="row">
                                            <div class="col-12">
                                                <img src="{{ asset($blog->image ?? 'image/not-found.png') }}" class="card-img-top" alt="Image" style="height:180px;">
                                                <!--<div class="card-body pl-2 pr-2" >-->
                                                <div class="card-body pl-2 pr-2" style="height: 200px;">
                                                    <h4 class="text-theme font-18">
                                                        <a href="{{ route('view_blog',[$blog->slug]) }}">{{ $blog->title }}</a>
                                                    </h4>
                                                    <p class="card-text ">
                                                        <?php
                                                            $text_length =  strlen($blog->description) < 100 ? strlen($blog->description) : strpos($blog->description, ' ', 90);
                                                        ?>
                                                        {!! strip_tags(substr($blog->description, 0, $text_length)) !!} ...
                                                    </p>
                                                    <a href="{{ route('view_blog',[$blog->slug]) }}" class="btn btn-link pl-0 float-right" style="color:black !important">Read More</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-sm-12 mt-2 text-right">
                            {!! $blogs->links() !!}
                        </div>
                    </div>
                
                    <div class="col-12 col-md-3 mt-5">
                        <h3 class="text-theme">Quick links</h3>
                        <div class="list-group font-12">
                            @foreach($quick_links as $link)
                                <a href="{{ route('view_quick_link', [$link->slug]) }}" class="list-group-item list-group-item-action">{{ $link->title }}</a>
                            @endforeach                   
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Popup -->
    @if( !empty($dynamic_popup) )
        <div class="custom-popup d-none center" style="text-align:center">
            <div class="row">
                <div class="col-12 text-right">
                    <button class="btn btn-default close-popup" title="Close"><i class="far fa-times-circle" style="font-size:36px;color:red;"></i></button>
                </div>                
            </div>
            <div class="container-md">
                <div class="row">
                    <div class="col-12 mt-0 mb-5">
                        {!! $dynamic_popup !!}
                        <a href="{{ route('search_advisor', ['Financial-Advisor']) }}" class="btn btn-warning btn-md no-radius">Search</a>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection