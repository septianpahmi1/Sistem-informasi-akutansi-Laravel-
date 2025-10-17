@include('admin.layouts.header')
@include('admin.layouts.navbar')
@include('admin.layouts.sidebar')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $title }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">{{ $title }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>



    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small card -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>Rp. {{ number_format($debitTotal, 0, ',', '.') }}</h3>
                            <p>Total Debit</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small card -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>Rp. {{ number_format($creditTotal, 0, ',', '.') }}</h3>

                            <p>Total Kredit</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small card -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>Rp. {{ number_format($salesTotal, 0, ',', '.') }}</h3>
                            <p>Total Penjualan</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-money-bill-wave-alt"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small card -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>Rp. {{ number_format($purchaseTotal, 0, ',', '.') }}</h3>
                            <p>Total Pembelian</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-md-12">
                    <!-- LINE CHART -->
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Chart</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <canvas id="lineChart"
                                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@include('admin.layouts.footer')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('lineChart').getContext('2d');

        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($months) !!},
                datasets: [{
                        label: 'Debit',
                        backgroundColor: 'rgba(60,141,188,0.9)',
                        data: {!! json_encode($debits) !!}
                    },
                    {
                        label: 'Kredit',
                        backgroundColor: 'rgba(210,214,222,1)',
                        data: {!! json_encode($credits) !!}
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,

                // ---- Untuk Chart.js v2 ----
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            // ✅ Format angka ke Rupiah di sumbu Y
                            callback: function(value, index, values) {
                                return 'Rp ' + value.toString().replace(
                                    /\B(?=(\d{3})+(?!\d))/g, ".");
                            }
                        }
                    }]
                },

                // ---- Untuk Chart.js v3+ ----
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                let value = context.parsed.y !== undefined ? context.parsed.y :
                                    context.yLabel;
                                if (label) label += ': ';
                                return label + 'Rp ' + value.toString().replace(
                                    /\B(?=(\d{3})+(?!\d))/g, ".");
                            }
                        }
                    },
                    legend: {
                        labels: {
                            font: {
                                size: 14
                            }
                        }
                    }
                }
            }
        });
    });
</script>
