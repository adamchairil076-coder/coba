<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Donatur</title>

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/icofont.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <style>
        body {
            background: #f7f7f7;
            min-height: 100vh;
        }

        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 15px;
        }

        .auth-card {
            background: #fff;
            border-radius: 14px;
            padding: 28px 32px;
            width: 100%;
            max-width: 460px;
            box-shadow: 0 10px 30px rgba(0,0,0,.08);
        }

        .auth-logo img {
            width: 62px;
        }

        .auth-title {
            font-weight: 700;
            color: #222;
            margin-bottom: 5px;
        }

        .form-group {
            margin-bottom: 12px;
        }

        .form-group label {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .form-control {
            height: 42px;
            border-radius: 6px;
            font-size: 14px;
        }

        .theme-btn {
            background: #ff6015;
            color: #fff;
            border: none;
            padding: 11px;
            border-radius: 6px;
            font-weight: 600;
        }

        .theme-btn:hover {
            background: #e5530f;
            color: #fff;
        }

        .auth-link {
            color: #ff6015;
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="auth-wrapper">
    <div class="auth-card">

        <div class="text-center auth-logo mb-3">
            <a href="{{ route('index') }}">
                <img src="{{ asset('assets/img/logo.png') }}" alt="Logo">
            </a>
        </div>

        <div class="text-center mb-4">
            <h3 class="auth-title">Register Donatur</h3>
            <p class="text-muted mb-0">Buat akun untuk mulai berdonasi di RUHAMA.</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 pl-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="{{ old('username') }}" required>
            </div>

            <div class="form-group">
                <label>Email Aktif</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label>Nomor HP</label>
                <input type="text"
                       name="phone"
                       class="form-control"
                       value="{{ old('phone') }}"
                       maxlength="13"
                       pattern="[0-9]{10,13}"
                       required>
                <small class="text-muted">Nomor HP maksimal 13 digit dan hanya angka.</small>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn theme-btn btn-block">
                Register
            </button>
        </form>

        <hr>

        <div class="text-center">
            <a href="{{ route('login') }}" class="auth-link">
                Sudah punya akun? Login
            </a>
        </div>

    </div>
</div>

</body>
</html>