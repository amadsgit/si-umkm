<?php

namespace App\Http\Controllers\Umkm;

use App\Http\Controllers\Controller;
use App\Models\PermintaanKonsultasi;
use App\Models\PesertaPembinaan;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardUmkmController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil UMKM milik user
        $umkm = Umkm::where('id', $user->id)->first();
        $umkmId = $umkm ? $umkm->id : null;

        // Inisialisasi statistik
        $totalKonsultasi = 0;
        $konsultasiSelesai = 0;
        $totalPembinaan = 0;
        $pembinaanSelesai = 0;

        if ($umkmId) {
            $totalKonsultasi = PermintaanKonsultasi::where('umkm_id', $umkmId)->count();
            // Konsultasi yang sudah selesai (status di tabel jadwal_konsultasi)
            $konsultasiSelesai = PermintaanKonsultasi::where('umkm_id', $umkmId)
                ->whereHas('jadwal', function ($query) {
                    $query->where('status', 'selesai');
                })
                ->count();

            $totalPembinaan = PesertaPembinaan::where('umkm_id', $umkmId)->count();
            $pembinaanSelesai = PesertaPembinaan::where('umkm_id', $umkmId)
                ->where('status_kehadiran', 'hadir')
                ->count();
        }

        return view('dashboard.umkm.index', compact(
            'user',
            'totalKonsultasi',
            'konsultasiSelesai',
            'totalPembinaan',
            'pembinaanSelesai'
        ));
    }

    public function profil()
    {
        $user = Auth::user();

        // Ambil UMKM milik user yang login
        $umkm = $user->umkm;

        if (! $umkm) {
            return redirect()->back()->with('error', 'Profil UMKM belum tersedia untuk akun ini.');
        }

        return view('dashboard.umkm.profil', compact('user', 'umkm'));
    }

    public function edit($id)
    {
        $user = Auth::user();
        $umkm = Umkm::findOrFail($id);

        return view('dashboard.umkm.edit', compact('user', 'umkm'));
    }

    public function update(Request $request, $id)
    {
        $umkm = Umkm::findOrFail($id);

        $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'bidang_usaha' => 'required|string|max:255',
            'alamat_usaha' => 'required|string',
            'tahun_berdiri' => 'required|digits:4',
            'kategori_usaha' => 'required|string|max:255',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only([
            'nama_usaha',
            'bidang_usaha',
            'alamat_usaha',
            'tahun_berdiri',
            'kategori_usaha',
        ]);

        // Upload foto baru
        if ($request->hasFile('foto_profil')) {
            // Hapus foto lama jika ada
            if ($umkm->foto_profil && \Storage::disk('public')->exists($umkm->foto_profil)) {
                \Storage::disk('public')->delete($umkm->foto_profil);
            }

            // Simpan foto baru
            $fotoPath = $request->file('foto_profil')->store('umkm/foto_profil', 'public');
            $data['foto_profil'] = $fotoPath;
        }

        $umkm->update($data);

        return redirect()->route('dashboard.umkm.profil')
            ->with('success', 'Profil UMKM berhasil diupdate.');
    }
}
