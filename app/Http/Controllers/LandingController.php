<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalPembinaan;

class LandingController extends Controller
{
    public function index()
    {
        $jadwalPembinaanList = JadwalPembinaan::all();
        return view('landing.beranda', compact('jadwalPembinaanList'));
    }
}
