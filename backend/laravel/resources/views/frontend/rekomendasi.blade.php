<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Rekomendasi • Yaww Music</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
/* ================= ROOT ================= */
body {
  min-height: 100vh;
  background:
    radial-gradient(circle at 10% 10%, rgba(120,140,255,.35), transparent 40%),
    radial-gradient(circle at 90% 80%, rgba(60,220,200,.25), transparent 45%),
    linear-gradient(135deg, #0b1026, #1a2456);
  color: white;
  font-family: "Inter", system-ui, sans-serif;
  overflow-x: hidden;
}

/* ================= WRAPPER ================= */
.rekom-wrapper {
  padding: 60px 70px 140px;
}

/* ================= TITLE ================= */
.rekom-title {
  font-size: 2rem;
  font-weight: 800;
  letter-spacing: .5px;
  margin-bottom: 36px;
}

.rekom-title::after {
  content: "";
  display: block;
  width: 70px;
  height: 4px;
  margin-top: 10px;
  border-radius: 999px;
  background: linear-gradient(90deg,#7dd3fc,#34d399);
}

/* ================= GRID ================= */
.rekom-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
  gap: 32px;
}

/* ================= CARD ================= */
.rekom-card {
  position: relative;
  background: linear-gradient(
    180deg,
    rgba(255,255,255,.18),
    rgba(255,255,255,.06)
  );
  backdrop-filter: blur(22px);
  border-radius: 24px;
  padding: 16px;
  box-shadow:
    0 25px 60px rgba(0,0,0,.55),
    inset 0 0 0 1px rgba(255,255,255,.15);
  transition: all .35s ease;
  overflow: hidden;
}

.rekom-card:hover {
  transform: translateY(-10px) scale(1.02);
  box-shadow: 0 35px 90px rgba(0,0,0,.75);
}

/* ================= IMAGE ================= */
.rekom-img {
  width: 100%;
  height: 230px;
  border-radius: 20px;
  object-fit: cover;
  transition: transform .45s ease;
}

.rekom-card:hover .rekom-img {
  transform: scale(1.1);
}

/* ================= INFO ================= */
.rekom-info {
  margin-top: 16px;
}

.rekom-info h5 {
  font-size: 1.05rem;
  font-weight: 700;
  margin: 0;
}

.rekom-info small {
  color: #c7d2fe;
  font-size: .8rem;
}

/* ================= DESC ================= */
.rekom-desc {
  font-size: .82rem;
  color: #e0e7ff;
  opacity: .85;
  margin-top: 6px;
  line-height: 1.45;
}

/* ================= PLAY BUTTON ================= */
.play-btn {
  margin-top: 16px;
  width: 100%;
  border-radius: 16px;
  background: linear-gradient(135deg,#38bdf8,#22c55e);
  border: none;
  color: #031019;
  font-weight: 800;
  padding: 10px;
  transition: .25s;
  box-shadow: 0 15px 40px rgba(56,189,248,.45);
}

.play-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 20px 65px rgba(56,189,248,.75);
}

/* ================= DASHBOARD BUTTON ================= */
.back-dashboard {
  position: fixed;
  bottom: 28px;
  left: 28px;
  padding: 12px 24px;
  border-radius: 999px;
  background: rgba(15,23,42,.85);
  backdrop-filter: blur(14px);
  color: white;
  text-decoration: none;
  font-weight: 600;
  box-shadow: 0 20px 50px rgba(0,0,0,.6);
  transition: .25s;
  z-index: 999;
}

.back-dashboard:hover {
  background: rgba(30,41,59,.95);
  transform: translateY(-3px);
}

/* ================= RESPONSIVE ================= */
@media (max-width: 768px) {
  .rekom-wrapper {
    padding: 40px 24px 140px;
  }
}
</style>
</head>

<body>

<div class="rekom-wrapper">

  <div class="rekom-title">✨ Rekomendasi Lagu</div>

  @if($rekomendasis->isEmpty())
    <div class="alert alert-warning">
      Belum ada rekomendasi.
    </div>
  @endif

  <div class="rekom-grid">
    @foreach ($rekomendasis as $rek)
      <div class="rekom-card">

        <img
          class="rekom-img"
          src="{{ $rek->photo
            ? asset('storage/'.$rek->photo)
            : asset('storage/img/artist-default.png') }}"
        >

        <div class="rekom-info">
          <h5>{{ $rek->judul }}</h5>
          <small>{{ $rek->artis }}</small>

          @if($rek->deskripsi)
            <div class="rekom-desc">
              {{ $rek->deskripsi }}
            </div>
          @endif

          @if($rek->song && $rek->song->audio_path)
            <button
              class="play-btn"
              data-audio="{{ asset('storage/'.$rek->song->audio_path) }}"
            >
              ▶ Putar Lagu
            </button>
          @endif
        </div>

      </div>
    @endforeach
  </div>

</div>

<!-- DASHBOARD -->
<a href="{{ url('/') }}" class="back-dashboard">
  ⬅ Dashboard
</a>

<!-- AUDIO -->
<audio id="audioPlayer"></audio>

<script>
const audio = document.getElementById('audioPlayer');
let currentBtn = null;

document.querySelectorAll('.play-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    const src = btn.dataset.audio;

    if (currentBtn === btn && !audio.paused) {
      audio.pause();
      btn.innerText = '▶ Putar Lagu';
      return;
    }

    if (currentBtn) {
      currentBtn.innerText = '▶ Putar Lagu';
    }

    audio.src = src;
    audio.play();
    btn.innerText = '⏸ Pause';
    currentBtn = btn;
  });
});

audio.addEventListener('ended', () => {
  if (currentBtn) {
    currentBtn.innerText = '▶ Putar Lagu';
  }
});
</script>

</body>
</html>
