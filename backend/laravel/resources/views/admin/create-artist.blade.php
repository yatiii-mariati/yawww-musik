<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Add Artist • Yaww Music</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
:root{
  --bg:#020617;
  --panel:#0b1228;
  --glass:rgba(255,255,255,.08);
  --primary:#60a5fa;
  --accent:#22c55e;
  --muted:#94a3b8;
}

/* ================= BODY ================= */
body{
  margin:0;
  min-height:100vh;
  background:
    radial-gradient(circle at 25% 15%, rgba(96,165,250,.25), transparent 45%),
    radial-gradient(circle at 80% 80%, rgba(34,197,94,.22), transparent 50%),
    linear-gradient(135deg,#020617,#0b1228 55%,#020617);
  font-family:"Inter",system-ui,sans-serif;
  color:white;
  display:flex;
  align-items:center;
  justify-content:center;
}

/* ================= CARD ================= */
.card{
  width:100%;
  max-width:520px;
  background:linear-gradient(
    180deg,
    rgba(255,255,255,.14),
    rgba(255,255,255,.04)
  );
  backdrop-filter:blur(30px);
  border-radius:32px;
  padding:34px;
  box-shadow:
    0 90px 180px rgba(0,0,0,.85),
    inset 0 0 0 1px rgba(255,255,255,.12);
}

/* ================= HEADER ================= */
.header{
  text-align:center;
  margin-bottom:28px;
}

.header h1{
  margin:0;
  font-size:1.6rem;
  font-weight:800;
  letter-spacing:.4px;
}

.header span{
  display:block;
  font-size:.85rem;
  color:var(--muted);
  margin-top:6px;
}

/* ================= FORM ================= */
.group{
  margin-bottom:18px;
}

label{
  display:block;
  font-size:.8rem;
  font-weight:600;
  color:#cbd5f5;
  margin-bottom:6px;
}

input, textarea{
  width:100%;
  background:rgba(255,255,255,.12);
  border:1px solid rgba(255,255,255,.25);
  border-radius:14px;
  padding:12px 14px;
  color:white;
  font-size:.9rem;
}

input::placeholder,
textarea::placeholder{
  color:#c7d2fe;
}

input:focus,
textarea:focus{
  outline:none;
  border-color:white;
  background:rgba(255,255,255,.18);
}

textarea{
  resize:none;
}

/* ================= FILE ================= */
.file{
  padding:10px;
}

/* ================= BUTTONS ================= */
.actions{
  margin-top:26px;
  display:flex;
  flex-direction:column;
  gap:12px;
}

.btn-save{
  background:linear-gradient(135deg,#22c55e,#16a34a);
  border:none;
  border-radius:999px;
  padding:12px;
  color:white;
  font-weight:700;
  cursor:pointer;
  transition:.25s;
}

.btn-save:hover{
  transform:translateY(-1px);
  box-shadow:0 10px 30px rgba(34,197,94,.4);
}

.btn-back{
  text-align:center;
  padding:10px;
  border-radius:999px;
  border:1px solid rgba(255,255,255,.35);
  color:white;
  text-decoration:none;
  font-weight:600;
}

.btn-back:hover{
  background:rgba(255,255,255,.12);
}

/* ================= FOOTER NOTE ================= */
.note{
  text-align:center;
  font-size:.75rem;
  color:var(--muted);
  margin-top:18px;
}
</style>
</head>

<body>

<div class="card">

  <!-- HEADER -->
  <div class="header">
    <h1>🎤 Add New Artist</h1>
    <span>Artist onboarding for Yaww Music</span>
  </div>

  <!-- FORM -->
  <form action="{{ route('admin.artists.store') }}"
        method="POST"
        enctype="multipart/form-data">
    @csrf

    <div class="group">
      <label>Artist Name</label>
      <input
        type="text"
        name="name"
        placeholder="Contoh: Pamungkas"
        required
      >
    </div>

    <div class="group">
      <label>Artist Photo</label>
      <input
        type="file"
        name="photo"
        class="file"
        required
      >
    </div>

    <div class="group">
      <label>Artist Bio</label>
      <textarea
        name="bio"
        rows="4"
        placeholder="Deskripsi singkat artis, genre, atau ciri khas musik"
      ></textarea>
    </div>

    <div class="actions">
      <button class="btn-save">
        💾 Save Artist
      </button>

      <a href="/admin" class="btn-back">
        ⬅ Back to Dashboard
      </a>
    </div>

  </form>

  <div class="note">
    Yaww Music • Artist Management System
  </div>

</div>

</body>
</html>
