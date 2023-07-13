<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Dashboard</title>
    <link rel="stylesheet" href="{{ asset('mazer-admin/assets/css/main/app.css') }}">
    <link rel="stylesheet" href="{{ asset('mazer-admin/assets/css/pages/auth.css') }}">
    <link rel="shortcut icon" href="{{ asset('mazer-admin/assets/images/logo/favicon.svg') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('mazer-admin/assets/images/logo/favicon.png') }}" type="image/png">
</head>

<body>
    <div id="auth">

<div class="row h-100">
    <div class="col-lg-6 col-12">
        <div id="auth-left">
            <div class="auth-logo">
                <a href="index.html"><img src="{{ asset('mazer-admin/assets/images/logo/logo.svg') }}" alt="Logo"></a>
            </div>

            <h1 class="auth-title">Silahkan masuk ke akun anda</h1>
            <p class="auth-subtitle mb-5">Masukkan email dan password dengan benar!</p>

            <form action="{{ route('login') }}" method="POST">
            @csrf
                <div class="form-group position-relative has-icon-left mb-4">
                    <input type="email" class="form-control form-control-xl" placeholder="Masukkan email anda!" name="email" value="{{ old('email') }}">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <div class="form-control-icon">
                        <i class="bi bi-person"></i>
                    </div>
                </div>
                <div class="form-group position-relative has-icon-left mb-4">
                    <input type="password" class="form-control form-control-xl" placeholder="Masukkan Password" name="password" value="{{ old('password') }}">
                    @error('password')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <div class="form-control-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                </div>

                <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5" type="submit">Log in</button>
            </form>
            
        </div>
    </div>
    <div class="col-lg-7 d-none d-lg-block">
        <div id="auth-right">

        </div>
    </div>
</div>

    </div>
</body>
</html>
