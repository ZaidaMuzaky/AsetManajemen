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
                        <div class="d-flex align-items-center" id="ch">
                            <h4 class="card-title">Daftar Jenis Barang</h4>
                            <div class="form-inline form-group col-8">
                                <label for="search" class="col-md-2 col-form-label">Search: </label>
                                <div class="col-md-3">
                                    <div id="search" class="input-full"></div>
                                </div>
                            </div>
                            <a class="btn btn-primary ml-auto btn-sm" href="{{ route('JenisBarang.create') }}">
                                <i class="fa fa-plus"></i>
                                Tambah Jenis Barang
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="JenisBarang" class="display table table-hover">
                                <thead>
                                    <tr>
                                        <th>Kode Jenis Barang</th>
                                        <th>Jenis Barang</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($JenisBarang as $p)
                                        <tr style="white-space:nowrap; width:1%;">
                                            <td>{{ $p->Kode_Jenis_Barang }}</td>
                                            <td>{{ $p->Jenis_Barang }}</td>
                                            <td>
                                                <a href="{{ route('JenisBarang.edit', $p->id) }}" type="button"
                                                    data-toggle="tooltip" title=""
                                                    class="btn btn-link btn-primary btn-lg" data-original-title="Edit Data">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <button id="jensibremove" data-id="{{ $p->id }}"
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
            $('#JenisBarang').DataTable({
                "bLengthChange": false,
                "bInfo": false,
                "paginate": false,
                "autoWidth": true,
                fixedColumns: {
                    leftColumns: 1
                },
                "language": {
                    search: "",
                    searchPlaceholder: "Cari Jenis Barang",
                },
                initComplete: (settings, json) => {
                    $('#JenisBarang_filter').appendTo('#search');
                },
            });
        });
    </script>
    <script>
        $('.show_confirm').click(function(e) {
            var id = $(this).data("id");
            var token = $("meta[name='csrf-token']").attr("content");
            swal({
                title: 'Hapus Data Jenis Barang ini?',
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
                        url: '/JenisBarang/' + id,
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
