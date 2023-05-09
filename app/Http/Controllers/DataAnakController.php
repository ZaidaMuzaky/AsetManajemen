<?php

namespace App\Http\Controllers;

use App\Models\DataAnak;
use App\Models\DataKeluarga;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DataAnakController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function buat($id)
    {
        $keluarga = DataKeluarga::with('pegawai', 'pasangan')->where('id', $id)->first();
        return view('pages.DataAnak.create', compact('keluarga'));
        // return response()->json($keluarga);
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date|date_format:d-m-Y',
            'agama' => 'required',
            'pendidikan' => 'required',
            'jenis_pekerjaan' => 'required',
            'status_pernikahan' => 'required',
            'status_hubungan_dalam_keluarga' => 'required',
            'kewarganegaraan' => 'required',
            'no_passport' => 'numeric|min:7|nullable',
            'no_kitap' => 'numeric|min:7|nullable',
            'nama_ayah' => 'required',
            'nama_ibu' => 'required',
        ]);
        // dd($request->all());
        $anak = new DataAnak();
        if (ucwords($request->kewarganegaraan) == 'Indonesia' || $request->kewarganegaraan == 'WNI') {
            $request->validate([
                'nik' => 'required|unique:data_anak,nik|digits_between:15,16',
                'no_kitap' => 'nullable|digits_between:7,15',
            ]);
            $anak->no_kitap = '';
            $anak->nik = $request->nik;
        } else if (ucwords($request->kewarganegaraan) != 'Indonesia' || $request->kewarganegaraan == 'WNI') {
            $request->validate([
                'nik' => 'nullable|unique:data_anak,nik|digits_between:15,16',
                'no_kitap' => 'required|digits_between:7,15',
            ]);
            $anak->nik = '';
            $anak->no_kitap = $request->no_kitap;
        } else {
            if ($request->nik != null) {
                $request->validate([
                    'nik' => 'required|unique:data_anak,nik|digits_between:15,16',
                    'no_kitap' => 'nullable|digits_between:7,15',
                ]);
                $anak->no_kitap = '';
                $anak->nik = $request->nik;
            } else {
                $request->validate([
                    'nik' => 'nullable|unique:data_anak,nik|digits_between:15,16',
                    'no_kitap' => 'required|digits_between:7,15',
                ]);
                $anak->nik = '';
                $anak->no_kitap = $request->no_kitap;
            }
        }
        $anak->nama_lengkap = ucwords($request->nama_lengkap);
        $anak->jenis_kelamin = $request->jenis_kelamin;
        $anak->tempat_lahir = ucwords($request->tempat_lahir);
        if ($request->tanggal_lahir != null) {
            $anak->tanggal_lahir = Carbon::createFromFormat('d-m-Y', $request->tanggal_lahir);
        } else {
            $anak->tanggal_lahir = $request->tanggal_lahir;
        }
        $anak->agama = $request->agama;
        $anak->pendidikan = $request->pendidikan;
        $anak->jenis_pekerjaan = $request->jenis_pekerjaan;
        $anak->status_pernikahan = $request->status_pernikahan;
        $anak->status_hubungan_dalam_keluarga = $request->status_hubungan_dalam_keluarga;
        $anak->kewarganegaraan = ucwords($request->kewarganegaraan);
        $anak->no_passport = $request->no_passport;
        $anak->nama_ayah = ucwords($request->nama_ayah);
        $anak->nama_ibu = ucwords($request->nama_ibu);

        $keluarga = DataKeluarga::where('id', $request->id_keluarga)->first();
        $anak->keluarga()->associate($keluarga);
        if ($anak->save()) {
            alert('Data Berhasil Tersimpan!')->background('#B5EDCC');
        } else {
            alert('Simpan Data Gagal!')->background('#F4CACA');
        }
        return redirect(route('Anak.list', $keluarga->id));
    }
    public function list($id)
    {
        $keluarga = DataKeluarga::with('pegawai', 'pasangan', 'anak')->find($id);
        $a = DataAnak::where('id_keluarga', $keluarga->id)->get();
        // return response()->json($keluarga);
        return view('pages.DataAnak.list', compact('keluarga', 'a'));
    }
    public function edit($id)
    {
        $anak = DataAnak::find($id);
        $keluarga = DataKeluarga::with('pegawai', 'pasangan')->where('id', $anak->id_keluarga)->first();
        // return response()->json($anak);
        return view('pages.DataAnak.edit', compact('anak', 'keluarga'));
    }
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'nama_lengkap' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date|date_format:d-m-Y',
            'agama' => 'required',
            'pendidikan' => 'required',
            'jenis_pekerjaan' => 'required',
            'status_pernikahan' => 'required',
            'status_hubungan_dalam_keluarga' => 'required',
            'kewarganegaraan' => 'required',
            'no_passport' => 'min:7|nullable',
            'nama_ayah' => 'required',
            'nama_ibu' => 'required',
        ]);
        $anak = DataAnak::where('id', $id)->first();
        if (ucwords($request->kewarganegaraan) == 'Indonesia') {
            $request->validate([
                'nik' => 'required|unique:data_anak,nik,' . $id . '|digits_between:15,16',
                'no_kitap' => 'nullable|digits_between:7,15',
            ]);
            $anak->no_kitap = '';
            $anak->nik = $request->nik;
        } else if (ucwords($request->kewarganegaraan) != 'Indonesia') {
            $request->validate([
                'nik' => 'nullable|unique:data_anak,nik,' . $id . '|digits_between:15,16',
                'no_kitap' => 'required|digits_between:7,15',
            ]);
            $anak->nik = '';
            $anak->no_kitap = $request->no_kitap;
        } else {
            if ($request->nik != null) {
                $request->validate([
                    'nik' => 'required|unique:data_anak,nik,' . $id . '|digits_between:15,16',
                    'no_kitap' => 'nullable|digits_between:7,15',
                ]);
                $anak->no_kitap = '';
                $anak->nik = $request->nik;
            } else {
                $request->validate([
                    'nik' => 'nullable|unique:data_anak,nik,' . $id . '|digits_between:15,16',
                    'no_kitap' => 'required|digits_between:7,15',
                ]);
                $anak->nik = '';
                $anak->no_kitap = $request->no_kitap;
            }
        }
        $anak->nama_lengkap = ucwords($request->nama_lengkap);
        $anak->jenis_kelamin = $request->jenis_kelamin;
        $anak->tempat_lahir = ucwords($request->tempat_lahir);
        if ($request->tanggal_lahir != null) {
            $anak->tanggal_lahir = Carbon::createFromFormat('d-m-Y', $request->tanggal_lahir);
        } else {
            $anak->tanggal_lahir = $request->tanggal_lahir;
        }
        $anak->agama = $request->agama;
        $anak->pendidikan = $request->pendidikan;
        $anak->jenis_pekerjaan = $request->jenis_pekerjaan;
        $anak->status_pernikahan = $request->status_pernikahan;
        $anak->status_hubungan_dalam_keluarga = $request->status_hubungan_dalam_keluarga;
        $anak->kewarganegaraan = ucwords($request->kewarganegaraan);
        $anak->no_passport = $request->no_passport;
        $anak->nama_ayah = ucwords($request->nama_ayah);
        $anak->nama_ibu = ucwords($request->nama_ibu);

        $keluarga = DataKeluarga::where('id', $request->id_keluarga)->first();
        $anak->keluarga()->associate($keluarga);
        if ($anak->save()) {
            alert('Data Berhasil Terupdate!')->background('#B5EDCC');
        } else {
            alert('Update Data Gagal!')->background('#F4CACA');
        }
        return redirect(route('Anak.list', $anak->id_keluarga));
    }

    public function show($id)
    {
        $anak = DataAnak::find($id);
        $keluarga = DataKeluarga::with('pegawai', 'pasangan')->where('id', $anak->id_keluarga)->first();
        // return response()->json($keluarga);
        return view('pages.DataAnak.show', compact('anak', 'keluarga'));
    }


    public function destroy($id)
    {
        DataAnak::find($id)->delete();
    }
    public function saveDataKeluarga()
    {
        alert('Data Berhasil Tersimpan!')->background('#B5EDCC');
        return redirect(route('Keluarga.index'));
    }
    public function destroyAll($id_keluarga)
    {
        DataAnak::where('id_keluarga', $id_keluarga)->delete();
    }
}
