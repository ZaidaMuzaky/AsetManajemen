<?php

namespace App\Http\Controllers;

use App\Models\DataAset;
use Illuminate\Http\Request;

class DataAsetController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $dataAset = DataAset::all();
        return view('pages.DataAset.index', compact('dataAset'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
