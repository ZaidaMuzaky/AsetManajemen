<?php

namespace App\Http\Controllers;

use App\Models\DetailAset;
use App\Models\Monitoring;
use App\Models\PenanggungJawab;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonitoringController extends Controller
{
    public function index()
    {
        $detailAset = DetailAset::all();
        return view('pages.monitoring.index', compact('detailAset'));
    }

    public function create($idDetailAset)
    {
        $detailAset = DetailAset::find($idDetailAset);
        $pj = PenanggungJawab::all();
        $status = Status::all();
        return view('pages.monitoring.create', compact('detailAset', 'pj', 'status'));
    }

    public function store($id, Request $request)
    {
        $request->validate([
            'kondisi' => 'required',
            'deskripsi' => 'required',
            'tgl_monitoring' => 'required',
            'idPenanggungJawab' => 'required',
        ]);
        $detailAset = DetailAset::find($id);
        $allData = $request->all();
        $allData['kode_aset'] = $detailAset->kode_aset;
        $allData['idDataAset'] = $id;
        $save = DB::transaction(
            function () use ($allData) {
                Monitoring::create($allData);
            }
        );
        if (is_null($save)) {
            alert('Data Berhasil Tersimpan!')->background('#B5EDCC');
        } else {
            alert('Simpan Data Gagal!')->background('#F4CACA');
        }
        return redirect()->route('monitoring.index');
    }

    public function show($id)
    {
        $monitoring = Monitoring::where('idDataAset', $id)->orderByDesc('id')->get();
        return view('pages.monitoring.history', compact('monitoring'));
    }

    public function edit($id)
    {
        $monitoring = Monitoring::find($id);
        $pj = PenanggungJawab::all();
        $status = Status::all();
        return view('pages.monitoring.edit', compact('monitoring', 'pj', 'status'));
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'kondisi' => 'required',
            'deskripsi' => 'required',
            'tgl_monitoring' => 'required',
            'idPenanggungJawab' => 'required',
        ]);
        $monitoring = Monitoring::find($id);
        $allData = $request->all();
        $allData['kode_aset'] = $monitoring->detailAset->kode_aset;
        $allData['idDataAset'] = $monitoring->idDataAset;
        $save = DB::transaction(
            function () use ($allData, $monitoring) {
                $monitoring->update($allData);
            }
        );
        if (is_null($save)) {
            alert('Data Berhasil Tersimpan!')->background('#B5EDCC');
        } else {
            alert('Simpan Data Gagal!')->background('#F4CACA');
        }
        return redirect()->route('monitoring.show', $monitoring->idDataAset);
    }

    public function destroy($id)
    {
        Monitoring::where('id', $id)->delete();
    }
    public function destroyAll($id)
    {
        Monitoring::where('idDataAset', $id)->delete();
    }
}
