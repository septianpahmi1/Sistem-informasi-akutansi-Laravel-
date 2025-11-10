{{-- resources/views/reports/cashflow_pdf.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'Laporan Arus Kas' }}</title>
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
    @endphp

    <div class="container">
        {{-- Header --}}
        <div class="report-header">
            <div class="company-name">KOPERASI CIPTA USAHA SENTOSA</div>
            <div class="report-title">Arus Kas</div>
            <div>{{ \Carbon\Carbon::parse($periodStart)->format('d M Y') ?? '-' }} s/d
                {{ \Carbon\Carbon::parse($periodEnd)->format('d M Y') ?? '-' }}</div>
            <div>Dapur: {{ $dapur->name ?? '-' }}</div>
            <div style="text-align:right;">Mata Uang: Indonesian Rupiah</div>
        </div>

        {{-- Aktivitas Operasi --}}
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
        <table class="table table-noborder">
            <tbody>
                <tr class="subtotal">
                    <td>Total Perubahan Kas Bersih</td>
                    <td class="amount">{{ rp($totalOperating + $totalInvesting + $totalFinancing) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
