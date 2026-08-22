<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JenisIuranController extends Controller
{
    /**
     * Tampilkan data kategori iuran
     */
    public function index()
    {
        $jenisIuran = DB::table('jenis_iuran')
            ->orderBy('nama_iuran', 'asc')
            ->get();

        return view('bendahara.jenis_iuran', compact('jenisIuran'));
    }

    /**
     * Simpan data kategori iuran baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_iuran' => ['required', 'string', 'max:255'],
            'jumlah'     => ['required', 'numeric', 'min:1000'],
        ], [
            'nama_iuran.required' => 'Nama iuran wajib diisi.',
            'jumlah.required'     => 'Nominal iuran wajib diisi.',
            'jumlah.min'          => 'Nominal iuran minimal Rp 1.000.',
        ]);

        DB::table('jenis_iuran')->insert([
            'nama_iuran' => $request->nama_iuran,
            'jumlah'     => $request->jumlah,
            'tanggal'    => now()->format('Y-m-d'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('bendahara.jenis_iuran.index')
            ->with('status', 'Kategori iuran berhasil ditambahkan!');
    }

    /**
     * Update data kategori iuran
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_iuran' => ['required', 'string', 'max:255'],
            'jumlah'     => ['required', 'numeric', 'min:1000'],
        ], [
            'nama_iuran.required' => 'Nama iuran wajib diisi.',
            'jumlah.required'     => 'Nominal iuran wajib diisi.',
        ]);

        DB::table('jenis_iuran')
            ->where('id_iuran', $id)
            ->update([
                'nama_iuran' => $request->nama_iuran,
                'jumlah'     => $request->jumlah,
                'updated_at' => now(),
            ]);

        return redirect()->route('bendahara.jenis_iuran.index')
            ->with('status', 'Data kategori iuran berhasil diperbarui!');
    }

    /**
     * Hapus data kategori iuran
     */
    public function destroy($id)
    {
        DB::table('jenis_iuran')->where('id_iuran', $id)->delete();

        return redirect()->route('bendahara.jenis_iuran.index')
            ->with('status', 'Kategori iuran telah berhasil dihapus.');
    }
}
