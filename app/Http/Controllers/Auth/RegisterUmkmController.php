<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Umkm;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class RegisterUmkmController extends Controller
{
    public function showForm()
    {
        return view('auth.register-umkm');
    }

    public function register(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
            'nama_usaha' => 'required|string|max:255',
            'bidang_usaha' => 'required|string|max:255',
            'alamat_usaha' => 'required|string',
            'tahun_berdiri' => 'required|numeric',
            'kategori_usaha' => 'required|in:mikro,kecil,menengah',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            // Simpan file foto profil
            $fotoPath = null;
            if ($request->hasFile('foto_profil')) {
                $fotoPath = $request->file('foto_profil')->store('umkm/foto_profil', 'public');
            }

            // Buat user
            $user = User::create([
                'username' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'role' => 'umkm',
            ]);

            // Buat profil UMKM
            Umkm::create([
                'id' => $user->id,
                'nama_usaha' => $request->nama_usaha,
                'bidang_usaha' => $request->bidang_usaha,
                'alamat_usaha' => $request->alamat_usaha,
                'tahun_berdiri' => $request->tahun_berdiri,
                'kategori_usaha' => $request->kategori_usaha,
                'foto_profil' => $fotoPath,
            ]);

            DB::commit();

            return redirect()->route('login')->with('success', 'Pendaftaran berhasil. Silakan login.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan saat mendaftar.')->withInput();
        }
    } 
}
