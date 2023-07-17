<?php

namespace App\Http\Controllers;

use App\Models\DataBarang;
use App\Models\DetailAset;
use App\Models\History;
use App\Models\Monitoring;
use App\Models\PenanggungJawab;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetailDataAsetController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $detailAset = DetailAset::all()->sortByDesc('id');
        return view('pages.DetailAset.index', compact('detailAset'));
    }

    public function create()
    {
        $status = Status::all();
        $pj = PenanggungJawab::all();
        $dataBarang = DataBarang::all();
        return view('pages.DetailAset.create', compact('status', 'pj', 'dataBarang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_aset' => 'required|unique:detail_aset,detail_aset.kode_aset',
            'nama' => 'required',
            'kategori_aset' => 'required',
            'tahun_perolehan' => 'required',
            'asal_perusahaan' => 'required',
            'kondisi' => 'required',
            'deskripsi_aset' => 'required',
            'lokasi' => 'required',
            'idPenanggungJawab' => 'required',
            'idDetailBarang' => 'required',
        ]);
        $allData = $request->all();
        $save = DB::transaction(
            function () use ($allData) {
                $save = DetailAset::create($allData);
                $allData['idDataAset'] = $save->id;
                History::create($allData);
            }
        );
        if (is_null($save)) {
            alert('Data Berhasil Tersimpan!')->background('#B5EDCC');
        } else {
            alert('Simpan Data Gagal!')->background('#F4CACA');
        }
        return redirect()->route('detail-aset.index');
    }

    public function edit($id)
    {
        $detailAset = DetailAset::find($id);
        $status = Status::all();
        $pj = PenanggungJawab::all();
        $dataBarang = DataBarang::all();
        return view('pages.DetailAset.edit', compact('status', 'pj', 'dataBarang', 'detailAset'));
    }

    public function update(int $id, Request $request)
    {
        $request->validate([
            'kode_aset' => 'required|unique:detail_aset,detail_aset.kode_aset,' . $id,
            'nama' => 'required',
            'kategori_aset' => 'required',
            'tahun_perolehan' => 'required',
            'asal_perusahaan' => 'required',
            'kondisi' => 'required',
            'deskripsi_aset' => 'required',
            'lokasi' => 'required',
            'idPenanggungJawab' => 'required',
            'idDetailBarang' => 'required',
        ]);

        $data = DetailAset::find($id);
        $history = array_merge($request->all(), ['idDataAset' => $id]);
        DB::transaction(
            function () use ($data, $request, $history) {
                $data->update($request->all());
                History::create($history);
            }
        );
        if ($data) {
            alert('Data Berhasil Terupdate!')->background('#B5EDCC');
        } else {
            alert('Update Data Gagal!')->background('#F4CACA');
        }
        return redirect()->route('detail-aset.index');
    }

    public function destroy($id)
    {
        DB::transaction(
            function () use ($id) {
                History::where('idDataAset', $id)->delete();
                DetailAset::find($id)->delete();
            }
        );
    }

    public function history($id)
    {
        $history = History::select('*')->where('idDataAset', $id)->orderByDesc('id')->get();
        return view('pages.DetailAset.history', compact('history'));
    }
}
