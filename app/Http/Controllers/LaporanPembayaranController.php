<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanPembayaranController extends Controller
{
    public function index(Request $request)
    {
        $iuran_id = $request->input('iuran');
        $status   = $request->input('status');

        $query = DB::table('pembayaran as p')
            ->join('warga as w', 'p.nik', '=', 'w.nik')
            ->join('jenis_iuran as ji', 'p.id_iuran', '=', 'ji.id_iuran')
            ->select('p.*', 'w.nama', 'w.nik', 'ji.nama_iuran')
            ->orderBy('p.created_at', 'DESC');

        if (!empty($iuran_id)) {
            $query->where('p.id_iuran', $iuran_id);
        }

        if (!empty($status)) {
            $query->where('p.status', $status);
        }

        $data = $query->get();
        $jenisIuranList = DB::table('jenis_iuran')->get();
        $totalUang = $data->where('status', 'Lunas')->sum('jumlah');

        return view('bendahara.laporan', compact('data', 'jenisIuranList', 'totalUang'));
    }

    public function cetakPdf(Request $request)
    {
        $iuran_id = $request->input('iuran');
        $status   = $request->input('status');

        $query = DB::table('pembayaran as p')
            ->join('warga as w', 'p.nik', '=', 'w.nik')
            ->join('jenis_iuran as ji', 'p.id_iuran', '=', 'ji.id_iuran')
            ->select('p.*', 'w.nama', 'w.nik', 'ji.nama_iuran')
            ->orderBy('p.created_at', 'DESC');

        if (!empty($iuran_id)) {
            $query->where('p.id_iuran', $iuran_id);
        }

        if (!empty($status)) {
            $query->where('p.status', $status);
        }

        $data = $query->get();
        $totalUang = $data->where('status', 'Lunas')->sum('jumlah');

        $pdf = Pdf::loadView('bendahara.laporan_pdf', compact('data', 'totalUang'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('Laporan_Pembayaran_' . date('Ymd_His') . '.pdf');
    }
}
