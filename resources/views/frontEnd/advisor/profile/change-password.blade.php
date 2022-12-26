@extends('frontEnd.advisor.masterPage')
@section('mainPart')
    <div class="row justify-content-center">
        <div class="col-md-5 col-sm-8">
            <form action="{{ $form_url }}" class="row form-horizontal" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="col-12 mt-10">
                    @include('frontEnd.advisor.include.alert')
                    <h3>Change Password</h3>
                    <hr/>
                </div>
                <!-- Password -->
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Password <span class="text-danger">*</span></label>                                
                        <input type="password" name="password" class="form-control" required  autocomplete="off">
                        @error('password')
                            <span class="text-danger" role="alert"> {{ $message}} </span>
                        @enderror
                    </div>                        
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Retype Password <span class="text-danger">*</span></label>                                
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>                        
                </div>

                 <!--submit -->
                 <div class="col-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Update </button>
                    </div>
                </div>
                

            </form>
        </div>
    </div>
@endsection