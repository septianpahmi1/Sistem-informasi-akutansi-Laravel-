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
                            <h3 class="card-title">Buat Laporan</h3>
                        </div>
                        <!-- /.card-header -->
                        <form action="{{ route('reportDeviden.getdata') }}" method="get"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="dapur_id">Pilih Dapur
                                                <code>*</code></label>
                                            <select name="dapur_id" id="dapur_id" class="form-control select2bs4"
                                                style="width: 100%;" required>
                                                <option selected disabled>Pilih Dapur</option>
                                                @foreach ($dapur1 as $dapurs)
                                                    <option value="{{ $dapurs->id }}">
                                                        {{ $dapurs->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="start_date">Tanggal Mulai <code>*</code></label>
                                            <input type="date" name="start_date" id="start_date" class="form-control"
                                                required />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="end_date">Tanggal Selesai <code>*</code></label>
                                            <input type="date" name="end_date" id="end_date" class="form-control"
                                                required />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary float-right">Submit</button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@include('admin.layouts.footer')
