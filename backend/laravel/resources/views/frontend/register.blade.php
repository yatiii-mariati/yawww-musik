<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Register • YomansMusic</title>

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      min-height: 100vh;
      margin: 0;
      background: linear-gradient(135deg, #6c7bd9, #1f2b4f);
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    .register-box {
      width: 100%;
      max-width: 440px;
      background: rgba(255, 255, 255, 0.08);
      backdrop-filter: blur(14px);
      border-radius: 18px;
      padding: 32px;
      box-shadow: 0 25px 50px rgba(0,0,0,.45);
    }

    .register-box h3 {
      font-weight: 600;
      margin-bottom: 24px;
      text-align: center;
    }

    .form-control {
      background: rgba(255,255,255,.12);
      border: 1px solid rgba(255,255,255,.25);
      color: white;
      border-radius: 10px;
    }

    .form-control::placeholder {
      color: #cfd8ff;
    }

    .form-control:focus {
      background: rgba(255,255,255,.18);
      border-color: #fff;
      color: white;
      box-shadow: none;
    }

    label {
      font-size: .85rem;
      color: #cfd8ff;
    }

    .btn-register {
      background: #1DB954;
      border: none;
      border-radius: 12px;
      font-weight: 600;
      padding: 10px;
    }

    .btn-register:hover {
      background: #1ed760;
    }

    a {
      color: #1DB954;
      text-decoration: none;
    }

    a:hover {
      color: #1ed760;
      text-decoration: underline;
    }

    .alert {
      border-radius: 10px;
      font-size: .9rem;
    }

    hr {
      border-color: rgba(255,255,255,.2);
    }
  </style>
</head>

<body>

<div class="register-box">

  <h3>🎶 Daftar YomansMusic</h3>

  {{-- SUCCESS --}}
  @if (session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif

  {{-- ERROR VALIDATION --}}
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <!-- ================= REGISTER FORM ================= -->
 <form method="POST" action="/register">
  @csrf

  <div class="mb-3">
    <label>Nama</label>
    <input
      type="text"
      name="name"
      class="form-control"
      placeholder="Nama lengkap"
      value="{{ old('name') }}"
      autocomplete="off"
      required
    >
  </div>

  <div class="mb-3">
    <label>Email</label>
    <input
      type="email"
      name="email"
      class="form-control"
      placeholder="email@example.com"
      value="{{ old('email') }}"
      required
    >
  </div>

  <div class="mb-4">
    <label>Password</label>
    <input
      type="password"
      name="password"
      class="form-control"
      placeholder="Minimal 6 karakter"
      required
    >
  </div>

  <button type="submit" class="btn btn-register w-100">
    Daftar
  </button>
</form>


  <hr class="my-4">

  <p class="text-center mb-0">
    Sudah punya akun?
    <a href="{{ route('login') }}">Login di sini</a>
  </p>

</div>

</body>
</html>
