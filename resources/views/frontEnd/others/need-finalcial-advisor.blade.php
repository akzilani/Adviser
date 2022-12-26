@extends('frontEnd.masterPage')
@section('title')
    Do I need a Financial Advisor ||
@stop
@section('mainPart')
    <section style="background-size: cover;background-repeat: no-repeat;background-position: center; background-image: url('{{ asset('image/financial.jpg') }}')">
        <div class="container-fluid">
            <div class="row justify-content-center" style="min-height: 250px">
            </div>
        </div>
    </section>
    <div class="container-lg bg-white mb-5" style="margin-top: -80px; position: relative;">
        <div class="row justify-content-center" >
            <div class="col-12 col-md-10 mt-5">
                <div class="row">                    
                    <div class="col-12 col-md-9">
                        <div>
                            <p class="font-13 m-0 text-theme">HELP & ADVICE</p>
                            <h3 class="m-0 text-theme">Do I need a Financial Advisor?</h3>      
                            <p class="mt-2 font-weight-bold font-16">
                                This a good question to ask. If you're considering hiring one, here are some other questions which might help you decide
                            </p>
                        </div>
                        <div>
                            <p class="font-weight-bold">Do you have a substantial amount of money to invest?</p>
                            <p class="">The word substantial is up to you. You may have £10,000 or £100,000, but if you feel that the word applies then, yes it's probably a good idea to get some advice.</p>
                        </div>

                        <div class="mt-5">
                            <p class="font-weight-bold ">Why get advice?</p>
                            <p class="">Without taking due care and diligence there's no way you can guarantee that the product your bank or high street organisation sold you will be any good. Investing, planning and saving are all governed by a raft of mitigating factors. Without specialist knowledge of your individual needs, there's no way a con-sultant can know what your future holds. A Financial Advisor, on the other hand, will be able to help you plan ahead. Maybe you need your funds to be a little more liquid or maybe you might find out your capital is being used to fund an organisation which you object to on a moral basis.</p>
                        </div>

                        <div class="mt-5">
                            <p class="font-weight-bold ">Are you good with money?</p>
                            <p class="">Don't be offended, most of us aren't great at budgeting. Sometimes we all need a little bit of help keeping in the black and there's no shame in reaching out to a professional if you're one of those who doesn't do money.</p>
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