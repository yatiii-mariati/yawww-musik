<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Playlist;
use App\Models\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PlaylistSongController extends Controller
{
    // 🔐 Ambil playlist milik user login
    private function getUserPlaylist($playlistId)
    {
        return Playlist::where('id', $playlistId)
            ->where('user_id', Auth::id())
            ->firstOrFail();
    }

    // ❤️ Ambil / buat playlist FAVORITE user login
    private function getFavoritePlaylist()
    {
        return Playlist::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'name' => 'Favorite'
            ]
        );
    }

    // ➕ Tambah lagu ke playlist manual
    public function store(Request $request, $playlist)
    {
        $playlist = $this->getUserPlaylist($playlist);

        $data = $request->validate([
            'song_id' => 'required|exists:songs,id'
        ]);

        $playlist->songs()->syncWithoutDetaching($data['song_id']);

        return response()->json([
            'message' => 'Song added to playlist'
        ]);
    }

    // 📌 Ambil lagu dalam playlist manual
    public function songs($playlist)
    {
        $playlist = $this->getUserPlaylist($playlist);

        return response()->json(
            $playlist->songs()->with('artist')->get()
        );
    }

    // ❤️ TOGGLE FAVORITE (INI YANG DIPAKAI FRONTEND)
    public function toggleFavorite($song)
    {
        $playlist = $this->getFavoritePlaylist();
        $song = Song::findOrFail($song);

        if ($playlist->songs()->where('song_id', $song->id)->exists()) {
            $playlist->songs()->detach($song->id);
            return response()->json(['favorited' => false]);
        }

        $playlist->songs()->attach($song->id);
        return response()->json(['favorited' => true]);
    }

    // 📥 Ambil semua favorite user login
    public function favorites()
    {
        $playlist = Playlist::where('user_id', Auth::id())
            ->where('name', 'Favorite')
            ->first();

        if (!$playlist) {
            return response()->json([]);
        }

        return response()->json(
            $playlist->songs()->with('artist')->get()
        );
    }

    // ❌ Hapus lagu dari playlist manual
    public function destroy($playlist, $song)
    {
        $playlist = $this->getUserPlaylist($playlist);
        $playlist->songs()->detach($song);

        return response()->json([
            'message' => 'Song removed from playlist'
        ]);
    }

    // 🔍 Cek apakah lagu sudah difavoritkan user login
public function isFavorited($song)
{
    $playlist = Playlist::where('user_id', Auth::id())
        ->where('name', 'Favorite')
        ->first();

    if (!$playlist) {
        return response()->json(['favorited' => false]);
    }

    return response()->json([
        'favorited' => $playlist->songs()->where('song_id', $song)->exists()
    ]);
}

// 🆔 Ambil playlist Favorite user login
public function favoritePlaylist()
{
    $playlist = $this->getFavoritePlaylist();

    return response()->json([
        'playlist_id' => $playlist->id
    ]);
}

}
