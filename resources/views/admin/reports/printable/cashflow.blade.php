{{-- resources/views/reports/profit_loss.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} | {{ config('app.name', 'Laravel') }}</title>
    <link href="/dist/img/logo.png" rel="icon">
    <link href="/dist/img/logo.png" rel="apple-touch-icon">

    {{-- Optional: gunakan AdminLTE / Bootstrap jika sudah ada --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <style>
        /* Print friendly */
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                -webkit-print-color-adjust: exact;
            }
        }

        body {
            font-family: "Source Sans Pro", Arial, sans-serif;
            font-size: 14px;
            color: #222;
        }

        .report-header {
            margin-bottom: 1rem;
            border-bottom: 2px solid #eee;
            padding-bottom: 0.5rem;
        }

        .company-name {
            font-weight: 700;
            font-size: 1.2rem;
        }

        .report-title {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .section-title {
            font-weight: 700;
            margin-top: 0.8rem;
            margin-bottom: 0.4rem;
        }

        .amount {
            text-align: right;
            white-space: nowrap;
        }

        .table-noborder thead th,
        .table-noborder tbody td {
            border: none;
            padding: 0.25rem .5rem;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, .02);
        }

        .subtotal {
            font-weight: 700;
            border-top: 1px dashed #ccc;
        }

        .negative {
            color: #c0392b;
        }

        .printed-info {
            font-size: 12px;
            color: #666;
            margin-top: 1rem;
        }
    </style>
</head>

<body>
    @php
        // Helper singkat untuk format rupiah — ganti dengan helper global jika ada
        function rp($value)
        {
            if ($value === null) {
                return '-';
            }
            $neg = $value < 0 ? '-' : '';
            $abs = abs((int) $value);
            return $neg . 'Rp ' . number_format($abs, 0, ',', '.');
        }

        // Contoh fallback variabel jika belum dikirim (bisa dihapus)
        // $companyName = $companyName ?? 'PT. Ghaleb Palindo International';
        // $periodStart = $periodStart ?? now()->startOfMonth()->format('d M Y');
        // $periodEnd = $periodEnd ?? now()->format('d M Y');

    @endphp

    <div class="container-fluid">
        <div class="row report-header text-center">
            <div class="col-md-12">
                <div class="report-title mb-4">KOPERASI CIPTA USAHA SENTOSA</div>
                <div class="report-title">Laporan Cashflow</div>
                <div>Dari {{ \Carbon\Carbon::parse($periodStart)->format('d M Y') }} s/d
                    {{ \Carbon\Carbon::parse($periodEnd)->format('d M Y') }}</div>
                <div class="float-right"> Mata Uang : {{ $currency ?? 'Indonesian Rupiah' }}
                </div>
            </div>
        </div>
        <div class="section-title">Cashflow dari Aktivitas Operasi</div>
        <table class="table table-noborder table-striped">
            <tbody>
                @foreach ($operatingActivities as $item)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td class="amount">{{ rp($item['amount']) }}</td>
                    </tr>
                @endforeach
                <tr class="subtotal">
                    <td>Net Cashflow Operasi</td>
                    <td class="amount">{{ rp($totalOperating) }}</td>
                </tr>
            </tbody>
        </table>

        {{-- Aktivitas Investasi --}}
        <div class="section-title">Cashflow dari Aktivitas Investasi</div>
        <table class="table table-noborder table-striped">
            <tbody>
                @foreach ($investingActivities as $item)
                    <tr>
                        <td>{{ $item['description'] }}</td>
                        <td class="amount">{{ rp($item['amount']) }}</td>
                    </tr>
                @endforeach
                <tr class="subtotal">
                    <td>Net Cashflow Investasi</td>
                    <td class="amount">{{ rp($totalInvesting) }}</td>
                </tr>
            </tbody>
        </table>

        {{-- Aktivitas Pendanaan --}}
        <div class="section-title">Cashflow dari Aktivitas Pendanaan</div>
        <table class="table table-noborder table-striped">
            <tbody>
                @foreach ($financingActivities as $item)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td class="amount">{{ rp($item['amount']) }}</td>
                    </tr>
                @endforeach
                <tr class="subtotal">
                    <td>Net Cashflow Pendanaan</td>
                    <td class="amount">{{ rp($totalFinancing) }}</td>
                </tr>
            </tbody>
        </table>

        {{-- Total Cashflow --}}
        <div class="section-title">Perubahan Kas Bersih</div>
        <table class="table table-noborder w-100">
            <tbody>
                <tr class="subtotal">
                    <td>Total Perubahan Kas Bersih</td>
                    <td class="amount">{{ rp($totalOperating + $totalInvesting + $totalFinancing) }}</td>
                </tr>
            </tbody>
        </table>
        <div class="mt-3 no-print">
            <button class="btn btn-primary" onclick="window.print()">Print</button>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>

    <script>
        window.addEventListener("load", function() {
            window.print();
        });
    </script>
</body>

</html>
