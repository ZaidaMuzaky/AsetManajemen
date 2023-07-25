@extends('layout.master')
@section('statusmutasi', 'active')
@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Tambah Memo</h4>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Tambah memo</div>
                    </div>
                    <form method="POST" action="{{ route('memo.store') }}" id="myForm">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-5">
                                    <div class="form-group">
                                        <label for="kode_memo">Kode Memo</label>
                                        <input type="text"
                                            value="@if (!empty(old('kode_memo'))) {{ old('kode_memo') }} @endif"
                                            name="kode_memo"
                                            class="form-control input-full @error('kode_memo') is-invalid @enderror"
                                            id="kode_memo">
                                        @error('kode_memo')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="text-capitalize">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="perihal">perihal</label>
                                        <input type="text"
                                            value="@if (!empty(old('perihal'))) {{ old('perihal') }} @endif"
                                            name="perihal"
                                            class="form-control input-full @error('perihal') is-invalid @enderror"
                                            id="perihal">
                                        @error('perihal')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="text-capitalize">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="pengirim">Pengirim</label>
                                        <select name="pengirim" class="form-control form-control">
                                            <option>---Pilih---</option>
                                            @foreach ($user as $d)
                                                <option
                                                    value="{{ $d->id }}"{{ old('pengirim') == $d->id ? 'selected' : '' }}>
                                                    {{ $d->id_user }}- {{ $d->nama }} </option>
                                            @endforeach
                                        </select>
                                        @error('pengirim')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="text-capitalize">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-5">
                                    <div class="form-group">
                                        <label for="tgl_memo">Tanggal Memo</label>
                                        <input type="text"
                                            value="@if (!empty(old('tgl_memo'))) {{ old('tgl_memo') }} @endif"
                                            name="tgl_memo"
                                            class="form-control input-full @error('tgl_memo') is-invalid @enderror"
                                            id="tgl_memo">
                                        @error('tgl_memo')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="text-capitalize">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="deskripsi">deskripsi</label>
                                        <input type="text" name="deskripsi"
                                            value="@if (!empty(old('deskripsi'))) {{ old('deskripsi') }} @endif"
                                            class="form-control  input-full @error('deskripsi') is-invalid @enderror"
                                            id="deskripsi">
                                        @error('deskripsi')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="text-capitalize">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="penerima">Penerima</label>
                                        <select name="penerima" class="form-control form-control">
                                            <option>---Pilih---</option>
                                            @foreach ($DaftarPengguna as $d)
                                                <option
                                                    value="{{ $d->id }}"{{ old('penerima') == $d->id ? 'selected' : '' }}>
                                                    {{ $d->nip }}- {{ $d->nama }} </option>
                                            @endforeach
                                        </select>
                                        @error('penerima')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="text-capitalize">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </div>
                </div>
            </div>
            <div class="card-action">
                <a class="btn btn-danger" href="{{ route('memo.index') }}">Batal</a>
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
            </form>
        </div>
    </div>
    </div>
    </div>
@endsection
