@extends('layout.master')
@section('statusdashboard', 'active')
@section('content')
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="text-white pb-2 fw-bold">Dashboard</h2>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="row mt--2">
  <div class="col-md-12">
      <div class="page-inner mt--5">
      <div class="card">
        <div class="card-header">
          <div class="card-title">Grafik Karyawan Tiap Tahun</div>
        </div>
        <div class="card-body">
          <div class="chart-container">
            <canvas id="multipleBarChart"></canvas>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title">Gender</div>
        </div>
        <div class="card-body">
          <div class="chart-container">
            <canvas id="gender" style="width: 50%; height: 50%"></canvas>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title">Status Kepegawaian</div>
        </div>
        <div class="card-body">
          <div class="chart-container">
            <canvas id="pegawai" style="width: 50%; height: 50%"></canvas>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title">Usia Karyawan</div>
        </div>
        <div class="card-body">
          <div class="chart-container">
            <canvas id="usia" style="width: 50%; height: 50%"></canvas>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title">Pendidikan Karyawan</div>
        </div>
        <div class="card-body">
          <div class="chart-container">
            <canvas id="pendidikan" style="width: 50%; height: 50%"></canvas>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title">Jabatan</div>
        </div>
        <div class="card-body">
          <div class="chart-container">
            <canvas id="jabatan" style="width: 50%; height: 50%"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> --}}
@endsection
@push('plugin-scripts')
    <script>
        gender = document.getElementById('gender').getContext('2d'),
            pegawai = document.getElementById('pegawai').getContext('2d'),
            usia = document.getElementById('usia').getContext('2d'),
            pendidikan = document.getElementById('pendidikan').getContext('2d'),
            jabatan = document.getElementById('jabatan').getContext('2d'),
            multipleBarChart = document.getElementById('multipleBarChart').getContext('2d');


        var umur_json = {!! json_encode($umur->toArray()) !!};
        var umur_value = [];
        for (let i = 0; i < umur_json.length; i++) {
            umur_value.push(umur_json[i].umur1);
            umur_value.push(umur_json[i].umur2);
            umur_value.push(umur_json[i].umur3);
            umur_value.push(umur_json[i].umur4);
            umur_value.push(umur_json[i].umur5);
            umur_value.push(umur_json[i].umur6);
            umur_value.push(umur_json[i].umur7);
        }

        Circles.create({
            id: 'circles-1',
            radius: 45,
            value: 60,
            maxValue: 100,
            width: 7,
            text: 5,
            colors: ['#f1f1f1', '#FF9E27'],
            duration: 400,
            wrpClass: 'circles-wrp',
            textClass: 'circles-text',
            styleWrapper: true,
            styleText: true
        })

        Circles.create({
            id: 'circles-2',
            radius: 45,
            value: 70,
            maxValue: 100,
            width: 7,
            text: 36,
            colors: ['#f1f1f1', '#2BB930'],
            duration: 400,
            wrpClass: 'circles-wrp',
            textClass: 'circles-text',
            styleWrapper: true,
            styleText: true
        })

        Circles.create({
            id: 'circles-3',
            radius: 45,
            value: 40,
            maxValue: 100,
            width: 7,
            text: 12,
            colors: ['#f1f1f1', '#F25961'],
            duration: 400,
            wrpClass: 'circles-wrp',
            textClass: 'circles-text',
            styleWrapper: true,
            styleText: true
        })

        var gender = new Chart(gender, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: {!! json_encode($totalGender) !!},
                    backgroundColor: ['#1363DF', '#F32424', '#1d7af3']
                }],

                labels: [
                    'Laki-Laki',
                    'Perempuan'
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'bottom'
                },
                layout: {
                    padding: {
                        left: 20,
                        right: 20,
                        top: 20,
                        bottom: 20
                    }
                }
            }
        });

        var pegawai = new Chart(pegawai, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: {!! json_encode($totalPegawai) !!},
                    backgroundColor: ['#5FD068', '#fdaf4b', '#FF7396', '#FAEA48']
                }],

                labels: [
                    'Organik Reka',
                    'PKWT Reka',
                    'Organik Inka',
                    'PKWT Inka',
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'bottom'
                },
                layout: {
                    padding: {
                        left: 20,
                        right: 20,
                        top: 20,
                        bottom: 20
                    }
                }
            }
        });

        var usia = new Chart(usia, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: umur_value,
                    backgroundColor: ['#1363DF', '#F32424', '#3AB0FF', '#5FD068', '#fdaf4b', '#FF7396',
                        '#FAEA48'
                    ]
                }],

                labels: [
                    '20-25 tahun',
                    '26-30 tahun',
                    '31-35 tahun',
                    '36-40 tahun',
                    '41-45 tahun',
                    '46-50 tahun',
                    '51-55 tahun'
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'bottom'
                },
                layout: {
                    padding: {
                        left: 20,
                        right: 20,
                        top: 20,
                        bottom: 20
                    }
                }
            }
        });

        var pendidikan = new Chart(pendidikan, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: {!! json_encode($totalPendidikan) !!},
                    backgroundColor: ['#1363DF', '#F32424', '#3AB0FF', '#5FD068', '#fdaf4b', '#FF7396',
                        '#FAEA48', '#1d7af3'
                    ]
                }],

                labels: [
                    'SMA/Sederajat',
                    'S1',
                    'S2',
                    'S3',
                    'D1',
                    'D2',
                    'D3',
                    'D4'
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'bottom'
                },
                layout: {
                    padding: {
                        left: 20,
                        right: 20,
                        top: 20,
                        bottom: 20
                    }
                }
            }
        });

        var jabatan = new Chart(jabatan, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: {!! json_encode($totalJabatan) !!},
                    backgroundColor: ['#1363DF', '#F32424', '#3AB0FF', '#5FD068']
                }],

                labels: [
                    'Belum Ada',
                    'Direktur',
                    'Supervisor',
                    'Manajer',
                    'Staff'
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'bottom'
                },
                layout: {
                    padding: {
                        left: 20,
                        right: 20,
                        top: 20,
                        bottom: 20
                    }
                }
            }
        });

        var myMultipleBarChart = new Chart(multipleBarChart, {
            type: 'bar',
            data: {
                labels: {!! json_encode($tahun) !!},
                datasets: [{
                    label: "Organik REKA",
                    backgroundColor: '#59d05d',
                    borderColor: '#59d05d',
                    data: {!! json_encode($tahunOrganikREKA) !!},
                }, {
                    label: "PKWT REKA",
                    backgroundColor: '#fdaf4b',
                    borderColor: '#fdaf4b',
                    data: {!! json_encode($tahunPKWTREKA) !!},
                }, {
                    label: "Organik INKA",
                    backgroundColor: '#177dff',
                    borderColor: '#177dff',
                    data: {!! json_encode($tahunOrganikINKA) !!},
                }, {
                    label: "PKWT INKA",
                    backgroundColor: '#3AB0FF',
                    borderColor: '#3AB0FF',
                    data: {!! json_encode($tahunPKWTINKA) !!},
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'bottom'
                },
                title: {
                    display: true,
                    text: 'Traffic Stats'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false
                },
                responsive: true,
                scales: {
                    xAxes: [{
                        stacked: true,
                    }],
                    yAxes: [{
                        stacked: true
                    }]
                }
            }
        });



        $('#lineChart').sparkline([105, 103, 123, 100, 95, 105, 115], {
            type: 'line',
            height: '70',
            width: '100%',
            lineWidth: '2',
            lineColor: '#ffa534',
            fillColor: 'rgba(255, 165, 52, .14)'
        });
    </script>
@endpush
