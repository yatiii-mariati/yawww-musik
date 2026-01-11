<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Rekomendasi • Yaww Music</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
  min-height: 100vh;
  background: linear-gradient(135deg, #6c7bd9, #1f2b4f);
  color: white;
  font-family: system-ui, sans-serif;
}

.rekom-wrapper {
  padding: 40px;
}

.rekom-title {
  font-size: 1.6rem;
  font-weight: 600;
  margin-bottom: 24px;
}

.rekom-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
  gap: 24px;
}

.rekom-card {
  background: rgba(255,255,255,.12);
  backdrop-filter: blur(14px);
  border-radius: 18px;
  padding: 14px;
  box-shadow: 0 20px 40px rgba(0,0,0,.35);
  transition: .25s;
}

.rekom-card:hover {
  transform: translateY(-6px);
}

.rekom-img {
  width: 100%;
  height: 200px;
  border-radius: 14px;
  object-fit: cover;
}

.rekom-info {
  margin-top: 12px;
}

.rekom-info h5 {
  margin: 0;
  font-size: 1rem;
  font-weight: 600;
}

.rekom-info small {
  color: #cfd8ff;
}

.rekom-desc {
  font-size: .85rem;
  opacity: .85;
  margin-top: 6px;
}

.play-btn {
  margin-top: 10px;
  width: 100%;
  border-radius: 12px;
  background: rgba(110,140,170,.7);
  border: none;
  color: white;
  font-weight: 600;
  padding: 8px;
}

.play-btn:hover {
  background: rgba(130,160,195,.9);
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

<!-- AUDIO GLOBAL -->
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
