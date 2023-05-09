@extends('layout.master')
@section('statusdivisi', 'active')
@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Tipe Divisi</h4>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Divisi</div>
                    </div>
                    <form method="POST" action="{{ route('divisi.update', $divisi->id) }}" id="myForm">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-5">
                                    <div class="form-group">
                                        <label for="Kode_divisi">Kode Divisi</label>
                                        <input
                                            value="@if (!empty(old('kode_divisi'))) {{ old('kode_divisi') }}@else{{ $divisi->kode_divisi }} @endif"
                                            type="text" name="kode_divisi"
                                            class="form-control @error('kode_divisi') is-invalid @enderror"
                                            id="Kode_divisi">
                                        @error('kode_divisi')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="text-capitalize">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-md-6 col-lg-5">
                                    <div class="form-group">
                                        <label for="nama_divisi">Nama Divisi</label>
                                        <input
                                            value="@if (!empty(old('nama_divisi'))) {{ old('nama_divisi') }}@else{{ $divisi->nama_divisi }} @endif"
                                            type="text" name="nama_divisi"
                                            class="form-control @error('nama_divisi') is-invalid @enderror"
                                            id="Nama_divisi">
                                        @error('nama_divisi')
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
                    <a class="btn btn-danger" href="{{ route('divisi.index') }}">Batal</a>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection
