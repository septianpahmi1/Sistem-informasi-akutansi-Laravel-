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
                @if (Auth::user()->role == 'Admin')
                    <div class="col-sm-6">
                        <button class="btn btn-success float-sm-right" type="button" data-toggle="modal"
                            data-target="#dapur">Buat Dapur Baru</button>
                    </div>
                @endif
                @include('admin.dapur.create')
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
                                        <th>Nama Dapur</th>
                                        <th>Alamat</th>
                                        @if (Auth::user()->role == 'Admin')
                                            <th></th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ Str::limit($item->address, 30) }}</td>
                                            </td>
                                            @if (Auth::user()->role == 'Admin')
                                                <td>
                                                    <div class="btn-group btn-block">
                                                        <button type="button" class="btn btn-sm btn-warning"
                                                            data-toggle="modal" data-target="#dapur{{ $item->id }}">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button url="{{ route('dapur.delete', $item->id) }}"
                                                            type="button" class="btn btn-sm btn-danger delete"
                                                            data-id="{{ $item->id }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    @include('admin.dapur.update')
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
