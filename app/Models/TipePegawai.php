<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipePegawai extends Model
{
    protected $table = 'tipe_pegawai';
    protected $primarykey = 'id';
    protected $fillable = [
        'kode_tipe_pegawai',
        'nama_tipe_pegawai'
    ];
    public function pegawai()
    {
        return $this->hasMany(Pegawai::class);
    }
}
