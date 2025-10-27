<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\JadwalPembinaan;
use App\Http\Controllers\Controller;
use App\Models\PermintaanKonsultasi;
use Illuminate\Support\Facades\Auth;

class RiwayatKegiatanController extends Controller
{
    public function IndexRiwayatKonsultasi()
    {
        $RiwayatKonsultasi = PermintaanKonsultasi::where('status', 'disetujui')
            ->whereHas('jadwal', function ($q) {
                $q->where('status', 'selesai');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('dashboard.admin.riwayatkegiatan.konsultasi', compact('RiwayatKonsultasi'
        ));
    }

    public function IndexRiwayatPembinaan()
    {
        $user = Auth::user();

        // Ambil semua data pembinaan dengan relasi + hitung peserta
        $RiwayatPembinaan = JadwalPembinaan::with(['jenis', 'topik', 'creator'])
            ->withCount('pesertaPembinaan')
            ->orderBy('tanggal', 'desc')
            ->paginate(5);

        // Hitung status berdasarkan waktu_mulai & waktu_akhir
        $RiwayatPembinaan->getCollection()->transform(function ($item) {
            $now = now();

            // Ambil tanggal pembinaan
            $date = $item->tanggal;

            // Ambil jam mulai & selesai dari waktu_mulai / waktu_selesai
            $start = $date->copy()->setTimeFromTimeString($item->waktu_mulai->format('H:i:s'));
            $end   = $date->copy()->setTimeFromTimeString($item->waktu_selesai->format('H:i:s'));

            if ($now->lt($start)) {
                $item->status = 'belum_mulai';
            } elseif ($now->between($start, $end)) {
                $item->status = 'berjalan';
            } else {
                $item->status = 'selesai';
            }

            return $item;
        });

        return view('dashboard.admin.riwayatkegiatan.pembinaan', compact('RiwayatPembinaan'));
    }

}
