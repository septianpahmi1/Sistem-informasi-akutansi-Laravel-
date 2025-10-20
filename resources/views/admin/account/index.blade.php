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
                    <button class="btn btn-success float-sm-right" type="button" data-toggle="modal"
                        data-target="#account">Buat Akun Baru</button>
                </div>
                @extends('admin.account.create')
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
                            <form id="filter-form" class="form-inline float-right">
                                <div class="input-group input-group-sm">
                                    <input type="date" name="start_date" id="start_date" class="form-control"
                                        value="{{ request('start_date', date('Y-m-d')) }}">
                                    <span class="mx-1">s/d</span>
                                    <input type="date" name="end_date" id="end_date" class="form-control"
                                        value="{{ request('end_date', date('Y-m-d')) }}">
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
                            <table id="example5" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Kode</th>
                                        <th>Akun</th>
                                        <th>Debit</th>
                                        <th>Credit</th>
                                        <th>Saldo Awal</th>
                                        <th>Total</th>
                                        @if(Auth::user()->role == 'Admin')
                                        <th>Aksi</th>
                                        @endif
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @foreach ($data as $item)
                                        @php
                                            $entries = $item->journalEntries;
                                            $totalDebit = $entries->where('type', 'debit')->sum('total');
                                            $totalKredit = $entries->where('type', 'credit')->sum('total');

                                            $total = $totalDebit - $totalKredit;
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->code }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>Rp. {{ number_format($totalDebit, 0, ',', '.') }}</td>
                                            <td>Rp. {{ number_format($totalKredit, 0, ',', '.') }}</td>
                                            <td>Rp. {{ number_format($item->opening_balance, 0, ',', '.') }}</td>
                                            <td>Rp. {{ number_format($total, 0, ',', '.') }}</td>
                                            @if(Auth::user()->role == 'Admin')
                                            <td>
                                                <div class="btn-group btn-block">
                                                    <button type="button" class="btn btn-sm btn-warning"
                                                        data-toggle="modal" data-target="#account{{ $item->id }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button url="{{ route('account.delete', $item->id) }}"
                                                        type="button" class="btn btn-sm btn-danger delete"
                                                        data-id="{{ $item->id }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    @extends('admin.account.update')
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
