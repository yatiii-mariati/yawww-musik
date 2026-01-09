<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Akun Saya • Yaww Music</title>

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('storage/css/account.css') }}">
</head>

<body class="yaww-bg text-white">

<div class="container account-container">

  <h3 class="mb-4 fw-semibold">👤 Akun Saya</h3>

  @auth
  <div class="account-card">

    <!-- FOTO PROFIL -->
    <div class="profile-box text-center mb-4">
      <img
        src="{{ auth()->user()->photo
          ? asset('storage/' . auth()->user()->photo) . '?v=' . time()
          : asset('storage/img/avatardef.jpg') }}"
        class="profile-img"
      >
      <div class="profile-label">Foto Profil</div>
    </div>

    <!-- GANTI FOTO -->
    <form action="/account/update-photo" method="POST" enctype="multipart/form-data" class="mb-4">
      @csrf
      <input
        type="file"
        name="photo"
        class="form-control yaww-input mb-2"
        accept="image/*"
        required
      >
      <button class="btn btn-outline-light w-100">
        Ganti Foto Profil
      </button>
    </form>

    <!-- INFO USER -->
    <div class="info-item">
      <span>Nama</span>
      <p>{{ auth()->user()->name }}</p>
    </div>

    <div class="info-item">
      <span>Email</span>
      <p>{{ auth()->user()->email }}</p>
    </div>

    <div class="info-item">
      <span>Bergabung Sejak</span>
      <p>{{ optional(auth()->user()->created_at)->format('d M Y') ?? '-' }}</p>
    </div>

    <!-- LOGOUT -->
    <form action="/logout" method="POST">
      @csrf
      <button class="btn btn-danger w-100 mt-4">
        🚪 Logout
      </button>
    </form>

  </div>
  @endauth

  @guest
    <div class="alert alert-warning">
      Silakan login untuk melihat halaman akun.
    </div>
  @endguest

</div>

</body>
</html>
