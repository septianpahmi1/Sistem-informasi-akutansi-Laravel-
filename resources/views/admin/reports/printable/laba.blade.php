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
                <div class="company-name">{{ $companyName ?? 'PT. Ghaleb Palindo International' }}</div>
                <div class="mb-4">
                    {{ $companyAddress ?? 'Jln. Hanjawar - Pacet RT.003 RW.013 Desa Sukanagalih, Kec. Cipanas, Kabupaten Cianjur' }}
                </div>
                <div class="report-title">Laba/Rugi (Standar)</div>
                <div class="mb-4">
                    Dari {{ \Carbon\Carbon::parse($periodStart)->format('d M Y') ?? '-' }}
                    s/d {{ \Carbon\Carbon::parse($periodEnd)->format('d M Y') ?? '-' }}
                </div>
                <div> Dapur : </div>
                <div class="report-title">{{ $dapur->name }}</div>
                <div class="float-right"> Mata Uang : {{ $currency ?? 'Indonesian Rupiah' }}
                </div>
            </div>
        </div>
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
            $costGrouped = groupByName($cost ?? []);
        @endphp

        {{-- Pendapatan --}}
        <div class="row">
            <div class="col-12">
                <div class="section-title">PENDAPATAN</div>
                <table class="table table-noborder table-striped w-100">
                    <tbody>
                        @foreach ($revenuesGrouped as $name => $amount)
                            <tr>
                                <td>{{ $name }}</td>
                                <td class="amount">{{ rp($amount) }}</td>
                            </tr>
                        @endforeach
                        <tr class="subtotal">
                            <td>Jumlah Pendapatan</td>
                            <td class="amount">{{ rp(array_sum($revenuesGrouped)) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Beban Pokok Penjualan --}}
        <div class="row">
            <div class="col-12">
                <div class="section-title">HARGA POKOK PENJUALAN</div>
                <table class="table table-noborder table-striped w-100">
                    <tbody>
                        <tr class="subtotal">
                            <td>Jumlah Harga Pokok Penjualan</td>
                            <td class="amount">{{ rp(array_sum($costGrouped)) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="section-title">BEBAN POKOK PENJUALAN</div>
                <table class="table table-noborder table-striped w-100">
                    <tbody>
                        <tr class="subtotal">
                            <td>Jumlah Beban Pokok Penjualan</td>
                            <td class="amount">{{ rp(array_sum($cogsGrouped)) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Laba Kotor --}}
        @php
            $totalRevenues = collect($revenues ?? [])->sum('amount');
            $totalCogs = collect($cogs ?? [])->sum('amount');
            $totalCost = collect($cost ?? [])->sum('amount');
            $grossProfit = $totalRevenues - $totalCogs - $totalCost;
        @endphp

        <div class="row">
            <div class="col-12">
                <table class="table table-noborder w-100">
                    <tbody>
                        <tr>
                            <td class="section-title">LABA KOTOR</td>
                            <td class="amount section-title">{{ rp($grossProfit) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Beban Operasional --}}
        <div class="row">
            <div class="col-12">
                <div class="section-title">BEBAN OPERASIONAL</div>
                <table class="table table-noborder table-striped w-100">
                    <tbody>
                        @foreach ($operationalGrouped as $name => $oprational)
                            <tr>
                                <td>{{ $name }}</td>
                                <td class="amount">{{ rp($oprational) }}</td>
                            </tr>
                        @endforeach

                        <tr class="subtotal">
                            <td>Jumlah Beban Operasional</td>
                            <td class="amount">
                                {{ rp(array_sum($operationalGrouped)) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Laba Operasional --}}
        @php
            $operatingIncome =
                $grossProfit - ($totalOperational ?? array_sum(array_column($operationalExpenses ?? [], 'amount')));
        @endphp
        <div class="row">
            <div class="col-12">
                <table class="table table-noborder w-100">
                    <tbody>
                        <tr>
                            <td class="section-title">PENDAPATAN OPERASIONAL</td>
                            <td class="amount section-title">{{ rp($operatingIncome) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pendapatan & Beban Non Operasional --}}
        <div class="row">
            <div class="col-12">
                <div class="section-title">PENDAPATAN DAN BEBAN NON OPERASIONAL</div>
                <table class="table table-noborder table-striped w-100">
                    <tbody>
                        {{-- Non-operating income --}}
                        @foreach ($nonOperatingIncome as $item)
                            <tr>
                                <td>{{ $item['name'] }}</td>
                                <td class="amount">{{ rp($item['amount']) }}</td>
                            </tr>
                        @endforeach
                        <tr class="subtotal">
                            <td>Jumlah Pendapatan Non Operasional</td>
                            <td class="amount">
                                {{ rp($totalNonOperatingIncome ?? array_sum(array_column($nonOperatingIncome ?? [], 'amount'))) }}
                            </td>
                        </tr>

                        {{-- Non-operating expense --}}
                        @foreach ($nonOpExpenseGrouped as $name => $amount)
                            <tr>
                                <td>{{ $name }}</td>
                                <td class="amount">{{ rp($amount) }}</td>
                            </tr>
                        @endforeach
                        <tr class="subtotal">
                            <td>Jumlah Beban Non Operasional</td>
                            <td class="amount">
                                {{ rp(array_sum($nonOpExpenseGrouped)) }}
                            </td>
                        </tr>

                        {{-- Total non-operational --}}
                        @php
                            $totalNonOp =
                                ($totalNonOperatingIncome ??
                                    array_sum(array_column($nonOperatingIncome ?? [], 'amount'))) -
                                ($totalNonOperatingExpenses ??
                                    array_sum(array_column($nonOperatingExpenses ?? [], 'amount')));
                        @endphp
                        <tr class="subtotal">
                            <td>Jumlah Pendapatan dan Beban Non Operasional</td>
                            <td class="amount {{ $totalNonOp < 0 ? 'negative' : '' }}">{{ rp($totalNonOp) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

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
        <div class="row">
            <div class="col-12">
                <table class="table table-noborder w-100">
                    <tbody>
                        <tr class="subtotal">
                            <td>LABA BERSIH</td>
                            <td class="amount subtotal {{ $netProfit < 0 ? 'negative' : '' }}">{{ rp($netProfit) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        {{-- Pembagian Laba Bersih ke Investor --}}
        {{-- @if (!empty($profitDistribution))
            <div class="row mt-2">
                <div class="col-12">
                    <div class="section-title">Pembagian Laba Bersih ke Investor</div>
                    <table class="table table-noborder table-striped">
                        <thead>
                            <tr>
                                <th>Investor</th>
                                <th>Persentase</th>
                                <th class="amount">Jumlah</th>
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
                                <td colspan="2">Total</td>
                                <td class="amount">{{ rp(array_sum(array_column($profitDistribution, 'amount'))) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endif --}}

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
