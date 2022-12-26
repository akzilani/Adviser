@extends('frontEnd.masterPage')
@section('title')
    {{ $post->title  }} ||
@stop
@section('mainPart')
   
    <section class="pt-0 " style="background-size: cover;background-repeat: no-repeat;background-position: center; background-color: #ffffff">
        <div class="container-fluid">
            <?php
                $admin = $post->admin;
            ?>
            <div class="row justify-content-center" style="background: #fff; border-top:1px solid #eee;">
                <div class="col-md-10 row">
                    <div class="col-8 col-sm-8  mb-2 row">
                        <div class="col-4 col-md-2 mt-1 pl-0">
                            <img src="{{ asset(file_exists($admin->image) ? $admin->image : 'image/dummy_user.jpg') }}" class="img-fluid rounded-circle ml-1 img-thumbnail" style="height: 65px;width:65px">
                        </div>
                        <div class="col-8 col-md-10 pl-0">
                            <h4 class="font-15 p-0 m-0 mt-1">{{ $admin->name }}</h4>
                            <p class="font-13">
                                {{ $admin->group->name ?? "" }} 
                            </p>
                        </div>
                    </div>
                    <div class="col-4 col-sm-4 text-right p-0">
                        <p class="font-13 p-0 m-0 mt-1">Updated {{ Carbon\Carbon::parse($post->created_at)->format("d M Y") }}</p>
                        @if($post->read_time)
                            <h5 class="font-13 text-dark p-0 m-0">{{ $post->read_time }} min read</h5>
                        @endif
                    </div>
                    
                   
                </div>
            </div>
            
            <div class="row justify-content-center" style="min-height: 300px">
                <!-- <div class="col-sm-2"></div> -->
                <div class="col-sm-12 col-md-8">
                    <img src="{{ asset($post->image ?? 'image/financial.jpg') }}" style="height:100%;">
                </div>
                <div class="col-sm-2"></div>
            </div>
            
        </div>
    </section>

    <div class="container-fluid bg-white mb-5" style="margin-top: -60px; position: relative;">
        <div class="row justify-content-center" >
            <div class="col-12 col-md-10 mt-5">
                <div class="row">                    
                    <div class="col-12 col-md-9">
                        <div>
                            <p class="p-0 m-0 text-theme">HELP & ADVICE</p>
                            <h3 class="p-0 m-0 text-theme font-24"><b>{{ $post->title }}</b></h3>
                        </div>
                        <div>
                            {!! $post->description !!}
                        </div>
                    </div>
                
                    <div class="col-12 col-md-3 mt-4">
                        <h3 class="text-theme">Quick links</h3>
                        <div class="list-group">                            
                            @foreach($quick_links as $link)
                                <a href="{{ route('view_quick_link',[$link->slug]) }}" class="list-group-item list-group-item-action">{{ $link->title }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
   <div class="card mb-3 d-flex" style=" max-width: 540px;  margin: auto;">
    <h6 class="mt-2" style="padding: 0 0.5em; color: #9F9E9E; letter-spacing: 3px; ">ABOUT THE AUTHOR</h6>
     <div class="row g-0">
       <div class="col-md-4">
         <img src="{{ asset(file_exists($admin->image) ? $admin->image : 'image/dummy_user.jpg') }}" class="img-fluid  rounded"   style="height: 100px;width:120px; padding-left:5%;">
       </div>
         <div class="col-md-8">
           <div class="card-body">
              <h4 class="card-title" style="letter-spacing: 1px;">{{ $admin->name }}</h5>
                 <p class="card-text">{!! $admin->bio !!}</p>
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