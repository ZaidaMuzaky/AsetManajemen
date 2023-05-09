<?php

namespace App\Http\Controllers;

use App\Exports\NipExport;
use App\Models\NIP;
use App\Models\Pegawai;
use App\Models\TipePegawai;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class NIPController extends Controller
{
    private $datanip = [
        'id_kepegawaian',
        'tahun_sk',
        'no_urut_pegawai',
        'nama_lengkap'
    ];
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function index()
    {
        $n = NIP::all();
        $tp = TipePegawai::all();
        $sk = NIP::select('tahun_sk')->distinct()->get();
        // return response()->json($sk);
        return view('pages.DataNip.index', compact('n', 'tp', 'sk'));
    }

    public function create()
    {
        $tp = TipePegawai::all()->sortBy('kode_tipe_pegawai');
        return view('pages.DataNip.create', compact('tp'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kepegawaian' => 'required|min:2|max:2',
            'tahun_sk' => 'required|min:4|max:4',
            'no_urut_pegawai' => 'required|min:5|max:5',
            'nama_lengkap' => 'required',
        ]);
        $nip = NIP::create($request->all());
        if ($nip) {
            alert('Data Berhasil Tersimpan!')->background('#B5EDCC');
        } else {
            alert('Simpan Data Gagal!')->background('#F4CACA');
        }
        return redirect()->route('NIP.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        if (Auth::user()->tipe_user == 'superadmin') {
            $nip = NIP::find($id);
            $tp = TipePegawai::all()->sortBy('kode_tipe_pegawai');
            return view('pages.DataNip.edit', compact('nip', 'tp'));
        } else {
            alert('Anda tidak memiliki hak untuk mengakses laman tersebut!')->background('#df6464');
            return redirect()->to(route('NIP.index'));
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_kepegawaian' => 'required|min:2|max:2',
            'tahun_sk' => 'required|min:4|max:4',
            'no_urut_pegawai' => 'required|min:5|max:5',
            'nama_lengkap' => 'required',
        ]);

        $nip = NIP::where('id', $id)->first();
        $nipold = $this->setNip($id);
        $pno = Pegawai::where([['nip', $nipold['nip']], ['nama', $nipold['nama']]]);
        // mengubah nip
        $nip->id_kepegawaian = $request->id_kepegawaian;
        $nip->tahun_sk = $request->tahun_sk;
        $nip->no_urut_pegawai = $request->no_urut_pegawai;
        $nip->nama_lengkap = $request->nama_lengkap;
        $nip->save();
        $ubah = $this->ubahNIPSemuaTabel($nipold, $nip, $request->id_kepegawaian, $request->nama_lengkap, $pno, $id);
        if ($ubah == 1) {
            alert('Data Berhasil Terupdate!')->background('#B5EDCC');
        } else {
            alert('Update Data Gagal!')->background('#F4CACA');
        }
        return redirect()->route('NIP.index');
    }
    public function setNip($id)
    {
        return DB::table('nip')
            ->where('id', $id)
            ->get()
            ->mapWithKeys(function ($data) {
                return [
                    'nip' => $data->id_kepegawaian . substr($data->tahun_sk, 2, 2) . $data->no_urut_pegawai,
                    'nama' => $data->nama_lengkap,
                    'tipepegawai' => $data->id_kepegawaian
                ];
            });
    }

    public function ubahNIPSemuaTabel($nipold, $nip, $id_kepegawaian, $nama_lengkap, $pno, $id)
    {
        $nipnew = $this->setNip($id);
        if ($nipnew['nip'] != $nipold['nip'] || $nipnew['nama'] != $nipold['nama']) {
            $pnb = Pegawai::where([['nip', $nipold['nip']], ['nama', $nipold['nama']]])->first();
            if ($pno->exists()) {
                $pnb->nip = $nipnew['nip'];
                if ($nip->nama_lengkap != $nipold['nama']  && $pnb->nama == $nipold['nama']) {
                    $pnb->nama = $nama_lengkap;
                }
                if ($id_kepegawaian != $nipold['tipepegawai']) {
                    $pnb->kode_tipe_pegawai = $this->getTipePegawai($id_kepegawaian, 'kode_tipe_pegawai');
                    $pnb->asal_kepegawaian = $this->getTipePegawai($id_kepegawaian, 'asal_kepegawaian');
                }
                $pnb->save();
            }
        }
        return 1;
    }
    public function getTipePegawai($kode, $tipe)
    {
        $tp = TipePegawai::where('kode_tipe_pegawai', $kode)->get(['id', 'nama_tipe_pegawai']);
        if ($tipe == 'kode_tipe_pegawai') {
            return $tp[0]['id'];
        } else if ($tipe = 'asal_kepegawaian') {
            $ak = explode(" ", $tp[0]['nama_tipe_pegawai']);
            return $ak[1];
        }
    }

    public function destroy($id)
    {
        NIP::find($id)->delete();
    }

    public function getSK(Request $request)
    {
        $sk = NIP::where('id_kepegawaian', $request->IDPegawai)->pluck('id_kepegawaian', 'tahun_sk');
        return response()->json($sk);
    }

    public function getNoUrut($id_kepegawaian, $tahun_sk)
    {
        $no = DB::table('nip')
            ->select('id_kepegawaian', 'tahun_sk', 'no_urut_pegawai')
            ->whereNotIn('nama_lengkap', function ($q) {
                $q->select('nama')->from('pegawai');
            })
            ->where([['id_kepegawaian', $id_kepegawaian], ['tahun_sk', $tahun_sk]])
            ->orderBy('no_urut_pegawai', 'ASC')
            ->pluck('tahun_sk', 'no_urut_pegawai');
        return response()->json($no);
    }
    public function getNoUrutbaru($id_kepegawaian, $tahun_sk)
    {
        $no = DB::table('nip')
            ->select('tahun_sk', 'no_urut_pegawai')
            ->where([['id_kepegawaian', $id_kepegawaian], ['tahun_sk', $tahun_sk]])
            ->orderBy('no_urut_pegawai', 'DESC')
            ->limit('1')
            ->pluck('no_urut_pegawai', 'tahun_sk');
        if (!empty(json_decode($no))) {
            return response()->json($no);
        } else {
            return response()->json([$tahun_sk => '00000']);
        }
    }

    public function getDataNip($id_kepegawaian, $tahun_sk, $no_urut_pegawai)
    {
        $data = DB::table('nip')
            ->select('id_kepegawaian', 'tahun_sk', 'no_urut_pegawai', 'nama_lengkap')
            ->whereNotIn('nama_lengkap', function ($q) {
                $q->select('nama')->from('pegawai');
            })
            ->where([
                ['id_kepegawaian', $id_kepegawaian],
                ['tahun_sk', $tahun_sk],
                ['no_urut_pegawai', $no_urut_pegawai]
            ])
            ->get()
            ->mapWithKeys(function ($data) {
                return [$data->nama_lengkap => $data->id_kepegawaian . substr($data->tahun_sk, 2, 2) . $data->no_urut_pegawai];
            });
        return response()->json($data);
    }

    public function cekNIP($id_kepegawaian, $tahun_sk, $no_urut_pegawai, $nama_lengkap)
    {
        $nip = NIP::select('nama_lengkap', 'id_kepegawaian', 'tahun_sk', 'no_urut_pegawai')
            ->where([
                ['id_kepegawaian', $id_kepegawaian],
                ['tahun_sk', $tahun_sk],
                ['no_urut_pegawai', $no_urut_pegawai]
            ]);
        // return response()->json($nip->exists());
        $oldnip = NIP::where('nama_lengkap', $nama_lengkap)->first();

        if ($nip->exists()) {
            if ($id_kepegawaian == $oldnip->id_kepegawaian && $tahun_sk == $oldnip->tahun_sk && $no_urut_pegawai == $oldnip->no_urut_pegawai) {
                return response()->json(['warning' => 'Nomor urut tidak berubah.']);
            } else {
                return response()->json(['danger' => 'NIP dengan nomor urut tersebut sudah ada.']);
            }
        } else {
            if ($no_urut_pegawai == '00000') {
                return response()->json(['danger' => 'Nomor Urut dimulai dari 00001.']);
            } else if (strlen($no_urut_pegawai) != 5) {
                return response()->json(['danger' => 'Nomor Urut Pegawai Harus 5 Karakter.']);
            } else {
                return response()->json(['success' => 'Nomor urut dapat digunakan.']);
            }
        }
    }

    public function export(Request $request)
    {
        $todayDate = Carbon::now()->format('d-m-Y-H-i-m');
        $nama = 'report-nip-' . $todayDate;
        $data = [];
        if ($request->id_kepegawaian == '' && $request->tahun_sk == '') {
            $data = NIP::get($this->datanip);
        } else if ($request->id_kepegawaian != '' && $request->tahun_sk == '') {
            $data = NIP::where('id_kepegawaian', $request->id_kepegawaian)->get($this->datanip);
        } else if ($request->id_kepegawaian == '' && $request->tahun_sk != '') {
            $data = NIP::where('tahun_sk', $request->tahun_sk)->get($this->datanip);
        } else if ($request->id_kepegawaian != '' && $request->tahun_sk != '') {
            $data = NIP::where([
                ['id_kepegawaian', $request->id_kepegawaian],
                ['tahun_sk', $request->tahun_sk]
            ])->get($this->datanip);
        }
        if (!empty($data[0]['id_kepegawaian'])) {
            return Excel::download(new NipExport($data), $nama . '.xlsx');
        } else {
            alert('Data Tidak Ditemukan!')->background('#df6464');
            return redirect()->back();
        }
    }
}
