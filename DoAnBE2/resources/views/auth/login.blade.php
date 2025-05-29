<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Đăng nhập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f7f7f7; }
        .auth-wrapper {
            max-width: 400px;
            margin: 80px auto;
            padding: 30px 20px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            text-align: center;
        }
        .auth-title { font-size: 1.25rem; margin-bottom: 1.5rem; font-weight: 500; }
        .form-control {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            margin-bottom: 1rem;
        }
        .btn-auth {
            width: 100%;
            padding: 0.75rem;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 500;
            background-color: #b3b3b3;
            border: none;
            color: #fff;
            transition: background-color 0.2s;
        }
        .btn-auth:hover:not(:disabled) { background-color: #999; }
        .auth-footer { font-size: 0.9rem; margin-top: 1rem; }
        .auth-footer a { font-weight: 500; text-decoration: none; }
        .form-check { text-align: left; }
    </style>
</head>
<body>
<div class="auth-wrapper">
    <h2 class="auth-title">Đăng nhập</h2>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <input
            type="email" name="email"
            class="form-control @error('email') is-invalid @enderror"
            placeholder="Địa chỉ Email"
            value="{{ old('email') }}" required autofocus
        >
        @error('email') <div class="text-danger mb-2">{{ $message }}</div> @enderror

        <input
            type="password" name="password"
            class="form-control @error('password') is-invalid @enderror"
            placeholder="Mật khẩu" required
        >
        @error('password') <div class="text-danger mb-2">{{ $message }}</div> @enderror

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                {{ old('remember') ? 'checked' : '' }}>
            <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
        </div>

        <button type="submit" class="btn-auth mt-2">Đăng nhập</button>
    </form>

    <div class="auth-footer">
        Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký</a>
    </div>
</div>
</body>
</html>
