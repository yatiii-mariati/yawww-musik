<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Favorit • Yaww Music</title>

<meta name="csrf-token" content="{{ csrf_token() }}">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    /* ================= BACKGROUND GAMBAR ================= */
    body {
        min-height: 100vh;

        /* 🔥 BACKGROUND IMAGE + OVERLAY */
        background-image:
            linear-gradient(
                rgba(2, 6, 23, 0.85),
                rgba(2, 6, 23, 0.85)
            ),
            url("{{ asset('img/bg.jpg') }}");

        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;

        color: white;
        font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    /* ================= GLASS EFFECT ================= */
    .glass {
        background: rgba(255,255,255,.08);
        backdrop-filter: blur(14px);
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 25px 50px rgba(0,0,0,.45);
    }

    .list-group-item {
        background: rgba(0,0,0,.55);
        border: 1px solid rgba(255,255,255,.08);
        color: white;
    }

    .list-group-item:hover {
        background: rgba(255,255,255,.08);
    }

    #playerBox {
        background: rgba(0,0,0,.85);
        border-radius: 16px;
        box-shadow: 0 15px 35px rgba(0,0,0,.6);
    }
</style>
</head>

<body>

@if (session('success'))
<div class="alert alert-success alert-dismissible fade show m-3">
    {{ session('success') }}
    <button class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if (session('error'))
<div class="alert alert-danger alert-dismissible fade show m-3">
    {{ session('error') }}
    <button class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="container mt-5">

    <div class="glass">

        <h2 class="mb-4">❤️ Lagu Favorit</h2>

        <ul id="favoriteList" class="list-group mb-4"></ul>

        <!-- PLAYER -->
        <div class="p-3 d-none" id="playerBox">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <strong id="playerTitle">Judul Lagu</strong><br>
                    <small id="playerArtist" class="text-secondary">Artist</small>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-outline-light btn-sm" onclick="prevSong()">⏮</button>
                    <button class="btn btn-success btn-sm" onclick="togglePlay()">⏯</button>
                    <button class="btn btn-outline-light btn-sm" onclick="nextSong()">⏭</button>
                </div>
            </div>

            <input type="range" id="progressBar" class="form-range mt-2" value="0">
        </div>

        <audio id="audio"></audio>

    </div>
</div>

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
            list.innerHTML = `
                <li class="list-group-item text-secondary">
                    Belum ada lagu favorit
                </li>`;
            return;
        }

        playlist = songs.map(song => ({
            id: song.id,
            title: song.title,
            artist: song.artist_name ?? "-",
            url: `${AUDIO_BASE}/${song.audio_path}`
        }));

        playlist.forEach((song, index) => {
            const li = document.createElement("li");
            li.className =
                "list-group-item d-flex justify-content-between align-items-center";

            li.innerHTML = `
                <div>
                    <strong>${song.title}</strong><br>
                    <small>${song.artist}</small>
                </div>
                <button class="btn btn-sm btn-danger">💔</button>
            `;

            li.onclick = () => playSong(index);

            li.querySelector("button").onclick = (e) => {
                e.stopPropagation();
                removeFavorite(song.id);
            };

            list.appendChild(li);
        });

    } catch {
        window.location.href = "/login";
    }
}

/* PLAYER */
function playSong(index) {
    currentIndex = index;
    const song = playlist[currentIndex];

    audio.src = song.url;
    audio.play();

    playerTitle.innerText = song.title;
    playerArtist.innerText = song.artist;

    playerBox.classList.remove("d-none");
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
    progressBar.value =
        (audio.currentTime / audio.duration) * 100 || 0;
});

progressBar.addEventListener("input", () => {
    audio.currentTime =
        (progressBar.value / 100) * audio.duration;
});

/* REMOVE FAVORITE */
function removeFavorite(songId) {
    fetch(`/web/favorites/remove/${songId}`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN":
                document.querySelector('meta[name="csrf-token"]').content,
            "Accept": "application/json"
        }
    })
    .then(() => loadFavoriteSongs())
    .catch(() => alert("Gagal menghapus favorit"));
}

document.addEventListener("DOMContentLoaded", loadFavoriteSongs);
</script>

</body>
</html>
