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
                    <a href="{{ route('journal.create') }}" class="btn btn-success float-sm-right" type="button">Buat
                        Journal Baru</a>
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
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Number</th>
                                        <th>Ket</th>
                                        <th>Tanggal</th>
                                        @if(Auth::user()->role == 'Admin')
                                        <th></th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $journal)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $journal->invoice_number }}</td>
                                            <td>{{ $journal->description }}</td>
                                            <td>{{ \Carbon\Carbon::parse($journal->date)->format('d/m/Y') }}
                                            </td>
                                            @if(Auth::user()->role == 'Admin')
                                            <td>
                                                <div class="btn-group btn-block">
                                                    <a href="{{ route('journal.detail', $journal->id) }}" type="button"
                                                        class="btn btn-sm btn-secondary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('journal.update', $journal->id) }}"
                                                        type="button" class="btn btn-sm btn-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button url="{{ route('journal.delete', $journal->id) }}"
                                                        type="button" class="btn btn-sm btn-danger delete"
                                                        data-id="{{ $journal->id }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            @endif
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
