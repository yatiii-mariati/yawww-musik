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
            'name' => 'required|string',
            'description' => 'nullable|string'
        ]);

        $playlist = JWTAuth::user()->playlists()->create($data);

        activity_log(
            'CREATE',
            'PLAYLIST',
            'Membuat playlist: ' . $playlist->name
        );

        return response()->json([
            'success' => true,
            'message' => 'Playlist created',
            'data' => $playlist
        ], 201);
    }

    public function show(Playlist $playlist)
    {
        return response()->json([
            'success' => true,
            'data' => $playlist->load('songs')
        ]);
    }

    public function update(Request $request, Playlist $playlist)
    {
        $playlist->update($request->only('name', 'description'));

        return response()->json([
            'success' => true,
            'message' => 'Playlist updated',
            'data' => $playlist
        ]);
    }

    public function destroy(Playlist $playlist)
    {
        $playlist->delete();

        return response()->json([
            'success' => true,
            'message' => 'Playlist deleted'
        ]);
    }
}
