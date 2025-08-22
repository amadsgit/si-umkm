<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UMKM;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class UMKMController extends Controller
{
    public function destroy($id)
    {
        $umkm = UMKM::findOrFail($id);
        $user = $umkm->user;

        // Hapus file foto_profil jika ada
        if ($umkm->foto_profil && Storage::disk('public')->exists($umkm->foto_profil)) {
            Storage::disk('public')->delete($umkm->foto_profil);
        }

        // Hapus data UMKM
        $umkm->delete();

        // Hapus user terkait
        $user->delete();

        return redirect()->route('admin.masterdata.index')->with('success', 'Data UMKM berhasil dihapus.');
    }
}
