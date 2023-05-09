<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\DaftarPengguna;
use Illuminate\Http\Request;

class DaftarPenggunaController extends Controller
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
        $DaftarPengguna = DaftarPengguna::all();
        $divisi = Divisi::all();

        return view("pages.DaftarPengguna.index", compact('DaftarPengguna', 'divisi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $divisi = Divisi::all();
        return view('pages.DaftarPengguna.create', compact('divisi'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_divisi' => 'required|',
            'nip'       => 'required|',
            'nama'      => 'required',
        ]);
        $tp = DaftarPengguna::create($request->all());
        if ($tp) {
            alert('Data Berhasil Tersimpan!')->background('#B5EDCC');
        } else {
            alert('Simpan Data Gagal!')->background('#F4CACA');
        }
        return redirect()->route('DaftarPengguna.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(DaftarPengguna $daftarPengguna)
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
        $DaftarPengguna = DaftarPengguna::find($id);
        $divisi = Divisi::all();

        return view('pages.DaftarPengguna.edit', compact('DaftarPengguna', 'divisi'));
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
            'id_divisi' => 'required|',
            'nip'       => 'required|',
            'nama'      => 'required',
        ]);

        $data = DaftarPengguna::find($id);
        $data->update([
            'id_divisi'     => $request->id_divisi,
            'nip'           => $request->nip,
            'nama'          => $request->nama
        ]);
        if ($data) {
            alert('Data Berhasil Terupdate!')->background('#B5EDCC');
        } else {
            alert('Update Data Gagal!')->background('#F4CACA');
        }
        return redirect()->route('DaftarPengguna.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DaftarPengguna::find($id)->delete();
    }
}
