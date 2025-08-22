<?php

namespace App\Http\Controllers\Admin;

use App\Models\Umkm;
use App\Models\User;
use App\Models\Konsultan;
use App\Models\KepalaUPTD;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
 
class MasterDataController extends Controller
{
    public function MasterDataIndex()
    {
        $user = Auth::user();
        $userList = User::all();
        $umkmList = Umkm::all();
        $konsultanList = Konsultan::all();
        $kepalaUptdList = KepalaUPTD::all();
        return view('dashboard.admin.masterdata.index', compact('user', 'userList', 'umkmList', 'konsultanList', 'kepalaUptdList'));
    }
}
