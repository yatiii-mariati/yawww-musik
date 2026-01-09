<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Artis • Yaww Music</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #6c7bd9, #1f2b4f);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .edit-box {
            width: 100%;
            max-width: 520px;
            background: rgba(255,255,255,.08);
            backdrop-filter: blur(14px);
            border-radius: 18px;
            padding: 32px;
            box-shadow: 0 25px 50px rgba(0,0,0,.45);
        }

        .edit-box h3 {
            font-weight: 600;
            text-align: center;
            margin-bottom: 24px;
        }

        .artist-photo {
            width: 160px;
            height: 160px;
            object-fit: cover;
            border-radius: 18px;
            border: 2px solid rgba(255,255,255,.3);
        }

        label {
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

        .btn-save {
            background: #1DB954;
            border: none;
            border-radius: 12px;
            font-weight: 600;
        }

        .btn-save:hover {
            background: #1ed760;
        }

        .btn-back {
            border-radius: 12px;
        }

        small {
            color: #cfd8ff;
        }
    </style>
</head>

<body>

<div class="edit-box">

    <h3>✏️ Edit Artis</h3>

    {{-- FOTO ARTIS --}}
    <div class="text-center mb-4">
        <img
            src="{{ $artist->photo ? asset('storage/'.$artist->photo) : asset('storage/img/artist-default.png') }}"
            class="artist-photo"
        >
    </div>

    {{-- FORM --}}
    <form action="{{ route('admin.artists.update', $artist->id) }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama Artis</label>
            <input
                type="text"
                name="name"
                class="form-control"
                value="{{ $artist->name }}"
                required
            >
        </div>

        <div class="mb-3">
            <label>Ganti Foto (opsional)</label>
            <input
                type="file"
                name="photo"
                class="form-control"
                accept="image/*"
            >
            <small>
                Biarkan kosong jika tidak ingin mengganti foto
            </small>
        </div>

        <button class="btn btn-save w-100 mt-3">
            💾 Simpan Perubahan
        </button>

        <a href="/admin" class="btn btn-secondary btn-back w-100 mt-2">
            ⬅ Kembali ke Dashboard
        </a>

    </form>

</div>

</body>
</html>
