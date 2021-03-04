@extends('layouts.authAdminBase')

@section('content')
<div class="row justify-content-center">
    <div class="col-6">
        <div class="card o-hidden border-0 shadow-lg my-5" style="border-radius: 2px">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row justify-content-center">
                    {{-- <div class="col-lg-7 d-none d-lg-block bg-register-image"></div> --}}
                    <div class="">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Reset Password</h1>
                            </div>
                            <form class="user" method="POST" action="{{ route('admin.password.update') }}">
                                @csrf
        
                                <input type="hidden" name="token" value="{{ $token }}">
        
                                <div class="form-group">
                                    <input id="email" type="email" class="form-control form-control-user @error('email') is-invalid @enderror"
                                        name="email" value="{{ $email ?? old('email') }}" required autocomplete="email"
                                        autofocus>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
        
                                <div class="form-group row">
                                    {{-- Password --}}
                                    <div class="col-6">
                                        <input id="password" type="password"
                                            class="form-control form-control-user @error('password') is-invalid @enderror" name="password" required
                                            autocomplete="new-password" placeholder="new password">
                                    </div>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    {{-- Repeat Password --}}
                                    <div class="col-6">
                                        <input id="password-confirm" type="password" class="form-control form-control-user"
                                            name="password_confirmation" required autocomplete="new-password" placeholder="confirm password">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Submit
                                </button>
                                <hr>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
