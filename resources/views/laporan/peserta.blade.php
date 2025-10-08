<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Peserta Magang - {{ $peserta->nama }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        h2, h3 { text-align: center; margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #888; padding: 6px 8px; }
        th { background: #f2f2f2; text-align: left; }
        .section { margin-top: 25px; }
        .footer { margin-top: 40px; text-align: right; font-size: 11px; }
    </style>
</head>
<body>
    <h2>LAPORAN PESERTA MAGANG</h2>
    <h3>PT Metaverse Digital Indonesia</h3>
    <hr>

    <div class="section">
        <strong>Nama:</strong> {{ $peserta->nama }} <br>
        <strong>Instansi:</strong> {{ $peserta->asal_instansi }} <br>
        <strong>Jurusan:</strong> {{ $peserta->jurusan }} <br>
        <strong>Periode:</strong>
        {{ $peserta->tanggal_mulai ? date('d M Y', strtotime($peserta->tanggal_mulai)) : '-' }}
        s/d
        {{ $peserta->tanggal_selesai ? date('d M Y', strtotime($peserta->tanggal_selesai)) : '-' }} <br>
        <strong>Status:</strong> {{ ucfirst($peserta->status) }}
    </div>

    <div class="section">
        <h4>Daftar Tugas</h4>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul Tugas</th>
                    <th>Tenggat Waktu</th>
                    <th>Status</th>
                    <th>Nilai</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tugas as $i => $t)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $t->judul }}</td>
                        <td>{{ $t->tenggat_waktu ? date('d M Y', strtotime($t->tenggat_waktu)) : '-' }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $t->status)) }}</td>
                        <td>{{ $t->nilai ? $t->nilai.'%' : '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center;">Belum ada tugas</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d M Y H:i') }}</p>
        <p><strong>Admin Magang</strong></p>
        <br><br>
        <p>_______________________</p>
    </div>
</body>
</html>
