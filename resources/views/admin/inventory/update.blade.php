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
                        <li class="breadcrumb-item"><a href="{{ route('inventory') }}">Inventory</a></li>
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
                            <h3 class="card-title">Update Persediaan</h3>
                        </div>
                        <!-- /.card-header -->
                        <form action="{{ route('inventory.updatepost', $data->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="code">Kode Barang <code>*</code></label>
                                            <input type="text" name="code" maxlength="150" id="code"
                                                class="form-control" value="{{ $data->code }}" required />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">Nama Barang <code>*</code></label>
                                            <input type="text" name="name" value="{{ $data->name }}"
                                                maxlength="150" id="name" class="form-control" required />
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">Persediaan Masuk</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="proof_number">Nomor Bukti <code>*</code></label>
                                                            <input type="proof_number"
                                                                value="{{ $data->stockIn->sum('proof_number') }}"
                                                                name="proof_number" id="proof_number"
                                                                class="form-control" required />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="date">Tanggal <code>*</code></label>
                                                            <input type="date" name="date" id="date"
                                                                class="form-control" required />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="price">Harga <code>*</code></label>
                                                            <input type="text" name="price" id="price"
                                                                class="form-control rupiah" required />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="number">Jumlah <code>*</code></label>
                                                            <input type="text" name="qty" value="1"
                                                                min="1" maxlength="5" max="99999"
                                                                id="number" class="form-control" required />
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
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">Persediaan Keluar</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="proof_number">Nomor Bukti
                                                                <code>*</code></label>
                                                            <input type="proof_number" name="proof_numberout"
                                                                id="proof_number" class="form-control" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="dateout">Tanggal <code>*</code></label>
                                                            <input type="date" name="dateout" id="dateout"
                                                                class="form-control" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="price">Harga <code>*</code></label>
                                                            <input type="text" name="priceout" id="priceout"
                                                                class="form-control rupiah" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="number">Jumlah <code>*</code></label>
                                                            <input type="text" name="qtyout" value="1"
                                                                min="1" maxlength="5" max="99999"
                                                                id="number" class="form-control" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="unit">Satuan <code>*</code></label>
                                                            <select name="unitout" id="unit"
                                                                class="form-control">
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
                                                            <input type="text" name="totalout" id="totalout"
                                                                class="form-control rupiah" readonly />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('inventory') }}" type="button" class="btn btn-default">Kembali</a>
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
