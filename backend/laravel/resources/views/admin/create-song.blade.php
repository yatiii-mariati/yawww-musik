<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Lagu • Yaww Music</title>
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
            max-width: 560px;
            margin: 80px auto;
            padding: 0 20px;
        }

        .glass-card {
            background: rgba(255,255,255,.08);
            backdrop-filter: blur(14px);
            border-radius: 18px;
            padding: 28px;
            box-shadow: 0 25px 50px rgba(0,0,0,.45);
        }

        h3 {
            font-weight: 700;
            margin-bottom: 24px;
            text-align: center;
        }

        .form-control,
        .form-select {
            background: rgba(255,255,255,.12);
            border: 1px solid rgba(255,255,255,.25);
            color: white;
            border-radius: 12px;
        }

        .form-control::placeholder {
            color: #cfd8ff;
        }

        .form-control:focus,
        .form-select:focus {
            background: rgba(255,255,255,.18);
            border-color: #fff;
            color: white;
            box-shadow: none;
        }

        option {
            color: #000;
        }

        label {
            font-size: .85rem;
            color: #cfd8ff;
            margin-bottom: 6px;
        }

        .btn-success {
            background: #1DB954;
            border: none;
            border-radius: 14px;
            font-weight: 600;
            padding: 10px;
        }

        .btn-success:hover {
            background: #1ed760;
        }

        .btn-back {
            margin-top: 12px;
            border-radius: 14px;
        }

        .alert {
            border-radius: 12px;
            font-size: .9rem;
        }
    </style>
</head>

<body>

<div class="page-wrapper">

    <div class="glass-card">

        <h3>➕ Tambah Lagu</h3>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST"
              action="{{ route('admin.songs.store') }}"
              enctype="multipart/form-data">
            @csrf

            {{-- JUDUL --}}
            <div class="mb-3">
                <label>Judul Lagu</label>
                <input
                    class="form-control"
                    name="title"
                    placeholder="Judul Lagu"
                    required
                >
            </div>

            {{-- PILIH ARTIS --}}
            <div class="mb-3">
                <label>Artis</label>
                <select class="form-select" name="artist_id" required>
                    <option value="">Pilih Artis</option>
                    @foreach($artists as $artist)
                        <option value="{{ $artist->id }}">
                            {{ $artist->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- PILIH ALBUM --}}
            <div class="mb-3">
                <label>Album</label>
                <select class="form-select" name="album_id" required>
                    <option value="">Pilih Album</option>
                    @foreach($albums as $album)
                        <option value="{{ $album->id }}">
                            {{ $album->title }} ({{ $album->artist->name }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- AUDIO --}}
            <div class="mb-4">
                <label>File Audio</label>
                <input
                    type="file"
                    name="audio"
                    class="form-control"
                    required
                >
            </div>

            <button class="btn btn-success w-100">
                💾 Simpan Lagu
            </button>

            <a href="{{ route('admin.songs.index') }}"
               class="btn btn-outline-light w-100 btn-back">
                ⬅ Kembali
            </a>

        </form>

    </div>

</div>

</body>
</html>
