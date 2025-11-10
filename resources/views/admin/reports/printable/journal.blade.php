<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ $title }} | {{ config('app.name', 'Laravel') }}</title>
    <link href="/dist/img/logo.png" rel="icon">
    <link href="/dist/img/logo.png" rel="apple-touch-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        @media print {
            .no-print {
                display: none;
            }
        }

        body {
            font-size: 14px;
        }

        .report-title {
            font-weight: bold;
            font-size: 18px;
        }

        .table th,
        .table td {
            padding: 6px;
            vertical-align: middle;
        }

        .amount {
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row report-header text-center mb-4">
            <div class="col-md-12">
                <div class="report-title mb-4">KOPERASI CIPTA USAHA SENTOSA</div>

                <div class="report-title">Journal Umum</div>
                <div>
                    Dari {{ \Carbon\Carbon::parse($start)->format('d M Y') ?? '-' }}
                    s/d {{ \Carbon\Carbon::parse($end)->format('d M Y') ?? '-' }}
                </div>
            </div>
        </div>

        <table class="table">
            <thead class="thead-light">
                <tr>
                    <th>Tanggal</th>
                    <th>Akun</th>
                    <th>Tipe</th>
                    <th class="amount">Nilai</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalDebit = 0;
                    $totalCredit = 0;
                @endphp
                @foreach ($journals as $row)
                    @foreach ($row->entries as $entry)
                        @php
                            if ($entry->type == 'debit') {
                                $totalDebit += $entry->total;
                            } else {
                                $totalCredit += $entry->total;
                            }
                        @endphp
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($row->date)->format('d M Y') }}</td>
                            <td>{{ $entry->account->name }}</td>
                            <td>{{ ucfirst($entry->type) }}</td>
                            <td class="amount">Rp {{ number_format($entry->total, 0, ',', '.') }}</td>
                            <td>{{ $row->description }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-right">Total Debit:</th>
                    <th class="amount">Rp {{ number_format($totalDebit, 0, ',', '.') }}</th>
                    <th></th>
                </tr>
                <tr>
                    <th colspan="3" class="text-right">Total Credit:</th>
                    <th class="amount">Rp {{ number_format($totalCredit, 0, ',', '.') }}</th>
                    <th></th>
                </tr>
                <tr>
                    <th colspan="3" class="text-right">Saldo Keseluruhan:</th>
                    <th class="amount">Rp {{ number_format($totalDebit - $totalCredit, 0, ',', '.') }}</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>

    </div>
    <script>
        window.addEventListener("load", function() {
            window.print();
        });
    </script>
</body>

</html>
