<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArtistController extends Controller
{
    public function edit(Artist $artist)
    {
        return view('admin.edit-artist', compact('artist'));
    }

    public function update(Request $request, Artist $artist)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('photo')) {

            if ($artist->photo && Storage::disk('public')->exists($artist->photo)) {
                Storage::disk('public')->delete($artist->photo);
            }

            $artist->photo = $request->file('photo')
                                     ->store('artists', 'public');
        }

        $artist->name = $request->name;
        $artist->save();

        return redirect('/admin')
            ->with('success', 'Artis berhasil diperbarui');
    }

    public function store(Request $request)
{
    $request->validate([
        'name'  => 'required|string|max:255',
        'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        'bio'   => 'nullable|string'
    ]);

    $path = $request->file('photo')
                    ->store('artists', 'public');

    \App\Models\Artist::create([
        'name'  => $request->name,
        'photo' => $path,
        'bio'   => $request->bio
    ]);

    return redirect('/admin')
        ->with('success', 'Artis berhasil ditambahkan');
}

public function destroy(Artist $artist)
{
    foreach ($artist->albums as $album) {
        foreach ($album->songs as $song) {

            if ($song->audio_path && Storage::disk('public')->exists($song->audio_path)) {
                Storage::disk('public')->delete($song->audio_path);
            }

            $song->delete();
        }

        $album->delete();
    }

    if ($artist->photo && Storage::disk('public')->exists($artist->photo)) {
        Storage::disk('public')->delete($artist->photo);
    }

    $artist->delete();

    return response()->json([
        'success' => true,
        'message' => 'Artist deleted'
    ]);
}

}
