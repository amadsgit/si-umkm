<?php

namespace App\Http\Controllers\Konsultan;

use Carbon\Carbon;
use App\Models\Konsultan;
use Illuminate\Http\Request;
use App\Models\HasilKonsultasi;
use App\Models\JadwalKonsultasi;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\PermintaanKonsultasi;

class KonsultanKonsultasiController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil data konsultan milik user
        $konsultan = Konsultan::where('id', $user->id)->first();
        $konsultanId = $konsultan ? $konsultan->id : null;

        // Statistik
        $totalKonsultasi = 0;
        $jadwalBerlangsung = null;

        if ($konsultanId) {
            $totalKonsultasi = PermintaanKonsultasi::where('konsultan_id', $konsultanId)->count();

            // Jadwal sedang berlangsung
            $now = Carbon::now();
            $jadwalBerlangsung = PermintaanKonsultasi::where('konsultan_id', $konsultanId)
                ->whereHas('jadwal', function ($q) use ($now) {
                    $q->whereDate('tanggal', $now->toDateString())
                      ->whereTime('waktu_mulai', '<=', $now->toTimeString())
                      ->whereTime('waktu_selesai', '>=', $now->toTimeString());
                })
                ->with(['jadwal', 'umkm.user', 'topik'])
                ->first();
        }

        // Konsultasi dijadwalkan
        $konsultasiDijadwalkan = PermintaanKonsultasi::where('konsultan_id', $konsultanId)
            ->whereHas('jadwal', fn($q) => $q->where('status', 'dijadwalkan'))
            ->with('jadwal')
            ->get();

        // Konsultasi selesai
        $konsultasiSelesai = PermintaanKonsultasi::where('konsultan_id', $konsultanId)
            ->whereHas('jadwal', fn($q) => $q->where('status', 'selesai'))
            ->with([
                'jadwal.hasilKonsultasi',
                'umkm',
                'topik',
                'konsultan.user'
            ])
            ->get();

        // Tambahkan dokumen_url ke setiap hasil konsultasi
        foreach ($konsultasiSelesai as $permintaan) {
            if ($permintaan->jadwal && $permintaan->jadwal->hasilKonsultasi) {
                $hasil = $permintaan->jadwal->hasilKonsultasi;
                $hasil->dokumen_url = $hasil->dokumen ? asset('storage/' . $hasil->dokumen) : null;
            }
        }

        return view('dashboard.konsultan.konsultasi.index', compact(
            'user',
            'totalKonsultasi',
            'jadwalBerlangsung',
            'konsultasiDijadwalkan',
            'konsultasiSelesai',
        ));
    }

    public function isiHasilKonsultasi($jadwalId)
    {
        $jadwal = JadwalKonsultasi::with(['permintaan.umkm', 'permintaan.topik'])
            ->findOrFail($jadwalId);

        return view('dashboard.konsultan.konsultasi.form_hasil', compact('jadwal'));
    }

    public function simpanHasilKonsultasi(Request $request, $jadwalId)
    {
        $request->validate([
            'ringkasan' => 'required|string',
            'solusi' => 'required|string',
            'dokumen' => 'nullable|file|max:2048', // max 2MB
        ]);

        $dokumenPath = null;

        if ($request->hasFile('dokumen')) {
            $file = $request->file('dokumen');
            $dokumenPath = $file->store('dokumen_konsultasi', 'public'); // path relatif
        }

        HasilKonsultasi::create([
            'jadwal_id' => $jadwalId,
            'ringkasan' => $request->ringkasan,
            'solusi' => $request->solusi,
            'dokumen' => $dokumenPath,
            'created_by' => Auth::id(),
        ]);

        return redirect()
            ->route('dashboard.konsultan.konsultasi.index')
            ->with('success', 'Hasil konsultasi berhasil disimpan.');
    }
}
