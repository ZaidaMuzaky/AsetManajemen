<?php

namespace App\Http\Controllers;

use App\Models\TipePegawai;
use Illuminate\Http\Request;

class TipePegawaiController extends Controller
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
        $Pegawai = TipePegawai::all();

        return view('pages.TipePegawai.index', compact('Pegawai'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.TipePegawai.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);

        $request->validate([
            'kode_tipe_pegawai' => 'required|unique:tipe_pegawai,tipe_pegawai.kode_tipe_pegawai|min:2',
            'nama_tipe_pegawai' => 'required',
        ]);
        $tp = TipePegawai::create($request->all());
        if ($tp) {
            alert('Data Berhasil Tersimpan!')->background('#B5EDCC');
        } else {
            alert('Simpan Data Gagal!')->background('#F4CACA');
        }
        return redirect()->route('tipePegawai.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Pegawai = TipePegawai::find($id);

        return view('pages.TipePegawai.edit', compact('Pegawai'));
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
            'kode_tipe_pegawai' => 'required|unique:tipe_pegawai,tipe_pegawai.kode_tipe_pegawai,' . $id . '|min:2',
            'nama_tipe_pegawai' => 'required',
        ]);

        $data = TipePegawai::find($id);
        $data->update([
            'kode_tipe_pegawai' => $request->kode_tipe_pegawai,
            'nama_tipe_pegawai' => $request->nama_tipe_pegawai
        ]);
        if ($data) {
            alert('Data Berhasil Terupdate!')->background('#B5EDCC');
        } else {
            alert('Update Data Gagal!')->background('#F4CACA');
        }
        return redirect()->route('tipePegawai.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TipePegawai::find($id)->delete();
    }
}
