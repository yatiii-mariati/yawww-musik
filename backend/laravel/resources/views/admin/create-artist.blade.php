<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Artis • Yaww Music</title>
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

        .form-control::placeholder {
            color: #cfd8ff;
        }

        .form-control:focus {
            background: rgba(255,255,255,.18);
            border-color: #fff;
            color: white;
            box-shadow: none;
        }

        textarea {
            resize: none;
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

        <h3>➕ Tambah Artis</h3>

        <form action="{{ route('admin.artists.store') }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf

            {{-- NAMA ARTIS --}}
            <div class="mb-3">
                <label>Nama Artis</label>
                <input
                    type="text"
                    name="name"
                    class="form-control"
                    placeholder="Nama artis"
                    required
                >
            </div>

            {{-- FOTO ARTIS --}}
            <div class="mb-3">
                <label>Foto Artis</label>
                <input
                    type="file"
                    name="photo"
                    class="form-control"
                    required
                >
            </div>

            {{-- BIO --}}
            <div class="mb-4">
                <label>Bio</label>
                <textarea
                    name="bio"
                    class="form-control"
                    rows="4"
                    placeholder="Deskripsi singkat artis (opsional)"
                ></textarea>
            </div>

            <button class="btn btn-success w-100">
                💾 Simpan Artis
            </button>

            <a href="/admin"
               class="btn btn-outline-light w-100 btn-back">
                ⬅ Kembali
            </a>

        </form>

    </div>

</div>

</body>
</html>
