<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pembayaran - {{ $pembayaran->order_id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            background: #f8f9fa;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            padding: 30px;
            text-align: center;
            position: relative;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            opacity: 0.3;
        }

        .header-content {
            position: relative;
            z-index: 1;
        }

        .logo {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            font-size: 24px;
        }

        .header h1 {
            font-size: 28px;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .header .subtitle {
            font-size: 14px;
            opacity: 0.9;
        }

        .content {
            padding: 40px;
        }

        .status-banner {
            text-align: center;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            font-weight: bold;
            font-size: 16px;
        }

        .status-berhasil {
            background: #d4edda;
            color: #155724;
            border: 2px solid #c3e6cb;
        }

        .status-menunggu {
            background: #fff3cd;
            color: #856404;
            border: 2px solid #ffeaa7;
        }

        .status-gagal {
            background: #f8d7da;
            color: #721c24;
            border: 2px solid #f5c6cb;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .info-card {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            transition: transform 0.2s;
        }

        .info-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .info-card .label {
            font-size: 11px;
            text-transform: uppercase;
            font-weight: 600;
            color: #6c757d;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }

        .info-card .value {
            font-size: 16px;
            font-weight: 600;
            color: #495057;
            word-break: break-all;
        }

        .amount-card {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            text-align: center;
            padding: 25px;
            border-radius: 10px;
            margin: 30px 0;
        }

        .amount-card .label {
            font-size: 14px;
            opacity: 0.9;
            margin-bottom: 10px;
        }

        .amount-card .value {
            font-size: 32px;
            font-weight: 700;
        }

        .qr-section {
            text-align: center;
            padding: 30px;
            background: #f8f9fa;
            border-radius: 10px;
            margin: 30px 0;
            border: 2px dashed #dee2e6;
        }

        .qr-code {
            display: inline-block;
            padding: 15px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .qr-section p {
            margin-top: 15px;
            font-size: 14px;
            color: #6c757d;
            font-weight: 500;
        }

        .footer {
            background: #f8f9fa;
            padding: 20px 40px;
            border-top: 1px solid #dee2e6;
            font-size: 11px;
            color: #6c757d;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer .left {
            font-weight: 500;
        }

        .footer .right {
            text-align: right;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .container {
                box-shadow: none;
                border-radius: 0;
            }

            .info-card:hover {
                transform: none;
                box-shadow: none;
            }

            .header::before {
                display: none;
            }

            @page {
                margin: 1cm;
                size: A4;
            }
        }

        .print-only {
            display: none;
        }

        @media print {
            .print-only {
                display: block;
            }

            .no-print {
                display: none;
            }
        }

        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 100px;
            color: rgba(0, 0, 0, 0.05);
            font-weight: bold;
            z-index: 0;
            pointer-events: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="watermark">{{ strtoupper($pembayaran->status) }}</div>

        <div class="header">
            <div class="header-content">
                <div class="logo">
                    <i>💳</i>
                </div>
                <h1>BUKTI PEMBAYARAN</h1>
                <div class="subtitle">
                    Dicetak pada {{ now()->translatedFormat('d F Y, H:i') }} WIB
                </div>
            </div>
        </div>

        <div class="content">
            <!-- Status Banner -->
            <div class="status-banner status-{{ $pembayaran->status }}">
                @php
                    $statusText = match ($pembayaran->status) {
                        'berhasil' => '✅ PEMBAYARAN BERHASIL',
                        'menunggu' => '⏳ MENUNGGU PEMBAYARAN',
                        'gagal' => '❌ PEMBAYARAN GAGAL',
                        'kadaluarsa' => '⏰ PEMBAYARAN KADALUARSA',
                        'dibatalkan' => '🚫 PEMBAYARAN DIBATALKAN',
                        default => '❓ STATUS TIDAK DIKENAL',
                    };
                @endphp
                {{ $statusText }}
            </div>

            <!-- Amount Card -->
            <div class="amount-card">
                <div class="label">Total Pembayaran</div>
                <div class="value">Rp{{ number_format($pembayaran->jumlah, 0, ',', '.') }}</div>
            </div>

            <!-- Info Grid -->
            <div class="info-grid">
                <div class="info-card">
                    <div class="label">Order ID</div>
                    <div class="value">{{ $pembayaran->order_id }}</div>
                </div>

                <div class="info-card">
                    <div class="label">Transaction ID</div>
                    <div class="value">{{ $pembayaran->transaction_id ?? 'Belum tersedia' }}</div>
                </div>

                <div class="info-card">
                    <div class="label">Metode Pembayaran</div>
                    <div class="value">{{ strtoupper($pembayaran->metode ?? 'Tidak diketahui') }}</div>
                </div>

                <div class="info-card">
                    <div class="label">Status Pembayaran</div>
                    <div class="value">{{ ucfirst($pembayaran->status) }}</div>
                </div>

                <div class="info-card">
                    <div class="label">Tanggal Pembayaran</div>
                    <div class="value">
                        {{ $pembayaran->tanggal_bayar ? $pembayaran->tanggal_bayar->translatedFormat('d F Y, H:i') . ' WIB' : 'Belum dibayar' }}
                    </div>
                </div>

                <div class="info-card">
                    <div class="label">Kode Peminjaman</div>
                    <div class="value">{{ $pembayaran->peminjaman->kode_peminjaman ?? 'Tidak terkait' }}</div>
                </div>
            </div>

            <!-- Additional Info if Available -->
            @if ($pembayaran->peminjaman)
                <div class="info-card" style="margin-bottom: 30px;">
                    <div class="label">Detail Peminjaman</div>
                    <div class="value">
                        <strong>Kode:</strong> {{ $pembayaran->peminjaman->kode_peminjaman }}<br>
                        @if (isset($pembayaran->peminjaman->user))
                            <strong>Peminjam:</strong>
                            {{ $pembayaran->peminjaman->user->name ?? 'Tidak diketahui' }}<br>
                        @endif
                        @if (isset($pembayaran->peminjaman->tanggal_pinjam))
                            <strong>Tanggal Pinjam:</strong>
                            {{ $pembayaran->peminjaman->tanggal_pinjam->translatedFormat('d F Y') }}<br>
                        @endif
                    </div>
                </div>
            @endif

            <!-- QR Code Section -->
            <div class="qr-section">
                <div class="qr-code">
                    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(120)->generate($pembayaran->order_id)) !!}">
                </div>
                <p><strong>QR Code:</strong> {{ $pembayaran->order_id }}</p>
                <p><small>Scan QR code ini untuk verifikasi pembayaran</small></p>
            </div>

            <!-- Notes Section -->
            <div class="info-card">
                <div class="label">Catatan</div>
                <div class="value">
                    <ul style="margin: 10px 0; padding-left: 20px; font-size: 12px; color: #6c757d;">
                        <li>Bukti pembayaran ini adalah dokumen resmi</li>
                        <li>Simpan bukti ini sebagai arsip transaksi Anda</li>
                        <li>Untuk pertanyaan, hubungi customer service kami</li>
                        @if ($pembayaran->status == 'berhasil')
                            <li style="color: #28a745; font-weight: bold;">✅ Pembayaran telah berhasil diproses</li>
                        @elseif($pembayaran->status == 'menunggu')
                            <li style="color: #ffc107; font-weight: bold;">⏳ Menunggu konfirmasi pembayaran</li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        <div class="footer">
            <div class="left">
                <strong>Sistem Manajemen Pembayaran</strong><br>
                Dokumen ini digenerate secara otomatis
            </div>
            <div class="right">
                Halaman 1 dari 1<br>
                <small>{{ now()->translatedFormat('d F Y, H:i') }} WIB</small>
            </div>
        </div>
    </div>

    <!-- Print Button (Hidden on print) -->
    <div class="no-print" style="text-align: center; margin: 20px 0;">
        <button onclick="window.print()"
            style="
           background: #007bff;
           color: white;
           border: none;
           padding: 12px 24px;
           border-radius: 6px;
           font-size: 14px;
           cursor: pointer;
           font-weight: 500;
           box-shadow: 0 2px 4px rgba(0,0,0,0.1);
       ">
            🖨️ Print Dokumen
        </button>
        <button onclick="window.close()"
            style="
           background: #6c757d;
           color: white;
           border: none;
           padding: 12px 24px;
           border-radius: 6px;
           font-size: 14px;
           cursor: pointer;
           font-weight: 500;
           margin-left: 10px;
           box-shadow: 0 2px 4px rgba(0,0,0,0.1);
       ">
            ❌ Tutup
        </button>
    </div>

    <script>
        // Auto print when page loads (optional)
        // window.addEventListener('load', function() {
        //     setTimeout(() => window.print(), 500);
        // });

        // Print button functionality
        function printDocument() {
            window.print();
        }

        // Add print styles dynamically
        window.addEventListener('beforeprint', function() {
            document.body.style.background = 'white';
        });

        window.addEventListener('afterprint', function() {
            document.body.style.background = '#f8f9fa';
        });
    </script>
</body>

</html>
