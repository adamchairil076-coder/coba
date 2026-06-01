<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Donasi</title>

    <style>
        body{
            font-family: sans-serif;
            font-size: 12px;
        }

        h2{
            text-align: center;
            margin-bottom: 5px;
        }

        .info{
            margin-bottom: 20px;
        }

        table{
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td{
            border: 1px solid #000;
            padding: 8px;
            font-size: 11px;
        }

        table th{
            background: #f2f2f2;
        }

        .text-center{
            text-align: center;
        }

        .summary{
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <h2>Laporan Donasi RUHAMA</h2>

    <div class="info">
        <strong>Total Transaksi:</strong>
        {{ $totalTransaction }}
        <br>

        <strong>Total Dana:</strong>
        Rp {{ number_format($totalDonation, 0, ',', '.') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Donatur</th>
                <th>Program</th>
                <th>Metode</th>
                <th>Status</th>
                <th>Nominal</th>
                <th>Tanggal</th>
            </tr>
        </thead>

        <tbody>

            @forelse($donations as $donation)

                <tr>

                    <td class="text-center">
                        {{ $loop->iteration }}
                    </td>

                    <td>
                        {{ $donation->name }}
                    </td>

                    <td>
                        {{ $donation->campaign->title ?? '-' }}
                    </td>

                    <td>
                        {{ $donation->payment_method ?? '-' }}
                    </td>

                    <td>
                        {{ ucfirst($donation->status ?? '-') }}
                    </td>

                    <td>
                        Rp {{ number_format($donation->amount, 0, ',', '.') }}
                    </td>

                    <td>
                        {{ $donation->created_at ? $donation->created_at->format('d M Y') : '-' }}
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="7" class="text-center">
                        Tidak ada data laporan.
                    </td>
                </tr>

            @endforelse

        </tbody>
    </table>

</body>
</html>