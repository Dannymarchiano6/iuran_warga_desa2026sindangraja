<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembayaranBendaharaController extends Controller
{
    /**
     * Tampilkan data pembayaran beserta filter dan statistik
     */
    public function index(Request $request)
    {
        $kategori = $request->get('kategori');

        // Query Utama Pembayaran dengan Join Warga & Jenis Iuran
        $query = DB::table('pembayaran as p')
            ->join('warga as w', 'p.nik', '=', 'w.nik')
            ->join('jenis_iuran as j', 'p.id_iuran', '=', 'j.id_iuran')
            ->select('p.*', 'w.nama', 'w.nik as nik_warga', 'j.nama_iuran')
            ->orderBy('p.created_at', 'desc');

        // Filter berdasarkan Kategori Iuran jika dipilih
        if (!empty($kategori)) {
            $query->where('p.id_iuran', $kategori);
        }

        $pembayaran = $query->get();

        // Hitung Total Terverifikasi (Status Lunas)
        $totalVerif = DB::table('pembayaran')
            ->where('status', 'Lunas')
            ->when($kategori, fn($q) => $q->where('id_iuran', $kategori))
            ->sum('jumlah') ?? 0;

        // Hitung Total Pending (Status Tidak Lunas)
        $totalPending = DB::table('pembayaran')
            ->where('status', 'Tidak Lunas')
            ->when($kategori, fn($q) => $q->where('id_iuran', $kategori))
            ->count();

        // Data Master Dropdown Select
        $listIuran = DB::table('jenis_iuran')->orderBy('nama_iuran', 'asc')->get();
        $listWarga = DB::table('warga')->orderBy('nama', 'asc')->get();

        return view('bendahara.pembayaran', compact(
            'pembayaran',
            'totalVerif',
            'totalPending',
            'listIuran',
            'listWarga'
        ));
    }

    /**
     * Simpan transaksi pembayaran baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nik'      => ['required', 'string'],
            'id_iuran' => ['required'],
            'status'   => ['required', 'string'],
        ]);

        // Ambil nominal otomatis berdasarkan jenis iuran yang dipilih
        $iuran = DB::table('jenis_iuran')->where('id_iuran', $request->id_iuran)->first();
        $jumlah = $iuran ? $iuran->jumlah : 0;

        DB::table('pembayaran')->insert([
            'nik'        => $request->nik,
            'id_iuran'   => $request->id_iuran,
            'jumlah'     => $jumlah,
            'status'     => $request->status,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('bendahara.pembayaran.index')
            ->with('status', 'Data pembayaran berhasil disimpan!');
    }

    /**
     * Update data pembayaran
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nik'      => ['required', 'string'],
            'id_iuran' => ['required'],
            'status'   => ['required', 'string'],
        ]);

        // Ambil nominal terbaru jika kategori iuran diubah
        $iuran = DB::table('jenis_iuran')->where('id_iuran', $request->id_iuran)->first();
        $jumlah = $iuran ? $iuran->jumlah : 0;

        DB::table('pembayaran')
            ->where('id', $id)
            ->update([
                'nik'        => $request->nik,
                'id_iuran'   => $request->id_iuran,
                'jumlah'     => $jumlah,
                'status'     => $request->status,
                'updated_at' => now(),
            ]);

        return redirect()->route('bendahara.pembayaran.index')
            ->with('status', 'Data pembayaran berhasil diperbarui!');
    }

    /**
     * Hapus data pembayaran
     */
    public function destroy($id)
    {
        DB::table('pembayaran')->where('id', $id)->delete();

        return redirect()->route('bendahara.pembayaran.index')
            ->with('status', 'Data pembayaran telah berhasil dihapus.');
    }
}
