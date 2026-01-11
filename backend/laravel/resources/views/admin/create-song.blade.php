<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Lagu • Yaww Music</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
/* ================= ROOT ================= */
:root {
  --primary: #60a5fa;
  --secondary: #818cf8;
  --accent: #34d399;
  --glass: rgba(255,255,255,.10);
}

/* ================= BODY ================= */
body {
  min-height: 100vh;
  background:
    radial-gradient(circle at 15% 10%, rgba(96,165,250,.25), transparent 40%),
    radial-gradient(circle at 85% 90%, rgba(52,211,153,.18), transparent 45%),
    linear-gradient(135deg, #0b1026, #121a3d, #0b1026);
  color: white;
  font-family: "Inter", system-ui, sans-serif;
}

/* ================= WRAPPER ================= */
.page-wrapper {
  max-width: 560px;
  margin: 90px auto;
  padding: 0 20px;
}

/* ================= GLASS CARD ================= */
.glass-card {
  background: linear-gradient(
    180deg,
    rgba(255,255,255,.18),
    rgba(255,255,255,.05)
  );
  backdrop-filter: blur(28px);
  border-radius: 26px;
  padding: 36px 34px;
  box-shadow:
    0 40px 90px rgba(0,0,0,.75),
    inset 0 0 0 1px rgba(255,255,255,.12);
}

/* ================= TITLE ================= */
.form-title {
  text-align: center;
  margin-bottom: 34px;
}

.form-title h3 {
  font-weight: 800;
  letter-spacing: .4px;
  margin-bottom: 6px;
}

.form-title span {
  font-size: .85rem;
  color: #c7d2fe;
}

/* ================= LABEL ================= */
label {
  font-size: .8rem;
  font-weight: 500;
  color: #dde3ff;
  margin-bottom: 6px;
}

/* ================= INPUT ================= */
.form-control,
.form-select {
  background: rgba(2,6,23,.85);
  border: 1px solid rgba(148,163,184,.25);
  color: white;
  border-radius: 16px;
  padding: 12px 16px;
}

.form-control::placeholder {
  color: #94a3b8;
}

.form-control:focus,
.form-select:focus {
  background: rgba(183, 183, 183, 0.95);
  border-color: var(--primary);
  box-shadow: 0 0 0 3px rgba(70, 101, 139, 0.35);
  color: white;
}

option {
  color: #000;
}

/* ================= BUTTON ================= */
.btn-save {
  margin-top: 10px;
  background: linear-gradient(135deg, var(--accent), #22c55e);
  border: none;
  border-radius: 18px;
  padding: 12px;
  font-weight: 700;
  color: #04210f;
  box-shadow: 0 18px 50px rgba(34,197,94,.45);
  transition: .25s;
}

.btn-save:hover {
  transform: translateY(-2px);
  box-shadow: 0 25px 70px rgba(34,197,94,.65);
}

/* ================= BACK BUTTON ================= */
.btn-back {
  margin-top: 14px;
  border-radius: 18px;
  padding: 11px;
  font-weight: 600;
  color: white;
  border: 1px solid rgba(255,255,255,.35);
}

.btn-back:hover {
  background: rgba(255,255,255,.15);
}

/* ================= ALERT ================= */
.alert {
  border-radius: 14px;
  font-size: .9rem;
}

/* ================= FILE INPUT ================= */
input[type=file]::file-selector-button {
  background: rgba(255,255,255,.15);
  border: none;
  padding: 8px 14px;
  border-radius: 10px;
  color: white;
  cursor: pointer;
}
</style>
</head>

<body>

<div class="page-wrapper">

  <div class="glass-card">

    <!-- TITLE -->
    <div class="form-title">
      <h3>➕ Tambah Lagu</h3>
      <span>Manajemen konten musik • Admin Panel</span>
    </div>

    @if(session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif

    <form method="POST"
          action="{{ route('admin.songs.store') }}"
          enctype="multipart/form-data">
      @csrf

      <!-- JUDUL -->
      <div class="mb-3">
        <label>Judul Lagu</label>
        <input
          class="form-control"
          name="title"
          placeholder="Contoh: Shape of You"
          required
        >
      </div>

      <!-- ARTIS -->
      <div class="mb-3">
        <label>Artis</label>
        <select class="form-select" name="artist_id" required>
          <option value="">Pilih Artis</option>
          @foreach($artists as $artist)
            <option value="{{ $artist->id }}">
              {{ $artist->name }}
            </option>
          @endforeach
        </select>
      </div>

      <!-- ALBUM -->
      <div class="mb-3">
        <label>Album</label>
        <select class="form-select" name="album_id" required>
          <option value="">Pilih Album</option>
          @foreach($albums as $album)
            <option value="{{ $album->id }}">
              {{ $album->title }} — {{ $album->artist->name }}
            </option>
          @endforeach
        </select>
      </div>

      <!-- AUDIO -->
      <div class="mb-4">
        <label>File Audio</label>
        <input
          type="file"
          name="audio"
          class="form-control"
          required
        >
      </div>

      <button class="btn-save w-100">
        💾 Simpan Lagu
      </button>

      <a href="{{ route('admin.songs.index') }}"
         class="btn btn-outline-light w-100 btn-back">
        ⬅ Kembali ke Daftar Lagu
      </a>

    </form>

  </div>

</div>

</body>
</html>
