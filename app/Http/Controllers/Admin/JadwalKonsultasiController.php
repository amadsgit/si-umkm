<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\JadwalKonsultasiMail;
use App\Models\JadwalKonsultasi;
use App\Models\Konsultan;
use App\Models\PermintaanKonsultasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class JadwalKonsultasiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $konsultanList = Konsultan::with('user')->get();

        // Cek semua jadwal yang sudah lewat dan ubah status jadi 'selesai'
        $now = now();
        $jadwalKadaluarsa = JadwalKonsultasi::where('status', 'dijadwalkan')
            ->where(function ($q) use ($now) {
                $q->where('tanggal', '<', $now->toDateString())
                    ->orWhere(function ($sub) use ($now) {
                        $sub->where('tanggal', '=', $now->toDateString())
                            ->where('waktu_selesai', '<', $now->format('H:i'));
                    });
            })
            ->get();

        foreach ($jadwalKadaluarsa as $jadwal) {
            $jadwal->status = 'selesai';
            $jadwal->save();
        }

        // Setelah status diupdate, ambil ulang data untuk list
        $pending = PermintaanKonsultasi::where('status', 'pending')->get();

        $disetujui = PermintaanKonsultasi::where('status', 'disetujui')
            ->whereDoesntHave('jadwal')
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        $dijadwalkan = PermintaanKonsultasi::where('status', 'disetujui')
            ->whereHas('jadwal', function ($q) {
                $q->whereIn('status', ['dijadwalkan', 'dibatalkan']);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        $selesai = PermintaanKonsultasi::where('status', 'disetujui')
            ->whereHas('jadwal', function ($q) {
                $q->where('status', 'selesai');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        // Permintaan yang ditolak
        $ditolakList = PermintaanKonsultasi::where('status', 'ditolak')
            ->latest()
            ->paginate(5);

        return view('dashboard.admin.jadwalkonsultasi.index', compact(
            'konsultanList', 'user', 'pending', 'disetujui', 'dijadwalkan', 'selesai', 'ditolakList'
        ));
    }

    public function UpdateStatusPermintaan(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'alasan' => 'nullable|string|max:500',
        ]);

        $permintaan = PermintaanKonsultasi::findOrFail($id);
        $permintaan->status = $validated['status'];

        // Jika status = "ditolak", isi alasan_ditolak
        if ($validated['status'] === 'ditolak') {
            $permintaan->alasan_ditolak = $validated['alasan'] ?? '-';
        } else {
            // Kosongkan alasan_ditolak jika status bukan ditolak
            $permintaan->alasan_ditolak = null;
        }

        $permintaan->save();

        return redirect()
            ->route('dashboard.admin.jadwalkonsultasi.index')
            ->with('success', 'Status permintaan berhasil diperbarui.');
    }

    public function PenjadwalanKonsultasi(Request $request, $id)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'konsultan_id' => 'required|exists:konsultan,id',
            'metode' => 'required|in:online,offline',
            'lokasi_link' => 'required|string',
            'status' => 'required|in:dijadwalkan,selesai,dibatalkan',
        ]);

        $permintaan = PermintaanKonsultasi::findOrFail($id);
        $permintaan->konsultan_id = $validated['konsultan_id'];
        $permintaan->status = 'disetujui';
        $permintaan->save();

        $jadwal = JadwalKonsultasi::create([
            'permintaan_id' => $permintaan->id,
            'tanggal' => $validated['tanggal'],
            'waktu_mulai' => $validated['waktu_mulai'],
            'waktu_selesai' => $validated['waktu_selesai'],
            'metode' => $validated['metode'],
            'lokasi_link' => $validated['lokasi_link'],
            'status' => $validated['status'],
        ]);

        // Kirim email ke UMKM
        if ($permintaan->umkm && $permintaan->umkm->user) {
            Mail::to($permintaan->umkm->user->email)
                ->send(new JadwalKonsultasiMail($jadwal, 'umkm'));
        }

        // Kirim email ke Konsultan
        if ($permintaan->konsultan && $permintaan->konsultan->user) {
            Mail::to($permintaan->konsultan->user->email)
                ->send(new JadwalKonsultasiMail($jadwal, 'konsultan'));
        }

        return redirect()
            ->route('dashboard.admin.jadwalkonsultasi.index')
            ->with('success', 'Jadwal konsultasi berhasil dibuat dan email notifikasi telah dikirim.');
    }

    public function EditJadwal($id)
    {
        $jadwal = JadwalKonsultasi::with('permintaan.umkm', 'permintaan.topik', 'permintaan.konsultan.user')
            ->findOrFail($id);
        $konsultanList = Konsultan::with('user')->get();

        return response()->json([
            'jadwal' => $jadwal,
            'konsultanList' => $konsultanList,
        ]);
    }

    public function UpdateJadwal(Request $request, $id)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'konsultan_id' => 'required|exists:konsultan,id',
            'metode' => 'required|in:online,offline',
            'lokasi_link' => 'required|string',
            'status' => 'required|in:dijadwalkan,selesai,dibatalkan',
        ]);

        $jadwal = JadwalKonsultasi::findOrFail($id);
        $jadwal->update($validated);

        $jadwal->permintaan->update([
            'konsultan_id' => $validated['konsultan_id'],
        ]);

        // Kirim email ke UMKM
        if ($jadwal->permintaan->umkm && $jadwal->permintaan->umkm->user) {
            Mail::to($jadwal->permintaan->umkm->user->email)
                ->send(new JadwalKonsultasiMail($jadwal, 'umkm'));
        }

        // Kirim email ke Konsultan
        if ($jadwal->permintaan->konsultan && $jadwal->permintaan->konsultan->user) {
            Mail::to($jadwal->permintaan->konsultan->user->email)
                ->send(new JadwalKonsultasiMail($jadwal, 'konsultan'));
        }

        return redirect()
            ->route('dashboard.admin.jadwalkonsultasi.index')
            ->with('success', 'Jadwal konsultasi berhasil diperbarui dan email notifikasi telah dikirim.');
    }
}
