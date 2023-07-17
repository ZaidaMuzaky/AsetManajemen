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
                        <div class="d-flex align-items-center" id="ch">
                            <h4 class="card-title">Data Monitoring</h4>
                            <div class="form-inline form-group col-8">
                                <label for="search" class="col-md-2 col-form-label">Search: </label>
                                <div class="col-md-3">
                                    <div id="search" class="input-full"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="monitoring" class="display table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Kode Aset</th>
                                        <th>Nama Aset</th>
                                        <th>Jumlah Monitoring</th>
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
                                            <td>
                                                <?php $count = count($item->monitoring); ?>
                                                @if ($count > 0)
                                                    <a href="{{ route('monitoring.show', $item->id) }}"
                                                        class="link-opacity-50-hove">{{ $count }}</a>
                                                @else
                                                    {{ $count }}
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('monitoring.create', $item->id) }}" type="button"
                                                    data-toggle="tooltip" title=""
                                                    class="btn btn-link btn-primary btn-lg"
                                                    data-original-title="Monitoring Data">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-file-earmark-plus-fill"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM8.5 7v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 1 0z" />
                                                    </svg>
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
            $('#monitoring').DataTable({
                bLengthChange: false,
                bInfo: false,
                paginate: false,
                autoWidth: true,
                language: {
                    search: "",
                    searchPlaceholder: "Data Aset",
                },
                initComplete: (settings, json) => {
                    $('#monitoring_filter').appendTo('#search');
                },
            });
        });

        $('.show_confirm').click(function(e) {
            var id = $(this).data("id");
            var token = $("meta[name='csrf-token']").attr("content");
            swal({
                title: 'Hapus Data Monitoring ini?',
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
                        url: '/monitoring/all/' + id,
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
