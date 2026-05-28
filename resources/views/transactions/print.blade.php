<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota_{{ $transaction->invoice_number }}</title>
    <style>
        /* Pengaturan ukuran kertas nota (gaya thermal/struk ringan) */
        body {
            font-family: 'Courier New', Courier, monospace; /* Font kasir klasik, rapi untuk angka */
            font-size: 14px;
            color: #333;
            line-height: 1.4;
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }

        .divider {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 5px 0;
            font-size: 13px;
        }

        .badge {
            display: inline-block;
            padding: 2px 6px;
            font-size: 12px;
            font-weight: bold;
            border: 1px solid #000;
        }

        /* Menghilangkan header-footer bawaan browser saat dicetak */
        @media print {
            body { margin: 0; padding: 10px; width: 100%; }
            @page { margin: 0; }
        }
    </style>
</head>
<body>

    <div class="text-center">
        <h2 style="margin: 0 0 5px 0; font-family: sans-serif;">KlinWash Laundry</h2>
        <p style="margin: 0; font-size: 12px;">Jl. Raya Ciamis No. 123, Ciamis</p>
        <p style="margin: 0; font-size: 12px;">Telp: 0812-3456-7890</p>
    </div>

    <div class="divider"></div>

    <table style="font-size: 13px;">
        <tr>
            <td>No. Nota</td>
            <td>: {{ $transaction->invoice_number }}</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>: {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td>Pelanggan</td>
            <td>: {{ $transaction->customer->customer_name }}</td>
        </tr>
        <tr>
            <td>No. Telp</td>
            <td>: {{ $transaction->customer->customer_phone ?? '-' }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    <table>
        <thead>
            <tr style="border-bottom: 1px dashed #000;">
                <th align="left">Layanan</th>
                <th align="center">Qty</th>
                <th align="right">Harga</th>
                <th align="right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($details as $detail)
                <tr>
                    <td>{{ $detail->service_name }}</td>
                    <td align="center">{{ $detail->quantity }} {{ $detail->unit }}</td>
                    <td align="right">{{ number_format($detail->price, 0, ',', '.') }}</td>
                    <td align="right">{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="divider"></div>

    <table class="font-bold">
        <tr>
            <td>TOTAL TAGIHAN</td>
            <td class="text-right">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>STATUS</td>
            <td class="text-right">
                <span class="badge">
                    {{ $transaction->payment_status === 'paid' ? 'LUNAS' : 'BELUM LUNAS' }}
                </span>
            </td>
        </tr>
    </table>

    <div class="divider" style="margin-top: 20px;"></div>

    <div class="text-center" style="font-size: 11px; margin-top: 10px;">
        <p style="margin: 0 0 5px 0;">Terima kasih atas kepercayaan Anda!</p>
        <p style="margin: 0; color: #555;">* Kain luntur/susut di luar tanggung jawab kami</p>
        <p style="margin: 0; color: #555;">* Nota ini harap dibawa saat pengambilan baju</p>
    </div>

    <script>
        window.print();

        // Opsional: Otomatis menutup tab setelah dialog cetak selesai/dicancel oleh kasir
        window.onafterprint = function() {
            window.close();
        }
    </script>

</body>
</html>
