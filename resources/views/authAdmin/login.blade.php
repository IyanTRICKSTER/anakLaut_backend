@extends('layouts.authAdminBase')

@section('content')
<!-- Outer Row -->
<div class="row justify-content-center">

    <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5" style="border-radius: 2px">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-7 d-none d-lg-block bg-login-image"></div>
                    <div class="col-lg-5">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Selamat Datang!</h1>
                            </div>
                            <form class="user" method="POST" action="{{ route('admin.login.submit') }}">
                                @csrf

                                <div class="form-group">
                                    <input type="email"
                                        class="form-control form-control-user @error('invalid') is-invalid @enderror"
                                        id="exampleInputEmail" aria-describedby="emailHelp"
                                        placeholder="Enter Email Address..." id="email" name="email"
                                        value="{{ old('email')}}">
                                </div>

                                <div class="form-group">
                                    <input type="password"
                                        class="form-control form-control-user @error('invalid') is-invalid @enderror"
                                        id="exampleInputPassword" placeholder="Password" id="password" name="password">

                                    @error('invalid')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" name="remember" class="custom-control-input"
                                            {{ old('remember') ? 'checked' : '' }} id="remember">
                                        <label class="custom-control-label" for="remember">Remember
                                            Me</label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Login
                                </button>
                                <hr>
                                <a href="index.html" class="btn btn-google btn-user btn-block">
                                    <i class="fab fa-google fa-fw"></i> Login with Google
                                </a>
                                <a href="index.html" class="btn btn-facebook btn-user btn-block">
                                    <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                                </a>
                            </form>
                            <hr>
                            @if (Route::has('admin.password.request'))
                            <div class="text-center">
                                <a class="small" href="{{ route('admin.password.request') }}">Lupa Password?</a>
                            </div>
                            @endif
                            <div class="text-center">
                                <a class="small" href="{{ route('admin.register') }}">Buat Akun!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
