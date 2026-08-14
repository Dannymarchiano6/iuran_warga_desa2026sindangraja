<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Ambil Statistik
        $totalKK    = DB::table('kartu_keluarga')->count();
        $totalWarga = DB::table('warga')->count();
        $totalUser  = DB::table('users')->count();

        // 5 Data Warga Terbaru
        $wargaBaru = DB::table('warga as w')
            ->join('kartu_keluarga as kk', 'w.id_kk', '=', 'kk.id_kk')
            ->select('w.*', 'kk.no_kk')
            ->orderBy('w.id_warga', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard_admin', compact('totalKK', 'totalWarga', 'totalUser', 'wargaBaru'));
    }

    public function users()
    {
        return redirect()->route('admin.users.index');
    }

    public function kk()
    {
        return "Halaman Data KK";
    }

    public function warga()
    {
        return "Halaman Data Warga";
    }
}
