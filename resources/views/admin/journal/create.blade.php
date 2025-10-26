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
                        <li class="breadcrumb-item"><a href="{{ route('purchase') }}">Journal Umum</a></li>
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
                            <h3 class="card-title">Buat Journal Baru</h3>
                        </div>
                        <!-- /.card-header -->
                        <form action="{{ route('journal.post') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="date">Tanggal <code>*</code></label>
                                            <input type="date" name="date" maxlength="150" id="date"
                                                class="form-control" required />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="dapur_id">Pilih Dapur
                                                <code>*</code></label>
                                            <select name="dapur_id" id="dapur_id" class="form-control select2bs4"
                                                style="width: 100%;" required>
                                                <option selected disabled>Pilih Dapur</option>
                                                @foreach ($dapur as $dapurs)
                                                    <option value="{{ $dapurs->id }}">
                                                        {{ $dapurs->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="description">Keterangan <code>*</code></label>
                                            <input type="text" name="description" maxlength="150" id="description"
                                                class="form-control" required />
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <div id="journalContainer">
                                            <div class="journal-entry card mb-3">
                                                <div class="card-header">
                                                    <h3 class="card-title">Detail Journal</h3>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="account_id">Pilih Akun
                                                                    <code>*</code></label>
                                                                <select name="account_id[]" id="account_id"
                                                                    class="form-control select2bs4" style="width: 100%;"
                                                                    required>
                                                                    <option selected disabled>Pilih Akun</option>
                                                                    @foreach ($akun as $ak)
                                                                        <option value="{{ $ak->id }}">
                                                                            {{ $ak->code }} -
                                                                            {{ $ak->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="type">Pilih Tipe
                                                                    <code>*</code></label>
                                                                <select name="type[]" id="type"
                                                                    class="form-control" style="width: 100%;" required>
                                                                    <option selected disabled>Pilih Tipe</option>
                                                                    <option value="debit">Debit</option>
                                                                    <option value="credit">Kredit</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="price">Harga <code>*</code></label>
                                                                <input type="text" name="price[]" id="price"
                                                                    class="form-control rupiah" required />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label for="number">Jumlah</label>
                                                                <input type="text" name="qty[]" maxlength="3"
                                                                    max="999" id="number" value="1"
                                                                    min="1" class="form-control" required />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label for="unit">Satuan <code>*</code></label>
                                                                <select name="unit[]" id="unit"
                                                                    class="form-control" required>
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
                                                                <input type="text" name="total[]" id="total"
                                                                    class="form-control rupiah" required readonly />
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="button" class="btn btn-primary text-center" id="addEntries"><i
                                            class="fas fa-plus-circle"></i> Tambah Journal</button>
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
