<?php

namespace App\Http\Controllers;

use App\Models\DaftarPengguna;
use App\Models\Memo;
use App\Models\User;
use Illuminate\Http\Request;

class MemoController extends Controller
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
        $user = User::all();
        $memo = Memo::all();

        return view('pages.Memo.index', compact('memo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $DaftarPengguna = DaftarPengguna::all();
        $user = User::all();

        return view('pages.Memo.create', compact('user', 'DaftarPengguna'));
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
            'Kode_memo' => 'required',
            'tgl_memo' => 'required',
            'perihal' => 'required',
            'deskripsi' => 'required',
            'pengirim' => 'required',
            'penerima' => 'required',
        ]);
        $tp = Memo::create($request->all());
        if ($tp) {
            alert('Data Berhasil Tersimpan!')->background('#B5EDCC');
        } else {
            alert('Simpan Data Gagal!')->background('#F4CACA');
        }
        return redirect()->route('Memo.index');
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
        $memo = Memo::find($id);
        $DaftarPengguna = DaftarPengguna::all();
        $user = User::all();
        return view('pages.memo.edit', compact('memo'));
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
            'kode_memo' => 'required',
            'tgl_memo' => 'required',
            'perihal' => 'required',
            'deskripsi' => 'required',
            'pengirim' => 'required',
            'penerima' => 'required',
        ]);

        $data = Memo::find($id);
        $data->update([
            'kode_memo' => $request->kode_memo,
            'tgl_memo' => $request->tgl_memo,
            'perihal' => $request->perihal,
            'deskripsi' => $request->deskripsi,
            'pengirim' => $request->pengirim,
            'penerima' => $request->penerima
        ]);
        if ($data) {
            alert('Data Berhasil Terupdate!')->background('#B5EDCC');
        } else {
            alert('Update Data Gagal!')->background('#F4CACA');
        }
        return redirect()->route('memo.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Memo::find($id)->delete();
    }
}
