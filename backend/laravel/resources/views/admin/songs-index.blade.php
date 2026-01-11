<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Admin • Music Library</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
:root{
  --bg:#020617;
  --panel:#0b1228;
  --glass:rgba(255,255,255,.08);
  --primary:#60a5fa;
  --accent:#22c55e;
  --danger:#ef4444;
  --text-muted:#94a3b8;
}

/* ================= BODY ================= */
body{
  margin:0;
  min-height:100vh;
  background:
    radial-gradient(circle at 20% 15%, rgba(96,165,250,.22), transparent 45%),
    radial-gradient(circle at 80% 80%, rgba(34,197,94,.18), transparent 50%),
    linear-gradient(135deg,#020617,#0b1228 45%,#020617);
  font-family:"Inter",system-ui,sans-serif;
  color:white;
}

/* ================= LAYOUT ================= */
.wrapper{
  max-width:1200px;
  margin:90px auto;
  padding:0 24px;
}

/* ================= HEADER ================= */
.header{
  display:flex;
  justify-content:space-between;
  align-items:center;
  margin-bottom:36px;
}

.header h1{
  font-size:2rem;
  font-weight:800;
  letter-spacing:.4px;
}

.header span{
  display:block;
  font-size:.85rem;
  color:var(--text-muted);
  font-weight:500;
}

.back-btn{
  padding:10px 22px;
  border-radius:999px;
  border:1px solid rgba(255,255,255,.35);
  color:white;
  text-decoration:none;
  font-weight:600;
  transition:.25s;
}

.back-btn:hover{
  background:rgba(255,255,255,.12);
}

/* ================= PANEL ================= */
.panel{
  background:linear-gradient(
    180deg,
    rgba(255,255,255,.12),
    rgba(255,255,255,.04)
  );
  backdrop-filter:blur(28px);
  border-radius:32px;
  padding:30px;
  box-shadow:
    0 70px 160px rgba(0,0,0,.85),
    inset 0 0 0 1px rgba(255,255,255,.1);
}

/* ================= SONG CARD ================= */
.song-card{
  display:flex;
  align-items:center;
  justify-content:space-between;
  padding:22px 26px;
  border-radius:22px;
  background:rgba(255,255,255,.04);
  margin-bottom:16px;
  transition:.28s ease;
}

.song-card:hover{
  background:rgba(255,255,255,.08);
  transform:translateY(-4px);
}

/* ================= LEFT ================= */
.song-left{
  display:flex;
  flex-direction:column;
  gap:6px;
}

.song-title{
  font-weight:600;
  font-size:1.05rem;
}

.song-meta{
  display:flex;
  gap:22px;
  font-size:.85rem;
  color:var(--text-muted);
}

/* ================= RIGHT ================= */
.song-action{
  display:flex;
  gap:10px;
}

.btn-delete{
  background:rgba(239,68,68,.85);
  border:none;
  border-radius:14px;
  padding:7px 18px;
  color:white;
  font-size:.85rem;
  font-weight:600;
  cursor:pointer;
}

.btn-delete:hover{
  background:#ef4444;
}

/* ================= EMPTY ================= */
.empty{
  text-align:center;
  padding:60px 0;
  color:var(--text-muted);
}

/* ================= ALERT ================= */
.alert{
  margin-bottom:26px;
  padding:14px 18px;
  border-radius:16px;
  background:rgba(34,197,94,.18);
  color:#d1fae5;
}
</style>
</head>

<body>

<div class="wrapper">

  <!-- HEADER -->
  <div class="header">
    <div>
      <h1>🎧 Music Library</h1>
      <span>Administrative song management</span>
    </div>

    <a href="/admin" class="back-btn">
      ⬅ Dashboard
    </a>
  </div>

  @if(session('success'))
    <div class="alert">
      {{ session('success') }}
    </div>
  @endif

  <!-- PANEL -->
  <div class="panel">

    @forelse($songs as $song)
      <div class="song-card">

        <!-- LEFT -->
        <div class="song-left">
          <div class="song-title">
            {{ $song->title }}
          </div>

          <div class="song-meta">
            <div>🎤 {{ $song->album->artist->name ?? '-' }}</div>
            <div>💿 {{ $song->album->title ?? '-' }}</div>
          </div>
        </div>

        <!-- RIGHT -->
        <div class="song-action">
          <form
            action="{{ route('admin.songs.destroy', $song->id) }}"
            method="POST"
            onsubmit="return confirm('Yakin hapus lagu ini?')"
          >
            @csrf
            @method('DELETE')
            <button class="btn-delete">
              🗑 Hapus
            </button>
          </form>
        </div>

      </div>
    @empty
      <div class="empty">
        Belum ada lagu
      </div>
    @endforelse

  </div>

</div>

</body>
</html>
