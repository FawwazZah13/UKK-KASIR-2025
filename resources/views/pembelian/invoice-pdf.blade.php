<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bukti Penjualan</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            padding: 20px;
        }

        h2, h4 {
            margin: 0;
        }

        .info {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 8px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .summary td {
            border: none;
            padding: 4px 0;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
        }

        .right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }
    </style>
</head>
<body>

    <h2>Fawwaz Mart</h2>
    <div class="info">
        Member Status: {{ ucfirst($pembelian->customer->status_customer) }}<br>
        No. HP : {{ $pembelian->customer->no_tlp }}<br>
        Bergabung Sejak : {{ \Carbon\Carbon::parse($pembelian->customer->created_at)->format('d F Y') }}<br>
        Poin Member : {{ $pembelian->poin }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Sub Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pembelian->details as $detail)
                <tr>
                    <td>{{ $detail->produk->nama_produk }}</td>
                    <td>{{ $detail->qty }}</td>
                    <td>Rp. {{ number_format($detail->produk->harga) }}</td>
                    <td>Rp. {{ number_format($detail->sub_total) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="summary">
        <tr>
            <td class="bold">Total Harga</td>
            <td class="right">Rp. {{ number_format(( $pembelian->total_harga + $pembelian->total_kembalian)) }}</td>
        </tr>
        <tr>
            <td class="bold">Harga Setelah Poin</td>
            <td class="right">Rp. {{ number_format($pembelian->total_harga) }}</td>
        </tr>
        <tr>
            <td class="bold">Total Kembalian</td>
            <td class="right">Rp. {{ number_format($pembelian->total_kembalian) }}</td>
        </tr>
    </table>

    <p>{{ \Carbon\Carbon::parse($pembelian->created_at)->toISOString() }} | {{ $pembelian->user->name }}</p>

    <div class="footer">
        <strong>Terima kasih atas pembelian Anda!</strong>
    </div>
</body>
</html>
