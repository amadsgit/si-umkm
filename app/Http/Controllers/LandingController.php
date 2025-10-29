<?php

namespace App\Http\Controllers;

use App\Models\JadwalPembinaan;
use Carbon\Carbon;

class LandingController extends Controller
{
    public function index()
    {
        // Ambil hanya jadwal pembinaan yang belum lewat
        $jadwalPembinaanList = JadwalPembinaan::where('tanggal', '>=', Carbon::today())
            ->orderBy('tanggal', 'asc')
            ->get();

        return view('landing.beranda', compact('jadwalPembinaanList'));
    }
}
