<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin • Rekomendasi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #0f172a;
            color: white;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .card {
            background: #020617;
            border: 1px solid #1e293b;
            border-radius: 14px;
        }

        .form-control, textarea, select {
            background: #020617;
            color: white;
            border: 1px solid #334155;
        }

        .form-control:focus, textarea:focus, select:focus {
            background: #020617;
            color: white;
            box-shadow: none;
            border-color: #38bdf8;
        }

        table th {
            color: #cbd5f5;
            font-weight: 600;
        }

        img.thumb {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid #334155;
        }

        .btn-success {
            background: #1DB954;
            border: none;
        }

        .btn-success:hover {
            background: #1ed760;
        }
    </style>
</head>

<body>

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>🎧 Admin • Rekomendasi Musik</h2>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light btn-sm">
            ⬅ Kembali ke Dashboard
        </a>
    </div>

    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- ================= FORM TAMBAH ================= --}}
    <div class="card p-4 mb-5">
        <h5 class="mb-3">➕ Tambah Rekomendasi</h5>

        <form method="POST" action="{{ route('admin.rekomendasi.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="row g-3">

                {{-- PILIH LAGU (WAJIB) --}}
                <div class="col-md-6">
                    <label class="form-label">Pilih Lagu</label>
                    <select name="song_id" class="form-control" required>
                        <option value="">-- Pilih Lagu --</option>
                        @foreach($songs as $song)
                            <option value="{{ $song->id }}">
                                {{ $song->title }}
                                — {{ $song->album->artist->name ?? '-' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Judul (Custom)</label>
                    <input type="text" name="judul" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Artis (Custom)</label>
                    <input type="text" name="artis" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Foto Artis (Opsional)</label>
                    <input type="file" name="photo" class="form-control" accept="image/*">
                </div>

                <div class="col-12">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" class="form-control"
                              placeholder="Alasan kenapa lagu ini direkomendasikan"></textarea>
                </div>
            </div>

            <button class="btn btn-success mt-4">
                💾 Simpan Rekomendasi
            </button>
        </form>
    </div>

    {{-- ================= LIST DATA ================= --}}
    <div class="card p-4">
        <h5 class="mb-3">📋 Daftar Rekomendasi</h5>

        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Judul</th>
                        <th>Artis</th>
                        <th>Lagu</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                @forelse($rekomendasis as $rek)
                    <tr>
                        <td>
                            <img
                                src="{{ $rek->photo
                                    ? asset('storage/'.$rek->photo)
                                    : asset('storage/img/artist-default.png') }}"
                                class="thumb"
                            >
                        </td>

                        <td>{{ $rek->judul }}</td>
                        <td>{{ $rek->artis }}</td>

                        <td class="text-secondary">
                            {{ $rek->song->title ?? '-' }}
                        </td>

                        <td class="text-secondary">
                            {{ $rek->deskripsi ?? '-' }}
                        </td>

                        <td>
                            <form action="{{ route('admin.rekomendasi.destroy', $rek->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Hapus rekomendasi ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">
                                    🗑 Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-secondary">
                            Belum ada rekomendasi
                        </td>
                    </tr>
                @endforelse

                </tbody>
            </table>
        </div>
    </div>

</div>

</body>
</html>
