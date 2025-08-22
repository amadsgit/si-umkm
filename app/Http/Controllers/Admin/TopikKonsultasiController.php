<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\TopikKonsultasi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TopikKonsultasiController extends Controller
{
    public function Index()
    {
        $user = Auth::user();
        $topikKonsultasiList = TopikKonsultasi::all();

        return view('dashboard.admin.topikkonsultasi.index', compact('user', 'topikKonsultasiList'));
    }

    public function create()
    {
        return view('dashboard.admin.topikkonsultasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_topik' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        TopikKonsultasi::create([
            'nama_topik' => $request->nama_topik,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.topik-konsultasi.index')->with('success', 'Topik berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $topik = TopikKonsultasi::findOrFail($id);
        return view('dashboard.admin.topikkonsultasi.edit', compact('topik'));
    }

    public function update(Request $request, $id)
    {
        $topik = TopikKonsultasi::findOrFail($id);

        $request->validate([
            'nama_topik' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $topik->update([
            'nama_topik' => $request->nama_topik,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.topik-konsultasi.index')->with('success', 'Topik berhasil diupdate.');
    }

    public function destroy($id)
    {
        $topik = TopikKonsultasi::findOrFail($id);
        $topik->delete();

        return redirect()->route('admin.topik-konsultasi.index')->with('success', 'Topik berhasil dihapus.');
    }
}

