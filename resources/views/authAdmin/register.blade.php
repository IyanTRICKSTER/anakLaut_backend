@extends('layouts.authAdminBase')

@section('content')
<div class="card o-hidden border-0 shadow-lg my-5" style="border-radius: 2px">
    <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg-7 d-none d-lg-block bg-register-image"></div>
            <div class="col-lg-5">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Buat Akun!</h1>
                    </div>
                    <form class="user" method="POST" action="{{ route('admin.register') }}">
                        @csrf
                        <div class="form-group row">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                                <input type="text" id="name"  class="form-control form-control-user @error('name') is-invalid @enderror" name="name"
                                    placeholder="First Name" value="{{ old('name') }}">
                            </div>
                            {{-- <div class="col-sm-6">
                                <input type="text" class="form-control form-control-user" id="exampleLastName"
                                    placeholder="Last Name">
                            </div> --}}
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="email" id="email" name="email" class="form-control form-control-user @error('email') is-invalid @enderror" 
                            placeholder="Email Address" value="{{ old('email') }}">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group row">
                            {{-- Password --}}
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="password" name="password" id="password" class="form-control form-control-user @error('password') is-invalid @enderror" 
                                    placeholder="Password" value="{{ old('password') }}">
                            </div>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            {{-- Repeat Password --}}
                            <div class="col-sm-6">
                                <input type="password" name="password_confirmation" id="password-confirm" class="form-control form-control-user" id="exampleRepeatPassword"
                                    placeholder="Repeat Password">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-user btn-block">
                            Register Account
                        </button>
                        <hr>
                        <a href="index.html" class="btn btn-google btn-user btn-block">
                            <i class="fab fa-google fa-fw"></i> Register with Google
                        </a>
                        <a href="index.html" class="btn btn-facebook btn-user btn-block">
                            <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                        </a>
                    </form>
                    <hr>
                    <div class="text-center">
                        <a class="small" href="{{ route('admin.login') }}">Sudah memiliki akun? Login!</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
