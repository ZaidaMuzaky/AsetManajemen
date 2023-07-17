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
                        <div class="d-flex align-items-center" id="ch">
                            <h4 class="card-title">History Daftar Data Aset</h4>
                            <div class="form-inline form-group col-8">
                                <label for="search" class="col-md-2 col-form-label">Search: </label>
                                <div class="col-md-3">
                                    <div id="search" class="input-full"></div>
                                </div>
                            </div>
                            <a class="btn btn-danger ml-auto btn-sm" href="{{ route('detail-aset.index') }}">
                                Kembali
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="history-data-aset" class="display table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nomor</th>
                                        <th>Nama Aset</th>
                                        <th>Perusahaan</th>
                                        <th>Divisi</th>
                                        <th>Tahun Pembelian</th>
                                        <th>Kondisi</th>
                                        <th>Tanggal Perubahan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 0; ?>
                                    @foreach ($history as $item)
                                        <?php $no++; ?>
                                        <tr style="white-space:nowrap; width:1%;">
                                            <td>{{ $no }}</td>
                                            <td>{{ $item->kode_aset }}</td>
                                            <td>{{ $item->nama }}</td>
                                            <td>{{ $item->asal_perusahaan }}</td>
                                            <td>{{ $item->penanggungJawab->divisi->nama_divisi }}</td>
                                            <td>{{ $item->tahun_perolehan }}</td>
                                            <td><span
                                                    class="badge badge-{{ $item->status->color }}">{{ $item->status->nama }}</span>
                                            </td>
                                            <td>
                                                {{ $item->created_at }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('plugin-scripts')
    <script>
        $(document).ready(function() {
            $('#history-data-aset').DataTable({
                bLengthChange: false,
                bInfo: false,
                paginate: false,
                autoWidth: true,
                language: {
                    search: "",
                    searchPlaceholder: "History Data Aset",
                },
                initComplete: (settings, json) => {
                    $('#history-data-aset_filter').appendTo('#search');
                },
            });
        });
    </script>
@endpush
