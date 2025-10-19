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
                <div class="col-lg-6 col-6">
                    <!-- small card -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>Rp. {{ number_format($debitTotal, 0, ',', '.') }}</h3>
                            <p>Total Debit</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-money-check-alt"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-6 col-6">
                    <!-- small card -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>Rp. {{ number_format($creditTotal, 0, ',', '.') }}</h3>
                            <p>Total Kredit</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-money-check"></i>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">DataTable {{ $title }}</h3>
                            <form id="filter-journal" class="form-inline float-right">
                                <div class="input-group input-group-sm">
                                    <input type="date" name="start_date" id="start_date" class="form-control"
                                        value="{{ request('start_date', now()->startOfMonth()->toDateString()) }}">
                                    <span class="mx-1">s/d</span>
                                    <input type="date" name="end_date" id="end_date" class="form-control"
                                        value="{{ request('end_date', now()->endOfMonth()->toDateString()) }}">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fas fa-search"></i> Tampilkan
                                        </button>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="entries1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Number</th>
                                        <th>Ket</th>
                                        <th>Tanggal</th>
                                        <th>Akun</th>
                                        <th>Debit</th>
                                        <th>Kredit</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @include('admin.journal.entries._table')
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@include('admin.layouts.footer')
