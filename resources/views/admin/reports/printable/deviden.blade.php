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
    @php
        function groupByName($items)
        {
            $grouped = [];
            foreach ($items as $item) {
                $name = $item['name'];
                if (!isset($grouped[$name])) {
                    $grouped[$name] = 0;
                }
                $grouped[$name] += $item['amount'];
            }
            return $grouped;
        }

        $revenuesGrouped = groupByName($revenues ?? []);
        $cogsGrouped = groupByName($cogs ?? []);
        $operationalGrouped = groupByName($operationalExpenses ?? []);
        $nonOpIncomeGrouped = groupByName($nonOperatingIncome ?? []);
        $nonOpExpenseGrouped = groupByName($nonOperatingExpenses ?? []);
    @endphp

    @php
        $totalRevenues = collect($revenues ?? [])->sum('amount');
        $totalCogs = collect($cogs ?? [])->sum('amount');
        $grossProfit = $totalRevenues - $totalCogs;
    @endphp

    {{-- Laba Operasional --}}
    @php
        $operatingIncome =
            $grossProfit - ($totalOperational ?? array_sum(array_column($operationalExpenses ?? [], 'amount')));
    @endphp
    {{-- Laba Bersih --}}
    @php
        $netProfit = ($operatingIncome ?? 0) + ($totalNonOp ?? 0);
        $profitDistribution = [];

        if (!empty($investors) && count($investors) > 0) {
            foreach ($investors as $inv) {
                $profitDistribution[] = [
                    'name' => $inv->name,
                    'percentage' => $inv->percentage,
                    'amount' => round($netProfit * ($inv->percentage / 100)),
                ];
            }
        }
    @endphp
    <div class="container-fluid">
        <div class="row report-header text-center">
            <div class="col-md-12">
                <table class="w-100">
                    <tr>
                        <td class="company-name" style="font-weight:bold;font-size:16px;text-align:center;">
                            {{ $companyName ?? 'PT. Ghaleb Palindo International' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="report-title" style="text-align:center;">
                            Pembagian Deviden
                        </td>
                    </tr>
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($periodStart)->format('d M Y') ?? '-' }} s/d
                            {{ \Carbon\Carbon::parse($periodEnd)->format('d M Y') ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Dapur : {{ $dapur->name }}</td>
                    </tr>
                    <tr>
                        <td style="float: left">LABA BERSIH : <strong class="{{ $netProfit < 0 ? 'negative' : '' }}">
                                {{ rp($netProfit) }}</strong></td>
                        <td style="float: right">Mata Uang : {{ $currency ?? 'Indonesian Rupiah' }}</td>
                    </tr>
                </table>

            </div>
        </div>

        {{-- Pembagian Laba Bersih ke Investor --}}
        @if (!empty($profitDistribution))
            <div class="row mt-2">
                <div class="col-12">
                    <div class="section-title">PEMBAGIAN LABA BERSIH</div>
                    <table class="table table-noborder table-striped">
                        <thead>
                            <tr>
                                <th>INVESTOR</th>
                                <th>PERSENTASE</th>
                                <th class="amount">JUMLAH</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($profitDistribution as $dist)
                                <tr>
                                    <td>{{ $dist['name'] }}</td>
                                    <td>{{ $dist['percentage'] }}%</td>
                                    <td class="amount">{{ rp($dist['amount']) }}</td>
                                </tr>
                            @endforeach
                            <tr class="subtotal">
                                <td colspan="2">TOTAL</td>
                                <td class="amount">{{ rp(array_sum(array_column($profitDistribution, 'amount'))) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>

    <script>
        window.addEventListener("load", function() {
            window.print();
        });
    </script>
</body>

</html>
