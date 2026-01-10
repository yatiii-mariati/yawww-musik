<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
    /* =========================
       LIST ALBUM
    ========================= */
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Album::with('artist')->get()
        ], 200);
    }

    /* =========================
       DETAIL ALBUM
    ========================= */
    public function show(Album $album)
    {
        $album->load(['artist', 'songs.genre']);

        return response()->json([
            'success' => true,
            'data' => [
                'id'         => $album->id,
                'title'      => $album->title,
                'artist_id'  => $album->artist_id,
                'artist'     => $album->artist->name ?? null,
                'cover'      => $album->cover,
                'cover_url'  => $album->cover
                    ? asset('storage/' . $album->cover)
                    : null,
                'songs'      => $album->songs
            ]
        ], 200);
    }

    /* =========================
       CREATE ALBUM
    ========================= */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'artist_id' => 'required|exists:artists,id',
            'title'     => 'required|string|max:255',
            'cover'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('cover')) {
            $validated['cover'] = $request->file('cover')
                ->store('albums', 'public');
        }

        $album = Album::create($validated);

        activity_log(
    'CREATE',
    'ALBUM',
    'Menambahkan album: ' . $album->title
);


        return response()->json([
            'success' => true,
            'message' => 'Album created successfully',
            'data' => [
                'id'         => $album->id,
                'title'      => $album->title,
                'artist_id'  => $album->artist_id,
                'cover'      => $album->cover,
                'cover_url'  => $album->cover
                    ? asset('storage/' . $album->cover)
                    : null
            ]
        ], 201);
    }

    /* =========================
       UPDATE ALBUM
    ========================= */
    public function update(Request $request, Album $album)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('cover')) {

            if ($album->cover && Storage::disk('public')->exists($album->cover)) {
                Storage::disk('public')->delete($album->cover);
            }

            $validated['cover'] = $request->file('cover')
                ->store('albums', 'public');
        }

        $album->update($validated);

        activity_log(
    'UPDATE',
    'ALBUM',
    'Update album ID ' . $album->id
);


        return response()->json([
            'success' => true,
            'message' => 'Album updated successfully',
            'data' => [
                'id'         => $album->id,
                'title'      => $album->title,
                'artist_id'  => $album->artist_id,
                'cover'      => $album->cover,
                'cover_url'  => $album->cover
                    ? asset('storage/' . $album->cover)
                    : null
            ]
        ], 200);
    }

    /* =========================
       DELETE ALBUM + LAGU + FILE
    ========================= */
    public function destroy(Album $album)
    {
        $album->load('songs');

        foreach ($album->songs as $song) {

            if ($song->audio_path && Storage::disk('public')->exists($song->audio_path)) {
                Storage::disk('public')->delete($song->audio_path);
            }

            $song->delete();
        }

        if ($album->cover && Storage::disk('public')->exists($album->cover)) {
            Storage::disk('public')->delete($album->cover);
        }

        $album->delete();

        activity_log(
    'DELETE',
    'ALBUM',
    'Hapus album: ' . $album->title
);


        return response()->json([
            'success' => true,
            'message' => 'Album deleted successfully'
        ], 200);
    }
}
