<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Riwayat Peminjaman</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container {
            width: 80%;
            margin: 0 auto;
        }

        .header,
        .content,
        .footer {
            margin-bottom: 20px;
        }

        .header h1 {
            text-align: center;
            font-size: 24px;
        }

        .content table {
            width: 100%;
            border-collapse: collapse;
        }

        .content table,
        .content th,
        .content td {
            border: 1px solid #000;
        }

        .content th,
        .content td {
            padding: 8px;
            text-align: left;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            margin-top: 40px;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .container {
                width: 100%;
                margin: 0;
                padding: 20px;
            }

            .footer {
                page-break-before: always;
                margin-top: 50px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Detail Riwayat Peminjaman</h1>
            <p><strong>Kode Peminjaman:</strong> {{ $riwayat->kode_peminjaman }}</p>
        </div>
        <div class="content">
            <table>
                <tr>
                    <th>Nama Peminjam</th>
                    <td>{{ $riwayat->user->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Fasilitas</th>
                    <td>{{ $riwayat->fasilitas->nama_fasilitas ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Tanggal Peminjaman</th>
                    <td>{{ $riwayat->tanggal_mulai->format('d M Y H:i') }} -
                        {{ $riwayat->tanggal_selesai->format('d M Y H:i') }}</td>
                </tr>
                <tr>
                    <th>Keperluan</th>
                    <td>{{ $riwayat->keperluan }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $riwayat->status }}</td>
                </tr>
                <tr>
                    <th>Disetujui Oleh</th>
                    <td>{{ $riwayat->approvedBy->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Catatan</th>
                    <td>{{ $riwayat->catatan ?? '-' }}</td>
                </tr>
            </table>
        </div>
        <div class="footer">
            <p>Dicetak pada: {{ now()->format('d M Y H:i') }}</p>
            <p>&copy; 2025, Universitas Bahaudin Mudhary</p> 
        </div>
    </div>
</body>

</html>
