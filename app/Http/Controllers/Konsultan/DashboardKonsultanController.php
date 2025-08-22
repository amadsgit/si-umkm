<?php

namespace App\Http\Controllers\Konsultan;

use Carbon\Carbon;
use App\Models\Konsultan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PermintaanKonsultasi;
use Illuminate\Support\Facades\Auth;

class DashboardKonsultanController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil data konsultan milik user
        $konsultan = Konsultan::where('id', $user->id)->first();
        $konsultanId = $konsultan ? $konsultan->id : null;

        // Inisialisasi statistik
        $totalKonsultasi = 0;
        $konsultasiSelesai = 0;
        $jadwalBerlangsung = null;

        if ($konsultanId) {
            $totalKonsultasi = PermintaanKonsultasi::where('konsultan_id', $konsultanId)->count();

            $konsultasiSelesai = PermintaanKonsultasi::where('konsultan_id', $konsultanId)
            ->whereHas('jadwal', function ($q) {
                $q->where('status', 'selesai');
            })
            ->with('jadwal')
            ->count();

            // Hitung sedang berlangsung
            $now = now();
            $konsultasiBerlangsung = PermintaanKonsultasi::where('konsultan_id', $konsultanId)
            ->where('status', 'disetujui')
            ->whereHas('jadwal', function ($q) use ($now) {
                $q->whereDate('tanggal', $now->toDateString())
                ->whereTime('waktu_mulai', '<=', $now->toTimeString())
                ->whereTime('waktu_selesai', '>=', $now->toTimeString());
            })
            ->count();

            
            $konsultasiMendatang = PermintaanKonsultasi::where('konsultan_id', $konsultanId)
            ->whereHas('jadwal', function ($q) {
                $q->where('status', 'dijadwalkan');
            })
            ->with('jadwal')
            ->count();
        }

        return view('dashboard.konsultan.index', compact(
            'user',
            'totalKonsultasi',
            'konsultasiSelesai',
            'konsultasiBerlangsung',
            'konsultasiMendatang'
        ));
    }

    public function profil()
    { 
        $user = Auth::user();
        $konsultanList = Konsultan::all();
        return view('dashboard.konsultan.profil', compact('user', 'konsultanList'));
    }

    public function edit($id)
    {
        $user = Auth::user();
        $konsultan = Konsultan::with('user')->findOrFail($id);

        // Pastikan konsultan yang login hanya bisa edit profilnya sendiri
        if ($konsultan->id !== $user->id) {
            abort(403, 'Akses ditolak');
        }

        return view('dashboard.konsultan.edit', compact('konsultan', 'user'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $konsultan = Konsultan::with('user')->findOrFail($id);

        if ($konsultan->id !== $user->id) {
            abort(403, 'Akses ditolak');
        }

        // Validasi
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'keahlian' => 'nullable|string|max:255',
            'sertifikasi' => 'nullable|string|max:255',
            'nomor_sertifikat' => 'nullable|string|max:255',
            'tanggal_sertifikat' => 'nullable|date',
            'lembaga' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'status_aktif' => 'nullable|boolean',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'file_sertifikat' => 'nullable|mimes:pdf,jpeg,png,jpg|max:5120',
        ]);

        // Update data user
        $konsultan->user->update([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
        ]);

        // Handle upload foto profil
        if ($request->hasFile('foto_profil')) {
            $pathFoto = $request->file('foto_profil')->store('foto_konsultan', 'public');
            $validated['foto_profil'] = $pathFoto;
        } else {
            unset($validated['foto_profil']);
        }

        // Handle upload file sertifikat
        if ($request->hasFile('file_sertifikat')) {
            $pathSertifikat = $request->file('file_sertifikat')->store('sertifikat_konsultan', 'public');
            $validated['file_sertifikat'] = $pathSertifikat;
        } else {
            unset($validated['file_sertifikat']);
        }

        // Update data konsultan
        $konsultan->update($validated);

        return redirect()->route('dashboard.konsultan.profil')
            ->with('success', 'Profil konsultan berhasil diperbarui');
    }
}
