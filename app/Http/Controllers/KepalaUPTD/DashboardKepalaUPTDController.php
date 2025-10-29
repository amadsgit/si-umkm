<?php

namespace App\Http\Controllers\KepalaUPTD;

use App\Exports\KonsultasiExport;
use App\Exports\PembinaanExport;
use App\Http\Controllers\Controller;
use App\Models\JadwalKonsultasi;
use App\Models\JadwalPembinaan;
use App\Models\KepalaUPTD;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class DashboardKepalaUPTDController extends Controller
{
    public function index()
    {
        $user = Auth::user();

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

        return view('dashboard.kepalauptd.index', compact(
            'user',
            'labels',
            'pembinaanData',
            'konsultasiData'
        ));
    }

    public function profil()
    {
        $user = Auth::user();

        $kepalauptd = $user->kepalaUPTD;

        return view('dashboard.kepalauptd.profil', compact('user', 'kepalauptd'));
    }

    // Method Edit
    public function edit($id)
    {
        $user = Auth::user();
        $kepalauptd = KepalaUPTD::with('user')->findOrFail($id);

        return view('dashboard.kepalauptd.edit', compact('user', 'kepalauptd'));
    }

    // Method Update
    public function update(Request $request, $id)
    {
        $kepalauptd = KepalaUPTD::with('user')->findOrFail($id);

        $request->validate([
            'username' => 'required|string|max:100',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'nip' => 'required|string|max:50',
            'jabatan' => 'required|string|max:100',
            'status_aktif' => 'required|boolean',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update data user terkait
        $kepalauptd->user->update([
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        // Update data Kepala UPTD
        $data = $request->only(['nip', 'jabatan', 'status_aktif']);

        // Upload foto baru jika ada
        if ($request->hasFile('foto_profil')) {
            if ($kepalauptd->foto_profil && Storage::exists('public/'.$kepalauptd->foto_profil)) {
                Storage::delete('public/'.$kepalauptd->foto_profil);
            }
            $data['foto_profil'] = $request->file('foto_profil')->store('kepalauptd', 'public');
        }

        $kepalauptd->update($data);

        return redirect()->route('dashboard.kepalauptd.profil')
            ->with('success', 'Profil Kepala UPTD berhasil diperbarui.');
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

        return view('dashboard.kepalauptd.laporanpembinaan', compact(
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

        return view('dashboard.kepalauptd.laporankonsultasi', compact(
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
