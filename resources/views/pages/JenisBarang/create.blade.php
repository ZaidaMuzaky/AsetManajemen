@extends('layout.master')
@section('statusJenisBarang', 'active')
@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Jenis Barang</h4>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Tambah Jenis Barang</div>
                    </div>
                    <form method="POST" action="{{ route('JenisBarang.store') }}" id="myForm">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-5">
                                    <div class="form-group">
                                        <label for="Kode_Jenis_Barang">Kode jenis Barang</label>
                                        <input type="text"
                                            value="@if (!empty(old('Kode_Jenis_Barang'))) {{ old('Kode_Jenis_Barang') }} @endif"
                                            name="Kode_Jenis_Barang"
                                            class="form-control input-full @error('Kode_Jenis_Barang') is-invalid @enderror"
                                            id="Kode_Jenis_Barang">
                                        @error('Kode_Jenis_Barang')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="text-capitalize">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-5">
                                    <div class="form-group">
                                        <label for="Jenis_Barang">Jenis Barang</label>
                                        <input type="text" name="Jenis_Barang"
                                            value="@if (!empty(old('Jenis_Barang'))) {{ old('Jenis_Barang') }} @endif"
                                            class="form-control  input-full @error('Jenis_Barang') is-invalid @enderror"
                                            id="Jenis_Barang">
                                        @error('Jenis_Barang')
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
                    <a class="btn btn-danger" href="{{ route('JenisBarang.index') }}">Batal</a>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection
