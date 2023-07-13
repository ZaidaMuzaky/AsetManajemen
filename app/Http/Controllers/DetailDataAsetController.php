<?php

namespace App\Http\Controllers;

use App\Models\DataBarang;
use App\Models\DetailAset;
use App\Models\PenanggungJawab;
use App\Models\Status;
use Illuminate\Http\Request;

class DetailDataAsetController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $detailAset = DetailAset::all();
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
        $save = DetailAset::create($request->all());
        if ($save) {
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

    public function destroy($id)
    {
        DetailAset::find($id)->delete();
    }
}
