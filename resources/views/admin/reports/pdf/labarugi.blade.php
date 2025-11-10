{{-- resources/views/reports/profit_loss_pdf.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'Laporan Laba/Rugi' }}</title>
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
            font-weight: 700;
            font-size: 18px;
        }

        .report-title {
            font-weight: 600;
            font-size: 16px;
            margin-top: 5px;
        }

        .section-title {
            font-weight: 700;
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
            font-weight: 700;
            border-top: 1px dashed #ccc;
        }

        .negative {
            color: #c0392b;
        }

        .printed-info {
            font-size: 11px;
            color: #666;
            margin-top: 10px;
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
        function groupByName($items)
        {
            $grouped = [];
            foreach ($items as $item) {
                $name = $item['name'];
                $grouped[$name] = ($grouped[$name] ?? 0) + $item['amount'];
            }
            return $grouped;
        }

        $revenuesGrouped = groupByName($revenues ?? []);
        $cogsGrouped = groupByName($cogs ?? []);
        $costGrouped = groupByName($cost ?? []);
        $operationalGrouped = groupByName($operationalExpenses ?? []);
        $nonOpIncomeGrouped = groupByName($nonOperatingIncome ?? []);
        $nonOpExpenseGrouped = groupByName($nonOperatingExpenses ?? []);

        $totalRevenues = array_sum($revenuesGrouped);
        $totalCogs = array_sum($cogsGrouped);
        $totalCost = array_sum($costGrouped);
        $grossProfit = $totalRevenues - $totalCogs - $totalCost;
        $operatingIncome = $grossProfit - array_sum($operationalGrouped);
        $totalNonOp = array_sum($nonOpIncomeGrouped) - array_sum($nonOpExpenseGrouped);
        $netProfit = $operatingIncome + $totalNonOp;
    @endphp

    <div class="container">
        <div class="report-header">
            <div class="company-name">{{ $companyName ?? 'PT. Ghaleb Palindo International' }}</div>
            <div class="report-title">Laba/Rugi (Standar)</div>
            <div>Dari {{ \Carbon\Carbon::parse($periodStart)->format('d M Y') ?? '-' }} s/d
                {{ \Carbon\Carbon::parse($periodEnd)->format('d M Y') ?? '-' }}</div>
            <div>Dapur: {{ $dapur->name ?? '-' }}</div>
            <div>Mata Uang: {{ $currency ?? 'IDR' }}</div>
        </div>

        {{-- Pendapatan --}}
        <div class="section-title">PENDAPATAN</div>
        <table class="table-noborder table-striped">
            <tbody>
                @foreach ($revenuesGrouped as $name => $amount)
                    <tr>
                        <td>{{ $name }}</td>
                        <td class="amount">{{ rp($amount) }}</td>
                    </tr>
                @endforeach
                <tr class="subtotal">
                    <td>Jumlah Pendapatan</td>
                    <td class="amount">{{ rp($totalRevenues) }}</td>
                </tr>
            </tbody>
        </table>

        {{-- Harga Pokok & Beban --}}
        <div class="section-title">HARGA POKOK & BEBAN</div>
        <table class="table-noborder table-striped">
            <tbody>
                <tr class="subtotal">
                    <td>Harga Pokok + COGS</td>
                    <td class="amount">{{ rp($totalCogs + $totalCost) }}</td>
                </tr>
                <tr class="subtotal">
                    <td>Beban Operasional</td>
                    <td class="amount">{{ rp(array_sum($operationalGrouped)) }}</td>
                </tr>
                <tr class="subtotal">
                    <td>Laba Kotor</td>
                    <td class="amount {{ $grossProfit < 0 ? 'negative' : '' }}">{{ rp($grossProfit) }}</td>
                </tr>
                <tr class="subtotal">
                    <td>Pendapatan Operasional</td>
                    <td class="amount {{ $operatingIncome < 0 ? 'negative' : '' }}">{{ rp($operatingIncome) }}</td>
                </tr>
                <tr class="subtotal">
                    <td>Pendapatan Non Operasional</td>
                    <td class="amount">{{ rp(array_sum($nonOpIncomeGrouped)) }}</td>
                </tr>
                <tr class="subtotal">
                    <td>Beban Non Operasional</td>
                    <td class="amount">{{ rp(array_sum($nonOpExpenseGrouped)) }}</td>
                </tr>
                <tr class="subtotal">
                    <td>Net Non Operasional</td>
                    <td class="amount {{ $totalNonOp < 0 ? 'negative' : '' }}">{{ rp($totalNonOp) }}</td>
                </tr>
                <tr class="subtotal">
                    <td><strong>LABA BERSIH</strong></td>
                    <td class="amount subtotal {{ $netProfit < 0 ? 'negative' : '' }}">
                        <strong>{{ rp($netProfit) }}</strong>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="printed-info">
            Dicetak pada: {{ now()->format('d M Y H:i') }}
        </div>
    </div>
</body>

</html>
