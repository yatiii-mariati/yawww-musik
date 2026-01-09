<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login • Yawww Musik</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: white;
        }

        .login-box {
            width: 100%;
            max-width: 420px;
            background: rgba(0,0,0,.55);
            backdrop-filter: blur(14px);
            border-radius: 18px;
            padding: 32px;
            box-shadow: 0 30px 60px rgba(0,0,0,.6);
        }

        .login-box h3 {
            font-weight: 600;
            margin-bottom: 24px;
            text-align: center;
        }

        .form-control {
            background: rgba(255,255,255,.1);
            border: 1px solid rgba(255,255,255,.25);
            color: white;
            border-radius: 10px;
        }

        .form-control::placeholder {
            color: #cfd8ff;
        }

        .form-control:focus {
            background: rgba(255,255,255,.15);
            color: white;
            border-color: #1DB954;
            box-shadow: none;
        }

        label {
            font-size: .85rem;
            color: #cfd8ff;
        }

        .btn-login {
            background: #1DB954;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            padding: 10px;
        }

        .btn-login:hover {
            background: #1ed760;
        }

        a {
            color: #1DB954;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .alert {
            border-radius: 10px;
            font-size: .9rem;
        }
    </style>
</head>
<body>

<div class="login-box">

    <h3>🎧 Login Yawww Musik</h3>

    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- ERROR --}}
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    {{-- LOGIN FORM --}}
    <form method="POST" action="/login">
        @csrf

        <div class="mb-3">
            <label>Email</label>
            <input
                type="email"
                name="email"
                class="form-control"
                placeholder="email@example.com"
                required
            >
        </div>

        <div class="mb-4">
            <label>Password</label>
            <input
                type="password"
                name="password"
                class="form-control"
                placeholder="Password"
                required
            >
        </div>

        <button class="btn btn-login w-100">
            Login
        </button>
    </form>

    <hr class="my-4 border-secondary">

    <p class="text-center mb-0">
        Belum punya akun?
        <a href="{{ route('register') }}">Daftar di sini</a>
    </p>

</div>

</body>
</html>
