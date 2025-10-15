<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .header p {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .summary-table {
            margin-bottom: 20px;
            width: 50%;
        }

        .summary-table td {
            border: none;
            padding: 5px;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #888;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Laporan Penjualan</h1>
        <p><strong>eyetails.co</strong></p>
        <p>Periode: {{ $startDate->format('d F Y') }} - {{ $endDate->format('d F Y') }}</p>
    </div>

    <h3>Ringkasan</h3>
    <table class="summary-table">
        <tr>
            <td>Total Pendapatan:</td>
            <td class="text-right"><strong>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</strong></td>
        </tr>
        <tr>
            <td>Total Pesanan Selesai:</td>
            <td class="text-right"><strong>{{ $totalOrders }}</strong></td>
        </tr>
        <tr>
            <td>Total Item Terjual:</td>
            <td class="text-right"><strong>{{ $totalItemsSold }}</strong></td>
        </tr>
    </table>

    <h3>Detail Transaksi</h3>
    <table>
        <thead>
            <tr>
                <th>ID Pesanan</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Metode Pembayaran</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
            <tr>
                <td>#{{ $order->id }}</td>
                <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                <td>{{ $order->customer_name }}</td>
                <td>{{ $order->payment_method }}</td>
                <td class="text-right">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center;">Tidak ada data transaksi pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->format('d F Y, H:i') }}
    </div>
</body>

</html>