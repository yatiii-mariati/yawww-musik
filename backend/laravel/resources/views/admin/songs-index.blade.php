<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Admin • Daftar Lagu</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
  min-height: 100vh;
  background: linear-gradient(
    135deg,
    #1e293b 0%,
    #0f172a 60%,
    #020617 100%
  );
  color: white;
  font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
}

/* container */
.admin-wrapper {
  max-width: 1100px;
  margin: 60px auto;
  padding: 0 20px;
}

/* header */
.page-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 30px;
}

.page-header h3 {
  font-weight: 600;
}

/* glass card */
.glass-card {
  background: rgba(255,255,255,.08);
  backdrop-filter: blur(16px);
  border-radius: 18px;
  padding: 22px;
  box-shadow: 0 30px 70px rgba(0,0,0,.6);
}

/* table */
.table {
  margin-bottom: 0;
}

.table thead th {
  border-bottom: 1px solid rgba(255,255,255,.25);
  color: #cbd5f5;
  font-weight: 600;
}

.table tbody tr {
  transition: .25s;
}

.table tbody tr:hover {
  background: rgba(255,255,255,.06);
}

.table td {
  vertical-align: middle;
}

/* buttons */
.btn-danger {
  background: rgba(220,38,38,.85);
  border: none;
  border-radius: 10px;
  padding: 4px 10px;
}

.btn-danger:hover {
  background: rgba(239,68,68,.95);
}

.btn-outline-light {
  border-radius: 12px;
}

/* empty */
.empty-text {
  color: #94a3b8;
}

/* alert */
.alert {
  border-radius: 12px;
}
</style>
</head>

<body>

<div class="admin-wrapper">

  <!-- HEADER -->
  <div class="page-header">
    <h3>🎵 Daftar Lagu</h3>
    <a href="/admin" class="btn btn-outline-light btn-sm">
      ⬅ Dashboard
    </a>
  </div>

  {{-- SUCCESS --}}
  @if(session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif

  <!-- TABLE CARD -->
  <div class="glass-card">

    <div class="table-responsive">
      <table class="table table-dark table-borderless align-middle">

        <thead>
          <tr>
            <th>Judul Lagu</th>
            <th>Artis</th>
            <th>Album</th>
            <th class="text-center">Aksi</th>
          </tr>
        </thead>

        <tbody>
        @forelse($songs as $song)
          <tr>
            <td>{{ $song->title }}</td>

            <td class="text-secondary">
              {{ $song->album->artist->name ?? '-' }}
            </td>

            <td class="text-secondary">
              {{ $song->album->title ?? '-' }}
            </td>

            <td class="text-center">
              <form
                action="{{ route('admin.songs.destroy', $song->id) }}"
                method="POST"
                onsubmit="return confirm('Yakin hapus lagu ini?')"
                style="display:inline"
              >
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
            <td colspan="4" class="text-center empty-text py-4">
              Belum ada lagu
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
