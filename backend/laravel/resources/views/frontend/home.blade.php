<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Yaww Music</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('storage/css/style.css') }}">
</head>

<body>

<div class="app-layout">

  <!-- ================= SIDEBAR ================= -->
  <aside class="sidebar">

    <div class="profile">
      <img src="{{ asset('storage/img/logo.jpg') }}">
      <div class="profile-info">
        <span class="name">Yaww Music</span>
      </div>
    </div>

    <div class="menu">
      <a href="{{ url('/') }}" class="active">🏠 Beranda</a>
      <a href="{{ url('/rekomendasi') }}">✨ Rekomendasi</a>
      <a href="{{ url('/favorites') }}">❤️ Favorit</a>
      <a href="{{ url('/login') }}">🔐 Login</a>
      <a href="{{ url('/account') }}">👤 Akun</a>
    </div>

  </aside>

  <!-- ================= MAIN CONTENT ================= -->
  <main class="content">
    <div class="content-inner">

      <!-- SEARCH -->
      <div class="topbar mb-3">
        <input id="searchArtist" class="search" placeholder="Search artist...">
      </div>

      <!-- ================= BANNER CAROUSEL ================= -->
      <div id="bannerCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
        <div class="carousel-inner rounded overflow-hidden">

          <div class="carousel-item active">
            <img
              src="{{ asset('storage/img/yawwbanner.jpg') }}"
              class="d-block w-100"
              style="height:360px; object-fit:cover;"
              alt="Banner 1">
          </div>

          <div class="carousel-item">
            <img
              src="{{ asset('storage/img/banner2.jpg') }}"
              class="d-block w-100"
              style="height:360px; object-fit:cover;"
              alt="Banner 2">
          </div>

        </div>
      </div>

      <!-- ================= ARTIST GRID ================= -->
      <div class="main d-flex flex-wrap gap-4">

        @foreach ($artists as $artist)
          <div class="audio"
            data-artist-id="{{ $artist->id }}"
            data-artist-image="{{ !empty($artist->photo) 
              ? asset('storage/'.$artist->photo) 
              : asset('img/artist-default.png') }}">

            <img
              src="{{ !empty($artist->photo) 
                ? asset('storage/'.$artist->photo) 
                : asset('img/artist-default.png') }}">

            <h2>{{ $artist->name }}</h2>
            <p>Artist</p>
          </div>
        @endforeach

      </div>

    </div>
  </main>
</div>

<!-- ================= MODAL ARTIST ================= -->
<div class="modal fade" id="artistModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content bg-dark text-white">

      <div class="modal-header">
        <img id="modalArtistImage" style="width:60px;height:60px;border-radius:10px;object-fit:cover">
        <h5 id="modalArtistName" class="ms-3 mb-0">Artist</h5>
        <button class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <ul class="nav nav-tabs mb-3">
          <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tabSongs">🎵 Lagu</button>
          </li>
          <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabAlbums">💿 Album</button>
          </li>
        </ul>

        <div class="tab-content">
          <div class="tab-pane fade show active" id="tabSongs">
            <ul class="list-group list-group-flush" id="songList"></ul>
          </div>

          <div class="tab-pane fade" id="tabAlbums">
            <div id="albumList" class="d-flex flex-wrap gap-3"></div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<!-- ================= MINI PLAYER ================= -->
<div id="miniPlayer" class="fixed-bottom text-white d-none">
  <div class="container py-2">

    <div class="d-flex justify-content-between align-items-center">
      <div class="d-flex gap-2 align-items-center">
        <img id="playerArtistImage" style="width:45px;height:45px;border-radius:8px">
        <div>
          <div id="playerTitle" class="fw-bold">Judul Lagu</div>
          <small id="playerArtist" class="text-secondary">Artist</small>
        </div>
      </div>

      <div class="d-flex gap-3">
        <button id="prevBtn" class="btn btn-outline-light btn-sm">⏮</button>
        <button id="playPauseBtn" class="btn btn-success btn-lg">⏯</button>
        <button id="nextBtn" class="btn btn-outline-light btn-sm">⏭</button>
      </div>

      <button id="shuffleBtn" class="btn btn-outline-light btn-sm">🔀</button>
    </div>

    <div class="d-flex gap-2 align-items-center mt-2">
      <small id="currentTime">0:00</small>
      <input type="range" id="progressBar" min="0" max="100" value="0">
      <small id="duration">0:00</small>
    </div>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('storage/js/player.js') }}"></script>
<script src="{{ asset('storage/js/app.js') }}"></script>

</body>
</html>
