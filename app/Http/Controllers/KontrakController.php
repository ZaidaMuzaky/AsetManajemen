<?php

namespace App\Http\Controllers;

use App\Models\Kontrak;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KontrakController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function update(Request $request, $id)
    {
        $kontrak = Kontrak::where('id_pegawai', $id)->first();
        if ($kontrak->dokumen_dasar_pensiun == null or $request->has('dokumen_dasar_pensiun')) {
            $request->validate([
                'dokumen_dasar_pensiun' => 'required|file|mimes:pdf'
            ]);
        }
        $i = 1;
        while ($i <= 10) {
            if ($request['kontrak_' . $i] != null) {

                $kontrak['kontrak_' . $i] = Carbon::createFromFormat('d-m-Y', $request['kontrak_' . $i]);

                if ($request['selesai_kontrak_' . $i] != null) {
                    $kontrak['selesai_kontrak_' . $i] = Carbon::createFromFormat('d-m-Y', $request['selesai_kontrak_' . $i]);
                } else {
                    $kontrak['selesai_kontrak_' . $i] = $request['selesai_kontrak_' . $i];
                }
            } else {
                $kontrak['kontrak_' . $i] = $request['kontrak_' . $i];
            }
            $kontrak->save();
            $i++;
        }
        if ($request['tanggal_npp'] != null) {
            $kontrak->tanggal_npp = Carbon::createFromFormat('d-m-Y', $request['tanggal_npp']);
        }
        if ($request['tanggal_pensiun'] != null) {
            $kontrak->tanggal_pensiun = Carbon::createFromFormat('d-m-Y', $request['tanggal_pensiun']);
        }
        $identitas = $request->nip . '-' . $request->nama;
        if ($request->has('dokumen_dasar_pensiun') && $request->dokumen_dasar_pensiun != '') {
            $file = $request->file('dokumen_dasar_pensiun');
            $name = 'Dokumen_Dasar_Pensiun_' . $identitas . '.' . $file->extension();
            if (Storage::exists($kontrak->dokumen_dasar_pensiun)) {
                Storage::delete($kontrak->dokumen_dasar_pensiun);
            }

            $url = Storage::putFileAs('public/Karyawan/' . $identitas . '/Dokumen/DokumenDasarPensiun', $file, $name);
            $kontrak->dokumen_dasar_pensiun = $url;
        }
        $kontrak->save();
    }
}
