<?php

namespace App\Http\Controllers;

use App\Models\DataKeluarga;
use App\Models\DataPasangan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DataPasanganController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function show($id)
    {
        //
    }

    public function buat($id)
    {
        $keluarga = DataKeluarga::with('pegawai')->where('id', $id)->first();
        return view('pages.DataPasangan.create', compact('keluarga'));
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
            'no_passport' => 'nullable|min:7',
            'nama_ayah' => 'required',
            'nama_ibu' => 'required',
        ]);
        $pasangan = new DataPasangan();
        if (ucwords($request->kewarganegaraan) == 'Indonesia' || $request->kewarganegaraan == 'WNI') {
            $request->validate([
                'nik' => 'required|unique:data_pasangan,nik|digits_between:15,16',
                'no_kitap' => 'nullable|digits_between:7,15',
            ]);
            $pasangan->no_kitap = '';
            $pasangan->nik = $request->nik;
        } else if (ucwords($request->kewarganegaraan) != 'Indonesia' || $request->kewarganegaraan != 'WNI') {
            $request->validate([
                'nik' => 'nullable|unique:data_pasangan,nik|digits_between:15,16',
                'no_kitap' => 'required|digits_between:7,15',
            ]);
            $pasangan->nik = '';
            $pasangan->no_kitap = $request->no_kitap;
        } else {
            if ($request->nik != null) {
                $request->validate([
                    'nik' => 'required|unique:data_pasangan,nik|digits_between:15,16',
                    'no_kitap' => 'nullable|digits_between:7,15',
                ]);
                $pasangan->no_kitap = '';
                $pasangan->nik = $request->nik;
            } else {
                $request->validate([
                    'nik' => 'nullable|unique:data_pasangan,nik|digits_between:15,16',
                    'no_kitap' => 'required|digits_between:7,15',
                ]);
                $pasangan->nik = '';
                $pasangan->no_kitap = $request->no_kitap;
            }
        }
        $pasangan->nama_lengkap = ucwords($request->nama_lengkap);
        $pasangan->nik = $request->nik;
        $pasangan->jenis_kelamin = $request->jenis_kelamin;
        $pasangan->tempat_lahir = ucwords($request->tempat_lahir);
        if ($request->tanggal_lahir != null) {
            $pasangan->tanggal_lahir = Carbon::createFromFormat('d-m-Y', $request->tanggal_lahir);
        } else {
            $pasangan->tanggal_lahir = $request->tanggal_lahir;
        }
        $pasangan->agama = $request->agama;
        $pasangan->pendidikan = $request->pendidikan;
        $pasangan->jenis_pekerjaan = $request->jenis_pekerjaan;
        $pasangan->status_pernikahan = $request->status_pernikahan;
        $pasangan->status_hubungan_dalam_keluarga = $request->status_hubungan_dalam_keluarga;
        $pasangan->kewarganegaraan = ucwords($request->kewarganegaraan);
        $pasangan->no_passport = $request->no_passport;
        $pasangan->no_kitap = $request->no_kitap;
        $pasangan->nama_ayah = ucwords($request->nama_ayah);
        $pasangan->nama_ibu = ucwords($request->nama_ibu);

        $keluarga = DataKeluarga::where('id', $request->id_keluarga)->first();
        $pasangan->keluarga()->associate($keluarga);
        $pasangan->save();
        if ($keluarga->status_anak == 'Ada') {
            return redirect(route('Anak.list', $keluarga->id));
        } else if ($keluarga->status_anak == 'Tidak Ada') {
            alert('Data Berhasil Tersimpan!')->background('#B5EDCC');
            return redirect(route('Keluarga.index'));
        }
    }
    public function edit($id)
    {
        $keluarga = DataKeluarga::with('pegawai', 'pasangan')->find($id);
        // return response()->json($keluarga);
        return view('pages.DataPasangan.edit', compact('keluarga'));
    }
    public function update(Request $request, $id)
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
            'no_passport' => 'min:7|nullable',
            'nama_ayah' => 'required',
            'nama_ibu' => 'required',
        ]);
        $pasangan = DataPasangan::where('id', $id)->first();
        if (ucwords($request->kewarganegaraan) == 'Indonesia') {
            $request->validate([
                'nik' => 'required|unique:data_pasangan,nik,' . $id . '|digits_between:15,16',
                'no_kitap' => 'nullable|digits_between:7,15',
            ]);
            $pasangan->no_kitap = '';
            $pasangan->nik = $request->nik;
        } else if (ucwords($request->kewarganegaraan) != 'Indonesia') {
            $request->validate([
                'nik' => 'nullable|unique:data_pasangan,nik,' . $id . '|digits_between:15,16',
                'no_kitap' => 'required|digits_between:7,15',
            ]);
            $pasangan->nik = '';
            $pasangan->no_kitap = $request->no_kitap;
        } else {
            if ($request->nik != null) {
                $request->validate([
                    'nik' => 'required|unique:data_pasangan,nik,' . $id . '|digits_between:15,16',
                    'no_kitap' => 'nullable|digits_between:7,15',
                ]);
                $pasangan->no_kitap = '';
                $pasangan->nik = $request->nik;
            } else {
                $request->validate([
                    'nik' => 'nullable|unique:data_pasangan,nik,' . $id . '|digits_between:15,16',
                    'no_kitap' => 'required|digits_between:7,15',
                ]);
                $pasangan->nik = '';
                $pasangan->no_kitap = $request->no_kitap;
            }
        }

        // dd($request->all());
        $pasangan->nama_lengkap = ucwords($request->nama_lengkap);
        $pasangan->jenis_kelamin = $request->jenis_kelamin;
        $pasangan->tempat_lahir = ucwords($request->tempat_lahir);
        if ($request->tanggal_lahir != null) {
            $pasangan->tanggal_lahir = Carbon::createFromFormat('d-m-Y', $request->tanggal_lahir);
        } else {
            $pasangan->tanggal_lahir = $request->tanggal_lahir;
        }
        $pasangan->agama = $request->agama;
        $pasangan->pendidikan = $request->pendidikan;
        $pasangan->jenis_pekerjaan = $request->jenis_pekerjaan;
        $pasangan->status_pernikahan = $request->status_pernikahan;
        $pasangan->status_hubungan_dalam_keluarga = $request->status_hubungan_dalam_keluarga;
        $pasangan->kewarganegaraan = ucwords($request->kewarganegaraan);
        $pasangan->no_passport = $request->no_passport;
        $pasangan->nama_ayah = ucwords($request->nama_ayah);
        $pasangan->nama_ibu = ucwords($request->nama_ibu);

        $keluarga = DataKeluarga::where('id', $request->id_keluarga)->first();
        $pasangan->keluarga()->associate($keluarga);
        $pasangan->save();
        if ($keluarga->status_anak == 'Ada') {
            return redirect(route('Anak.list', $keluarga->id));
        } else if ($keluarga->status_anak == 'Tidak Ada') {
            alert('Data Berhasil Terupdate!')->background('#B5EDCC');
            return redirect(route('Keluarga.index'));
        }
    }
}
