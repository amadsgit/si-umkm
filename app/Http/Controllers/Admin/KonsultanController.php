<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Konsultan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\KonsultanAccountMail;


class KonsultanController extends Controller
{
    public function create()
    {
        return view('dashboard.admin.masterdata.tabs.konsultan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username'      => 'required|string|max:255|unique:users',
            'email'         => 'required|email|unique:users',
            'phone'         => 'required|string|max:20',
            'password'      => 'required|string|min:6|confirmed',
            'keahlian'      => 'required|string',
            'sertifikasi'   => 'nullable|string',
            'bio'           => 'nullable|string',
            'foto_profil'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'nomor_sertifikat'    => 'nullable|string|max:255',
            'tanggal_sertifikat'  => 'nullable|date',
            'lembaga'             => 'nullable|string|max:255',
            'file_sertifikat'     => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        // Simpan password plaintext untuk dikirim via email
        $plaintextPassword = $request->password;

        // 1. Buat user baru
        $user = User::create([
            'username'  => $request->username,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'password'  => Hash::make($request->password),
            'role'      => 'konsultan',
        ]);

        // 2. Upload foto profil & sertifikat jika ada
        $fotoPath = null;
        if ($request->hasFile('foto_profil')) {
            $fotoPath = $request->file('foto_profil')->store('konsultan/foto_profil', 'public');
        }

        $fileSertifikatPath = null;
        if ($request->hasFile('file_sertifikat')) {
            $fileSertifikatPath = $request->file('file_sertifikat')->store('konsultan/sertifikat', 'public');
        }

        // 3. Simpan ke tabel konsultan
        Konsultan::create([
            'id'                  => $user->id,
            'keahlian'            => $request->keahlian,
            'sertifikasi'         => $request->sertifikasi,
            'nomor_sertifikat'    => $request->nomor_sertifikat,
            'tanggal_sertifikat'  => $request->tanggal_sertifikat,
            'lembaga'             => $request->lembaga,
            'file_sertifikat'     => $fileSertifikatPath,
            'bio'                 => $request->bio,
            'foto_profil'         => $fotoPath,
            'status_aktif'        => 1,
        ]);

        // 4. Kirim email ke user
        Mail::to($user->email)->send(new KonsultanAccountMail(
            $user->email,
            $user->username,
            $plaintextPassword
        ));

        return redirect()->route('admin.masterdata.index')->with('success', 'Konsultan berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $konsultan = Konsultan::with('user')->findOrFail($id);
        return view('dashboard.admin.masterdata.tabs.konsultan.edit', compact('konsultan'));
    }

    public function update(Request $request, $id)
    {
        $konsultan = Konsultan::findOrFail($id);
        $user = $konsultan->user;

        $request->validate([
            'username'      => 'required|string|max:255|unique:users,username,' . $user->id,
            'email'         => 'required|email|unique:users,email,' . $user->id,
            'phone'         => 'required|string|max:20',
            'password'      => 'nullable|string|min:6|confirmed',
            'keahlian'      => 'required|string',
            'sertifikasi'   => 'nullable|string',
            'bio'           => 'nullable|string',
            'foto_profil'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'nomor_sertifikat'    => 'nullable|string|max:255',
            'tanggal_sertifikat'  => 'nullable|date',
            'lembaga'             => 'nullable|string|max:255',
            'file_sertifikat'     => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'status_aktif' => 'required|in:0,1',
        ]);

        // Update user
        $user->update([
            'username' => $request->username,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        // Handle file uploads
        if ($request->hasFile('foto_profil')) {
            if ($konsultan->foto_profil) {
                Storage::disk('public')->delete($konsultan->foto_profil);
            }
            $konsultan->foto_profil = $request->file('foto_profil')->store('konsultan/foto_profil', 'public');
        }

        if ($request->hasFile('file_sertifikat')) {
            if ($konsultan->file_sertifikat) {
                Storage::disk('public')->delete($konsultan->file_sertifikat);
            }
            $konsultan->file_sertifikat = $request->file('file_sertifikat')->store('konsultan/sertifikat', 'public');
        }

        // Update konsultan
        $konsultan->update([
            'keahlian'            => $request->keahlian,
            'sertifikasi'         => $request->sertifikasi,
            'nomor_sertifikat'    => $request->nomor_sertifikat,
            'tanggal_sertifikat'  => $request->tanggal_sertifikat,
            'lembaga'             => $request->lembaga,
            'bio'                 => $request->bio,
            'status_aktif'        => $request->status_aktif,
        ]);

        return redirect()->route('admin.masterdata.index')->with('success', 'Data konsultan berhasil diupdate.');
    }


    public function destroy($id)
    {
        $konsultan = Konsultan::findOrFail($id);
        $user = $konsultan->user;

        // Hapus file foto_profil jika ada
        if ($konsultan->foto_profil && Storage::disk('public')->exists($konsultan->foto_profil)) {
            Storage::disk('public')->delete($konsultan->foto_profil);
        }

        // Hapus file sertifikat jika ada
        if ($konsultan->file_sertifikat && Storage::disk('public')->exists($konsultan->file_sertifikat)) {
            Storage::disk('public')->delete($konsultan->file_sertifikat);
        }

        // Hapus data konsultan
        $konsultan->delete();

        // Hapus user terkait
        $user->delete();

        return redirect()->route('admin.masterdata.index')->with('success', 'Data konsultan berhasil dihapus.');
    }

}
