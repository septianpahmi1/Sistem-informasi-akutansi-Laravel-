<div class="modal fade" id="setting">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Password Update</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('password.update') }}" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    @method('get')
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="update_password_current_password">Password
                                    Saat ini</label>
                                <input id="update_password_current_password" name="current_password" type="password"
                                    class="form-control" autocomplete="current-password" />
                                @error('current_password')
                                    <span class="text-danger mt-3 mb-3">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="update_password_password">Password Baru</label>
                                <input id="update_password_password" name="password" type="password"
                                    class="form-control" autocomplete="new-password" />
                                @error('password')
                                    <span class="text-danger mt-3 mb-3">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="update_password_password_confirmation">Konfirmasi Password Baru</label>
                                <input id="update_password_password_confirmation" name="password_confirmation"
                                    type="password" class="form-control" autocomplete="new-password" />
                            </div>
                            @error('password_confirmation')
                                <span class="text-danger mt-3 mb-3">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
