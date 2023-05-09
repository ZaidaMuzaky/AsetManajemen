<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function index()
    {
        $Jabatan = Jabatan::all();

        return view('pages.DataJabatan.index', compact('Jabatan'));
    }

    public function create()
    {
        return view('pages.DataJabatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_jabatan' => [
                'required',
                'unique:jabatan,kode_jabatan'
            ],
            'nama_jabatan' => 'required',
            'status' => 'required',
        ]);
        $jabatan = Jabatan::create([
            'kode_jabatan' => $request->kode_jabatan,
            'nama_jabatan' => $request->nama_jabatan,
            'status' => $request->status
        ]);
        if ($jabatan) {
            alert('Data Berhasil Tersimpan!')->background('#B5EDCC');
        } else {
            alert('Simpan Data Gagal!')->background('#F4CACA');
        }
        return redirect()->route('Jabatan.index');
    }

    public function edit($id)
    {
        $Jabatan = Jabatan::find($id);

        return view('pages.DataJabatan.edit', compact('Jabatan'));
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_jabatan' => [
                'required',
                'unique:jabatan,kode_jabatan,' . $id,
            ],
            'nama_jabatan' => 'required',
            'status' => 'required',
        ]);

        $data = Jabatan::find($id);
        $data->update([
            'kode_jabatan' => $request->kode_jabatan,
            'nama_jabatan' => $request->nama_jabatan,
            'status' => $request->status
        ]);
        if ($data) {
            alert('Data Berhasil Terupdate!')->background('#B5EDCC');
        } else {
            alert('Update Data Gagal!')->background('#F4CACA');
        }
        return redirect()->route('Jabatan.index')->with('success', 'Data Berhasil Di Update');
    }


    public function destroy($id)
    {
        Jabatan::find($id)->delete();
    }
}
