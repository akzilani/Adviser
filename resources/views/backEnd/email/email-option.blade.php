@extends('backEnd.masterPage')
@section('mainPart')
<div class="row justify-content-center">
    <div class="col-12 col-lg-12 mt-2 mb-2">
        @include('backEnd.includes.alert')
    </div>
    <div class="col-12 col-lg-12 mt-2 mb-2">
        <div class="card">
            <div class="card-header bg-info">
                {{ $title ?? ""}}
            </div>
            <div class="card-body">
                <form action="{{ $form_url }}" class="row form-horizontal" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="welcome_email" value="1" {{ isset($data->welcome_email) && $data->welcome_email == 1 ? 'checked' : Null }} > Send Welcome Email
                            </label>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="password_reset_email" value="1" {{ isset($data->password_reset_email) && $data->password_reset_email == 1 ? 'checked' : Null }} > Send Password Reset Email
                            </label>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="account_verification_email" value="1" {{ isset($data->account_verification_email) && $data->account_verification_email == 1 ? 'checked' : Null }} > Send Account Activation Email
                            </label>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="match_me_lead_notification_email" value="1" {{ isset($data->match_me_lead_notification_email) && $data->match_me_lead_notification_email == 1 ? 'checked' : Null }} > Send Match Me Lead Email
                            </label>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="search_local_notification_email" value="1" {{ isset($data->search_local_notification_email) && $data->search_local_notification_email == 1 ? 'checked' : Null }} > Send Search Local Lead Email
                            </label>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="auction_create_email" value="1" {{ isset($data->auction_create_email) && $data->auction_create_email == 1 ? 'checked' : Null }} > Send Auction Creating Email
                            </label>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="auction_bid_email" value="1" {{ isset($data->auction_bid_email) && $data->auction_bid_email == 1 ? 'checked' : Null }} > Send Auction Bidding Email
                            </label>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="auction_win_email" value="1" {{ isset($data->auction_win_email) && $data->auction_win_email == 1 ? 'checked' : Null }} > Send Auction Win Email
                            </label>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="terms_of_condition_email" value="1" {{ isset($data->terms_of_condition_email) && $data->terms_of_condition_email == 1 ? 'checked' : Null }} > Send Terms & Conditions Email
                            </label>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="signup_email" value="1" {{ isset($data->signup_email) && $data->signup_email == 1 ? 'checked' : Null }} > Send Signup Email
                            </label>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="match_me_lead_referral" value="1" {{ isset($data->match_me_lead_referral) && $data->match_me_lead_referral == 1 ? 'checked' : Null }} > Send Match Me Lead Referral
                            </label>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="search_local_lead_referral" value="1" {{ isset($data->search_local_lead_referral) && $data->search_local_lead_referral == 1 ? 'checked' : Null }} > Send Search Local Lead Referral
                            </label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"> Save </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection