@foreach ($data as $item)
    <div class="modal fade" id="account{{ $item->id }}">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Akun</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('account.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="number">Kode <code>*</code></label>
                                    <input type="text" id="number" maxlength="8" value="{{ $item->code }}"
                                        minlength="1" class="form-control" name="code" required autofocus>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name">Nama Akun <code>*</code></label>
                                    <input type="text" id="name" maxlength="30" minlength="1"
                                        value="{{ $item->name }}" class="form-control" name="name" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="type">Tipe Akun <code>*</code></label>
                                    <select name="type" id="type" class="form-control" required>
                                        <option selected disabled>-- Pilih Tipe Akun --</option>
                                        <option value="asset" {{ $item->type == 'asset' ? 'selected' : '' }}>Aset
                                        </option>
                                        <option value="liability" {{ $item->type == 'liability' ? 'selected' : '' }}>
                                            Kewajiban</option>
                                        <option value="equity" {{ $item->type == 'equity' ? 'selected' : '' }}>Ekuitas
                                        </option>
                                        <option value="income" {{ $item->type == 'income' ? 'selected' : '' }}>
                                            Penghasilan</option>
                                        <option value="expense" {{ $item->type == 'expense' ? 'selected' : '' }}>
                                            Beban</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="opening_balance">Saldo awal </label>
                                    <input type="text" id="opening_balance" value="{{ $item->opening_balance }}"
                                        maxlength="30" class="form-control rupiah" name="opening_balance">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endforeach
