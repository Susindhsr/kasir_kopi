<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <title>Struk Transaksi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <style>
        /* Cetak */
        @media print {
            @page {
                size: 80mm auto;
                margin: 5mm;
            }
            body {
                font-family: monospace;
                font-size: 11px;
                color: #000;
                background: none;
                padding: 0;
                margin: 0;
            }
            .struk {
                width: 100%;
                max-width: 80mm;
                margin: 0 auto;
            }
            .text-center { text-align: center; }
            .text-right { text-align: right; }
            .divider {
                border-top: 1px dashed #000;
                margin: 6px 0;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 8px;
            }
            th, td {
                padding: 4px 6px;
                vertical-align: top;
            }
            .total-row td {
                border-top: 1px dashed #000;
                font-weight: bold;
                padding-top: 6px;
            }
        }

        /* Layar */
        @media screen {
            body {
                font-family: monospace;
                font-size: 14px;
                color: #000;
                background: #f9f9f9;
                padding: 10px;
            }
            .struk {
                width: 100%;
                max-width: 400px;
                margin: 0 auto;
                background: white;
                padding: 15px 20px;
                box-shadow: 0 0 8px rgba(0,0,0,0.1);
                border-radius: 5px;
            }
            .text-center { text-align: center; }
            .text-right { text-align: right; }
            .divider {
                border-top: 1px dashed #ccc;
                margin: 10px 0;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 12px;
            }
            th, td {
                padding: 6px 8px;
            }
            .total-row td {
                border-top: 1px dashed #999;
                font-weight: bold;
                padding-top: 10px;
            }

            @media (max-width: 400px) {
                body { padding: 5px; font-size: 12px; }
                .struk { padding: 10px 12px; max-width: 100%; }
                th, td { padding: 4px 6px; }
            }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="struk">
        <div class="text-center">
            <strong>Susinda</strong><br>
            Ngembul - Balerejo<br>
            081 228 757 864
        </div>

        <div class="divider"></div>

        @php
            $bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
            $tgl = $transaksi->created_at->day;
            $bln = $bulan[$transaksi->created_at->month - 1];
            $thn = $transaksi->created_at->year;
            $jam = $transaksi->created_at->format('H:i');

            $subtotalKopi = 0;
            $subtotalSelip = 0;

            foreach ($transaksi->details as $item) {
                $nama = strtolower(trim($item->produk->nama));
                if ($nama === 'kopi') {
                    $subtotalKopi += $item->subtotal;
                }
                if ($nama === 'selip') {
                    $subtotalSelip += $item->subtotal;
                }
            }

            if ($subtotalKopi > 0 && $subtotalSelip > 0) {
                $totalHitung = $subtotalKopi - $subtotalSelip;
                $labelTotal = 'Total (Kopi - Selip):';
            } elseif ($subtotalKopi > 0) {
                $totalHitung = $subtotalKopi;
                $labelTotal = 'Total (Kopi):';
            } elseif ($subtotalSelip > 0) {
                $totalHitung = $subtotalSelip;
                $labelTotal = 'Total (Selip):';
            } else {
                $totalHitung = 0;
                $labelTotal = 'Total:';
            }
        @endphp

        <div>
            <strong>Nama:</strong> {{ $transaksi->nama_pembeli ?? '-' }}<br>
            <strong>Tanggal:</strong> {{ $tgl }} {{ $bln }} {{ $thn }} - {{ $jam }} WIB
        </div>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item</th>
                    <th class="text-right">Harga</th>
                    <th class="text-right">Jml</th>
                    <th class="text-right">Sub</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaksi->details as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->produk->nama }}</td>
                        <td class="text-right">Rp {{ number_format($item->produk->harga ?? 0, 0, ',', '.') }}</td>
                        <td class="text-right">{{ $item->jumlah }} {{ $item->produk->satuan ?? '' }}</td>
                        <td class="text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach

                <tr class="total-row">
                    <td colspan="4" class="text-right">{{ $labelTotal }}</td>
                    <td class="text-right">Rp {{ number_format($totalHitung, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="divider"></div>

        <div class="text-center" style="margin-top: 10px;">
            ~ Terima kasih ~
        </div>
    </div>
</body>
</html>
