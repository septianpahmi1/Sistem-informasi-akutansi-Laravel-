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
                        <li class="breadcrumb-item"><a href="{{ route('purchase') }}">Update Journal</a></li>
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
                            <h3 class="card-title">Update Journal</h3>
                        </div>
                        <!-- /.card-header -->
                        <form action="{{ route('journal.updatepost', $data->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="date">Tanggal <code>*</code></label>
                                            <input type="date" name="date" value="{{ old('date', $data->date) }}"
                                                maxlength="150" id="date" class="form-control" required />
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="description">Keterangan <code>*</code></label>
                                            <input type="text" name="description" maxlength="150" id="description"
                                                value="{{ old('description', $data->description) }}"
                                                class="form-control" required />
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <div id="journalContainer">
                                            @foreach ($data->entries as $entry)
                                                <div class="journal-entry card mb-3">
                                                    <div class="card-header">
                                                        <h3 class="card-title">Detail Journal {{ $loop->iteration }}
                                                        </h3>
                                                        @if ($loop->iteration > 1)
                                                            <button type="button"
                                                                class="btn btn-danger btn-sm remove-entry float-right">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Pilih Akun <code>*</code></label>
                                                                    <select name="account_id[]"
                                                                        class="form-control select2bs4" required>
                                                                        <option disabled>Pilih Akun</option>
                                                                        @foreach ($akun as $ak)
                                                                            <option value="{{ $ak->id }}"
                                                                                {{ $entry->account_id == $ak->id ? 'selected' : '' }}>
                                                                                {{ $ak->code }} -
                                                                                {{ $ak->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Pilih Tipe <code>*</code></label>
                                                                    <select name="type[]" class="form-control"
                                                                        required>
                                                                        <option value="debit"
                                                                            {{ $entry->type == 'debit' ? 'selected' : '' }}>
                                                                            Debit</option>
                                                                        <option value="credit"
                                                                            {{ $entry->type == 'credit' ? 'selected' : '' }}>
                                                                            Kredit</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>Harga <code>*</code></label>
                                                                    <input type="text" name="price[]"
                                                                        value="{{ $entry->price }}"
                                                                        class="form-control rupiah" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label>Jumlah</label>
                                                                    <input type="text" name="qty[]"
                                                                        value="{{ $entry->qty }}" maxlength="3"
                                                                        class="form-control" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="unit">Satuan <code>*</code></label>
                                                                    <select name="unit[]" id="unit"
                                                                        class="form-control" required>
                                                                        <option value="Pcs"
                                                                            {{ $data->status == 'Pcs' ? 'selected' : '' }}>
                                                                            Pcs
                                                                        </option>
                                                                        <option value="Unit"
                                                                            {{ $data->status == 'Unit' ? 'selected' : '' }}>
                                                                            Unit</option>
                                                                        <option value="Buah"
                                                                            {{ $data->status == 'Buah' ? 'selected' : '' }}>
                                                                            Buah</option>
                                                                        <option value="Lusin"
                                                                            {{ $data->status == 'Lusin' ? 'selected' : '' }}>
                                                                            Lusin</option>
                                                                        <option value="Gram"
                                                                            {{ $data->status == 'Gram' ? 'selected' : '' }}>
                                                                            Gram</option>
                                                                        <option value="Kg"
                                                                            {{ $data->status == 'Kg' ? 'selected' : '' }}>
                                                                            Kg
                                                                        </option>
                                                                        <option value="Box"
                                                                            {{ $data->status == 'Box' ? 'selected' : '' }}>
                                                                            Box
                                                                        </option>
                                                                        <option value="Dus"
                                                                            {{ $data->status == 'Dus' ? 'selected' : '' }}>
                                                                            Dus
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>Total <code>*</code></label>
                                                                    <input type="text" name="total[]"
                                                                        value="{{ $entry->total }}"
                                                                        class="form-control rupiah" readonly required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
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
