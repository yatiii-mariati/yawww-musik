<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Song;
use App\Models\Artist;
use App\Models\Album;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SongController extends Controller
{
    /**
     * ============================
     * LIST LAGU (DASHBOARD)
     * ============================
     */
    public function index()
    {
        return view('admin.songs.index', [
            'songs' => Song::with(['album.artist', 'genre'])->latest()->get()
        ]);
    }

    /**
     * ============================
     * FORM TAMBAH LAGU
     * ============================
     */
    public function create()
    {
        return view('admin.songs.create', [
            'artists' => Artist::all(),
            
        ]);
    }

    /**
     * ============================
     * SIMPAN LAGU BARU
     * ============================
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'     => 'required|string|max:255',
            'artist_id' => 'required|exists:artists,id',
            'genre_id'  => 'required|exists:genres,id',
            'audio'     => 'required|mimes:mp3,wav'
        ]);

        // album default per artist
        $album = Album::firstOrCreate([
            'artist_id' => $request->artist_id,
            'title'     => 'Single'
        ]);

        // simpan file audio
        $path = $request->file('audio')->store('songs', 'public');

        Song::create([
            'title'      => $request->title,
            'album_id'   => $album->id,
            'genre_id'   => $request->genre_id,
            'audio_path' => $path,
            'duration'  => 0 // default agar tidak error DB
        ]);

        return redirect()
            ->route('admin.songs.index')
            ->with('success', 'Lagu berhasil ditambahkan');
    }

    /**
     * ============================
     * FORM EDIT LAGU
     * ============================
     */
    public function edit(Song $song)
    {
        return view('admin.songs.edit', [
            'song'    => $song,
            
        ]);
    }

    /**
     * ============================
     * UPDATE DATA LAGU
     * ============================
     */
    public function update(Request $request, Song $song)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'genre_id'=> 'required|exists:genres,id'
        ]);

        $song->update([
            'title'    => $request->title,
            'genre_id'=> $request->genre_id
        ]);

        return redirect()
            ->route('admin.songs.index')
            ->with('success', 'Lagu berhasil diperbarui');
    }

    /**
     * ============================
     * HAPUS LAGU
     * ============================
     */
    public function destroy(Song $song)
    {
        if ($song->audio_path && Storage::disk('public')->exists($song->audio_path)) {
            Storage::disk('public')->delete($song->audio_path);
        }

        $song->delete();

        return redirect()
            ->route('admin.songs.index')
            ->with('success', 'Lagu berhasil dihapus');
    }
}
