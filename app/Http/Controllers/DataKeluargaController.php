<?php

namespace App\Http\Controllers;

use App\Models\DataAnak;
use App\Models\DataKeluarga;
use App\Models\DataPasangan;
use App\Models\Pegawai;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Exports\DataKeluargaExport;
use App\Imports\DataKeluargaImport;
use Maatwebsite\Excel\Facades\Excel;

class DataKeluargaController extends Controller
{
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
        $k = DataKeluarga::with('pegawai')
            ->get();
        $b = DB::table('data_keluarga')
            ->join('pegawai', 'pegawai.id', 'data_keluarga.id_pegawai')
            ->select([
                'pegawai.nip',
                'pegawai.nama',
                'data_keluarga.status_perkawinan',
                'data_keluarga.id',
                DB::raw('(select distinct count(*) from data_anak where data_anak.id_keluarga = data_keluarga.id) as jumlah_anak')
            ])
            ->get();
        $k = $b;
        // return response()->json($k);
        return view('pages.DataKeluarga.index', compact('k'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $p = DB::table('pegawai')
            ->select('*')
            ->whereNotIn('id', function ($q) {
                $q->select('id_pegawai')->from('data_keluarga');
            })
            ->get()
            ->sortBy('nip');
        return view('pages.DataKeluarga.create', compact('p'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([

            'id_pegawai' => 'required',
            'status_perkawinan' => 'required',
            'no_kk' => 'required|unique:data_keluarga,no_kk|digits_between:15,16',
            'status_anak' => 'required',
            'dokumen_kk' => 'required|file|mimes:pdf',
        ]);
        //  dd($request->all());
        $pegawai = Pegawai::find($request->id_pegawai);
        $file = $request->file('dokumen_kk');
        $identitas = $pegawai->nip . '-' . $pegawai->nama;
        $name = 'Dokumen_Keluarga_' . $pegawai->nip . '_' . $pegawai->nama . '_' . $this->getTanggal('date') . '.' . $file->extension();

        if (Storage::exists('public/Karyawan/' . $identitas . '/Dokumen/DataKeluarga/' . $name)) {
            Storage::delete('public/Karyawan/' . $identitas . '/Dokumen/DataKeluarga/' . $name);
        }

        $url = Storage::putFileAs('public/Karyawan/' . $identitas . '/Dokumen/DataKeluarga', $file, $name);
        DataKeluarga::create([
            'id_pegawai' => $request->id_pegawai,
            'status_perkawinan' => $request->status_perkawinan,
            'no_kk' => $request->no_kk,
            'status_anak' => $request->status_anak,
            'dokumen_kk' => $url,
        ]);
        $k = DataKeluarga::where('id_pegawai', $request->id_pegawai)->first();
        if ($k->status_perkawinan == 'Belum Menikah') {
            alert('Data Berhasil Tersimpan!')->background('#B5EDCC');
            return redirect()->route('Keluarga.index');
        } else if ($k->status_perkawinan == 'Menikah') {
            return redirect()->route('Pasangan.buat', $k->id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $keluarga = DataKeluarga::where('data_keluarga.id', $id)->first();
        $a = DataAnak::where('id_keluarga', $keluarga->id)->get();
        return view('pages.DataKeluarga.show', compact('keluarga', 'a'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $keluarga = DataKeluarga::with('pegawai')->find($id);
        return view('pages.DataKeluarga.edit', compact('keluarga'));
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
        $data = DataKeluarga::find($id);
        $rules = [
            'nama' => 'required',
            'id_pegawai' => 'required',
            'status_perkawinan' => 'required',
            'no_kk' => 'required|unique:data_keluarga,no_kk,' . $data->id . '|digits_between:15,16',
            'status_anak' => 'required',
        ];
        $customMessages = [
            'required' => ':attribute diperlukan.',
            'unique' => ':attribute telah digunakan.'
        ];
        $this->validate($request, $rules, $customMessages);
        if (!Storage::exists($data->dokumen_kk) && !$request->has('dokumen_kk')) {
            alert('Dokumen Tersimpan Tidak Ditemukan', 'Silahkan Upload Dokumen KK Baru!')->background('#FACEA8');
            return redirect()->back();
        } else {
            $data->id_pegawai = $request->id_pegawai;
            $data->status_perkawinan = $request->status_perkawinan;
            $data->no_kk = $request->no_kk;
            $data->status_anak = $request->status_anak;

            if ($request->has('dokumen_kk')) {
                $request->validate(['dokumen_kk' => 'required|file|mimes:pdf']);
                $file = $request->file('dokumen_kk');
                $identitas = $request->nip . '-' . $request->nama;
                $name = 'Dokumen_Keluarga_' . $request->nip . '_' . $request->nama . '_' . $this->getTanggal('date') . '.' . $file->extension();

                if (Storage::exists($data->dokumen_kk)) {
                    Storage::delete('public/Karyawan/' . $identitas . '/Dokumen/DataKeluarga/' . $name);
                }

                $url = Storage::putFileAs('public/Karyawan/' . $identitas . '/Dokumen/DataKeluarga/', $file, $name);
                $data->dokumen_kk = $url;
            }
            $data->save();

            if ($request->status_anak_lama == 'Ada' && $request->status_anak == 'Tidak Ada') {
                $anak = new DataAnakController();
                $anak->destroyAll($id);
            }

            $pasangan = DataPasangan::where('id_keluarga', $id)->first();
            if ($request->status_perkawinan_lama == 'Belum Menikah' && $request->status_perkawinan == 'Menikah') {
                if ($pasangan === null) {
                    $psg = new DataPasangan();
                    $psg->id_keluarga = $data->id;
                    $psg->save();
                }
                return redirect()->route('Pasangan.edit', $data->id);
            } else if ($request->status_perkawinan_lama == 'Menikah' && $request->status_perkawinan == 'Menikah') {
                if ($pasangan === null) {
                    $psg = new DataPasangan();
                    $psg->id_keluarga = $data->id;
                    $psg->save();
                }
                return redirect()->route('Pasangan.edit', $data->id);
            } else {
                alert('Data Berhasil Terupdate!')->background('#B5EDCC');
                return redirect()->route('Keluarga.index');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DataAnak::where('id_keluarga', $id)->delete();
        DataPasangan::where('id_keluarga', $id)->delete();
        DataKeluarga::find($id)->delete();
    }
    public function export()
    {
        $nama = 'report-keluarga-' . $this->getTanggal('datetime');
        $keluarga =
            DataKeluarga::leftJoin('pegawai', 'pegawai.id', 'data_keluarga.id_pegawai')
            ->select([
                'pegawai.nip',
                'pegawai.nama',
                DB::raw('CAST(no_kk AS int) as no_kk'),
                'status_perkawinan',
                'dokumen_kk',
                'status_anak',
            ])->get();
        $pasangan =
            DB::table('data_keluarga')
            ->rightJoin('data_pasangan', 'data_pasangan.id_keluarga', 'data_keluarga.id')
            ->select([
                DB::raw('CAST(data_keluarga.no_kk AS int) as no_kk'),
                'data_pasangan.nama_lengkap',
                DB::raw('CAST(data_pasangan.nik AS int) as nik'),
                'data_pasangan.jenis_kelamin',
                'data_pasangan.tempat_lahir',
                'data_pasangan.tanggal_lahir',
                'data_pasangan.agama',
                'data_pasangan.pendidikan',
                'data_pasangan.jenis_pekerjaan',
                'data_pasangan.status_pernikahan',
                'data_pasangan.status_hubungan_dalam_keluarga',
                'data_pasangan.kewarganegaraan',
                'data_pasangan.no_passport',
                'data_pasangan.no_kitap',
                'data_pasangan.nama_ayah',
                'data_pasangan.nama_ibu',
            ])->get();
        $anak =
            DB::table('data_keluarga')
            ->rightJoin('data_anak', 'data_anak.id_keluarga', 'data_keluarga.id')
            ->select([
                DB::raw('CAST(data_keluarga.no_kk AS int) as no_kk'),
                'data_anak.nama_lengkap',
                DB::raw('CAST(data_anak.nik AS int) as nik'),
                'data_anak.jenis_kelamin',
                'data_anak.tempat_lahir',
                'data_anak.tanggal_lahir',
                'data_anak.agama',
                'data_anak.pendidikan',
                'data_anak.jenis_pekerjaan',
                'data_anak.status_pernikahan',
                'data_anak.status_hubungan_dalam_keluarga',
                'data_anak.kewarganegaraan',
                'data_anak.no_passport',
                'data_anak.no_kitap',
                'data_anak.nama_ayah',
                'data_anak.nama_ibu',
            ])->get();
        if (!empty($keluarga[0]['no_kk'])) {
            return Excel::download(new DataKeluargaExport($keluarga, $pasangan, $anak), $nama . '.xlsx');
        } else {
            alert('Data Keluarga Tidak Ditemukan!')->background('#df6464');
            return redirect()->back();
        }
    }
    public function import(Request $request)
    {
        if ($request->has('file')) {
            $import = Excel::import(new DataKeluargaImport, $request->file('file'));
            if ($import) {
                alert('Data Berhasil Tersimpan!')->background('#B5EDCC');
            } else {
                alert('Import Data Gagal!')->background('#F4CACA');
            }
        }
        return redirect()->route('Keluarga.index');
    }

    public function getTanggal($tipe)
    {
        if ($tipe == 'date') {
            return Carbon::now()->format('d-m-Y');
        } else if ($tipe == 'datetime') {
            return Carbon::now()->format('d-m-Y-H-i-m');
        }
    }
}
