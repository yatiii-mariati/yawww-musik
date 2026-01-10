<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Album • Yaww Music</title>
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
            max-width: 520px;
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

        label {
            font-size: .85rem;
            color: #cfd8ff;
            margin-bottom: 6px;
        }

        .form-control {
            background: rgba(255,255,255,.12);
            border: 1px solid rgba(255,255,255,.25);
            color: white;
            border-radius: 12px;
        }

        .form-control:disabled {
            background: rgba(255,255,255,.08);
            color: #cfd8ff;
        }

        .form-control::placeholder {
            color: #cfd8ff;
        }

        .form-control:focus {
            background: rgba(255,255,255,.18);
            border-color: #fff;
            color: white;
            box-shadow: none;
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
    </style>
</head>

<body>

<div class="page-wrapper">

    <div class="glass-card">

        <h3>💿 Tambah Album</h3>

        <form action="{{ route('admin.albums.store', $artist->id) }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="artist_id" value="{{ $artist->id }}">

            {{-- ARTIS --}}
            <div class="mb-3">
                <label>Artis</label>
                <input
                    type="text"
                    class="form-control"
                    value="{{ $artist->name }}"
                    disabled
                >
            </div>

            {{-- JUDUL ALBUM --}}
            <div class="mb-3">
                <label>Judul Album</label>
                <input
                    type="text"
                    name="title"
                    class="form-control"
                    placeholder="Judul album"
                    required
                >
            </div>

            {{-- COVER ALBUM --}}
            <div class="mb-4">
                <label>Cover Album</label>
                <input
                    type="file"
                    name="cover"
                    class="form-control"
                >
            </div>

            <button class="btn btn-success w-100">
                💾 Simpan Album
            </button>

            <a href="{{ route('admin.dashboard') }}"
               class="btn btn-outline-light w-100 btn-back">
                ⬅ Kembali
            </a>

        </form>

    </div>

</div>

</body>
</html>
