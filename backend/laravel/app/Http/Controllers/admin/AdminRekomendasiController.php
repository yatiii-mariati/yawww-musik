<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rekomendasi;
use App\Models\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminRekomendasiController extends Controller
{
   public function index()
{
    return view('admin.rekomendasi', [
        'songs' => Song::with('album.artist')->get(),
        'rekomendasis' => Rekomendasi::with('song')->latest()->get(),
    ]);
}


    public function store(Request $request)
    {
        $request->validate([
            'song_id'   => 'required|exists:songs,id',
            'judul'     => 'required',
            'artis'     => 'required',
            'photo'     => 'nullable|image',
            'deskripsi' => 'nullable',
        ]);

        $photo = $request->hasFile('photo')
            ? $request->file('photo')->store('rekomendasi', 'public')
            : null;

        Rekomendasi::create([
            'song_id'   => $request->song_id,
            'judul'     => $request->judul,
            'artis'     => $request->artis,
            'photo'     => $photo,
            'deskripsi' => $request->deskripsi,
        ]);

        return back()->with('success', 'Rekomendasi berhasil ditambahkan');
    }

    public function destroy(Rekomendasi $rekomendasi)
    {
        if ($rekomendasi->photo && Storage::disk('public')->exists($rekomendasi->photo)) {
            Storage::disk('public')->delete($rekomendasi->photo);
        }

        $rekomendasi->delete();

        return back()->with('success', 'Rekomendasi berhasil dihapus');
    }
}
