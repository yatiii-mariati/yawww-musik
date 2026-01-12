<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Yawww Music • Admin Rekomendasi</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
/* ================= ROOT ================= */
:root {
  --cyan: #38bdf8;
  --green: #22c55e;
  --glass: rgba(255,255,255,.08);
}

/* ================= BODY ================= */
body {
  min-height: 100vh;
  background:
    radial-gradient(circle at 10% 10%, rgba(56,189,248,.25), transparent 35%),
    radial-gradient(circle at 90% 80%, rgba(34,197,94,.18), transparent 40%),
    linear-gradient(135deg, #020617, #020617 40%, #0b1220);
  color: white;
  font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
}

/* ================= HEADER ================= */
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 50px;
}

.header h1 {
  font-size: 1.8rem;
  font-weight: 800;
  letter-spacing: .4px;
}

.header span {
  background: linear-gradient(135deg, var(--cyan), var(--green));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

/* ================= GLASS CARD ================= */
.glass {
  background: linear-gradient(
    180deg,
    rgba(255,255,255,.12),
    rgba(255,255,255,.02)
  );
  backdrop-filter: blur(22px);
  border-radius: 26px;
  padding: 30px;
  box-shadow:
    0 40px 120px rgba(0,0,0,.8),
    inset 0 0 0 1px rgba(255,255,255,.12);
  margin-bottom: 45px;
  position: relative;
}

/* glow border */
.glass::before {
  content: "";
  position: absolute;
  inset: -1px;
  border-radius: 26px;
  background: linear-gradient(135deg, rgba(56,189,248,.6), rgba(34,197,94,.6));
  opacity: .25;
  z-index: -1;
}

/* ================= FORM ================= */
label {
  font-size: .8rem;
  color: #c7d2fe;
}

.form-control, textarea, select {
  background: rgba(2,6,23,.85);
  border: 1px solid rgba(148,163,184,.25);
  color: white;
  border-radius: 16px;
}

.form-control:focus, textarea:focus, select:focus {
  background: rgba(2,6,23,.95);
  border-color: var(--cyan);
  box-shadow: 0 0 0 3px rgba(56,189,248,.35);
  color: white;
}

/* ================= BUTTON ================= */
.btn-save {
  background: linear-gradient(135deg, var(--cyan), var(--green));
  border: none;
  border-radius: 18px;
  padding: 12px 26px;
  font-weight: 700;
  color: #031019;
  box-shadow: 0 15px 40px rgba(56,189,248,.5);
}

.btn-save:hover {
  transform: translateY(-2px);
  box-shadow: 0 20px 60px rgba(56,189,248,.7);
}

/* ================= LIST STYLE ================= */
.list-card {
  display: grid;
  grid-template-columns: 90px 1fr 1fr 2fr auto;
  gap: 18px;
  align-items: center;
  padding: 18px;
  border-radius: 20px;
  background: rgba(255,255,255,.04);
  margin-bottom: 14px;
  transition: .25s;
}

.list-card:hover {
  background: rgba(255,255,255,.08);
  transform: scale(1.01);
}

.list-title {
  font-weight: 600;
}

.list-muted {
  font-size: .85rem;
  color: #94a3b8;
}

/* ================= IMAGE ================= */
.thumb {
  width: 80px;
  height: 80px;
  border-radius: 16px;
  object-fit: cover;
  box-shadow: 0 10px 30px rgba(0,0,0,.6);
}

/* ================= DELETE ================= */
.btn-delete {
  background: rgba(239,68,68,.9);
  border: none;
  border-radius: 14px;
  padding: 6px 12px;
  color: white;
}

.btn-delete:hover {
  background: #ef4444;
}
</style>
</head>

<body>

<div class="container py-5">

  <!-- HEADER -->
  <div class="header">
    <h1>🎧 <span>Yawww Music</span> Admin</h1>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light btn-sm">
      ⬅ Dashboard
    </a>
  </div>

  <!-- FORM -->
  <div class="glass">
    <h4 class="mb-4">➕ Tambah Rekomendasi Lagu</h4>

    <form method="POST" action="{{ route('admin.rekomendasi.store') }}" enctype="multipart/form-data">
      @csrf

      <div class="row g-4">
        <div class="col-md-6">
          <label>Pilih Lagu</label>
          <select name="song_id" class="form-control" required>
            <option value="">-- Pilih Lagu --</option>
            @foreach($songs as $song)
              <option value="{{ $song->id }}">
                {{ $song->title }} — {{ $song->album->artist->name ?? '-' }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="col-md-6">
          <label>Judul</label>
          <input type="text" name="judul" class="form-control" required>
        </div>

        <div class="col-md-6">
          <label>Artis</label>
          <input type="text" name="artis" class="form-control" required>
        </div>

        <div class="col-md-6">
          <label>Foto</label>
          <input type="file" name="photo" class="form-control">
        </div>

        <div class="col-12">
          <label>Deskripsi</label>
          <textarea name="deskripsi" rows="3" class="form-control"></textarea>
        </div>
      </div>

      <button class="btn-save mt-4">
        💾 Simpan Rekomendasi
      </button>
    </form>
  </div>

  <!-- LIST -->
  <div class="glass">
    <h4 class="mb-4">🔥 Rekomendasi Aktif</h4>

    @forelse($rekomendasis as $rek)
      <div class="list-card">
        <img src="{{ $rek->photo ? asset('storage/'.$rek->photo) : asset('storage/img/artist-default.png') }}" class="thumb">

        <div>
          <div class="list-title">{{ $rek->judul }}</div>
          <div class="list-muted">{{ $rek->artis }}</div>
        </div>

        <div class="list-muted">
          🎵 {{ $rek->song->title ?? '-' }}
        </div>

        <div class="list-muted">
          {{ $rek->deskripsi ?? '-' }}
        </div>

        <form action="{{ route('admin.rekomendasi.destroy', $rek->id) }}"
              method="POST"
              onsubmit="return confirm('Hapus rekomendasi ini?')">
          @csrf
          @method('DELETE')
          <button class="btn-delete">🗑</button>
        </form>
      </div>
    @empty
      <p class="text-secondary text-center">Belum ada rekomendasi</p>
    @endforelse
  </div>

</div>

</body>
</html> apakah sudah benar begini? 