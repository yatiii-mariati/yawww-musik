<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Playlist;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class PlaylistController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => JWTAuth::user()->playlists()->with('songs')->get()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $playlist = JWTAuth::user()->playlists()->create($data);

        activity_log('CREATE', 'PLAYLIST', 'Membuat playlist: ' . $playlist->name);

        return response()->json([
            'success' => true,
            'message' => 'Playlist created',
            'data' => $playlist
        ], 201);
    }

    public function show($id)
    {
        $playlist = JWTAuth::user()
            ->playlists()
            ->with('songs')
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $playlist
        ]);
    }

    public function update(Request $request, $id)
    {
        $playlist = JWTAuth::user()->playlists()->findOrFail($id);

        $playlist->update($request->only('name', 'description'));

        activity_log('UPDATE', 'PLAYLIST', 'Update playlist: ' . $playlist->name);

        return response()->json([
            'success' => true,
            'message' => 'Playlist updated',
            'data' => $playlist
        ]);
    }

    public function destroy($id)
    {
        $playlist = JWTAuth::user()->playlists()->findOrFail($id);

        $playlist->delete();

        activity_log('DELETE', 'PLAYLIST', 'Hapus playlist: ' . $playlist->name);

        return response()->json([
            'success' => true,
            'message' => 'Playlist deleted'
        ]);
    }
}
