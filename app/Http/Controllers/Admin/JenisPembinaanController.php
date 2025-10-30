<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisPembinaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JenisPembinaanController extends Controller
{
    public function Index()
    {
        $user = Auth::user();
        $jenisPembinaanList = JenisPembinaan::with('creator')->paginate(5);

        return view('dashboard.admin.jenispembinaan.index', compact('user', 'jenisPembinaanList'));
    }

    public function create()
    {
        return view('dashboard.admin.jenispembinaan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pembinaan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        JenisPembinaan::create([
            'nama_pembinaan' => $request->nama_pembinaan,
            'deskripsi' => $request->deskripsi,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('admin.jenis-pembinaan.index')->with('success', 'Jenis Pembinaan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jenis = JenisPembinaan::findOrFail($id);

        return view('dashboard.admin.jenispembinaan.edit', compact('jenis'));
    }

    public function update(Request $request, $id)
    {
        $jenis = JenisPembinaan::findOrFail($id);

        $request->validate([
            'nama_pembinaan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $jenis->update([
            'nama_pembinaan' => $request->nama_pembinaan,
            'deskripsi' => $request->deskripsi,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('admin.jenis-pembinaan.index')->with('success', 'Jenis Pembinaan berhasil diperbaharui.');
    }

    public function destroy($id)
    {
        $jenis = JenisPembinaan::findOrFail($id);
        $jenis->delete();

        return redirect()->route('admin.jenis-pembinaan.index')->with('success', 'Jenis Pembinaan berhasil dihapus.');
    }
}
