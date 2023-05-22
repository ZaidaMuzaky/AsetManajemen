<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // // BAR CHART
        // for ($i = 1; $i < 11; $i++) {
        //     ${'OrganikREKA' . $i} = DB::select("
        //     SELECT YEAR(k.kontrak_" . $i . ") AS year_kontrak_" . $i . ", YEAR(k.selesai_kontrak_" . $i . ") AS year_selesai_kontrak_" . $i . ", t.nama_tipe_pegawai
        //     from kontrak AS k
        //     LEFT JOIN pegawai AS p
        //     ON k.id_pegawai = p.id
        //     LEFT JOIN tipe_pegawai AS t
        //     ON  p.kode_tipe_pegawai = t.id
        //     WHERE t.nama_tipe_pegawai = 'Organik REKA' AND status_karyawan ='Aktif'
        //     ");
        // }

        // for ($i = 1; $i < 11; $i++) {
        //     ${'PKWTREKA' . $i} = DB::select("
        //     SELECT YEAR(k.kontrak_" . $i . ") AS year_kontrak_" . $i . ", YEAR(k.selesai_kontrak_" . $i . ") AS year_selesai_kontrak_" . $i . ", t.nama_tipe_pegawai
        //     from kontrak AS k
        //     LEFT JOIN pegawai AS p
        //     ON k.id_pegawai = p.id
        //     LEFT JOIN tipe_pegawai AS t
        //     ON  p.kode_tipe_pegawai = t.id
        //     WHERE t.nama_tipe_pegawai = 'PKWT REKA' AND status_karyawan ='Aktif'
        //     ");
        // }


        // for ($i = 1; $i < 11; $i++) {
        //     ${'OrganikINKA' . $i} = DB::select("
        //     SELECT YEAR(k.kontrak_" . $i . ") AS year_kontrak_" . $i . ", YEAR(k.tanggal_pensiun) AS year_selesai_kontrak_" . $i . ", t.nama_tipe_pegawai
        //     from kontrak AS k
        //     LEFT JOIN pegawai AS p
        //     ON k.id_pegawai = p.id
        //     LEFT JOIN tipe_pegawai AS t
        //     ON  p.kode_tipe_pegawai = t.id
        //     WHERE t.nama_tipe_pegawai = 'Organik INKA' AND status_karyawan ='Aktif'
        //     ");
        // }

        // for ($i = 1; $i < 11; $i++) {
        //     ${'PKWTINKA' . $i} = DB::select("
        //     SELECT YEAR(k.kontrak_" . $i . ") AS year_kontrak_" . $i . ", YEAR(k.selesai_kontrak_" . $i . ") AS year_selesai_kontrak_" . $i . ", t.nama_tipe_pegawai
        //     from kontrak AS k
        //     LEFT JOIN pegawai AS p
        //     ON k.id_pegawai = p.id
        //     LEFT JOIN tipe_pegawai AS t
        //     ON  p.kode_tipe_pegawai = t.id
        //     WHERE t.nama_tipe_pegawai = 'PKWT INKA' AND status_karyawan ='Aktif'
        //     ");
        // }

        // //Mengambil tahun dari server
        // $tahunSekarang = (int) date('Y');


        // $tahunloop = ['OrganikREKA', 'PKWTREKA', 'OrganikINKA', 'PKWTINKA'];
        // $tahun = [$tahunSekarang - 6, $tahunSekarang - 5, $tahunSekarang - 4, $tahunSekarang - 3, $tahunSekarang - 2, $tahunSekarang - 1, $tahunSekarang, $tahunSekarang + 1, $tahunSekarang + 2, $tahunSekarang + 3];
        // $tahunOrganikREKA = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        // $tahunPKWTREKA = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        // $tahunOrganikINKA = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        // $tahunPKWTINKA = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        // for ($h = 0; $h < 4; $h++) {
        //     for ($i = 1; $i <= 9; $i++) {
        //         for ($j = 0; $j < count(${$tahunloop[$h] . $i}); $j++) {
        //             if (${$tahunloop[$h] . $i}[$j]->{'year_kontrak_' . $i} != 0) {
        //                 for ($k = ${$tahunloop[$h] . $i}[$j]->{'year_kontrak_' . $i}; $k <= ${$tahunloop[$h] . $i}[$j]->{'year_selesai_kontrak_' . $i}; $k++) {
        //                     for ($l = 0; $l < 10; $l++) {
        //                         if ($k == $tahun[$l]) {
        //                             ${'tahun' . $tahunloop[$h]}[$l]++;
        //                         }
        //                     }
        //                 }
        //             }
        //         }
        //     }
        // }

        // for ($h = 0; $h < 4; $h++) {
        //     for ($i = 1; $i <= 9; $i++) {
        //         for ($j = 0; $j < count(${$tahunloop[$h] . $i}); $j++) {
        //             if (${$tahunloop[$h] . $i}[$j]->{'year_kontrak_' . $i} != 0) {
        //                 for ($k = ${$tahunloop[$h] . $i}[$j]->{'year_kontrak_' . $i}; $k <= ${$tahunloop[$h] . $i}[$j]->{'year_selesai_kontrak_' . $i}; $k++) {
        //                     for ($l = 0; $l < 10; $l++) {
        //                         if ($k == $tahun[$l] && $k == ${$tahunloop[$h] . ($i + 1)}[$j]->{'year_kontrak_' . ($i + 1)} && $k == ${$tahunloop[$h] . $i}[$j]->{'year_selesai_kontrak_' . $i}) {
        //                             ${"tahun" . $tahunloop[$h]}[$l]--;
        //                         }
        //                     }
        //                 }
        //             }
        //         }
        //     }
        // }
        // // END OF BAR CHART

        // $dataGender = DB::table('pegawai')
        //     ->select(DB::raw('COUNT(jenis_kelamin) as jumlahgender, jenis_kelamin'))
        //     ->where('status_karyawan', '=', 'aktif')
        //     ->groupby('jenis_kelamin')
        //     ->orderBy('jenis_kelamin', 'ASC')
        //     ->get();

        // $totalGender = [null, null];
        // foreach ($dataGender as $key) {
        //     if ($key->jenis_kelamin == 'Perempuan') {
        //         $totalGender[1] = $key->jumlahgender;
        //     } elseif ($key->jenis_kelamin == 'Laki-Laki') {
        //         $totalGender[0] = $key->jumlahgender;
        //     }
        // }
        // // dd($dataGender);
        // $dataPendidikan = Pegawai::select(DB::raw(" pendidikan_terakhir , COUNT(pendidikan_terakhir) as total"))
        //     ->where('status_karyawan', '=', 'aktif')
        //     ->groupBy('pendidikan_terakhir')
        //     ->orderBy('pendidikan_terakhir', 'ASC')
        //     ->get();

        // $totalPendidikan = [null, null, null, null, null, null, null, null];
        // foreach ($dataPendidikan as $key) {
        //     if ($key->pendidikan_terakhir == 'SMA') {
        //         $totalPendidikan[0] = $key->total;
        //     } elseif ($key->pendidikan_terakhir == 'S1') {
        //         $totalPendidikan[1] = $key->total;
        //     } elseif ($key->pendidikan_terakhir == 'S2') {
        //         $totalPendidikan[2] = $key->total;
        //     } elseif ($key->pendidikan_terakhir == 'D3') {
        //         $totalPendidikan[3] = $key->total;
        //     } elseif ($key->pendidikan_terakhir == 'D4') {
        //         $totalPendidikan[4] = $key->total;
        //     } elseif ($key->pendidikan_terakhir == 'D1') {
        //         $totalPendidikan[5] = $key->total;
        //     } elseif ($key->pendidikan_terakhir == 'D2') {
        //         $totalPendidikan[6] = $key->total;
        //     } elseif ($key->pendidikan_terakhir == 'S3') {
        //         $totalPendidikan[7] = $key->total;
        //     }
        // }
        // // dd($totalPendidikan);

        // $dataJabatan = Pegawai::select(DB::raw(" kode_jabatan , COUNT(kode_jabatan) as jumlahjabatan"))
        //     ->where('status_karyawan', '=', 'aktif')
        //     ->groupBy('kode_jabatan')
        //     ->orderBy('kode_jabatan', 'ASC')
        //     ->get();
        // // dd($dataJabatan);

        // $totalJabatan = [null, null, null, null, null];
        // foreach ($dataJabatan as $key) {
        //     if ($key->kode_jabatan == 1) {
        //         $totalJabatan[0] = $key->jumlahjabatan;
        //     } elseif ($key->kode_jabatan == 2) {
        //         $totalJabatan[1] = $key->jumlahjabatan;
        //     } elseif ($key->kode_jabatan == 3) {
        //         $totalJabatan[2] = $key->jumlahjabatan;
        //     } elseif ($key->kode_jabatan == 4) {
        //         $totalJabatan[3] = $key->jumlahjabatan;
        //     } elseif ($key->kode_jabatan == 5) {
        //         $totalJabatan[4] = $key->jumlahjabatan;
        //     }
        // }
        // // dd($totalJabatan);
        // $dataPegawai = Pegawai::select(DB::raw(" kode_tipe_pegawai , COUNT(kode_tipe_pegawai) as jumlahpegawai"))
        //     ->where('status_karyawan', '=', 'aktif')
        //     ->groupBy('kode_tipe_pegawai')
        //     ->orderBy('kode_tipe_pegawai')
        //     ->get();
        // // dd($dataJabatan);

        // $totalPegawai = [null, null, null, null, null];
        // foreach ($dataPegawai as $key) {
        //     if ($key->kode_tipe_pegawai == 1) {
        //         $totalPegawai[0] = $key->jumlahpegawai;
        //     } elseif ($key->kode_tipe_pegawai == 2) {
        //         $totalPegawai[1] = $key->jumlahpegawai;
        //     } elseif ($key->kode_tipe_pegawai == 3) {
        //         $totalPegawai[2] = $key->jumlahpegawai;
        //     } elseif ($key->kode_tipe_pegawai == 4) {
        //         $totalPegawai[3] = $key->jumlahpegawai;
        //     }
        // }

        // $umur = DB::table('pegawai')
        //     ->select(
        //         DB::raw('COUNT(CASE WHEN umur BETWEEN 20 AND 25 THEN 1 END) as umur1'),
        //         DB::raw('COUNT(CASE WHEN umur BETWEEN 26 AND 30 THEN 1 END) as umur2'),
        //         DB::raw('COUNT(CASE WHEN umur BETWEEN 31 AND 35 THEN 1 END) as umur3'),
        //         DB::raw('COUNT(CASE WHEN umur BETWEEN 36 AND 40 THEN 1 END) as umur4'),
        //         DB::raw('COUNT(CASE WHEN umur BETWEEN 41 AND 45 THEN 1 END) as umur5'),
        //         DB::raw('COUNT(CASE WHEN umur BETWEEN 46 AND 50 THEN 1 END) as umur6'),
        //         DB::raw('COUNT(CASE WHEN umur BETWEEN 51 AND 55 THEN 1 END) as umur7'),
        //     )
        //     ->where('status_karyawan', '=', 'aktif')
        //     ->get();



        return view('dashboard',);
    }
}
