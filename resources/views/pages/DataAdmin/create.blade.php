@extends('layout.master')
@section('statusadmin', 'active')
@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Admin</h4>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Tambah Admin</div>
                    </div>
                    <form enctype="multipart/form-data" method="POST" action="{{ route('admin.store') }}" id="myForm">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-5">
                                    <div class="form-group">
                                        <label for="nama">Nama</label>
                                        <input type="text" name="nama"
                                            value="@if (!empty(old('nama'))) {{ old('nama') }} @endif"
                                            class="form-control input-full @error('nama') is-invalid @enderror"
                                            id="nama">
                                        @error('nama')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="text-capitalize">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" name="email"
                                            value="@if (!empty(old('email'))) {{ old('email') }} @endif"
                                            class="form-control input-full @error('email') is-invalid @enderror"
                                            id="email">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="text-capitalize">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-5">
                                    <div class="form-group">
                                        <label for="tipe_user">Tipe User</label>
                                        <select name="tipe_user"
                                            class="form-control input-full @error('tipe_user') is-invalid @enderror"
                                            id="tipe_user">
                                            <option value="">---Pilih---</option>
                                            <option value="admin"
                                                @if (!empty(old('tipe_user'))) {{ old('tipe_user') == 'admin' ? 'selected' : '' }} @endif>
                                                Admin</option>
                                            <option value="superadmin"
                                                @if (!empty(old('tipe_user'))) {{ old('tipe_user') == 'superadmin' ? 'selected' : '' }} @endif>
                                                Super admin</option>
                                        </select>
                                        @error('tipe_user')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="text-capitalize">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="text" name="password"
                                            class="form-control input-full @error('password') is-invalid @enderror"
                                            id="password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="text-capitalize">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 col-lg-5">
                                    <div class="card">
                                        <div class="card-header" style="font-weight: bold;">Foto</div>
                                        <div class="card-body bg-grey1 text-center">
                                            <div class="form-group mb-4">
                                                <div class="mb-4">
                                                    <div class="image-area mt-4">
                                                        <img id="imageResult" src="#" alt=""
                                                            class="img-fluid rounded shadow-sm mx-auto d-block">
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <label for="upload" class="btn btn-grey m-0 rounded-pill px-4">Pilih
                                                        Foto</label>
                                                    <input name="foto" id="upload" type="file"
                                                        onchange="readURL(this);" style="display: none;"
                                                        class="form-control border-0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-action">
                            <a class="btn btn-danger" href="{{ route('admin.index') }}">Batal</a>
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('plugin-scripts')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imageResult')
                        .attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        $(function() {
            $('#upload').on('change', function() {
                readURL(input);
            });
        });
        /*  ==========================================
            SHOW UPLOADED IMAGE NAME
        * ========================================== */
        var input = document.getElementById('upload');
        var infoArea = document.getElementById('upload-label');
        input.addEventListener('change', showFileName);

        function showFileName(event) {
            var input = event.srcElement;
            var fileName = input.files[0].name;
            infoArea.textContent = 'File name: ' + fileName;
        }
    </script>
@endpush
