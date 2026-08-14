<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class KartuKeluargaController extends Controller
{
    /**
     * Tampilkan List Data KK beserta Anggotanya
     */
    public function index()
    {
        $kk = DB::table('kartu_keluarga as kk')
            ->select('kk.*', DB::raw('(SELECT COUNT(*) FROM warga w WHERE w.id_kk = kk.id_kk) as jumlah'))
            ->orderBy('kk.id_kk', 'desc')
            ->get();

        // Attach daftar anggota ke masing-masing KK
        foreach ($kk as $item) {
            $item->warga = DB::table('warga')
                ->where('id_kk', $item->id_kk)
                ->orderBy('status_keluarga', 'desc')
                ->get();
        }

        return view('admin.data_kk', compact('kk'));
    }

    /**
     * Simpan Data KK Baru (Validasi Ketat 16 Digit & Anti-Duplikat)
     */
    public function store(Request $request)
    {
        $request->validate([
            'no_kk'  => 'required|numeric|digits:16|unique:kartu_keluarga,no_kk',
            'alamat' => 'nullable|string',
            'rt'     => 'nullable|string|max:5',
            'rw'     => 'nullable|string|max:5',
        ], [
            'no_kk.required' => 'Nomor KK wajib diisi.',
            'no_kk.numeric'  => 'Nomor KK harus berupa angka.',
            'no_kk.digits'   => 'Nomor KK wajib persis 16 digit angka!',
            'no_kk.unique'   => 'Nomor KK ini sudah terdaftar di sistem!',
        ]);

        DB::table('kartu_keluarga')->insert([
            'no_kk'      => $request->no_kk,
            'alamat'     => $request->alamat,
            'rt'         => $request->rt,
            'rw'         => $request->rw,
            'created_at' => now(),
        ]);

        return redirect()->route('admin.kk.index')->with('notif', 'Data KK berhasil ditambahkan!');
    }

    /**
     * Update Data KK (Validasi Ketat 16 Digit & Anti-Duplikat)
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'no_kk'  => [
                'required',
                'numeric',
                'digits:16',
                Rule::unique('kartu_keluarga', 'no_kk')->ignore($id, 'id_kk')
            ],
            'alamat' => 'nullable|string',
            'rt'     => 'nullable|string|max:5',
            'rw'     => 'nullable|string|max:5',
        ], [
            'no_kk.required' => 'Nomor KK wajib diisi.',
            'no_kk.numeric'  => 'Nomor KK harus berupa angka.',
            'no_kk.digits'   => 'Nomor KK wajib persis 16 digit angka!',
            'no_kk.unique'   => 'Nomor KK ini sudah digunakan oleh data KK lain!',
        ]);

        DB::table('kartu_keluarga')
            ->where('id_kk', $id)
            ->update([
                'no_kk'  => $request->no_kk,
                'alamat' => $request->alamat,
                'rt'     => $request->rt,
                'rw'     => $request->rw,
            ]);

        return redirect()->route('admin.kk.index')->with('notif', 'Data KK berhasil diperbarui!');
    }

    /**
     * Hapus KK beserta Warganya
     */
    public function destroy($id)
    {
        DB::table('warga')->where('id_kk', $id)->delete();
        DB::table('kartu_keluarga')->where('id_kk', $id)->delete();

        return redirect()->route('admin.kk.index')->with('notif', 'Data KK beserta warganya telah dihapus!');
    }

    /**
     * Simpan Anggota Warga Baru (NIK Validasi Ketat 16 Digit)
     */
    public function storeAnggota(Request $request)
    {
        $request->validate([
            'id_kk' => 'required',
            'nik'   => 'required|numeric|digits:16|unique:warga,nik',
            'nama'  => 'required|string|max:255',
        ], [
            'nik.required' => 'NIK wajib diisi.',
            'nik.numeric'  => 'NIK harus berupa angka.',
            'nik.digits'   => 'NIK wajib persis 16 digit angka!',
            'nik.unique'   => 'NIK ini sudah terdaftar sebagai warga!',
        ]);

        DB::table('warga')->insert([
            'id_kk'           => $request->id_kk,
            'nik'             => $request->nik,
            'nama'            => $request->nama,
            'tempat_lahir'    => $request->tempat_lahir,
            'tanggal_lahir'   => $request->tanggal_lahir,
            'jenis_kelamin'   => $request->jenis_kelamin,
            'status_keluarga' => $request->status_keluarga,
            'no_hp'           => $request->no_hp,
        ]);

        return redirect()->route('admin.kk.index')->with('notif', 'Anggota keluarga berhasil ditambahkan.');
    }
}
