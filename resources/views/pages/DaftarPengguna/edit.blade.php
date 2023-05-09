@extends('layout.master')
@section('statusDaftarPengguna', 'active')
@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Daftar Pengguna</h4>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Daftar Pengguna</div>
                    </div>
                    <form method="POST" action="{{ route('DaftarPengguna.update', $DaftarPengguna->id) }}" id="myForm">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-5">
                                    <div class="form-group">
                                        <label for="nip">NIP Pegawai</label>
                                        <input
                                            value="@if (!empty(old('nip'))) {{ old('nip') }}@else{{ $DaftarPengguna->nip }} @endif"
                                            type="text" name="nip"
                                            class="form-control @error('nip') is-invalid @enderror" id="nip">
                                        @error('nip')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="text-capitalize">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="id_divisi">Divisi</label>
                                        <select name="id_divisi" class="form-control form-control">
                                            @foreach ($divisi as $d)
                                                <option value="{{ $d->id }}"
                                                    {{ $DaftarPengguna->id_divisi == $d->id ? 'selected' : '' }}>
                                                    {{ $d->kode_divisi }} - {{ $d->nama_divisi }}</option>
                                            @endforeach
                                        </select>
                                        @error('id_divisi')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="text-capitalize">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-5">
                                    <div class="form-group">
                                        <label for="nama_pegawai">Nama Pegawai</label>
                                        <input
                                            value="@if (!empty(old('nama'))) {{ old('nama') }}@else{{ $DaftarPengguna->nama }} @endif"
                                            type="text" name="nama"
                                            class="form-control @error('nama') is-invalid @enderror" id="nama">
                                        @error('nama')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="text-capitalize">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="card-action">
                    <a class="btn btn-danger" href="{{ route('DaftarPengguna.index') }}">Batal</a>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection
