<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Register • Yawww Musik</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
  min-height: 100vh;
  margin: 0;
  background: linear-gradient(
    90deg,
    #6f7f8e 0%,
    #4a6270 45%,
    #1e2f38 100%
  );
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
  color: white;
}

/* soft vignette */
body::after {
  content: "";
  position: fixed;
  inset: 0;
  background: radial-gradient(
    circle at center,
    rgba(255,255,255,.04),
    rgba(0,0,0,.45)
  );
  pointer-events: none;
}

.register-box {
  width: 100%;
  max-width: 440px;
  background: rgba(20,30,40,.55);
  backdrop-filter: blur(16px);
  border-radius: 20px;
  padding: 34px;
  box-shadow: 0 30px 70px rgba(0,0,0,.55);
  position: relative;
  z-index: 1;
}

.register-box h3 {
  font-weight: 600;
  margin-bottom: 26px;
  text-align: center;
}

label {
  font-size: .85rem;
  color: #d6e0ff;
}

.form-control {
  background: rgba(255,255,255,.12);
  border: 1px solid rgba(255,255,255,.25);
  color: white;
  border-radius: 12px;
}

.form-control::placeholder {
  color: rgba(255,255,255,.7);
}

.form-control:focus {
  background: rgba(255,255,255,.18);
  border-color: #9bb6d3;
  color: white;
  box-shadow: none;
}

/* BUTTON */
.btn-register {
  background: rgba(110,140,170,.75);
  border: 1px solid rgba(160,190,220,.35);
  border-radius: 14px;
  font-weight: 600;
  padding: 11px;
  color: white;
  transition: .25s;
}

.btn-register:hover {
  background: rgba(130,160,195,.9);
}

a {
  color: #9fd0ff;
  text-decoration: none;
}

a:hover {
  text-decoration: underline;
}

.alert {
  border-radius: 12px;
  font-size: .9rem;
}

hr {
  border-color: rgba(255,255,255,.2);
}
</style>
</head>

<body>

<div class="register-box">

  <h3>🎶 Daftar Yawww Musik</h3>

  {{-- SUCCESS --}}
  @if (session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif

  {{-- ERROR --}}
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <!-- FORM -->
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
