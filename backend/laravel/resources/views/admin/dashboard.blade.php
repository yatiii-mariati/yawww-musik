<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Admin Panel • Yaww Music</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
/* ================= ROOT ================= */
:root {
  --primary: #7dd3fc;
  --secondary: #818cf8;
  --accent: #34d399;
  --danger: #ef4444;
  --glass: rgba(255,255,255,.10);
}

/* ================= BODY ================= */
body {
  min-height: 100vh;
  background:
    radial-gradient(circle at 20% 15%, rgba(125,211,252,.25), transparent 40%),
    radial-gradient(circle at 80% 85%, rgba(52,211,153,.18), transparent 45%),
    linear-gradient(135deg, #0b1026, #121a3d, #0b1026);
  color: #fff;
  font-family: "Inter", system-ui, sans-serif;
}

/* ================= CONTAINER ================= */
.admin-container {
  max-width: 1180px;
  margin: 70px auto 100px;
  padding: 0 24px;
}

/* ================= HEADER ================= */
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 36px;
}

.header h2 {
  font-size: 2rem;
  font-weight: 800;
  letter-spacing: .4px;
}

.header h2 span {
  background: linear-gradient(135deg, var(--primary), var(--accent));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

/* ================= GLASS ================= */
.glass {
  background: linear-gradient(
    180deg,
    rgba(255,255,255,.16),
    rgba(255,255,255,.04)
  );
  backdrop-filter: blur(26px);
  border-radius: 26px;
  padding: 28px;
  box-shadow:
    0 40px 90px rgba(0,0,0,.7),
    inset 0 0 0 1px rgba(255,255,255,.12);
}

/* ================= ACTION BUTTONS ================= */
.action-buttons {
  display: flex;
  flex-wrap: wrap;
  gap: 14px;
  margin-bottom: 28px;
}

.action-buttons .btn {
  border-radius: 14px;
  font-weight: 600;
  padding: 10px 18px;
}

/* ================= ARTIST CARD ================= */
.artist-card {
  background: rgba(10,12,30,.65);
  border-radius: 18px;
  padding: 18px 22px;
  margin-bottom: 14px;
  transition: .3s ease;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.artist-card:hover {
  background: rgba(255,255,255,.10);
  transform: translateY(-3px);
}

/* ================= ARTIST LEFT ================= */
.artist-left {
  display: flex;
  align-items: center;
  gap: 18px;
}

.artist-photo {
  width: 68px;
  height: 68px;
  border-radius: 18px;
  object-fit: cover;
  box-shadow: 0 10px 30px rgba(0,0,0,.5);
}

.artist-name {
  font-weight: 600;
  font-size: 1.05rem;
  letter-spacing: .3px;
}

/* ================= ACTIONS ================= */
.artist-actions {
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
}

.artist-actions .btn {
  border-radius: 12px;
  font-size: .85rem;
  padding: 6px 14px;
}

/* ================= BUTTON CUSTOM ================= */
.btn-success {
  background: linear-gradient(135deg, #22c55e, #16a34a);
  border: none;
}

.btn-success:hover {
  opacity: .9;
}

.btn-info {
  background: linear-gradient(135deg, #38bdf8, #0284c7);
  border: none;
  color: #000;
}

.btn-warning {
  background: linear-gradient(135deg, #fbbf24, #f59e0b);
  border: none;
}

.btn-outline-light:hover {
  background: rgba(255,255,255,.15);
}

/* ================= EMPTY ================= */
.empty-text {
  text-align: center;
  color: #c7d2fe;
  margin-top: 40px;
}

/* ================= HOME ================= */
.home-btn {
  background: rgba(15,23,42,.85);
  backdrop-filter: blur(14px);
  padding: 10px 20px;
  border-radius: 999px;
  font-weight: 600;
  text-decoration: none;
  color: white;
  transition: .25s;
}

.home-btn:hover {
  transform: translateY(-3px);
  background: rgba(30,41,59,.95);
}
</style>
</head>

<body>

<div class="admin-container">

  <!-- HEADER -->
  <div class="header">
    <h2>🎧 <span>Admin Panel</span></h2>
    <a href="{{ route('home') }}" class="home-btn">🏠 Dashboard</a>
  </div>

  <div class="glass">

    <!-- ACTION -->
    <div class="action-buttons">
      <a href="/admin/songs/create" class="btn btn-success">➕ Tambah Lagu</a>
      <a href="{{ route('admin.artists.create') }}" class="btn btn-primary">➕ Tambah Artis</a>
      <a href="{{ route('admin.songs.index') }}" class="btn btn-warning">🎵 Kelola Lagu</a>
      <a href="{{ route('admin.rekomendasi') }}" class="btn btn-info">✨ Kelola Rekomendasi</a>
    </div>

    <h5 class="mb-3 fw-semibold">🎤 Daftar Artis</h5>

    @if ($artists->isEmpty())
      <p class="empty-text">Belum ada artis</p>
    @endif

    @foreach ($artists as $artist)
      <div class="artist-card">

        <div class="artist-left">
          <img
            src="{{ $artist->photo
              ? asset('storage/'.$artist->photo)
              : asset('storage/img/artist-default.png') }}"
            class="artist-photo"
          >
          <div class="artist-name">{{ $artist->name }}</div>
        </div>

        <div class="artist-actions">
          <a href="{{ route('admin.artists.show', $artist->id) }}" class="btn btn-info">👁 Detail</a>
          <a href="{{ route('admin.artists.edit', $artist->id) }}" class="btn btn-outline-light">✏️ Edit</a>
          <form action="{{ route('admin.artists.destroy', $artist->id) }}"
                method="POST"
                onsubmit="return confirm('Yakin hapus artis ini?')">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">🗑 Hapus</button>
          </form>
        </div>

      </div>
    @endforeach

  </div>

</div>

</body>
</html>
