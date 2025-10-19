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
                        <li class="breadcrumb-item"><a href="{{ route('purchase') }}">Faktur Pembelian</a></li>
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
                            <h3 class="card-title">Buat Faktur Pembelian</h3>
                        </div>
                        <!-- /.card-header -->
                        <form action="{{ route('purchase.post') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="supplier_id">Supplier <code>*</code></label>
                                            <select name="supplier_id" id="supplier_id" class="form-control select2bs4"
                                                style="width: 100%;" required>
                                                <option selected disabled>Pilih Supplier</option>
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
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="number">Jumlah</label>
                                                            <input type="text" name="qty" maxlength="5"
                                                                max="99999" id="number" value="1"
                                                                min="1" class="form-control" required />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="unit">Satuan <code>*</code></label>
                                                            <select name="unit" id="unit" class="form-control"
                                                                required>
                                                                <option value="Pcs">Pcs</option>
                                                                <option value="Unit">Unit</option>
                                                                <option value="Buah">Buah</option>
                                                                <option value="Lusin">Lusin</option>
                                                                <option value="Gram">Gram</option>
                                                                <option value="Kg">Kg</option>
                                                                <option value="Box">Box</option>
                                                                <option value="Dus">Dus</option>
                                                            </select>
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
                                <a href="{{ route('purchase') }}" type="button" class="btn btn-default">Kembali</a>
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
