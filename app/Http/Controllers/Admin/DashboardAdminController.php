<?php

namespace App\Http\Controllers\Admin;

use App\Models\Umkm;
use App\Models\Konsultan;
use App\Models\KepalaUPTD;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardAdminController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('dashboard.admin.index', compact('user'));
    }
}
