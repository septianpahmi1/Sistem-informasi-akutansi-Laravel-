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
                        <li class="breadcrumb-item"><a href="{{ route('sales') }}">Faktur Penjualan</a></li>
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
                            <h3 class="card-title">Faktur Penjualan</h3>
                        </div>
                        <!-- /.card-header -->
                        <form action="{{ route('sales.post') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="customer_id">Pelanggan/ Customer <code>*</code></label>
                                            <select name="customer_id" id="customer_id" class="form-control select2bs4"
                                                style="width: 100%;" required>
                                                <option selected disabled>Pilih Pelanggan/ Customer</option>
                                                @foreach ($data as $customer)
                                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="ket">Keterangan <code>*</code></label>
                                            <input type="text" name="ket" maxlength="150" id="ket"
                                                class="form-control" required />
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">Detail Penjualan</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="price">Harga <code>*</code></label>
                                                            <input type="text" name="price" id="price"
                                                                class="form-control rupiah" required />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="number">Jumlah</label>
                                                            <input type="text" name="qty" maxlength="3"
                                                                max="999" id="number" class="form-control"
                                                                required />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="total">Total <code>*</code></label>
                                                            <input type="text" name="total" id="total"
                                                                class="form-control rupiah" required readonly />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="date">Tanggal <code>*</code></label>
                                                            <input type="date" name="date" id="date"
                                                                class="form-control" required />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="due_date">Tanggal Expired</label>
                                                            <input type="date" name="due_date" id="due_date"
                                                                class="form-control" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="status">Status <code>*</code></label>
                                                            <select type="text" name="status" id="status"
                                                                class="form-control" required>
                                                                <option value="" selected disabled>Pilih Status
                                                                </option>
                                                                <option value="draft">Draft</option>
                                                                <option value="paid">Paid</option>
                                                                <option value="overdue">Over Due</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('sales') }}" type="button" class="btn btn-default">Kembali</a>
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
