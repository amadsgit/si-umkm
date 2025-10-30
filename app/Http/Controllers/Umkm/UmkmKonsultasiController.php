<?php

namespace App\Http\Controllers\Umkm;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\PermintaanKonsultasi;
use App\Models\TopikKonsultasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UmkmKonsultasiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $now = now();

        // Permintaan konsultasi yang masih berjalan / menunggu
        $permintaanList = PermintaanKonsultasi::where('umkm_id', $user->umkm->id)
            ->with(['topik', 'konsultan.user', 'jadwal', 'hasilKonsultasi'])
            ->where(function ($query) use ($now) {
                $query->where('status', 'pending') // tampilkan semua yang pending
                    ->orWhereHas('jadwal', function ($q) use ($now) {
                        $q->where(function ($query) use ($now) {
                            $query->where('status', '!=', 'selesai')
                                ->where(function ($sub) use ($now) {
                                    // Hanya tampilkan yang belum lewat waktu jadwal
                                    $sub->where('tanggal', '>', $now->toDateString())
                                        ->orWhere(function ($t) use ($now) {
                                            $t->where('tanggal', $now->toDateString())
                                                ->where('waktu_selesai', '>', $now->format('H:i:s'));
                                        });
                                });
                        });
                    });
            })
            ->latest()
            ->get();

        $riwayatList = PermintaanKonsultasi::where('umkm_id', $user->umkm->id)
            ->whereHas('jadwal', function ($q) {
                $q->where('status', 'selesai');
            })
            ->with([
                'topik',
                'konsultan.user',
                'jadwal',
                'hasilKonsultasi',
            ])
            ->latest()
            ->paginate(3);

        // Permintaan yang ditolak
        $ditolakList = PermintaanKonsultasi::where('umkm_id', $user->umkm->id)
            ->where('status', 'ditolak')
            ->with(['topik', 'konsultan.user', 'jadwal', 'hasilKonsultasi'])
            ->latest()
            ->paginate(5);

        return view('dashboard.umkm.konsultasi.index', compact('user', 'permintaanList', 'riwayatList', 'ditolakList'));
    }

    public function create()
    {
        // Ambil semua topik konsultasi aktif
        $topikList = TopikKonsultasi::where('is_aktif', true)->get();

        return view('dashboard.umkm.konsultasi.create', compact('topikList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'topik_id' => 'required|exists:topik_konsultasi,id',
            'preferensi_tanggal' => 'required|date|after_or_equal:today',
            'deskripsi_masalah' => 'nullable|string',
        ]);

        // Simpan data
        PermintaanKonsultasi::create([
            'umkm_id' => Auth::user()->umkm->id,
            'topik_id' => $request->topik_id,
            'preferensi_tanggal' => $request->preferensi_tanggal,
            'deskripsi_masalah' => $request->deskripsi_masalah,
            'status' => 'pending', // default
        ]);

        return redirect()->route('dashboard.umkm.konsultasi.index')
            ->with('success', 'Permintaan konsultasi berhasil diajukan.');
    }

    public function destroy($id)
    {
        $user = Auth::user();

        // Cari permintaan konsultasi milik UMKM yang sedang login
        $permintaan = PermintaanKonsultasi::where('id', $id)
            ->where('umkm_id', $user->umkm->id)
            ->firstOrFail();

        // Hapus data
        $permintaan->delete();

        return redirect()->route('dashboard.umkm.konsultasi.index')
            ->with('success', 'Permintaan konsultasi berhasil dibatalkan.');
    }

    public function feedbackForm($id)
    {
        $user = Auth::user();

        $permintaan = PermintaanKonsultasi::where('id', $id)
            ->where('umkm_id', $user->umkm->id)
            ->with(['hasilKonsultasi', 'konsultan.user'])
            ->firstOrFail();

        return view('dashboard.umkm.konsultasi.feedback', compact('permintaan'));
    }

    public function feedbackStore(Request $request, $id)
    {
        $user = Auth::user();

        $permintaan = PermintaanKonsultasi::where('id', $id)
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
                'target_id' => $permintaan->id,
                'target_type' => 'konsultan',
            ],
            [
                'rating' => $request->rating,
                'komentar' => $request->komentar,
                'created_at' => now(),
            ]
        );

        return redirect()->route('dashboard.umkm.konsultasi.index')
            ->with('success', 'Feedback berhasil dikirim.');
    }
}
