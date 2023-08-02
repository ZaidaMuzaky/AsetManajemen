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
                        <div class="card-title">Edit Admin</div>
                    </div>
                    <form enctype="multipart/form-data" method="POST" action="{{ route('admin.update', $user->id_user) }}"
                        id="myForm">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-5">
                                    <div class="form-group">
                                        <label for="nama">Nama</label>
                                        <input
                                            value="@if (!empty(old('nama'))) {{ old('nama') }}@else{{ $user->nama }} @endif"
                                            type="text" name="nama"
                                            class="form-control @error('nama') is-invalid @enderror" id="nama">
                                        @error('nama')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="text-capitalize">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input
                                            value="@if (!empty(old('email'))) {{ old('email') }}@else{{ $user->email }} @endif"
                                            type="text" name="email"
                                            class="form-control @error('email') is-invalid @enderror" id="email">
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
                                            class="form-control form-control @error('tipe_user') is-invalid @enderror"
                                            id="tipe_user">
                                            <option value="">---Pilih---</option>
                                            <option value="admin"
                                                @if (!empty(old('tipe_user'))) {{ old('tipe_user') == 'admin' ? 'selected' : '' }}@else{{ $user->tipe_user == 'admin' ? 'selected' : '' }} @endif>
                                                admin</option>
                                            <option value="superadmin"
                                                @if (!empty(old('tipe_user'))) {{ old('tipe_user') == 'superadmin' ? 'selected' : '' }}@else{{ $user->tipe_user == 'superadmin' ? 'selected' : '' }} @endif>
                                                Super admin</option>
                                        </select>
                                        @error('tipe_user')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="text-capitalize">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="tahun_sk">Password</label>
                                        <input type="password" name="password" class="form-control form-control"
                                            id="password">
                                        <span class="text-warning text-capitalize text-small">Kosongkan password jika tidak
                                            ingin mengganti</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 col-lg-5">
                                    <div class="card">
                                        <div class="card-header" style="font-weight: bold;">Foto</div>
                                        <div class="card-body bg-grey1 text-center">
                                            <div class="form-group mb-0">
                                                <div class="mb-0">
                                                    <div class="image-area mt-0" style="width:200px">
                                                        @if ($user->foto == 'null')
                                                            <img id="imageResult" src="{{ asset('img/avatar.png') }}"
                                                                alt="image profile"
                                                                class="img-fluid rounded shadow-sm mx-auto d-block">
                                                        @else
                                                            <img id="imageResult" src="{{ Storage::url($user->foto) }}"
                                                                alt=""
                                                                class="img-fluid rounded shadow-sm mx-auto d-block">
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="mt-4">
                                                    <label for="upload" class="btn btn-grey m-0 rounded-pill px-2">Pilih
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
