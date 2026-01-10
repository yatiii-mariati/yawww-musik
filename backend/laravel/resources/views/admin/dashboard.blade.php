<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel • Yaww Music</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #6c7bd9, #1f2b4f);
            color: white;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .admin-container {
            max-width: 1100px;
            margin: 60px auto;
            padding: 0 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header h2 {
            font-weight: 700;
        }

        .action-buttons .btn {
            border-radius: 12px;
            font-weight: 600;
        }

        .glass-card {
            background: rgba(255,255,255,.08);
            backdrop-filter: blur(14px);
            border-radius: 16px;
            padding: 16px 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,.35);
            margin-bottom: 16px;
        }

        .artist-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .artist-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .artist-photo {
            width: 64px;
            height: 64px;
            border-radius: 14px;
            object-fit: cover;
            border: 2px solid rgba(255,255,255,.25);
        }

        .artist-name {
            font-weight: 600;
            font-size: 1.05rem;
        }

        .artist-actions .btn {
            border-radius: 10px;
            font-size: .85rem;
        }

        .btn-success {
            background: #1DB954;
            border: none;
        }

        .btn-success:hover {
            background: #1ed760;
        }

        .btn-info {
            background: #4da3ff;
            border: none;
            color: #000;
        }

        .btn-warning {
            background: #f0ad4e;
            border: none;
        }

        .btn-outline-light:hover {
            background: rgba(255,255,255,.15);
        }

        .empty-text {
            color: #cfd8ff;
            text-align: center;
            margin-top: 40px;
        }
    </style>
</head>

<body>

<div class="admin-container">

    {{-- HEADER --}}
    <div class="header">
        <h2>🎧 Admin Panel</h2>

        <div class="action-buttons d-flex gap-2 flex-wrap">
            <a href="/admin/songs/create" class="btn btn-success">
                ➕ Tambah Lagu
            </a>

            <a href="{{ route('admin.artists.create') }}" class="btn btn-primary">
                ➕ Tambah Artis
            </a>

            <a href="{{ route('admin.songs.index') }}" class="btn btn-warning">
    🎵 Kelola Lagu
            </a>
        </div>

        <a href="{{ route('admin.rekomendasi') }}" class="btn btn-info">
    ✨ Kelola Rekomendasi
</a>

    </div>

    {{-- ARTIST LIST --}}
    <h5 class="mb-3">🎤 Daftar Artis</h5>

    @if($artists->isEmpty())
        <p class="empty-text">Belum ada artis</p>
    @endif

    @foreach($artists as $artist)
        <div class="glass-card">

            <div class="artist-item">

                <div class="artist-left">
                    <img
                        src="{{ $artist->photo
                            ? asset('storage/'.$artist->photo)
                            : asset('storage/img/artist-default.png') }}"
                        class="artist-photo"
                    >

                    <div class="artist-name">
                        {{ $artist->name }}
                    </div>
                </div>

                <div class="artist-actions d-flex gap-2">

                    {{-- DETAIL --}}
                    <a href="{{ route('admin.artists.show', $artist->id) }}"
                       class="btn btn-info btn-sm">
                        👁 Detail
                    </a>

                    {{-- EDIT --}}
                    <a href="{{ route('admin.artists.edit', $artist->id) }}"
                       class="btn btn-outline-light btn-sm">
                        ✏️ Edit
                    </a>

                    {{-- DELETE --}}
                    <form action="{{ route('admin.artists.destroy', $artist->id) }}"
                          method="POST"
                          onsubmit="return confirm('Yakin hapus artis ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">
                            🗑️ Hapus
                        </button>
                    </form>

                </div>

            </div>

        </div>
    @endforeach

</div>

</body>
</html>
