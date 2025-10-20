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
                <div class="col-sm-6">
                    <a href="{{ route('inventory.create') }}" class="btn btn-success float-sm-right" type="button">Buat
                        Persediaan Baru</a>
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
                            <h3 class="card-title">DataTable {{ $title }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @php
                                if (!function_exists('rupiah')) {
                                    function rupiah($angka)
                                    {
                                        return 'Rp ' . number_format($angka ?? 0, 0, ',', '.');
                                    }
                                }
                            @endphp
                            <table id="example1" class="table table-bordered table-striped">
                                <thead class="text-center">
                                    <tr>
                                        <th rowspan="2">Tgl</th>
                                        <th rowspan="2">Kode Brg</th>
                                        <th rowspan="2">Nama Barang</th>
                                        <th colspan="3">Masuk</th>
                                        <th colspan="3">Keluar</th>
                                        <th colspan="3">Saldo Akhir</th>
                                        <th rowspan="2">Aksi</th>
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
                                    @foreach ($data as $item)
                                        @php
                                            $totalInQty = $item->stockIn->sum('qty');
                                            $totalInPrice = $item->stockIn->avg('price');
                                            $totalInTotal = $item->stockIn->sum('total');

                                            $totalOutQty = $item->stockOut->sum('qty');
                                            $totalOutPrice = $item->stockOut->avg('price');
                                            $totalOutTotal = $item->stockOut->sum('total');

                                            $saldoQty = $totalInQty - $totalOutQty;
                                            $saldoHarga = $saldoQty > 0 ? $totalInPrice : 0;
                                            $saldoTotal = $saldoQty * $saldoHarga;
                                        @endphp

                                        <tr class="text-center">
                                            <td>{{ Carbon\Carbon::parse($item->date)->format('d/m/y') }}</td>
                                            <td>{{ $item->code }}</td>
                                            <td>{{ $item->name }}</td>

                                            <td>{{ $totalInQty }}</td>
                                            <td>{{ rupiah($totalInPrice) }}</td>
                                            <td>{{ rupiah($totalInTotal) }}</td>

                                            <td>{{ $totalOutQty }}</td>
                                            <td>{{ rupiah($totalOutPrice) }}</td>
                                            <td>{{ rupiah($totalOutTotal) }}</td>

                                            <td>{{ $saldoQty }}</td>
                                            <td>{{ rupiah($saldoHarga) }}</td>
                                            <td>{{ rupiah($saldoTotal) }}</td>

                                            <td>
                                                <div class="btn-group btn-block">
                                                    <button type="button" class="btn btn-sm btn-success"
                                                        data-toggle="modal"
                                                        data-target="#inventory{{ $item->id }}">
                                                        <i class="fas fa-door-open"></i>
                                                    </button>
                                                    <a href="{{ route('inventory.update', $item->id) }}" type="button"
                                                        class="btn btn-sm btn-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button url="{{ route('inventory.delete', $item->id) }}"
                                                        type="button" class="btn btn-sm btn-danger delete"
                                                        data-id="{{ $item->id }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
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
