<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DataAsetController extends Controller
{

    private $dataexport = [
        'nip',
        'nama',
        'status_karyawan',
        'kontrak.kontrak_1',
        'kontrak.selesai_kontrak_1',
        'kontrak.kontrak_2',
        'kontrak.selesai_kontrak_2',
        'kontrak.kontrak_3',
        'kontrak.selesai_kontrak_3',
        'kontrak.kontrak_4',
        'kontrak.selesai_kontrak_4',
        'kontrak.kontrak_5',
        'kontrak.selesai_kontrak_5',
        'kontrak.kontrak_6',
        'kontrak.selesai_kontrak_6',
        'kontrak.kontrak_7',
        'kontrak.selesai_kontrak_7',
        'kontrak.kontrak_8',
        'kontrak.selesai_kontrak_8',
        'kontrak.kontrak_9',
        'kontrak.selesai_kontrak_9',
        'kontrak.kontrak_10',
        'kontrak.selesai_kontrak_10',
        'kontrak.tanggal_npp',
        'kontrak.tanggal_pensiun',
        'kontrak.dokumen_dasar_pensiun',
        'masa_kerja',
        'asal_kepegawaian',
        'jenis_kelamin',
        'pendidikan_terakhir',
        'pendidikan_tnt',
        'jurusan_pendidikan',
        'sekolah_universitas',
        'pendidikan_diakui',
        'tempat_lahir',
        'tanggal_lahir',
        'umur',
        'agama',
        'status_hubungan_dalam_keluarga',
        'nama_ayah',
        'nama_ibu',
        'alamat_ktp',
        'alamat_domisili',
        'kota_asal',
        'no_ktp',
        'kewarganegaraan',
        'no_passport',
        'no_kitap',
        'no_bpjs_kesehatan',
        'no_bpjs_ketenagakerjaan',
        'nama_bank',
        'no_rekening_gaji',
        'no_rekening_ppip',
        'npwp',
        'no_handphone',
        'email',
        'unit_kerja',
        'departemen',
        'division',
        'foto_pegawai',
        'jabatan.nama_jabatan',
        'tipe_pegawai.nama_tipe_pegawai',
    ];

    public function __construct()
    {
        $this->middleware(['auth']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $k = Pegawai::with('tipepegawai', 'jabatan')
            ->orderBy('status_karyawanf')
            ->get();
        $tp = TipePegawai::all();
        return view('pages.DataAset.index', compact('k', 'tp'));
    }
    public function getDataKaryawan()
    {
        $data = Pegawai::with('tipepegawai', 'kontrak')->get();
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $n = NIP::all();
        $tp = TipePegawai::all();
        return view('pages.DataKaryawan.create', compact('n', 'tp'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|unique:pegawai,pegawai.nip',
            'nama_lengkap' => 'required',
            'id_kepegawaian' => 'required'
        ]);

        Pegawai::create([
            'nip' => $request->nip,
            'nama' => $request->nama_lengkap,
            'kode_tipe_pegawai' => $this->getTipePegawai($request->id_kepegawaian, 'kode_tipe_pegawai'),
            'kode_jabatan' => '1',
            'asal_kepegawaian' => $this->getTipePegawai($request->id_kepegawaian, 'asal_kepegawaian')
        ]);
        $pegawai = Pegawai::where('nip', $request->nip)->first();
        $kontrak = new Kontrak;
        $kontrak->id_pegawai = $pegawai->id;
        if ($kontrak->save()) {
            alert('Data Berhasil Tersimpan!')->background('#B5EDCC');
        } else {
            alert('Simpan Data Gagal!')->background('#F4CACA');
        }
        return redirect()->route('Karyawan.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $k = Pegawai::with('tipepegawai', 'kontrak', 'jabatan')->where('id', $id)->get();
        return view('pages.DataKaryawan.detail', compact('k'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $p = Pegawai::with('kontrak')->where('id', $id)->get();
        $tp = TipePegawai::all();
        $j = Jabatan::all();
        $d = Division::all();
        return view('pages.DataKaryawan.edit', compact('p', 'tp', 'j', 'd'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nip' => 'required|numeric',
            'nama' => 'required',
            'status_karyawan' => 'required',
            'masa_kerja' => 'required',
            'asal_kepegawaian' => 'required',
            'jenis_kelamin' => 'required',
            'pendidikan_terakhir' => 'required',
            'pendidikan_tnt' => 'required',
            'jurusan_pendidikan' => 'required',
            'sekolah_universitas' => 'required',
            'pendidikan_diakui' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'umur' => 'required',
            'agama' => 'required',
            'status_hubungan_dalam_keluarga' => 'required',
            'nama_ayah' => 'required',
            'nama_ibu' => 'required',
            'alamat_ktp' => 'required',
            'alamat_domisili' => 'required',
            'kota_asal' => 'required',
            'kewarganegaraan' => 'required',
            'no_bpjs_kesehatan' => 'required|numeric',
            'no_bpjs_ketenagakerjaan' => 'required|numeric',
            'nama_bank' => 'required',
            'no_rekening_gaji' => 'required|numeric',
            'no_rekening_ppip' => 'required|numeric',
            'npwp' => 'required|numeric',
            'no_handphone' => 'required|numeric',
            'no_passport' => 'nullable|numeric',
            'email' => 'required|email',
            'unit_kerja' => 'required',
            'departemen' => 'required',
            'division' => 'required',
            'kode_jabatan'  => 'required',
            'kode_tipe_pegawai' => 'required',
            'kontrak_1' => 'required|date',
            'selesai_kontrak_1' => 'required|date',
            'tanggal_npp' => 'nullable',
            'tanggal_pensiun' => 'required',
        ]);
        // dd($request->all());
        $pegawai = Pegawai::where('id', $id)->first();
        if (ucwords($request->kewarganegaraan) == 'Indonesia' || $request->kewarganegaraan == 'WNI') {
            $request->validate([
                'no_ktp' => 'required|unique:pegawai,no_ktp,' . $id . '|digits_between:15,16',
                'no_kitap' => 'nullable|digits_between:7,15',
            ]);
            $pegawai->no_kitap = '';
            $pegawai->no_ktp = $request->no_ktp;
        } else if (ucwords($request->kewarganegaraan) != 'Indonesia' || $request->kewarganegaraan != 'WNI') {
            $request->validate([
                'no_ktp' => 'nullable|unique:pegawai,no_ktp,' . $id . '|digits_between:15,16',
                'no_kitap' => 'required|digits_between:7,15',
            ]);
            $pegawai->no_ktp = '';
            $pegawai->no_kitap = $request->no_kitap;
        } else {
            if ($request->no_ktp != null) {
                $request->validate([
                    'no_ktp' => 'required|unique:pegawai,no_ktp,' . $id . '|digits_between:15,16',
                    'no_kitap' => 'nullable|digits_between:7,15',
                ]);
                $pegawai->no_kitap = '';
                $pegawai->no_ktp = $request->no_ktp;
            } else {
                $request->validate([
                    'no_ktp' => 'nullable|unique:pegawai,no_ktp,' . $id . '|digits_between:15,16',
                    'no_kitap' => 'required|digits_between:7,15',
                ]);
                $pegawai->no_ktp = '';
                $pegawai->no_kitap = $request->no_kitap;
            }
        }
        $oldnama = $pegawai->nama;
        $nip = NIP::where('nama_lengkap', $oldnama)->first();
        if ($nip != null) {
            if ($request->nama != $oldnama && $nip->nama_lengkap == $oldnama) {
                $nip->nama_lengkap = $request->nama;
                $nip->save();
            }
        }

        // Kontrak ditangani oleh KontrakController
        $kontrak = new KontrakController();
        $kontrak->update($request, $pegawai->id);

        $identitas = $pegawai->nip . '-' . $pegawai->nama;
        if ($request->has('foto_pegawai') or $pegawai->foto_pegawai == null) {
            $request->validate([
                'foto_pegawai' => 'required|file|mimes:jpg,png,jpeg'
            ]);
        }

        // Data Pegawai (Pribadi dan Kelengkapan)
        $pegawai->nip = $request->nip;
        $pegawai->nama = ucwords($request->nama);
        $pegawai->status_karyawan = $request->status_karyawan;
        $pegawai->masa_kerja = ucwords($request->masa_kerja);
        $pegawai->asal_kepegawaian = $request->asal_kepegawaian;
        $pegawai->jenis_kelamin = $request->jenis_kelamin;
        $pegawai->pendidikan_terakhir = $request->pendidikan_terakhir;
        $pegawai->pendidikan_tnt = $request->pendidikan_tnt;
        $pegawai->jurusan_pendidikan = ucfirst($request->jurusan_pendidikan);
        $pegawai->sekolah_universitas = ucwords($request->sekolah_universitas);
        $pegawai->pendidikan_diakui = ucfirst($request->pendidikan_diakui);
        $pegawai->tempat_lahir = ucwords($request->tempat_lahir);
        if ($request->tanggal_lahir != null) {
            $pegawai->tanggal_lahir = Carbon::createFromFormat('d-m-Y', $request->tanggal_lahir);
        } else {
            $pegawai->tanggal_lahir = $request->tanggal_lahir;
        }
        $pegawai->umur = $request->umur;
        $pegawai->agama = ucfirst($request->agama);
        $pegawai->status_hubungan_dalam_keluarga = ucfirst($request->status_hubungan_dalam_keluarga);
        $pegawai->nama_ayah = ucwords($request->nama_ayah);
        $pegawai->nama_ibu = ucwords($request->nama_ibu);
        $pegawai->alamat_ktp = ucwords($request->alamat_ktp);
        $pegawai->alamat_domisili = ucwords($request->alamat_domisili);
        $pegawai->kota_asal = ucwords($request->kota_asal);
        $pegawai->kewarganegaraan = ucwords($request->kewarganegaraan);
        $pegawai->no_bpjs_kesehatan = $request->no_bpjs_kesehatan;
        $pegawai->no_passport = $request->no_passport;
        $pegawai->no_bpjs_ketenagakerjaan = $request->no_bpjs_ketenagakerjaan;
        $pegawai->nama_bank = ucwords($request->nama_bank);
        $pegawai->no_rekening_gaji = $request->no_rekening_gaji;
        $pegawai->no_rekening_ppip = $request->no_rekening_ppip;
        $pegawai->npwp = $request->npwp;
        $pegawai->no_handphone = $request->no_handphone;
        $pegawai->email = $request->email;
        $pegawai->unit_kerja = $request->unit_kerja;
        $pegawai->departemen = $request->departemen;
        $pegawai->division = $request->division;
        $pegawai->kode_jabatan = $request->kode_jabatan;
        $pegawai->kode_tipe_pegawai = $request->kode_tipe_pegawai;

        if ($request->has('foto_pegawai') && $request->foto_pegawai != '') {
            $file = $request->file('foto_pegawai');
            $name = 'Pegawai_Reka_' . $identitas . '.' . $file->extension();

            if (Storage::exists($pegawai->foto_pegawai)) {
                Storage::delete($pegawai->foto_pegawai);
            }

            $url = Storage::putFileAs('public/Karyawan/' . $identitas . '/foto/Karyawan', $file, $name);
            $pegawai->foto_pegawai = $url;
        }
        if ($pegawai->save()) {
            alert('Data Berhasil Terupdate!')->background('#B5EDCC');
        } else {
            alert('Update Data Gagal!')->background('#F4CACA');
        }
        return redirect()->route('Karyawan.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pegawai = Pegawai::find($id);
        Kontrak::where('id_pegawai', $id)->delete();
        $t = new DataTrainingController();
        $t->destroyall($id);
        $s = new DataSertifikasiController();
        $s->destroyall($id);
        $keluarga = DataKeluarga::where('id_pegawai', $id)->first();
        if (!empty($keluarga->id)) {
            $kc = new DataKeluargaController();
            $kc->destroy($keluarga->id);
        }
        $pegawai->delete();
        // return redirect()->route('Karyawan.index');
    }

    public function export(Request $request)
    {
        $todayDate = Carbon::now()->format('d-m-Y-H-i-m');
        $nama = 'report-pegawai-' . $todayDate;
        $data = [];
        if ($request->kode_tipe_pegawai == '' && $request->asal_kepegawaian == '') {
            $data =  Pegawai::join('kontrak', 'kontrak.id_pegawai', 'pegawai.id')
                ->join('jabatan', 'jabatan.id', 'pegawai.kode_jabatan')
                ->join('tipe_pegawai', 'tipe_pegawai.id', 'pegawai.kode_tipe_pegawai')
                ->orderBy('nama', 'ASC')
                ->get($this->dataexport);
        } elseif ($request->kode_tipe_pegawai != '' && $request->asal_kepegawaian == '') {
            $data =  Pegawai::join('kontrak', 'kontrak.id_pegawai', 'pegawai.id')
                ->join('jabatan', 'jabatan.id', 'pegawai.kode_jabatan')
                ->join('tipe_pegawai', 'tipe_pegawai.id', 'pegawai.kode_tipe_pegawai')
                ->orderBy('nama', 'ASC')
                ->where('pegawai.kode_tipe_pegawai', $request->kode_tipe_pegawai)
                ->get($this->dataexport);
        } elseif ($request->kode_tipe_pegawai == '' && $request->asal_kepegawaian != '') {
            $data =  Pegawai::join('kontrak', 'kontrak.id_pegawai', 'pegawai.id')
                ->join('jabatan', 'jabatan.id', 'pegawai.kode_jabatan')
                ->join('tipe_pegawai', 'tipe_pegawai.id', 'pegawai.kode_tipe_pegawai')
                ->orderBy('nama', 'ASC')
                ->where('pegawai.asal_kepegawaian', $request->asal_kepegawaian)
                ->get($this->dataexport);
        } elseif ($request->kode_tipe_pegawai != '' && $request->kode_tipe_pegawai != '') {
            $data =  Pegawai::join('kontrak', 'kontrak.id_pegawai', 'pegawai.id')
                ->join('jabatan', 'jabatan.id', 'pegawai.kode_jabatan')
                ->join('tipe_pegawai', 'tipe_pegawai.id', 'pegawai.kode_tipe_pegawai')
                ->orderBy('nama', 'ASC')
                ->where([
                    ['pegawai.kode_tipe_pegawai', $request->kode_tipe_pegawai],
                    ['pegawai.asal_kepegawaian', $request->asal_kepegawaian]
                ])
                ->get($this->dataexport);
        }
        if (!empty($data[0]['nip'])) {
            return Excel::download(new PegawaiExport($data), $nama . '.xlsx');
        } else {
            alert('Data Tidak Ditemukan!')->background('#df6464');
            return redirect()->back();
        }
    }
    public function import(Request $request)
    {
        if ($request->has('file')) {
            $import = Excel::import(new PegawaiImport, $request->file('file'));
            if ($import) {
                alert('Data Berhasil Tersimpan!')->background('#B5EDCC');
            } else {
                alert('Simpan Data Gagal!')->background('#F4CACA');
            }
        }
        return redirect()->route('Karyawan.index');
    }
    public function getUnitKerja($nama)
    {
        $divisi = Division::where('nama_divisi', $nama)->first();
        $uk = UnitKerja::where('division_id', $divisi->id)->pluck('nama_unit_kerja', 'id');
        return response()->json($uk);
    }
}
