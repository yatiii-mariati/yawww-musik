<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login • Yawww Musik</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(
                90deg,
                #5f7381 0%,
                #3f5663 50%,
                #1e2f38 100%
            );
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: white;
        }

        body::after {
            content: "";
            position: fixed;
            inset: 0;
            background: radial-gradient(
                circle at center,
                rgba(255,255,255,0.05),
                rgba(0,0,0,0.35)
            );
            pointer-events: none;
        }

        .login-box {
            width: 100%;
            max-width: 440px;
            background: rgba(15, 25, 30, 0.65);
            backdrop-filter: blur(18px);
            border-radius: 20px;
            padding: 36px;
            box-shadow: 0 30px 70px rgba(0,0,0,.6);
            position: relative;
            z-index: 1;
        }

        .login-box h3 {
            font-weight: 600;
            margin-bottom: 26px;
            text-align: center;
            letter-spacing: .5px;
        }

        /* INPUT – TRANSPARENT */
        .form-control {
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.25);
            color: #f2f6ff;
            border-radius: 12px;
            padding: 12px 14px;
        }

        .form-control::placeholder {
            color: rgba(230,235,255,0.6);
        }

        .form-control:focus {
            background: rgba(255,255,255,0.16);
            border-color: rgba(180,200,255,0.8);
            color: white;
            box-shadow: none;
        }

        label {
            font-size: .85rem;
            color: #cfd8ff;
            margin-bottom: 6px;
        }

        /* BUTTON – BLUE GREY TRANSPARENT */
        .btn-login {
            background: rgba(110, 140, 170, 0.65);
            border: 1px solid rgba(160, 190, 220, 0.45);
            border-radius: 14px;
            font-weight: 600;
            padding: 12px;
            color: #f4f8ff;
            backdrop-filter: blur(8px);
            transition: all .25s ease;
        }

        .btn-login:hover {
            background: rgba(130, 160, 195, 0.85);
            transform: translateY(-1px);
        }

        a {
            color: #8fb4ff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        hr {
            border-color: rgba(255,255,255,0.15);
        }

        .alert {
            border-radius: 12px;
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

    <hr class="my-4">

    <p class="text-center mb-0">
        Belum punya akun?
        <a href="{{ route('register') }}">Daftar di sini</a>
    </p>

</div>

</body>
</html>
