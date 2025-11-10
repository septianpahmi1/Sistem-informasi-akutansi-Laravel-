@include('admin.layouts.header')
@include('admin.layouts.navbar')
@include('admin.layouts.sidebar')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $title }}</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">{{ $title }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Pilih Metode Export</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                @if (!empty($revenues) || !empty($cogs) || !empty($operationalExpenses))
                                    <a href="{{ route('reportDeviden.pdf', [
                                        'dapur_id' => $dapur->id,
                                        'start_date' => $periodStart->toDateString(),
                                        'end_date' => $periodEnd->toDateString(),
                                    ]) }}"
                                        class="btn btn-danger btn-sm mx-1">
                                        <i class="fas fa-file-pdf"></i> Download PDF
                                    </a>

                                    <a href="{{ route('reportDeviden.xls', [
                                        'dapur_id' => $dapur->id,
                                        'start_date' => $periodStart->toDateString(),
                                        'end_date' => $periodEnd->toDateString(),
                                    ]) }}"
                                        class="btn btn-success btn-sm mx-1">
                                        <i class="fas fa-file-excel"></i> Download Excel
                                    </a>

                                    <a href="{{ route('reportDeviden.print', [
                                        'dapur_id' => $dapur->id,
                                        'start_date' => $periodStart->toDateString(),
                                        'end_date' => $periodEnd->toDateString(),
                                    ]) }}"
                                        class="btn btn-primary btn-sm mx-1" target="_blank">
                                        <i class="fas fa-print"></i> Print
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@include('admin.layouts.footer')
