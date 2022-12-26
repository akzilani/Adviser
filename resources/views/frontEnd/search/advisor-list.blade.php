@extends('frontEnd.masterPage')
@section('style')
    <style>
        .question textarea{border:1px solid #ddd; padding: 5px; border-radius: 5px; min-width:100%; min-height: 80px; background: #fff; resize: none;}
        .question textarea:focus, .question question:active{border: 1px solid orange !important; outline: none;}
        .form-control{border: 1px solid #333; color:#555; }
    </style>
@stop
@section('mainPart')
    <!-- Question -->
    <section style="background: #eee;" class="pt-4 pb-4">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <h4 class="text-uppercase mb-0">YOUR QUESTION</h4>
                    <div class="question">
                        <textarea  >{{ $lead->question ?? "" }} </textarea>
                    </div>
                    </div>
                </div>
            </div>

            <!-- Searching Part -->
            <form class="row mt-2" action="{{ $form_url }}" id="find-advisor" method="GET">
                <!-- Left Section -->
                <div class="col-sm-4" >
                    <div class="form-group">
                        <h4 class="text-uppercase mb-0">Search by Postcode</h4>
                        <div class="alert alert-danger post-code-smg d-none">
                            Postcode is required
                        </div>
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" name="post_code" id="post_code" value="{{ $post_code }}">
                            <div class="input-group-prepend">
                                <button class="btn btn-success no-radius" type="submit">Search</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <h4 class="text-uppercase mt-3 mb-0">SEARCH LOCAL</h4>
                        <div class="mb-2">
                            <select class="form-control" name="distance" id="distance">
                                <option value="">Up to 1.5 hours</option>
                                <option value="37.28">Up to 1 hour</option>
                                <option value="27.96">Up to 45 minutes</option>
                                <option value="60">Match Rating™</option> 
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="match-rating d-none">
                            <h4 class="text-uppercase mt-3 mb-0">SEARCH BY AREAS OF ADVICE</h4>
                            <div class="mb-2">
                                <select class="form-control" name="service_offer" id="service_offer">
                                    <option value="" selected disabled="disabled">Select areas of advice</option>
                                    @foreach($service_offers as $offer)
                                        <option value="{{ $offer->id }}" >{{ $offer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <h4 class="text-uppercase mt-3 mb-0">SEARCH BY ADVISOR MINIMUM FUND / MORTGAGE VALUE</h4>
                        <div class="mb-2">
                            <select class="form-control" name="fund_size" id="fund_size">
                                @foreach ($fund_size as $fund)
                                    <option value="{{ $fund->min_fund }}">{{ $fund->name }}</option>
                                @endforeach 
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="mb-3 text-right">
                            <button type="reset" class="btn btn-danger no-radius">Reset</button>
                        </div>
                    </div>
                </div>

                <!-- Right Section -->
                <div class="col-sm-8">
                    <div class="row">

                        <div class="col-12 mt-2">
                            <div class="bg-theme p-2">
                                <!--<h4 class="text-white">Need help choosing an advisor?</h4>
                                <p class="font-14 mb-0">
                                    Our team can suggest the best advisors for your situation - call us now to get suggestions. Call us on 020 3468 4215. 
                                </p>-->
                                <h4 class="text-white">{!! $blue_box_content_header !!}</h4>
                                <p class="font-14 mb-0">
                                   {!! $blue_box_content_paragraph !!}
                                </p>
                            </div>                            
                        </div>
                    </div>

                    <!-- Advisor List -->
                    <div class="row">
                        <div class="col-12 advisor-panel" id="advisor-list">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="loading" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background-color:transparent; border:0px;">            
                <div class="row">
                    <div class="col-12 text-center">
                        <img class="img-fluid" src="{{ asset('image/loading.svg') }}" style="width:150px">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="feedback_modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">                    
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-warning mb-0" >
                            <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            {!! $popup_content !!}
                            <div class="text-right">
                                <button type="button" class="btn btn-info" data-dismiss="modal">ok</button>
                            </div>
                        </div>                        
                    </div>
                </div>
                
        </div>
    </div>

@stop
@section('script')
    <script>
        $(document).on("submit", "#find-advisor", function(e){
            e.preventDefault();
            
            if( $('#post_code').val().length < 4){
                $(".post-code-smg").removeClass('d-none');
            }else{
                $(".post-code-smg").addClass('d-none');
                findAdvisor();
            }
        });

        $(document).on("change", "#distance, #fund_size, #service_offer", function(){
            if( $('#distance').val() == 60 ){
                $('.match-rating').removeClass("d-none");
            }else{
                $('.match-rating').addClass("d-none");
            }
            $('#find-advisor').submit();
        });

        $(document).ready(function(){
            setTimeout(searchAdvisor, 100);
            @if( !empty($popup_content) )
                $("#feedback_modal").modal("show");
            @endif
        });

        $(document).on('click', '#advisor-pagination .pagination a', function(e){
            e.preventDefault();
            // $("#loading").modal("show");
            let url = $(this).attr('href');
            $.ajax({
                url: url,
                data: {
                    post_code   : $('#post_code').val(),
                    distance    : $('#distance').val(),
                    service_offer : $('#service_offer').val(),
                    fund_size   : $('#fund_size').val(),
                },
                success : function(output) {
                    $('#advisor-list').html(output.page);
                    // $("#loading").modal("hide");
                }
            });
            
        });

        function findAdvisor(){
            // $("#loading").modal("show");
            let form = $("#find-advisor");
            $.ajax({
                method : form.attr('method'),
                url: form.attr("action"),
                data: {
                    post_code   : $('#post_code').val(),
                    distance    : $('#distance').val(),
                    service_offer : $('#service_offer').val(),
                    fund_size   : $('#fund_size').val(),
                },
                success : function(output) {
                    $('#advisor-list').html(output.page);
                    // $("#loading").modal("hide");
                }
            });
        }

        function searchAdvisor(){
            $.ajax({
                url: "{{ URL::current() }}",
                data: {
                    post_code   : $('#post_code').val(),
                    distance    : $('#distance').val(),
                    service_offer : $('#service_offer').val(),
                    fund_size   : $('#fund_size').val(),
                },
                success : function(output) {
                    $('#advisor-list').html(output.page);
                }
            });
        }
    </script>
@endsection


