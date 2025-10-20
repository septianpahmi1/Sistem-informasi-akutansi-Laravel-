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
                @if(Auth::user()->role == 'Admin')
                <div class="col-sm-6">
                    <a href="{{ route('inventory.create') }}" class="btn btn-success float-sm-right" type="button">Buat
                        Persediaan Baru</a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">DataTable {{ $title }}</h3>
                            <form id="filter-inventory" class="form-inline float-right">
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
                                <thead class="text-center">
                                    <tr>
                                        <th rowspan="2">Tgl</th>
                                        <th rowspan="2">Kode Brg</th>
                                        <th rowspan="2">Nama Barang</th>
                                        <th colspan="3">Masuk</th>
                                        <th colspan="3">Keluar</th>
                                        <th colspan="3">Saldo Akhir</th>
                                        @if(Auth::user()->role == 'Admin')
                                        <th rowspan="2">Aksi</th>
                                        @endif
                                    </tr>
                                    <tr>
                                        {{-- Masuk --}}
                                        <th>Qty</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        {{-- Keluar --}}
                                        <th>Qty</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        {{-- Saldo --}}
                                        <th>Qty</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @include('admin.inventory._table', ['data' => $data])
                                    @include('admin.inventory.supply_out')
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
