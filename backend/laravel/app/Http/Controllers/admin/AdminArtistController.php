<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArtistController extends Controller
{
    /**
     * Remove the specified artist from storage.
     */
    public function destroy(Artist $artist)
    {
        // Hapus foto artist jika ada
        if (!empty($artist->photo) && Storage::disk('public')->exists($artist->photo)) {
            Storage::disk('public')->delete($artist->photo);
        }

        // (Optional) Hapus relasi album & lagu jika perlu
        // foreach ($artist->albums as $album) {
        //     foreach ($album->songs as $song) {
        //         if ($song->audio_path && Storage::disk('public')->exists($song->audio_path)) {
        //             Storage::disk('public')->delete($song->audio_path);
        //         }
        //         $song->delete();
        //     }
        //
        //     if ($album->cover && Storage::disk('public')->exists($album->cover)) {
        //         Storage::disk('public')->delete($album->cover);
        //     }
        //
        //     $album->delete();
        // }

        // Hapus artist
        $artist->delete();

        // Redirect kembali ke dashboard admin
        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Artist berhasil dihapus');
    }
}
