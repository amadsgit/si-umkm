<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalPembinaan;
use App\Models\JenisPembinaan;
use App\Models\PesertaPembinaan;
use App\Models\TopikPembinaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalPembinaanController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $jadwalPembinaanList = JadwalPembinaan::with(['creator', 'jenis', 'topik'])
            ->withCount('pesertaPembinaan') // hitung jumlah peserta
            ->latest()
            ->paginate(5);

        return view('dashboard.admin.jadwalpembinaan.index', compact('user', 'jadwalPembinaanList'));
    }

    public function create()
    {
        $user = Auth::user();
        $jenisList = JenisPembinaan::all();
        $topikList = TopikPembinaan::all();

        return view('dashboard.admin.jadwalpembinaan.create', compact('user', 'jenisList', 'topikList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_id' => 'required|exists:jenis_pembinaan,id',
            'topik_pembinaan_id' => 'nullable|exists:topik_pembinaan,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'lokasi' => 'required|string|max:255',
            'kuota' => 'required|integer|min:1',
            'metode' => 'required|in:offline,online',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $validated['created_by'] = Auth::id();

        JadwalPembinaan::create($validated);

        return redirect()->route('admin.jadwal-pembinaan.index')
            ->with('success', 'Jadwal pembinaan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = Auth::user();
        $jadwalPembinaan = JadwalPembinaan::findOrFail($id);
        $jenisList = JenisPembinaan::all();
        $topikList = TopikPembinaan::all();

        return view('dashboard.admin.jadwalpembinaan.edit', compact('user', 'jadwalPembinaan', 'jenisList', 'topikList'));
    }

    public function update(Request $request, $id)
    {
        $jadwalPembinaan = JadwalPembinaan::findOrFail($id);

        $validated = $request->validate([
            'jenis_id' => 'required|exists:jenis_pembinaan,id',
            'topik_pembinaan_id' => 'nullable|exists:topik_pembinaan,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'lokasi' => 'required|string|max:255',
            'kuota' => 'required|integer|min:1',
            'metode' => 'required|in:offline,online',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Jika ada upload thumbnail baru
        if ($request->hasFile('thumbnail')) {
            // Hapus thumbnail lama jika ada
            if ($jadwalPembinaan->thumbnail && \Storage::disk('public')->exists($jadwalPembinaan->thumbnail)) {
                \Storage::disk('public')->delete($jadwalPembinaan->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $jadwalPembinaan->update($validated);

        return redirect()->route('admin.jadwal-pembinaan.index')
            ->with('success', 'Jadwal pembinaan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jadwalPembinaan = JadwalPembinaan::findOrFail($id);

        // Hapus file thumbnail jika ada dan filenya ada di storage
        if ($jadwalPembinaan->thumbnail && \Storage::disk('public')->exists($jadwalPembinaan->thumbnail)) {
            \Storage::disk('public')->delete($jadwalPembinaan->thumbnail);
        }

        // Hapus record dari database
        $jadwalPembinaan->delete();

        return redirect()->route('admin.jadwal-pembinaan.index')
            ->with('success', 'Jadwal pembinaan berhasil dihapus.');
    }

    public function peserta($id)
    {
        $jadwal = JadwalPembinaan::findOrFail($id);

        $pesertaList = PesertaPembinaan::with(['umkm.user'])
            ->where('pembinaan_id', $id)
            ->paginate(1);

        return view('dashboard.admin.jadwalpembinaan.peserta', compact('jadwal', 'pesertaList'));
    }
}
