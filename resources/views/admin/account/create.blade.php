<div class="modal fade" id="account">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Buat Akun Baru</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('account.post') }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="number">Kode <code>*</code></label>
                                <input type="text" id="number" maxlength="8" minlength="1" class="form-control"
                                    name="code" required autofocus>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name">Nama Akun <code>*</code></label>
                                <input type="text" id="name" name="name" maxlength="30" minlength="1"
                                    class="form-control" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="type">Tipe Akun <code>*</code></label>
                                <select name="type" id="type" class="form-control" required>
                                    <option selected disabled>-- Pilih Tipe Akun --</option>
                                    <option value="asset">Aset</option>
                                    <option value="liability">Kewajiban</option>
                                    <option value="equity">Ekuitas</option>
                                    <option value="income">Pendapatan</option>
                                    <option value="expense">Beban</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="opening_balance">Saldo awal </label>
                                <input type="text" id="opening_balance" value="0" maxlength="30"
                                    class="form-control rupiah" name="opening_balance">
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
