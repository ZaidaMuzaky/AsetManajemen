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
                            <h4 class="card-title">Data Daftar Data Aset</h4>
                            <div class="form-inline form-group col-8">
                                <label for="search" class="col-md-2 col-form-label">Search: </label>
                                <div class="col-md-3">
                                    <div id="search" class="input-full"></div>
                                </div>
                            </div>
                            <a class="btn btn-primary ml-auto btn-sm" href="{{ route('detail-aset.create') }}">
                                <i class="fa fa-plus"></i>
                                Tambah Data Aset
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="DataAset" class="display table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nomor</th>
                                        <th>Nama Aset</th>
                                        <th>Perusahaan</th>
                                        <th>Divisi</th>
                                        <th>Tahun Pembelian</th>
                                        <th>Kondisi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 0; ?>
                                    @foreach ($detailAset as $item)
                                        <?php $no++; ?>
                                        <tr style="white-space:nowrap; width:1%;">
                                            <td>{{ $no }}</td>
                                            <td>{{ $item->kode_aset }}</td>
                                            <td>{{ $item->nama }}</td>
                                            <td>{{ $item->asal_perusahaan }}</td>
                                            <td>{{ $item->penanggungJawab->divisi->nama_divisi }}</td>
                                            <td>{{ $item->tahun_perolehan }}</td>
                                            <td>{{ $item->kondisi }}</td>
                                            <td>
                                                <a href="{{ route('detail-aset.edit', $item->id) }}" type="button"
                                                    data-toggle="tooltip" title=""
                                                    class="btn btn-link btn-primary btn-lg" data-original-title="Edit Data">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="{{ route('detail-aset.edit', $item->id) }}" type="button"
                                                    data-toggle="tooltip" title=""
                                                    class="btn btn-link btn-primary btn-lg" data-original-title="History">
                                                    <i class="fas fa-user-clock"></i>
                                                </a>
                                                <button id="delete-detail_aset" data-id="{{ $item->id }}"
                                                    data-toggle="tooltip" title=""
                                                    class="btn btn-link btn-danger show_confirm"
                                                    data-original-title="Hapus Data">
                                                    <i class="fa fa-trash-alt"></i>
                                                </button>
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
            $('#DataAset').DataTable({
                bLengthChange: false,
                bInfo: false,
                paginate: false,
                autoWidth: true,
                language: {
                    search: "",
                    searchPlaceholder: "Data Aset",
                },
                initComplete: (settings, json) => {
                    $('#DataAset_filter').appendTo('#search');
                },
            });
        });

        $('.show_confirm').click(function(e) {
            var id = $(this).data("id");
            var token = $("meta[name='csrf-token']").attr("content");
            swal({
                title: 'Hapus Data Aset ini?',
                text: "Apakah Anda yakin ingin menghapus Data ini",
                buttons: {
                    cancel: {
                        visible: true,
                        text: 'Batal',
                        className: 'btn btn-focus'
                    },
                    confirm: {
                        text: 'Hapus',
                        className: 'btn btn-danger'
                    }
                }
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: 'DELETE',
                        url: '/detail-aset/' + id,
                        data: {
                            "id": id,
                            "_token": token,
                        },
                    }).done(function(data) {
                        swal({
                            title: 'Data berhasil terhapus',
                            buttons: {
                                confirm: {
                                    className: 'btn btn-success'
                                }
                            }
                        }).then(function() {
                            location.reload();
                        })
                        $(".swal-modal").css('background-color', '#DCF4E6');
                    }).fail(function(data) {
                        swal({
                            title: 'Data Gagal dihapus',
                            buttons: {
                                confirm: {
                                    className: 'btn btn-success'
                                }
                            }
                        });
                        $(".swal-modal").css('background-color', '#F4E2E2');
                    })
                } else {
                    swal.close();
                }
            });
            $(".swal-modal").css('background-color', '#F4E2E2');
        })
    </script>
@endpush