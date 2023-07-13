@extends('layout.master')
@section('detail-aset', 'active')
@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Daftar Data Aset</h4>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Tambah Data Aset</div>
                    </div>
                    <form method="POST" action="{{ route('detail-aset.store') }}" id="myForm">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-5">
                                    <div class="form-group">
                                        <label for="kode_aset">Kode Aset</label>
                                        <input type="text" value="{{ old('kode_aset') }}" name="kode_aset"
                                            class="form-control input-full @error('kode_aset') is-invalid @enderror"
                                            id="kode_aset" required>
                                        @error('kode_aset')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="text-capitalize">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="kategori_aset">Kategori Aset</label>
                                        <input type="text" name="kategori_aset" value="{{ old('kategori_aset') }}"
                                            class="form-control  input-full @error('kategori_aset') is-invalid @enderror"
                                            id="kategori_aset" required>
                                        @error('kategori_aset')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="text-capitalize">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="asal_perusahaan">Asal Perolehan</label>
                                        <input type="text" name="asal_perusahaan" value="{{ old('asal_perusahaan') }}"
                                            class="form-control  input-full @error('asal_perusahaan') is-invalid @enderror"
                                            id="asal_perusahaan" required>
                                        @error('asal_perusahaan')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="text-capitalize">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="lokasi">Lokasi</label>
                                        <input type="text" name="lokasi" value="{{ old('lokasi') }}"
                                            class="form-control  input-full @error('lokasi') is-invalid @enderror"
                                            id="lokasi" required>
                                        @error('lokasi')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="text-capitalize">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="idPenanggungJawab">Penanggung Jawab</label>
                                        <select name="idPenanggungJawab" class="form-control form-control" required>
                                            <option>---Pilih---</option>
                                            @foreach ($pj as $item)
                                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                        @error('idPenanggungJawab')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="text-capitalize">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="idDetailBarang">Detail Barang</label>
                                        <select name="idDetailBarang" class="form-control form-control" required>
                                            <option>---Pilih---</option>
                                            @foreach ($dataBarang as $item)
                                                <option value="{{ $item->id }}">{{ $item->nama_barang }}</option>
                                            @endforeach
                                        </select>
                                        @error('idDetailBarang')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="text-capitalize">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-5">
                                    <div class="form-group">
                                        <label for="nama">Nama</label>
                                        <input type="text" name="nama" value="{{ old('nama') }}"
                                            class="form-control  input-full @error('nama') is-invalid @enderror"
                                            id="nama" required>
                                        @error('nama')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="text-capitalize">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="tahun_perolehan">Tahun Perolehan</label>
                                        <input type="input" name="tahun_perolehan" value="{{ old('tahun_perolehan') }}"
                                            class="form-control  input-full @error('tahun_perolehan') is-invalid @enderror"
                                            placeholder="YYYY" maxlength="4" id="tahun_perolehan" min="2000"
                                            max="2030" required>
                                        @error('tahun_perolehan')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="text-capitalize">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="kondisi">Kondisi</label>
                                        <select name="kondisi" id="kondisi" class="form-control" required>
                                            <option value="">Pilih Kondisi</option>
                                            @foreach ($status as $item)
                                                <option value="{{ $item->value }}">{{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                        @error('kondisi')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="text-capitalize">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="deskripsi_aset">Deskripsi Aset</label>
                                        <textarea name="deskripsi_aset" id="deskripsi_aset" cols="30" rows="10" class="form-control" required>{{ old('deskripsi_aset') }}</textarea>
                                        @error('deskripsi_aset')
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
                    <a class="btn btn-danger" href="{{ route('detail-aset.index') }}">Batal</a>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
