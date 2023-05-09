<?php

namespace App\Http\Controllers;

use App\Models\DataSertifikasi;
use App\Models\Pegawai;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Exports\DataSertifikasiExport;
use App\Imports\DataSertifikasiImport;
use Maatwebsite\Excel\Facades\Excel;

class DataSertifikasiController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function index()
    {
        $s = DataSertifikasi::select('id_pegawai', 'p.nip', 'p.nama')
            ->addSelect(DB::raw('COUNT(data_sertifikasi.id) AS jumlah'))
            ->join('pegawai as p', 'id_pegawai', '=', 'p.id')
            ->groupBy('id_pegawai')
            ->get();
        // return response()->json($data);
        return view('pages.DataSertifikasi.index', compact('s'));
    }
    public function listsertifikasi($id_pegawai)
    {
        $pegawai = DataSertifikasi::select('id_pegawai', 'p.nama')
            ->join('pegawai as p', 'id_pegawai', '=', 'p.id')
            ->where('id_pegawai', $id_pegawai)
            ->first();
        $s = DataSertifikasi::where('id_pegawai', $id_pegawai)->get();
        return view('pages.DataSertifikasi.listsertifikasi', compact('s', 'pegawai'));
    }

    public function create()
    {
        $p = Pegawai::all()->sortBy('nip');
        return view('pages.DataSertifikasi.create', compact('p'));
    }

    public function store(Request $request)
    {
        $i = 1;
        $pegawai = Pegawai::where('id', $request['id_pegawai'])->first();

        while ($i <= $request->jumlah) {
            if (!$request->has('dokumen_data_sertifikasi_' . $i)) {
                $sertifikasi = DataSertifikasi::create([
                    'id_pegawai' => $request['id_pegawai'],
                    'nama_sertifikasi' => $request['nama_sertifikasi_' . $i],
                    'jenis_sertifikasi' => $request['jenis_sertifikasi_' . $i],
                    'bidang_sertifikasi' => $request['bidang_sertifikasi_' . $i],
                    'penyelenggara' => $request['penyelenggara_' . $i],
                    'lokasi_sertifikasi' => $request['lokasi_sertifikasi_' . $i],
                    'waktu_mulai_pelaksanaan' => Carbon::createFromFormat('d-m-Y', $request['waktu_mulai_pelaksanaan_' . $i]),
                    'waktu_selesai_pelaksanaan' => Carbon::createFromFormat('d-m-Y', $request['waktu_selesai_pelaksanaan_' . $i]),
                    'tanggal_sertifikat_diterbitkan' => Carbon::createFromFormat('d-m-Y', $request['tanggal_sertifikat_diterbitkan_' . $i]),
                    'masa_berlaku_sampai_dengan' => Carbon::createFromFormat('d-m-Y', $request['masa_berlaku_sampai_dengan_' . $i]),
                    'dokumen_data_sertifikasi' => '',
                ]);
            } else {
                // $request->validate(['dokumen_data_training_' . $i => 'required|file|mimes:pdf,jpg,png,jpeg']);
                $file = $request->file('dokumen_data_sertifikasi_' . $i);
                $identitas = $pegawai->nip . '-' . $pegawai->nama;
                $name = 'Dokumen_Sertifikasi_' . $identitas . '_' . $request['nama_sertifikasi_' . $i] . '-' . $this->getTanggal('date') . '.' . $file->extension();
                if (Storage::exists('public/Karyawan/' . $identitas . '/Dokumen/DataSertifikasi' . $name)) {
                    Storage::delete('public/Karyawan/' . $identitas . '/Dokumen/DataSertifikasi' . $name);
                }
                $url = Storage::putFileAs('public/Karyawan/' . $identitas . '/Dokumen/DataSertifikasi', $file, $name);
                $sertifikasi = DataSertifikasi::create([
                    'id_pegawai' => $request['id_pegawai'],
                    'nama_sertifikasi' => $request['nama_sertifikasi_' . $i],
                    'jenis_sertifikasi' => $request['jenis_sertifikasi_' . $i],
                    'bidang_sertifikasi' => $request['bidang_sertifikasi_' . $i],
                    'penyelenggara' => $request['penyelenggara_' . $i],
                    'lokasi_sertifikasi' => $request['lokasi_sertifikasi_' . $i],
                    'waktu_mulai_pelaksanaan' => Carbon::createFromFormat('d-m-Y', $request['waktu_mulai_pelaksanaan_' . $i]),
                    'waktu_selesai_pelaksanaan' => Carbon::createFromFormat('d-m-Y', $request['waktu_selesai_pelaksanaan_' . $i]),
                    'tanggal_sertifikat_diterbitkan' => Carbon::createFromFormat('d-m-Y', $request['tanggal_sertifikat_diterbitkan_' . $i]),
                    'masa_berlaku_sampai_dengan' => Carbon::createFromFormat('d-m-Y', $request['masa_berlaku_sampai_dengan_' . $i]),
                    'dokumen_data_sertifikasi' => $url,
                ]);
            }
            $i++;
        }
        if ($sertifikasi) {
            alert('Data Berhasil Tersimpan!')->background('#B5EDCC');
        } else {
            alert('Simpan Data Gagal!')->background('#F4CACA');
        }
        // return response()->json($t);
        return redirect(route('Sertifikasi.index'));
    }
    public function edit($id)
    {
        $sertifikasi = DataSertifikasi::find($id);
        $p = Pegawai::all()->sortBy('nip');
        return view('pages.DataSertifikasi.edit', compact('sertifikasi', 'p'));
    }
    public function update(Request $request, $id)
    {
        $pegawai = Pegawai::where('id', $request['id_pegawai'])->first();
        $data_sertifikasi = DataSertifikasi::where('id', $id)->first();
        if ($data_sertifikasi->dokumen_data_sertifikasi != null && Storage::exists($data_sertifikasi->dokumen_data_sertifikasi)) {
            $request->validate([
                'id_pegawai' => 'required',
                'nama_sertifikasi' => 'required',
                'jenis_sertifikasi' => 'required',
                'bidang_sertifikasi' => 'required',
                'penyelenggara' => 'required',
                'lokasi_sertifikasi' => 'required',
                'waktu_mulai_pelaksanaan' => 'required|date',
                'waktu_selesai_pelaksanaan' => 'required|date',
                'tanggal_sertifikat_diterbitkan' => 'required|date',
                'masa_berlaku_sampai_dengan' => 'required|date',
            ]);
        } else if ($data_sertifikasi->dokumen_data_sertifikasi != null && !Storage::exists($data_sertifikasi->dokumen_data_sertifikasi)) {
            $request->validate([
                'id_pegawai' => 'required',
                'nama_sertifikasi' => 'required',
                'jenis_sertifikasi' => 'required',
                'bidang_sertifikasi' => 'required',
                'penyelenggara' => 'required',
                'lokasi_sertifikasi' => 'required',
                'waktu_mulai_pelaksanaan' => 'required|date',
                'waktu_selesai_pelaksanaan' => 'required|date',
                'tanggal_sertifikat_diterbitkan' => 'required|date',
                'masa_berlaku_sampai_dengan' => 'required|date',
                'dokumen_data_sertifikasi' => 'required|file|mimes:pdf'
            ]);
        } else {
            $request->validate([
                'id_pegawai' => 'required',
                'nama_sertifikasi' => 'required',
                'jenis_sertifikasi' => 'required',
                'bidang_sertifikasi' => 'required',
                'penyelenggara' => 'required',
                'lokasi_sertifikasi' => 'required',
                'waktu_mulai_pelaksanaan' => 'required|date',
                'waktu_selesai_pelaksanaan' => 'required|date',
                'tanggal_sertifikat_diterbitkan' => 'required|date',
                'masa_berlaku_sampai_dengan' => 'required|date',
                'dokumen_data_sertifikasi' => 'required|file|mimes:pdf'
            ]);
        }
        $identitas = $pegawai->nip . '-' . $pegawai->nama;
        $data_sertifikasi->id_pegawai = $request['id_pegawai'];
        $data_sertifikasi->nama_sertifikasi = $request['nama_sertifikasi'];
        $data_sertifikasi->jenis_sertifikasi = $request['jenis_sertifikasi'];
        $data_sertifikasi->bidang_sertifikasi = $request['bidang_sertifikasi'];
        $data_sertifikasi->penyelenggara = $request['penyelenggara'];
        $data_sertifikasi->lokasi_sertifikasi = $request['lokasi_sertifikasi'];
        if ($request->has('waktu_mulai_pelaksanaan')) {
            $data_sertifikasi->waktu_mulai_pelaksanaan = Carbon::createFromFormat('d-m-Y', $request['waktu_mulai_pelaksanaan']);
        } else {
            $data_sertifikasi->waktu_mulai_pelaksanaan = $request['waktu_mulai_pelaksanaan'];
        }
        if ($request->has('waktu_selesai_pelaksanaan')) {
            $data_sertifikasi->waktu_selesai_pelaksanaan = Carbon::createFromFormat('d-m-Y', $request['waktu_selesai_pelaksanaan']);
        } else {
            $data_sertifikasi->waktu_selesai_pelaksanaan = $request['waktu_selesai_pelaksanaan'];
        }
        if ($request->has('tanggal_sertifikat_diterbitkan')) {
            $data_sertifikasi->tanggal_sertifikat_diterbitkan = Carbon::createFromFormat('d-m-Y', $request['tanggal_sertifikat_diterbitkan']);
        } else {
            $data_sertifikasi->tanggal_sertifikat_diterbitkan = $request['tanggal_sertifikat_diterbitkan'];
        }
        if ($request->has('masa_berlaku_sampai_dengan')) {
            $data_sertifikasi->masa_berlaku_sampai_dengan = Carbon::createFromFormat('d-m-Y', $request['masa_berlaku_sampai_dengan']);
        } else {
            $data_sertifikasi->masa_berlaku_sampai_dengan = $request['masa_berlaku_sampai_dengan'];
        }
        if ($request->has('dokumen_data_sertifikasi') && $request->dokumen_data_sertifikasi != '') {
            $file = $request->file('dokumen_data_sertifikasi');
            $name = 'Dokumen_sertifikasi_' . $identitas . '_' . $request['nama_sertifikasi'] . '-' . $this->getTanggal('date') . '.' . $file->extension();

            if (Storage::exists($data_sertifikasi->dokumen_data_sertifikasi)) {
                Storage::delete($data_sertifikasi->dokumen_data_sertifikasi);
            }
            $url = Storage::putFileAs('public/Karyawan/' . $identitas . '/Dokumen/DataSertifikasi', $file, $name);
            $data_sertifikasi->dokumen_data_sertifikasi = $url;
        }
        if ($data_sertifikasi->save()) {
            alert('Data Berhasil Terupdate!')->background('#B5EDCC');
        } else {
            alert('Update Data Gagal!')->background('#F4CACA');
        }
        return redirect(route('Sertifikasi.list', $request->id_pegawai));
    }

    public function show($id)
    {
        $sertifikasi = DataSertifikasi::with('pegawai')->find($id);
        return view('pages.DataSertifikasi.detail', compact('sertifikasi'));
    }
    public function destroy($id)
    {
        $ds = DataSertifikasi::where('id', $id)->first();
        if (Storage::exists($ds->dokumen_data_sertifikasi)) {
            Storage::delete($ds->dokumen_data_sertifikasi);
        }
        $ds->delete();
    }
    public function destroyall($id)
    {
        $ds = DataSertifikasi::where('id_pegawai', $id);
        $data = $ds->get();
        foreach ($data as $d) {
            if (Storage::exists($d->dokumen_data_sertifikasi)) {
                Storage::delete($d->dokumen_data_sertifikasi);
            }
        }
        $ds->delete();
    }
    public function export()
    {
        $nama = 'report-sertifikasi-' . $this->getTanggal('datetime');

        $data = DataSertifikasi::join('pegawai', 'pegawai.id', 'data_sertifikasi.id_pegawai')
            ->select([
                'pegawai.nip',
                'pegawai.nama',
                'nama_sertifikasi',
                'jenis_sertifikasi',
                'bidang_sertifikasi',
                'penyelenggara',
                'lokasi_sertifikasi',
                'waktu_mulai_pelaksanaan',
                'waktu_selesai_pelaksanaan',
                'tanggal_sertifikat_diterbitkan',
                'masa_berlaku_sampai_dengan',
                'dokumen_data_sertifikasi'
            ])
            ->get();
        // return response()->json($a);
        if (!empty($data[0]['nama_sertifikasi'])) {
            return Excel::download(new DataSertifikasiExport($data), $nama . '.xlsx');
        } else {
            alert('Data Sertifikasi Tidak Ditemukan!')->background('#df6464');
            return redirect()->back();
        }
    }
    public function import(Request $request)
    {
        if ($request->has('file')) {
            $import = Excel::import(new DataSertifikasiImport, $request->file('file'));
            if ($import) {
                alert('Data Berhasil Tersimpan!')->background('#B5EDCC');
            } else {
                alert('Simpan Data Gagal!')->background('#F4CACA');
            }
        }
        return redirect()->route('Sertifikasi.index');
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
