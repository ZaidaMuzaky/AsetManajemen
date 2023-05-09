<?php

namespace App\Http\Controllers;

use App\Models\JenisBarang;
use Illuminate\Http\Request;

class JenisBarangController extends Controller
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
        $JenisBarang = JenisBarang::all();

        return view('pages.JenisBarang.index', compact('JenisBarang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.JenisBarang.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'Kode_Jenis_Barang' => 'required|unique:Jenis_Barang,Jenis_Barang.kode_Jenis_Barang|min:2',
            'Jenis_Barang' => 'required',
        ]);
        $tp = JenisBarang::create($request->all());
        if ($tp) {
            alert('Data Berhasil Tersimpan!')->background('#B5EDCC');
        } else {
            alert('Simpan Data Gagal!')->background('#F4CACA');
        }
        return redirect()->route('JenisBarang.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $JenisBarang = JenisBarang::find($id);

        return view('pages.JenisBarang.edit', compact('JenisBarang'));
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
        //
        $request->validate([
            'Kode_Jenis_Barang' => 'required|unique:Jenis_Barang,Jenis_Barang.Kode_Jenis_Barang,' . $id . '|min:2',
            'Jenis_Barang'      => 'required',
        ]);

        $data = JenisBarang::find($id);
        $data->update([
            'Kode_Jenis_Barang' => $request->Kode_Jenis_Barang,
            'Jenis_Barang'      => $request->Jenis_Barang
        ]);
        if ($data) {
            alert('Data Berhasil Terupdate!')->background('#B5EDCC');
        } else {
            alert('Update Data Gagal!')->background('#F4CACA');
        }
        return redirect()->route('JenisBarang.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        JenisBarang::find($id)->delete();
    }
}
