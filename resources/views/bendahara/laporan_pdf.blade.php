<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan_Pembayaran_{{ date('Ymd') }}</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #1a1c23; margin: 0; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header h3 { margin: 0; font-size: 16px; font-weight: bold; }
        .header p { margin: 5px 0 0 0; font-size: 10px; color: #555; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table, th, td { border: 1px solid #000; }
        th { background-color: #f8f9fa; padding: 8px; text-align: left; font-size: 10px; text-transform: uppercase; }
        td { padding: 8px; vertical-align: middle; }

        .text-center { text-align: center; }
        .text-end { text-align: right; }
        .fw-bold { font-weight: bold; }

        .ttd-box { float: right; width: 200px; text-align: center; margin-top: 30px; }
    </style>
</head>
<body>

    <div class="header">
        <h3>LAPORAN PEMBAYARAN IURAN WARGA</h3>
        <p>Tanggal Cetak: {{ date('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 30px;" class="text-center">NO</th>
                <th>NAMA WARGA / NIK</th>
                <th>KATEGORI IURAN</th>
                <th>NOMINAL</th>
                <th class="text-center">STATUS</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $index => $row)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ strtoupper($row->nama) }}</strong><br>
                        <span style="font-size: 9px; color: #555;">NIK: {{ $row->nik }}</span>
                    </td>
                    <td>{{ $row->nama_iuran }}</td>
                    <td>Rp {{ number_format($row->jumlah, 0, ',', '.') }}</td>
                    <td class="text-center">{{ strtoupper($row->status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data laporan pembayaran.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-end">TOTAL TERVERIFIKASI</th>
                <th colspan="2">Rp {{ number_format($totalUang, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

    <div class="ttd-box">
        <p>Mengetahui,</p>
        <br><br><br>
        <p class="fw-bold">( Bendahara )</p>
    </div>

</body>
</html>
