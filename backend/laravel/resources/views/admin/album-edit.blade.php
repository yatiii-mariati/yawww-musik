<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Album • Yaww Music</title>
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
            margin: 70px auto;
            padding: 0 20px;
        }

        .glass-card {
            background: rgba(255,255,255,.08);
            backdrop-filter: blur(14px);
            border-radius: 20px;
            padding: 28px;
            box-shadow: 0 25px 50px rgba(0,0,0,.45);
        }

        h4 {
            font-weight: 700;
            margin-bottom: 20px;
        }

        .form-label {
            font-size: .85rem;
            color: #cfd8ff;
        }

        .form-control {
            background: rgba(255,255,255,.12);
            border: 1px solid rgba(255,255,255,.25);
            color: white;
            border-radius: 10px;
        }

        .form-control:focus {
            background: rgba(255,255,255,.18);
            border-color: #fff;
            color: white;
            box-shadow: none;
        }

        .cover-preview {
            width: 130px;
            height: 130px;
            object-fit: cover;
            border-radius: 14px;
            border: 2px solid rgba(255,255,255,.25);
        }

        .btn-warning {
            background: #f5b942;
            border: none;
            font-weight: 600;
            border-radius: 12px;
        }

        .btn-warning:hover {
            background: #ffc857;
        }

        .btn-outline-light {
            border-radius: 12px;
        }

        small {
            color: #cfd8ff;
        }
    </style>
</head>

<body>

<div class="page-wrapper">

    <!-- KEMBALI -->
    <a href="{{ route('admin.artists.show', $album->artist_id) }}"
       class="btn btn-outline-light mb-4">
        ⬅ Kembali
    </a>

    <div class="glass-card">

        <h4>✏️ Edit Album</h4>

        <form action="{{ route('admin.albums.update', $album->id) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <!-- JUDUL -->
            <div class="mb-3">
                <label class="form-label">Judul Album</label>
                <input
                    type="text"
                    name="title"
                    class="form-control"
                    value="{{ old('title', $album->title) }}"
                    required
                >
            </div>

            <!-- COVER -->
            <div class="mb-4">
                <label class="form-label">Cover Album</label>

                @if($album->cover)
                    <img src="{{ asset('storage/'.$album->cover) }}"
                         class="cover-preview d-block mb-2">
                @endif

                <input type="file" name="cover" class="form-control">

                <small>
                    Kosongkan jika tidak ingin mengganti cover
                </small>
            </div>

            <button class="btn btn-warning w-100">
                💾 Simpan Perubahan
            </button>

        </form>

    </div>

</div>

</body>
</html>
