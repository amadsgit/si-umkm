<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\KepalaUPTD;
use Illuminate\Http\Request;
use App\Mail\KepalaUPTDAccountMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class KepalaUPTDController extends Controller
{
    public function create()
    {
        return view('dashboard.admin.masterdata.tabs.kepalauptd.create');
    }

   public function store(Request $request)
    {
        $request->validate([
            'username'      => 'required|string|max:255|unique:users',
            'email'         => 'required|email|unique:users',
            'phone'         => 'required|string|max:20',
            'password'      => 'required|string|min:6|confirmed',
            'nip'           => 'required|string|max:255|unique:kepala_uptd',
            'jabatan'       => 'required|string|max:255',
            'foto_profil'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $plaintextPassword = $request->password;

        // 1. Buat user baru
        $user = User::create([
            'username'  => $request->username,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'password'  => Hash::make($request->password),
            'role'      => 'kepala_uptd',
        ]);

        // 2. Upload foto profil
        $fotoPath = null;
        if ($request->hasFile('foto_profil')) {
            $fotoPath = $request->file('foto_profil')->store('kepala_uptd/foto_profil', 'public');
        }

        // 3. Simpan ke tabel kepala_uptd
        KepalaUPTD::create([
            'id'           => $user->id,
            'nip'          => $request->nip,
            'jabatan'      => $request->jabatan,
            'foto_profil'  => $fotoPath,
            'status_aktif' => 1,
        ]);

        // 4. Kirim email ke user
        Mail::to($user->email)->send(new KepalaUPTDAccountMail(
            $user->email,
            $user->username,
            $plaintextPassword
        ));

        return redirect()->route('admin.masterdata.index')->with('success', 'Kepala UPTD berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kepala = KepalaUPTD::with('user')->findOrFail($id);
        return view('dashboard.admin.masterdata.tabs.kepalauptd.edit', compact('kepala'));
    }

    public function update(Request $request, $id)
    {
        $kepala = KepalaUPTD::findOrFail($id);
        $user = $kepala->user;

        $request->validate([
            'username'      => 'required|string|max:255|unique:users,username,' . $user->id,
            'email'         => 'required|email|unique:users,email,' . $user->id,
            'phone'         => 'required|string|max:20',
            'password'      => 'nullable|string|min:6|confirmed',
            'nip'           => 'required|string|max:255|unique:kepala_uptd,nip,' . $id,
            'jabatan'       => 'required|string|max:255',
            'foto_profil'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status_aktif'  => 'required|in:0,1',
        ]);

        // Update user
        $user->update([
            'username' => $request->username,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        // Upload foto baru (hapus yang lama jika ada)
        if ($request->hasFile('foto_profil')) {
            if ($kepala->foto_profil && Storage::disk('public')->exists($kepala->foto_profil)) {
                Storage::disk('public')->delete($kepala->foto_profil);
            }
            $kepala->foto_profil = $request->file('foto_profil')->store('kepala_uptd/foto_profil', 'public');
        }

        // Update data kepala_uptd
        $kepala->update([
            'nip'           => $request->nip,
            'jabatan'       => $request->jabatan,
            'status_aktif'  => $request->status_aktif,
        ]);

        return redirect()->route('admin.masterdata.index')->with('success', 'Data Kepala UPTD berhasil diupdate.');
    }

    public function destroy($id)
    {
        $kepala = KepalaUPTD::findOrFail($id);
        $user = $kepala->user;

        // Hapus foto jika ada
        if ($kepala->foto_profil && Storage::disk('public')->exists($kepala->foto_profil)) {
            Storage::disk('public')->delete($kepala->foto_profil);
        }

        // Hapus relasi dan user
        $kepala->delete();
        $user->delete();

        return redirect()->route('admin.masterdata.index')->with('success', 'Data Kepala UPTD berhasil dihapus.');
    }
}
