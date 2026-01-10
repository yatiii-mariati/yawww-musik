<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SongController extends Controller
{
    // =========================
    // PUBLIC
    // =========================

    public function index()
    {
        return response()->json(
            Song::with(['album.artist'])->get()
        );
    }

    /**
     * DIGUNAKAN FRONTEND (JS)
     * HARUS return ARRAY LANGSUNG
     */
    public function byArtist($artistId)
    {
        $songs = Song::with(['album', 'album.artist'])
            ->whereHas('album', function ($q) use ($artistId) {
                $q->where('artist_id', $artistId);
            })
            ->get()
            ->map(function ($song) {
                return [
                    'id' => $song->id,
                    'title' => $song->title,
                    'audio_path' => $song->audio_path,

                    // HARUS STRING (dipakai JS)
                    'album' => optional($song->album)->title,

                    // dipakai JS (boleh null)
                    'album_cover' => $song->album && $song->album->cover
                        ? $song->album->cover
                        : null,

                    'artist_name' => optional($song->album->artist)->name,

                    'artist_photo' =>
                        $song->album &&
                        $song->album->artist &&
                        $song->album->artist->photo
                            ? asset('storage/'.$song->album->artist->photo)
                            : null,
                ];
            });

        // 🔥 WAJIB ARRAY LANGSUNG
        return response()->json($songs);
    }

    // =========================
    // AUTH CRUD
    // =========================

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'    => 'required|string|max:255',
            'album_id' => 'required|exists:albums,id',
            'duration' => 'required|integer|min:1',
            'audio'    => 'required|file|mimes:mp3,wav'
        ]);

        // simpan audio
        $path = $request->file('audio')->store('songs', 'public');

        $song = Song::create([
            'title'      => $validated['title'],
            'album_id'   => $validated['album_id'],
            'duration'   => $validated['duration'],
            'audio_path' => $path
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Song created successfully',
            'data'    => $song
        ], 201);
    }

    public function show(Song $song)
    {
        return response()->json(
            $song->load('album.artist')
        );
    }

    public function update(Request $request, Song $song)
    {
        $validated = $request->validate([
            'title'    => 'sometimes|required|string|max:255',
            'album_id' => 'sometimes|required|exists:albums,id',
            'duration' => 'sometimes|required|integer|min:1',
            'audio'    => 'nullable|file|mimes:mp3,wav'
        ]);

        if ($request->hasFile('audio')) {

            // hapus audio lama
            if ($song->audio_path && Storage::disk('public')->exists($song->audio_path)) {
                Storage::disk('public')->delete($song->audio_path);
            }

            // simpan audio baru
            $validated['audio_path'] =
                $request->file('audio')->store('songs', 'public');
        }

        $song->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Song updated successfully',
            'data'    => $song
        ]);
    }

    public function destroy(Song $song)
    {
        if ($song->audio_path && Storage::disk('public')->exists($song->audio_path)) {
            Storage::disk('public')->delete($song->audio_path);
        }

        $song->delete();

        return response()->json([
            'success' => true,
            'message' => 'Song deleted'
        ]);
    }
}
