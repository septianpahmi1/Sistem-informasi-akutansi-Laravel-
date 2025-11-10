{{-- resources/views/reports/profit_loss_pdf.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'Pembagian Deviden' }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
            color: #222;
        }

        .container {
            width: 100%;
            padding: 10px;
        }

        .report-header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px solid #eee;
            padding-bottom: 5px;
        }

        .company-name {
            font-weight: bold;
            font-size: 16px;
        }

        .report-title {
            font-weight: 600;
            font-size: 14px;
            margin-top: 5px;
        }

        .section-title {
            font-weight: bold;
            margin-top: 15px;
            margin-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 5px 8px;
        }

        .table-noborder td,
        .table-noborder th {
            border: none;
        }

        .table-striped tr:nth-child(odd) {
            background-color: #f8f9fa;
        }

        .amount {
            text-align: right;
        }

        .subtotal {
            font-weight: bold;
            border-top: 1px dashed #ccc;
        }

        .negative {
            color: #c0392b;
        }
    </style>
</head>

<body>
    @php
        function rp($value)
        {
            if ($value === null) {
                return '-';
            }
            $neg = $value < 0 ? '-' : '';
            $abs = abs((int) $value);
            return $neg . 'Rp ' . number_format($abs, 0, ',', '.');
        }

        $totalRevenues = collect($revenues ?? [])->sum('amount');
        $totalCogs = collect($cogs ?? [])->sum('amount');
        $grossProfit = $totalRevenues - $totalCogs;
        $operatingIncome =
            $grossProfit - ($totalOperational ?? array_sum(array_column($operationalExpenses ?? [], 'amount')));
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

    <div class="container">
        <div class="report-header">
            <div class="company-name">{{ $companyName ?? 'PT. Ghaleb Palindo International' }}</div>
            <div class="report-title">Pembagian Deviden</div>
            <div>Dari {{ \Carbon\Carbon::parse($periodStart)->format('d M Y') ?? '-' }} s/d
                {{ \Carbon\Carbon::parse($periodEnd)->format('d M Y') ?? '-' }}</div>
            <div>Dapur: {{ $dapur->name ?? '-' }}</div>
            <div>
                <table class="table-noborder" style="width:100%;">
                    <tr>
                        <td style="text-align:left;">LABA BERSIH : <strong
                                class="{{ $netProfit < 0 ? 'negative' : '' }}">{{ rp($netProfit) }}</strong></td>
                        <td style="text-align:right;">Mata Uang : {{ $currency ?? 'Indonesian Rupiah' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        @if (!empty($profitDistribution))
            <div class="section-title">PEMBAGIAN LABA BERSIH</div>
            <table class="table table-striped">
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
                        <td class="amount">{{ rp(array_sum(array_column($profitDistribution, 'amount'))) }}</td>
                    </tr>
                </tbody>
            </table>
        @endif
    </div>
</body>

</html>
