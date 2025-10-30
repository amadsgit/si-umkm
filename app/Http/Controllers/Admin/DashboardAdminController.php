<?php

namespace App\Http\Controllers\Admin;

use App\Exports\KonsultasiExport;
use App\Exports\PembinaanExport;
use App\Http\Controllers\Controller;
use App\Models\JadwalKonsultasi;
use App\Models\JadwalPembinaan;
use App\Models\JenisPembinaan;
use App\Models\Konsultan;
use App\Models\Umkm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class DashboardAdminController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $umkm = Umkm::get();
        $konsultan = Konsultan::get();
        $jenisPembinaan = JenisPembinaan::get();

        $pembinaan = JadwalPembinaan::with(['jenis', 'topik', 'creator'])
            ->withCount('pesertaPembinaan')
            ->orderBy('tanggal', 'desc')
            ->get();
        // Ambil semua data konsultasi dengan relasi
        $konsultasi = JadwalKonsultasi::with(['permintaan', 'hasilKonsultasi'])
            ->orderBy('tanggal', 'desc')
            ->get();

        // Statistik Pembinaan per bulan
        $pembinaanStats = JadwalPembinaan::select(
            DB::raw('MONTH(tanggal) as bulan'),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

        // Statistik Konsultasi per bulan
        $konsultasiStats = JadwalKonsultasi::select(
            DB::raw('MONTH(tanggal) as bulan'),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

        // Label bulan (1–12)
        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        // Data sesuai index bulan
        $pembinaanData = [];
        $konsultasiData = [];
        for ($i = 1; $i <= 12; $i++) {
            $pembinaanData[] = $pembinaanStats[$i] ?? 0;
            $konsultasiData[] = $konsultasiStats[$i] ?? 0;
        }

        return view('dashboard.admin.index', compact('user', 'pembinaan', 'konsultasi', 'pembinaanData', 'konsultasiData', 'umkm', 'konsultan', 'jenisPembinaan'));
    }

    public function laporanpembinaan()
    {
        $user = Auth::user();

        // Ambil semua data pembinaan dengan relasi + hitung peserta
        $pembinaan = JadwalPembinaan::with(['jenis', 'topik', 'creator'])
            ->withCount('pesertaPembinaan')
            ->orderBy('tanggal', 'desc')
            ->paginate(5);

        // Statistik singkat (total kegiatan)
        $totalPembinaan = JadwalPembinaan::with(['jenis', 'topik', 'creator'])->count();
        $totalKonsultasi = JadwalKonsultasi::with(['permintaan', 'hasilKonsultasi'])->count();

        return view('dashboard.admin.laporanRekapitulasi.laporanpembinaan', compact(
            'user',
            'pembinaan',
            'totalPembinaan',
            'totalKonsultasi'
        ));
    }

    public function laporankonsultasi()
    {
        $user = Auth::user();

        // Ambil semua data konsultasi dengan relasi
        $konsultasi = JadwalKonsultasi::with(['permintaan', 'hasilKonsultasi'])
            ->orderBy('tanggal', 'desc')
            ->paginate(5);

        // Statistik singkat (total kegiatan)
        $totalPembinaan = JadwalPembinaan::with(['jenis', 'topik', 'creator'])->count();
        $totalKonsultasi = JadwalKonsultasi::with(['permintaan', 'hasilKonsultasi'])->count();

        return view('dashboard.admin.laporanRekapitulasi.laporankonsultasi', compact(
            'user',
            'konsultasi',
            'totalPembinaan',
            'totalKonsultasi'
        ));
    }

    public function exportPembinaan()
    {
        return Excel::download(new PembinaanExport, 'laporan_pembinaan.xlsx');
    }

    public function exportKonsultasi()
    {
        return Excel::download(new KonsultasiExport, 'laporan_konsultasi.xlsx');
    }
}
