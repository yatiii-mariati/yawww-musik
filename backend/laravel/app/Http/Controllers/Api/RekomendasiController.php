<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rekomendasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class RekomendasiController extends Controller
{
    /* =========================
       LIST REKOMENDASI
    ========================= */
    public function index()
    {
        activity_log(
            'VIEW',
            'REKOMENDASI',
            'Melihat daftar rekomendasi'
        );

        return response()->json([
            'success' => true,
            'data' => Rekomendasi::all()
        ], 200);
    }

    /* =========================
       CREATE REKOMENDASI
    ========================= */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100'
        ]);

        $rekomendasi = Rekomendasi::create($data);

        activity_log(
            'CREATE',
            'REKOMENDASI',
            'Menambahkan rekomendasi: ' . $rekomendasi->name
        );

        return response()->json([
            'success' => true,
            'message' => 'Rekomendasi berhasil dibuat',
            'data' => $rekomendasi
        ], 201);
    }

    /* =========================
       DETAIL REKOMENDASI
    ========================= */
    public function show(Rekomendasi $rekomendasi)
    {
        activity_log(
            'VIEW',
            'REKOMENDASI',
            'Melihat rekomendasi ID ' . $rekomendasi->id
        );

        return response()->json([
            'success' => true,
            'data' => $rekomendasi
        ], 200);
    }

    /* =========================
       UPDATE REKOMENDASI
    ========================= */
    public function update(Request $request, Rekomendasi $rekomendasi)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100'
        ]);

        $rekomendasi->update($data);

        activity_log(
            'UPDATE',
            'REKOMENDASI',
            'Update rekomendasi ID ' . $rekomendasi->id
        );

        return response()->json([
            'success' => true,
            'message' => 'Rekomendasi berhasil diperbarui',
            'data' => $rekomendasi
        ], 200);
    }

    /* =========================
       DELETE REKOMENDASI
    ========================= */
    public function destroy(Rekomendasi $rekomendasi)
    {
        $name = $rekomendasi->name;

        $rekomendasi->delete();

        activity_log(
            'DELETE',
            'REKOMENDASI',
            'Hapus rekomendasi: ' . $name
        );

        return response()->json([
            'success' => true,
            'message' => 'Rekomendasi berhasil dihapus'
        ], 200);
    }

    public function uploadPhoto(Request $request, Rekomendasi $rekomendasi)
{
    $request->validate([
        'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // hapus foto lama jika ada
    if ($rekomendasi->photo && Storage::disk('public')->exists($rekomendasi->photo)) {
        Storage::disk('public')->delete($rekomendasi->photo);
    }

    // simpan foto baru
    $path = $request->file('photo')->store('rekomendasi', 'public');

    $rekomendasi->update([
        'photo' => $path
    ]);

    return response()->json([
        'message' => 'Foto rekomendasi berhasil diupload',
        'data' => [
            'id' => $rekomendasi->id,
            'photo' => $path,
            'photo_url' => asset('storage/' . $path),
        ]
    ]);
}

}

