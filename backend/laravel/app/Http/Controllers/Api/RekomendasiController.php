<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rekomendasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RekomendasiController extends Controller
{
    /* =========================
       LIST
    ========================= */
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Rekomendasi::all()
        ]);
    }

    /* =========================
       CREATE
    ========================= */
    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:150',
            'artis' => 'required|string|max:100',
            'deskripsi' => 'required|string'
        ]);

        $rekomendasi = Rekomendasi::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Rekomendasi berhasil ditambahkan',
            'data' => $rekomendasi
        ], 201);
    }

    /* =========================
       DETAIL
    ========================= */
    public function show($id)
    {
        $rekomendasi = Rekomendasi::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $rekomendasi
        ]);
    }

    /* =========================
       UPDATE
    ========================= */
    public function update(Request $request, $id)
    {
        $rekomendasi = Rekomendasi::findOrFail($id);

        $data = $request->validate([
            'judul' => 'required|string|max:150',
            'artis' => 'required|string|max:100',
            'deskripsi' => 'required|string'
        ]);

        $rekomendasi->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Rekomendasi berhasil diperbarui',
            'data' => $rekomendasi
        ]);
    }

    /* =========================
       DELETE
    ========================= */
    public function destroy($id)
    {
        $rekomendasi = Rekomendasi::findOrFail($id);
        $rekomendasi->delete();

        return response()->json([
            'success' => true,
            'message' => 'Rekomendasi berhasil dihapus'
        ]);
    }
}
