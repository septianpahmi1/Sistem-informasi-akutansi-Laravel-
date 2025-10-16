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
                    <a href="{{ route('sales.create') }}" class="btn btn-success float-sm-right" type="button">Buat
                        Faktur Penjualan</a>
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
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Number</th>
                                        <th>Customer</th>
                                        <th>Keterangan</th>
                                        <th>Tanggal</th>
                                        <th>Harga</th>
                                        <th>Qty</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $item->invoice_number }}</td>
                                            <td>{{ $item->customer->name }}</td>
                                            <td>{{ $item->ket }}</td>
                                            <td>{{ Carbon\Carbon::parse($item->date)->format('d/m/Y') }}</td>
                                            <td>Rp. {{ number_format($item->price, 0, ',', '.') }}</td>
                                            <td>{{ $item->qty }} {{ $item->unit }}</td>
                                            <td>Rp. {{ number_format($item->total, 0, ',', '.') }}</td>
                                            <td>
                                                @if ($item->status == 'draft')
                                                    <button class="btn btn-outline-warning btn-sm btn-block"
                                                        readonly>Draft</button>
                                                @elseif($item->status == 'paid')
                                                    <button class="btn btn-outline-success btn-sm btn-block"
                                                        readonly>Paid</button>
                                                @elseif($item->status == 'overdue')
                                                    <button class="btn btn-outline-danger btn-sm btn-block"
                                                        readonly>Over
                                                        Due</button>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group btn-block">
                                                    <a href="{{ route('sales.invoice', $item->id) }}" target="_blank"
                                                        type="button" class="btn btn-sm btn-success">
                                                        <i class="fas fa-file-pdf"></i>
                                                    </a>
                                                    <a href="{{ route('sales.update', $item->id) }}" type="button"
                                                        class="btn btn-sm btn-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button url="{{ route('sales.delete', $item->id) }}" type="button"
                                                        class="btn btn-sm btn-danger delete"
                                                        data-id="{{ $item->id }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
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
