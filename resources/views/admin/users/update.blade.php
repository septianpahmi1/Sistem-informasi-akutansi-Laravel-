@foreach ($data as $item)
    <div class="modal fade" id="users{{ $item->id }}">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Buat Pengguna Baru</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('users.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name">Nama <code>*</code></label>
                                    <input type="text" id="name" value="{{ $item->name }}" maxlength="60"
                                        minlength="1" class="form-control" name="name" required autofocus>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="email">Email <code>*</code></label>
                                    <input type="email" id="email" name="email" value="{{ $item->email }}"
                                        class="form-control" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="password">Password <code>*</code></label>
                                    <input type="password" value="{{ $item->password }}" id="password" name="password"
                                        class="form-control" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="role">Pilih Role <code>*</code></label>
                                    <select id="role" name="role" class="form-control" required>
                                        <option value="" selected disabled>Pilih Role</option>
                                        <option value="Admin" {{ $item->role == 'Admin' ? 'Selected' : '' }}>Admin
                                        </option>
                                        <option value="Bendahara" {{ $item->role == 'Bendahara' ? 'Selected' : '' }}>
                                            Bendahara</option>
                                    </select>
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
