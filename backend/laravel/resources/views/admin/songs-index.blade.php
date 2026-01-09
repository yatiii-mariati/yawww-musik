<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin - Daftar Lagu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark text-white">

<div class="container mt-5">
    <h3 class="mb-4">🎵 Daftar Lagu</h3>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-dark table-striped align-middle">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Artis</th>
                <th>Album</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
        @forelse($songs as $song)
            <tr>
                <td>{{ $song->title }}</td>

                <td>
                    {{ $song->album->artist->name ?? '-' }}
                </td>

                <td>
                    {{ $song->album->title ?? '-' }}
                </td>

                <td class="text-center">
                    <form action="{{ route('admin.songs.destroy', $song->id) }}"
                          method="POST"
                          onsubmit="return confirm('Yakin hapus lagu ini?')"
                          style="display:inline">
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
                <td colspan="4" class="text-center text-secondary">
                    Belum ada lagu
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <a href="/admin" class="btn btn-outline-light mt-3">
        ⬅ Kembali ke Dashboard
    </a>
</div>

</body>
</html>
