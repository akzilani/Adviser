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
                            <label>Select Mailer <span class="text-danger">*</span></label>
                            <select name="mail_mailer" class="form-control" required >
                                <option value="">Select Mailer</option>
                                <option value="smtp" {{ isset($data->mail_mailer) && $data->mail_mailer == "smtp" ? "selected" : Null }}>SMTP</option>
                                <option value="sendmail" {{ isset($data->mail_mailer) && $data->mail_mailer == "sendmail" ? "selected" : Null }}>SendMail</option>
                                <option value="mailgun" {{ isset($data->mail_mailer) && $data->mail_mailer == "mailgun" ? "selected" : Null }}>Mailgun</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label>Mail From Name</label>
                            <input type="text" name="mail_from_name" class="form-control" value="{{ $data->mail_from_name ?? Null }}" >
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label>Mail Host <span class="text-danger">*</span></label>
                            <input type="text" name="mail_host" class="form-control" value="{{ $data->mail_host ?? Null }}" required >
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label>Mail Port <span class="text-danger">*</span></label>
                            <input type="text" name="mail_port" class="form-control" value="{{ $data->mail_port ?? Null }}" required >
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label>Mail From Email<span class="text-danger">*</span></label>
                            <input type="text" name="mail_from_address" class="form-control" value="{{ $data->mail_from_address ?? Null }}" required >
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label>EMail / Mail Username <span class="text-danger">*</span></label>
                            <input type="text" name="mail_username" class="form-control" value="{{ $data->mail_username ?? Null }}" required >
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label>Mail Password <span class="text-danger">*</span></label>
                            <input type="text" name="mail_password" class="form-control" value="{{ $data->mail_password ?? Null }}" required >
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label>Mail Encryption <span class="text-danger">*</span></label>
                            <input type="text" name="mail_encryption" class="form-control" value="{{ $data->mail_encryption ?? Null }}" required >
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