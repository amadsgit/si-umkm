<?php

namespace App\Http\Controllers\Umkm;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\JadwalPembinaan;
use App\Models\PesertaPembinaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UmkmPembinaanController extends Controller
{
    public function index()
    {
        $umkm = Auth::user()->umkm;

        if (! $umkm) {
            return redirect()->back()->with('error', 'UMKM tidak ditemukan.');
        }

        $jadwalPembinaanList = JadwalPembinaan::withCount('pesertaPembinaan')
            ->whereDoesntHave('pesertaPembinaan', function ($query) use ($umkm) {
                $query->where('umkm_id', $umkm->id);
            })
            ->whereDate('tanggal', '>=', now()) // hanya tampilkan jadwal hari ini & yang akan datang
            ->orderBy('tanggal', 'asc') // disarankan ubah ke ASC supaya urutan dari yang terdekat
            ->take(6)
            ->get();

        return view('dashboard.umkm.pembinaan.index', compact('jadwalPembinaanList'));
    }

    public function apply($id)
    {
        $umkm = Auth::user()->umkm; // cek relasi user->umkm sudah ada atau belum
        if (! $umkm) {
            return redirect()->back()->with('error', 'UMKM tidak ditemukan.');
        }

        $jadwal = JadwalPembinaan::findOrFail($id);

        // Cek apakah sudah pernah daftar
        $sudahDaftar = PesertaPembinaan::where('pembinaan_id', $jadwal->id)
            ->where('umkm_id', $umkm->id)
            ->exists();

        if ($sudahDaftar) {
            return redirect()->route('dashboard.umkm.pembinaan.listpembinaan')
                ->with('warning', 'Anda sudah terdaftar di pembinaan ini.');
        }

        // Simpan ke tabel peserta_pembinaan
        PesertaPembinaan::create([
            'pembinaan_id' => $jadwal->id,
            'umkm_id' => $umkm->id,
            'status_kehadiran' => 'belum_absensi', // default
        ]);

        return redirect()->route('dashboard.umkm.pembinaan.listpembinaan')
            ->with('success', 'Berhasil mendaftar ke pembinaan!');
    }

    public function listPembinaan()
    {
        $umkm = Auth::user()->umkm;

        if (! $umkm) {
            return redirect()->back()->with('error', 'UMKM tidak ditemukan.');
        }

        $pembinaanSaya = PesertaPembinaan::with('pembinaan')
            ->where('umkm_id', $umkm->id)
            ->join('jadwal_pembinaan', 'peserta_pembinaan.pembinaan_id', '=', 'jadwal_pembinaan.id')
            ->orderBy('jadwal_pembinaan.tanggal', 'desc')
            ->orderBy('jadwal_pembinaan.waktu_mulai', 'desc')
            ->select('peserta_pembinaan.*')
            ->paginate(5);

        $now = now();

        foreach ($pembinaanSaya as $peserta) {
            $p = $peserta->pembinaan;
            if (! $p) {
                continue;
            }

            try {
                // gabungkan tanggal + jam
                $mulai = \Carbon\Carbon::parse($p->tanggal.' '.$p->waktu_mulai);
                $selesai = \Carbon\Carbon::parse($p->tanggal.' '.$p->waktu_selesai);
            } catch (\Exception $e) {
                continue;
            }

            // kalau sudah lewat waktu selesai & status masih "belum_absensi"
            if ($now->gt($selesai) && $peserta->status_kehadiran === 'belum_absensi') {
                $peserta->update(['status_kehadiran' => 'tidak_hadir']);
                $peserta->status_kehadiran = 'tidak_hadir'; // supaya sinkron di collection
            }
        }

        return view('dashboard.umkm.pembinaan.list', [
            'pembinaanSaya' => $pembinaanSaya,
            'user' => Auth::user(),
        ]);
    }

    public function absen(Request $request, $id)
    {
        $request->validate([
            'status_kehadiran' => 'required|in:hadir,izin',
        ]);

        $peserta = PesertaPembinaan::findOrFail($id);

        // pastikan hanya UMKM terkait yang bisa update
        if ($peserta->umkm_id !== Auth::user()->umkm->id) {
            return back()->with('error', 'Unauthorized');
        }

        $peserta->update([
            'status_kehadiran' => $request->status_kehadiran,
        ]);

        return back()->with('success', 'Absensi berhasil disimpan!');
    }

    public function feedbackForm($id)
    {
        $user = Auth::user();

        $pembinaan = PesertaPembinaan::where('id', $id)
            ->where('umkm_id', $user->umkm->id)
            ->with('pembinaan')
            ->firstOrFail();

        return view('dashboard.umkm.pembinaan.feedback', compact('pembinaan'));
    }

    public function feedbackStore(Request $request, $id)
    {
        $user = Auth::user();

        $pembinaan = PesertaPembinaan::where('id', $id)
            ->where('umkm_id', $user->umkm->id)
            ->firstOrFail();

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:500',
        ]);

        // Buat atau update feedback
        Feedback::updateOrCreate(
            [
                'umkm_id' => $user->umkm->id,
                'target_id' => $pembinaan->id,
                'target_type' => 'pembinaan',
            ],
            [
                'rating' => $request->rating,
                'komentar' => $request->komentar,
                'created_at' => now(),
            ]
        );

        return redirect()->route('dashboard.umkm.pembinaan.listpembinaan')
            ->with('success', 'Feedback pembinaan berhasil dikirim.');
    }
}
