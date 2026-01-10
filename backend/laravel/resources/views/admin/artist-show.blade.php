<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $artist->name }} • Yaww Music</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #6c7bd9, #1f2b4f);
            color: white;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .page-wrapper {
            max-width: 1100px;
            margin: 60px auto;
            padding: 0 20px;
        }

        .glass-card {
            background: rgba(255,255,255,.08);
            backdrop-filter: blur(14px);
            border-radius: 20px;
            padding: 26px;
            box-shadow: 0 25px 50px rgba(0,0,0,.45);
        }

        .artist-header {
            display: flex;
            align-items: center;
            gap: 18px;
            margin-bottom: 24px;
        }

        .artist-header img {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: 14px;
            border: 2px solid rgba(255,255,255,.25);
        }

        h2 {
            font-weight: 700;
            margin-bottom: 2px;
        }

        .subtitle {
            color: #cfd8ff;
            font-size: .9rem;
        }

        .album-card {
            width: 190px;
            background: rgba(0,0,0,.6);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 12px 30px rgba(0,0,0,.4);
        }

        .album-card img {
            width: 100%;
            height: 190px;
            object-fit: cover;
        }

        .album-placeholder {
            height: 190px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,.06);
            color: #cfd8ff;
            font-size: .85rem;
        }

        .album-body {
            padding: 10px;
            text-align: center;
        }

        .album-title {
            font-weight: 600;
            font-size: .95rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .album-footer {
            padding: 10px;
            display: grid;
            gap: 6px;
        }

        .btn-warning {
            background: #f5b942;
            border: none;
        }

        .btn-warning:hover {
            background: #ffc857;
        }
    </style>
</head>

<body>

<div class="page-wrapper">

    <!-- KEMBALI -->
    <a href="{{ route('admin.dashboard') }}"
       class="btn btn-outline-light mb-4">
        ⬅ Kembali ke Dashboard
    </a>

    <div class="glass-card">

        <!-- INFO ARTIST -->
        <div class="artist-header">
            @if($artist->photo)
                <img src="{{ asset('storage/'.$artist->photo) }}">
            @endif

            <div>
                <h2>{{ $artist->name }}</h2>
                <div class="subtitle">
                    Total Album: {{ $artist->albums->count() }}
                </div>
            </div>
        </div>

        <!-- TAMBAH ALBUM -->
        <a href="{{ route('admin.albums.create', $artist->id) }}"
           class="btn btn-warning mb-4">
            ➕ Tambah Album
        </a>

        <hr class="border-light opacity-25">

        <!-- DAFTAR ALBUM -->
        <h5 class="mb-3">💿 Daftar Album</h5>

        @if($artist->albums->isEmpty())
            <p class="text-secondary">
                Belum ada album untuk artis ini.
            </p>
        @else
            <div class="d-flex flex-wrap gap-4">

                @foreach($artist->albums as $album)
                    <div class="album-card">

                        <!-- COVER -->
                        @if($album->cover)
                            <img src="{{ asset('storage/'.$album->cover) }}">
                        @else
                            <div class="album-placeholder">
                                No Cover
                            </div>
                        @endif

                        <!-- INFO -->
                        <div class="album-body">
                            <div class="album-title">
                                {{ $album->title }}
                            </div>
                            <small class="text-secondary">
                                {{ $album->songs->count() ?? 0 }} Lagu
                            </small>
                        </div>

                        <!-- AKSI -->
                        <div class="album-footer">
                            <a href="{{ route('admin.albums.edit', $album->id) }}"
                               class="btn btn-sm btn-outline-warning">
                                ✏️ Edit Album
                            </a>

                            <form action="{{ route('admin.albums.destroy', $album->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Yakin hapus album ini? Semua lagu di dalamnya akan ikut terhapus!')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger w-100">
                                    🗑️ Hapus Album
                                </button>
                            </form>
                        </div>

                    </div>
                @endforeach

            </div>
        @endif

    </div>

</div>

</body>
</html>
