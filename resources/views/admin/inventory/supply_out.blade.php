@foreach ($data as $item)
    <div class="modal fade" id="inventory{{ $item->id }}">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Persediaan keluar</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('inventory.out', $item->id) }}" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="proof_number">Nomor Bukti
                                        <code>*</code></label>
                                    <input type="proof_number" name="proof_numberout" id="proof_number"
                                        class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dateout">Tanggal <code>*</code></label>
                                    <input type="date" name="dateout" id="dateout" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="price">Harga <code>*</code></label>
                                    <input type="text" name="priceout" id="priceout" class="form-control rupiah" />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="number">Jumlah <code>*</code></label>
                                    <input type="text" name="qtyout" value="1" min="1" maxlength="5"
                                        max="99999" id="number" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="unit">Satuan <code>*</code></label>
                                    <select name="unitout" id="unit" class="form-control">
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
                                    <input type="text" name="totalout" id="totalout" class="form-control rupiah"
                                        readonly />
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
