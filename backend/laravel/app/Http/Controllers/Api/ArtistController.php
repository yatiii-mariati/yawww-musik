<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Facades\JWTAuth;

class ArtistController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Artist::latest()->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio'  => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // Upload photo jika ada
        if ($request->hasFile('photo')) {
            $validated['photo'] =
                $request->file('photo')->store('artists', 'public');
        }

        $artist = Artist::create($validated);

        activity_log(
            'CREATE',
            'ARTIST',
            'Menambahkan artist: ' . $artist->name
        );

        Log::info('Artist created', [
            'user_id'   => JWTAuth::user()?->id,
            'artist_id' => $artist->id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Artist created successfully',
            'data' => $artist->fresh()
        ], 201);
    }

    public function show(Artist $artist)
    {
        return response()->json([
            'success' => true,
            'data' => $artist
        ]);
    }

    public function update(Request $request, Artist $artist)
    {
        $validated = $request->validate([
            'name'  => 'sometimes|required|string|max:255',
            'bio'   => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // Upload photo jika ada
        if ($request->hasFile('photo')) {

            if ($artist->photo && Storage::disk('public')->exists($artist->photo)) {
                Storage::disk('public')->delete($artist->photo);
            }

            $validated['photo'] =
                $request->file('photo')->store('artists', 'public');
        }

        // Pastikan ada data yang diupdate
        if (empty($validated)) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada data yang diubah'
            ], 422);
        }

        $artist->update($validated);

        activity_log(
            'UPDATE',
            'ARTIST',
            'Update artist ID ' . $artist->id
        );

        return response()->json([
            'success' => true,
            'message' => 'Artist updated successfully',
            'data' => $artist->fresh() // ambil data terbaru dari DB
        ]);
    }

    public function destroy(Artist $artist)
    {
        // Hapus foto jika ada
        if ($artist->photo && Storage::disk('public')->exists($artist->photo)) {
            Storage::disk('public')->delete($artist->photo);
        }

        $artist->delete();

        activity_log(
            'DELETE',
            'ARTIST',
            'Hapus artist: ' . $artist->name
        );

        return response()->json([
            'success' => true,
            'message' => 'Artist deleted successfully'
        ]);
    }

    public function updatePhoto(Request $request, Artist $artist)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($artist->photo && Storage::disk('public')->exists($artist->photo)) {
            Storage::disk('public')->delete($artist->photo);
        }

        $path = $request->file('photo')->store('artists', 'public');

        $artist->update(['photo' => $path]);

        activity_log(
            'UPDATE_PHOTO',
            'ARTIST',
            'Update foto artist ID ' . $artist->id
        );

        return response()->json([
            'success' => true,
            'message' => 'Artist photo updated successfully',
            'data' => $artist->fresh()
        ]);
    }
}
