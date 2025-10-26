<div class="modal fade" id="mitra">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Buat Mitra/ Investor Baru</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('mitra.post') }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="name">Nama <code>*</code></label>
                                <input type="text" id="name" maxlength="60" minlength="1" class="form-control"
                                    name="name" required autofocus>
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
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="number">Persentasi(%)</label>
                                <input type="text" id="number" name="percentage" maxlength="2" max="99"
                                    minlength="1" class="form-control">
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
