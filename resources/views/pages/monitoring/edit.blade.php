@extends('layout.master')
@section('monitoring', 'active')
@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Monitoring</h4>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Tambah Monitoring</div>
                    </div>
                    <form method="POST" action="{{ route('monitoring.update', $monitoring->id) }}" id="myForm">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-5">
                                    <div class="form-group">
                                        <label for="kode_aset">Kode Aset</label>
                                        <input type="text"
                                            value="{{ old('kode_aset') ?? $monitoring->detailAset->kode_aset }}"
                                            name="kode_aset"
                                            class="form-control input-full @error('kode_aset') is-invalid @enderror"
                                            id="kode_aset" readonly>
                                        @error('kode_aset')
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
                                                <option value="{{ $item->id }}"
                                                    {{ $monitoring->idPenanggungJawab == $item->id ? 'selected' : '' }}>
                                                    {{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                        @error('idPenanggungJawab')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="text-capitalize">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="deskripsi">Deskripsi</label>
                                        <textarea name="deskripsi" id="deskripsi" cols="30" rows="10" class="form-control" required>{{ old('deskripsi') ?? $monitoring->deskripsi }}</textarea>
                                        @error('deskripsi')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="text-capitalize">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-5">
                                    <div class="form-group">
                                        <label for="tgl_monitoring">Tanggal Monitoring</label>
                                        <input type="date" name="tgl_monitoring"
                                            value="{{ old('tgl_monitoring') ?? $monitoring->tgl_monitoring }}"
                                            class="form-control  input-full @error('tgl_monitoring') is-invalid @enderror"
                                            id="tgl_monitoring" required>
                                        @error('tgl_monitoring')
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
                                                <option value="{{ $item->value }}"
                                                    {{ $monitoring->kondisi == $item->value ? 'selected' : '' }}>
                                                    {{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                        @error('kondisi')
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
                    <a class="btn btn-danger" href="{{ route('monitoring.index') }}">Batal</a>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
