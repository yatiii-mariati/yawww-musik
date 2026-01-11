<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Favorit • Yaww Music</title>

<meta name="csrf-token" content="{{ csrf_token() }}">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
/* ================= ROOT ================= */
:root {
  --primary: #7dd3fc;
  --accent: #34d399;
  --danger: #ef4444;
}

/* ================= BODY ================= */
body {
  min-height: 100vh;
  background:
    radial-gradient(circle at 15% 10%, rgba(125,211,252,.25), transparent 40%),
    radial-gradient(circle at 85% 80%, rgba(52,211,153,.18), transparent 45%),
    linear-gradient(135deg, #0b1026, #121a3d, #0b1026);
  color: #fff;
  font-family: "Inter", system-ui, sans-serif;
}

/* ================= CONTAINER ================= */
.fav-wrapper {
  max-width: 960px;
  margin: 60px auto 160px;
  padding: 0 20px;
}

/* ================= GLASS ================= */
.glass {
  background: linear-gradient(
    180deg,
    rgba(255,255,255,.14),
    rgba(255,255,255,.04)
  );
  backdrop-filter: blur(24px);
  border-radius: 26px;
  padding: 32px;
  box-shadow:
    0 35px 90px rgba(0,0,0,.7),
    inset 0 0 0 1px rgba(255,255,255,.12);
}

/* ================= TITLE ================= */
.page-title {
  font-size: 1.8rem;
  font-weight: 800;
  letter-spacing: .4px;
  margin-bottom: 26px;
}

.page-title span {
  background: linear-gradient(135deg, var(--primary), var(--accent));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

/* ================= LIST ================= */
.song-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 14px 18px;
  border-radius: 16px;
  background: rgba(0,0,0,.45);
  margin-bottom: 12px;
  transition: .25s;
}

.song-item:hover {
  background: rgba(255,255,255,.08);
  transform: scale(1.01);
}

.song-info strong {
  font-size: .95rem;
}

.song-info small {
  color: #c7d2fe;
}

/* ================= BUTTON ================= */
.btn-remove {
  background: var(--danger);
  border: none;
  border-radius: 12px;
  padding: 6px 12px;
  color: white;
}

.btn-remove:hover {
  background: #dc2626;
}

/* ================= PLAYER ================= */
#playerBox {
  position: fixed;
  left: 50%;
  bottom: 24px;
  transform: translateX(-50%);
  width: min(960px, 95%);
  background: rgba(10,12,30,.92);
  backdrop-filter: blur(20px);
  border-radius: 22px;
  padding: 16px 22px;
  box-shadow: 0 30px 80px rgba(0,0,0,.8);
  z-index: 999;
}

#playerBox.hidden {
  display: none;
}

.player-controls button {
  background: none;
  border: none;
  color: white;
  font-size: 20px;
}

.player-controls button:hover {
  color: var(--primary);
}

/* ================= PROGRESS ================= */
#progressBar {
  accent-color: var(--primary);
}

/* ================= DASHBOARD ================= */
.back-dashboard {
  position: fixed;
  left: 24px;
  bottom: 24px;
  background: rgba(15,23,42,.9);
  backdrop-filter: blur(14px);
  padding: 12px 24px;
  border-radius: 999px;
  color: white;
  text-decoration: none;
  font-weight: 600;
  box-shadow: 0 20px 50px rgba(0,0,0,.7);
  transition: .25s;
}

.back-dashboard:hover {
  transform: translateY(-3px);
  background: rgba(30,41,59,.95);
}
</style>
</head>

<body>

<div class="fav-wrapper">

  <div class="glass">

    <div class="page-title">❤️ <span>Lagu Favorit</span></div>

    <div id="favoriteList"></div>

  </div>
</div>

<!-- PLAYER -->
<div id="playerBox" class="hidden">
  <div class="d-flex justify-content-between align-items-center">
    <div>
      <strong id="playerTitle">Judul Lagu</strong><br>
      <small id="playerArtist" class="text-secondary">Artist</small>
    </div>

    <div class="player-controls d-flex gap-3">
      <button onclick="prevSong()">⏮</button>
      <button onclick="togglePlay()">⏯</button>
      <button onclick="nextSong()">⏭</button>
    </div>
  </div>

  <input type="range" id="progressBar" class="form-range mt-2" value="0">
</div>

<audio id="audio"></audio>

<!-- DASHBOARD -->
<a href="{{ url('/') }}" class="back-dashboard">⬅ Dashboard</a>

<script>
const AUDIO_BASE = "http://127.0.0.1:8000/storage";
const audio = document.getElementById("audio");
const list = document.getElementById("favoriteList");
const playerBox = document.getElementById("playerBox");
const progressBar = document.getElementById("progressBar");
const playerTitle = document.getElementById("playerTitle");
const playerArtist = document.getElementById("playerArtist");

let playlist = [];
let currentIndex = 0;

/* LOAD FAVORITES */
async function loadFavoriteSongs() {
  try {
    const res = await fetch("/web/favorites/list", {
      headers: { "Accept": "application/json" }
    });
    if (!res.ok) throw new Error();

    const songs = await res.json();
    list.innerHTML = "";

    if (!songs.length) {
      list.innerHTML = `<p class="text-secondary">Belum ada lagu favorit</p>`;
      return;
    }

    playlist = songs.map(song => ({
      id: song.id,
      title: song.title,
      artist: song.artist_name ?? "-",
      url: `${AUDIO_BASE}/${song.audio_path}`
    }));

    playlist.forEach((song, index) => {
      const div = document.createElement("div");
      div.className = "song-item";

      div.innerHTML = `
        <div class="song-info">
          <strong>${song.title}</strong><br>
          <small>${song.artist}</small>
        </div>
        <button class="btn-remove">💔</button>
      `;

      div.onclick = () => playSong(index);
      div.querySelector("button").onclick = e => {
        e.stopPropagation();
        removeFavorite(song.id);
      };

      list.appendChild(div);
    });

  } catch {
    window.location.href = "/login";
  }
}

/* PLAYER */
function playSong(index) {
  currentIndex = index;
  const song = playlist[index];

  audio.src = song.url;
  audio.play();

  playerTitle.innerText = song.title;
  playerArtist.innerText = song.artist;
  playerBox.classList.remove("hidden");
}

function togglePlay() {
  audio.paused ? audio.play() : audio.pause();
}

function nextSong() {
  currentIndex = (currentIndex + 1) % playlist.length;
  playSong(currentIndex);
}

function prevSong() {
  currentIndex = (currentIndex - 1 + playlist.length) % playlist.length;
  playSong(currentIndex);
}

/* PROGRESS */
audio.addEventListener("timeupdate", () => {
  progressBar.value = (audio.currentTime / audio.duration) * 100 || 0;
});

progressBar.addEventListener("input", () => {
  audio.currentTime = (progressBar.value / 100) * audio.duration;
});

/* REMOVE */
function removeFavorite(id) {
  fetch(`/web/favorites/remove/${id}`, {
    method: "POST",
    headers: {
      "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
    }
  }).then(loadFavoriteSongs);
}

document.addEventListener("DOMContentLoaded", loadFavoriteSongs);
</script>

</body>
</html>
