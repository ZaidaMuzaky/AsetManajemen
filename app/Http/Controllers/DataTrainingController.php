<?php

namespace App\Http\Controllers;

use App\Models\DataTraining;
use App\Models\Pegawai;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Exports\DataTrainingExport;
use App\Imports\DataTrainingImport;
use Maatwebsite\Excel\Facades\Excel;

class DataTrainingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function index()
    {
        $t = DataTraining::select('id_pegawai', 'p.nip', 'p.nama')
            ->addSelect(DB::raw('COUNT(data_training.id) AS jumlah'))
            ->join('pegawai as p', 'id_pegawai', '=', 'p.id')
            ->groupBy('id_pegawai')
            ->get();
        // return response()->json($data);
        return view('pages.DataTraining.index', compact('t'));
    }
    public function listtraining($id_pegawai)
    {
        $pegawai = DataTraining::select('id_pegawai', 'p.nama')
            ->join('pegawai as p', 'id_pegawai', '=', 'p.id')
            ->where('id_pegawai', $id_pegawai)
            ->first();
        $t = DataTraining::where('id_pegawai', $id_pegawai)->get();
        return view('pages.DataTraining.listtraining', compact('t', 'pegawai'));
    }

    public function create()
    {
        $p = Pegawai::all()->sortBy('nip');
        return view('pages.DataTraining.create', compact('p'));
    }

    public function store(Request $request)
    {
        $i = 1;
        $pegawai = Pegawai::where('id', $request['id_pegawai'])->first();

        while ($i <= $request->jumlah) {
            if (!$request->has('dokumen_data_training_' . $i)) {
                $training = DataTraining::create([
                    'id_pegawai' => $request['id_pegawai'],
                    'nama_training' => $request['nama_training_' . $i],
                    'bidang_training' => $request['bidang_training_' . $i],
                    'jenis_training' => $request['jenis_training_' . $i],
                    'penyelenggara' => $request['penyelenggara_' . $i],
                    'lokasi_training' => $request['lokasi_training_' . $i],
                    'waktu_mulai_pelaksanaan' => Carbon::createFromFormat('d-m-Y', $request['waktu_mulai_pelaksanaan_' . $i]),
                    'waktu_selesai_pelaksanaan' => Carbon::createFromFormat('d-m-Y', $request['waktu_selesai_pelaksanaan_' . $i]),
                    'dokumen_data_training' => '',
                ]);
            } else {
                // $request->validate(['dokumen_data_training_' . $i => 'required|file|mimes:pdf,jpg,png,jpeg']);
                $file = $request->file('dokumen_data_training_' . $i);
                $identitas = $pegawai->nip . '-' . $pegawai->nama;
                $name = 'Dokumen_Training_' . $identitas . '_' . $request['nama_training_' . $i] . '-' . $this->getTanggal('date') . '.' . $file->extension();
                if (Storage::exists('public/Karyawan/' . $identitas . '/Dokumen/DataTraining' . $name)) {
                    Storage::delete('public/Karyawan/' . $identitas . '/Dokumen/DataTraining' . $name);
                }
                $url = Storage::putFileAs('public/Karyawan/' . $identitas . '/Dokumen/DataTraining', $file, $name);
                $training = DataTraining::create([
                    'id_pegawai' => $request['id_pegawai'],
                    'nama_training' => $request['nama_training_' . $i],
                    'bidang_training' => $request['bidang_training_' . $i],
                    'jenis_training' => $request['jenis_training_' . $i],
                    'penyelenggara' => $request['penyelenggara_' . $i],
                    'lokasi_training' => $request['lokasi_training_' . $i],
                    'waktu_mulai_pelaksanaan' => Carbon::createFromFormat('d-m-Y', $request['waktu_mulai_pelaksanaan_' . $i]),
                    'waktu_selesai_pelaksanaan' => Carbon::createFromFormat('d-m-Y', $request['waktu_selesai_pelaksanaan_' . $i]),
                    'dokumen_data_training' => $url,
                ]);
            }
            $i++;
        }
        if ($training) {
            alert('Data Berhasil Tersimpan!')->background('#B5EDCC');
        } else {
            alert('Simpan Data Gagal!')->background('#F4CACA');
        }
        // return response()->json($t);
        return redirect(route('Training.index'));
    }
    public function edit($id)
    {
        $training = DataTraining::find($id);
        $p = Pegawai::all()->sortBy('nip');
        return view('pages.DataTraining.edit', compact('training', 'p'));
    }
    public function update(Request $request, $id)
    {
        $pegawai = Pegawai::where('id', $request['id_pegawai'])->first();
        $data_training = DataTraining::where('id', $id)->first();
        if ($data_training->dokumen_data_training != null && Storage::exists($data_training->dokumen_data_training)) {
            $request->validate([
                'id_pegawai' => 'required',
                'nama_training' => 'required',
                'bidang_training' => 'required',
                'jenis_training' => 'required',
                'penyelenggara' => 'required',
                'lokasi_training' => 'required',
                'waktu_mulai_pelaksanaan' => 'required|date',
                'waktu_selesai_pelaksanaan' => 'required|date',
            ]);
        } else if ($data_training->dokumen_data_training != null && !Storage::exists($data_training->dokumen_data_training)) {
            $request->validate([
                'id_pegawai' => 'required',
                'nama_training' => 'required',
                'bidang_training' => 'required',
                'jenis_training' => 'required',
                'penyelenggara' => 'required',
                'lokasi_training' => 'required',
                'waktu_mulai_pelaksanaan' => 'required|date',
                'waktu_selesai_pelaksanaan' => 'required|date',
                'dokumen_data_training' => 'required|file|mimes:pdf'
            ]);
        } else {
            $request->validate([
                'id_pegawai' => 'required',
                'nama_training' => 'required',
                'bidang_training' => 'required',
                'jenis_training' => 'required',
                'penyelenggara' => 'required',
                'lokasi_training' => 'required',
                'waktu_mulai_pelaksanaan' => 'required|date',
                'waktu_selesai_pelaksanaan' => 'required|date',
                'dokumen_data_training' => 'required|file|mimes:pdf'
            ]);
        }

        $identitas = $pegawai->nip . '-' . $pegawai->nama;
        $data_training->id_pegawai = $request['id_pegawai'];
        $data_training->nama_training = $request['nama_training'];
        $data_training->bidang_training = $request['bidang_training'];
        $data_training->jenis_training = $request['jenis_training'];
        $data_training->penyelenggara = $request['penyelenggara'];
        $data_training->lokasi_training = $request['lokasi_training'];
        if ($request->has('waktu_mulai_pelaksanaan')) {
            $data_training->waktu_mulai_pelaksanaan = Carbon::createFromFormat('d-m-Y', $request['waktu_mulai_pelaksanaan']);
        } else {
            $data_training->waktu_mulai_pelaksanaan = $request['waktu_mulai_pelaksanaan'];
        }
        if ($request->has('waktu_selesai_pelaksanaan')) {
            $data_training->waktu_selesai_pelaksanaan = Carbon::createFromFormat('d-m-Y', $request['waktu_selesai_pelaksanaan']);
        } else {
            $data_training->waktu_selesai_pelaksanaan = $request['waktu_selesai_pelaksanaan'];
        }
        if ($request->has('dokumen_data_training') && $request->dokumen_data_training != '') {
            $file = $request->file('dokumen_data_training');
            $name = 'Dokumen_Training_' . $identitas . '_' . $request['nama_training'] . '-' . $this->getTanggal('date') . '.' . $file->extension();

            if (Storage::exists($data_training->dokumen_data_training)) {
                Storage::delete($data_training->dokumen_data_training);
            }
            $url = Storage::putFileAs('public/Karyawan/' . $identitas . '/Dokumen/DataTraining', $file, $name);
            $data_training->dokumen_data_training = $url;
        }
        if ($data_training->save()) {
            alert('Data Berhasil Terupdate!')->background('#B5EDCC');
        } else {
            alert('Update Data Gagal!')->background('#F4CACA');
        }
        return redirect(route('Training.list', $request->id_pegawai));
    }

    public function show($id)
    {
        $training = DataTraining::with('pegawai')->find($id);
        return view('pages.DataTraining.detail', compact('training'));
    }
    public function destroy($id)
    {
        $dt = DataTraining::where('id', $id)->first();
        if (Storage::exists($dt->dokumen_data_training)) {
            Storage::delete($dt->dokumen_data_training);
        }
        $dt->delete();
    }
    public function destroyall($id)
    {
        $dt = DataTraining::where('id_pegawai', $id);
        $data = $dt->get();
        foreach ($data as $d) {
            if (Storage::exists($d->dokumen_data_training)) {
                Storage::delete($d->dokumen_data_training);
            }
        }
        $dt->delete();
    }
    public function export()
    {
        $nama = 'report-training-' . $this->getTanggal('datetime');

        $data = DataTraining::join('pegawai', 'pegawai.id', 'data_training.id_pegawai')
            ->select([
                'pegawai.nip',
                'pegawai.nama',
                'nama_training',
                'jenis_training',
                'bidang_training',
                'penyelenggara',
                'lokasi_training',
                'waktu_mulai_pelaksanaan',
                'waktu_selesai_pelaksanaan',
                'dokumen_data_training'
            ])
            ->get();
        // return response()->json($data);
        if (!empty($data[0]['nama_training'])) {
            return Excel::download(new DataTrainingExport($data), $nama . '.xlsx');
        } else {
            alert('Data Training Tidak Ditemukan!')->background('#df6464');
            return redirect()->back();
        }
    }
    public function import(Request $request)
    {
        if ($request->has('file')) {
            $import = Excel::import(new DataTrainingImport, $request->file('file'));
            if ($import) {
                alert('Data Berhasil Tersimpan!')->background('#B5EDCC');
            } else {
                alert('Simpan Data Gagal!')->background('#F4CACA');
            }
        }
        return redirect()->route('Training.index');
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
