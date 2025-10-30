<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TopikPembinaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopikPembinaanController extends Controller
{
    public function Index()
    {
        $user = Auth::user();
        $topikPembinaanList = TopikPembinaan::paginate(5);

        return view('dashboard.admin.topikpembinaan.index', compact('user', 'topikPembinaanList'));
    }

    public function create()
    {
        return view('dashboard.admin.topikpembinaan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_topik_pembinaan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        TopikPembinaan::create([
            'nama_topik_pembinaan' => $request->nama_topik_pembinaan,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.topik-pembinaan.index')->with('success', 'Topik Pembinaan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $topik_pembinaan = TopikPembinaan::findOrFail($id);

        return view('dashboard.admin.topikpembinaan.edit', compact('topik_pembinaan'));
    }

    public function update(Request $request, $id)
    {
        $topik_pembinaan = TopikPembinaan::findOrFail($id);

        $request->validate([
            'nama_topik_pembinaan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $topik_pembinaan->update([
            'nama_topik_pembinaan' => $request->nama_topik_pembinaan,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.topik-pembinaan.index')->with('success', 'Topik Pembinaan berhasil diperbaharui.');
    }

    public function destroy($id)
    {
        $topik_pembinaan = TopikPembinaan::findOrFail($id);
        $topik_pembinaan->delete();

        return redirect()->route('admin.topik-pembinaan.index')->with('success', 'Topik Pembinaan berhasil dihapus.');
    }
}
