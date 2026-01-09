<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
    // FORM TAMBAH ALBUM
    public function create(Artist $artist)
    {
        return view('admin.create-album', compact('artist'));
    }

    // SIMPAN ALBUM
    public function store(Request $request, Artist $artist)
{
    $request->validate([
        'title' => 'required',
        'cover' => 'nullable|image'
    ]);

    $coverPath = null;

    if ($request->hasFile('cover')) {
        $coverPath = $request->file('cover')->store('albums', 'public');
    }

    Album::create([
        'artist_id' => $artist->id,
        'title'     => $request->title,
        'cover'     => $coverPath,
    ]);

    return redirect()
        ->route('admin.artists.show', $artist->id)
        ->with('success', 'Album berhasil ditambahkan');
}

public function edit(Album $album)
{
    return view('admin.album-edit', compact('album'));
}

public function update(Request $request, Album $album)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'cover' => 'nullable|image|max:2048'
    ]);

    $data = [
        'title' => $request->title
    ];

    if ($request->hasFile('cover')) {
        // hapus cover lama (opsional tapi rapi)
        if ($album->cover && Storage::disk('public')->exists($album->cover)) {
            Storage::disk('public')->delete($album->cover);
        }

        $data['cover'] = $request->file('cover')
            ->store('albums', 'public');
    }

    $album->update($data);

    return redirect()
        ->route('admin.artists.show', $album->artist_id)
        ->with('success', 'Album berhasil diperbarui');
}


}
