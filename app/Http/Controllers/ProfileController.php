<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    public function view()
    {
        $users = Auth::user();
        $user = User::where('id_user', $users->id_user)->first();
        return view('viewprofil', compact('users', 'user'));
    }
    public function edit()
    {
        $users = Auth::user();
        $user = User::where('id_user', $users->id_user)->first();
        return view('editprofil', compact('users', 'user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required',
        ]);

        $user = User::find($id);
        $user->nama = $request->nama;
        $user->email = $request->email;
        if ($request->has('password') && $request->password != '') {
            $user->password = Hash::make($request->password);
        }

        if ($request->has('foto')) {
            $file = $request->file('foto');
            $name = 'Admin_Reka_'  . $request->nama . '.' . $file->extension();

            if (Storage::exists($name)) {
                Storage::delete('public/images/foto/Admin' . $name);
            }

            $url = Storage::putFileAs('public/images/foto/Admin', $file, $name);
            $user->foto = $url;
        }

        if ($user->save()) {
            alert('Data Berhasil Terupdate!')->background('#B5EDCC');
        } else {
            alert('Update Data Gagal!')->background('#F4CACA');
        }
        return redirect()->route('User.viewprofil');
    }
}
