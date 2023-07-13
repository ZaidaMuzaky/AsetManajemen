<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisBarang extends Model
{
    use HasFactory;
    protected $table = 'jenis_barang';
    protected $primarykey = 'id';
    protected $fillable = [
        'Kode_Jenis_Barang',
        'Jenis_Barang'
    ];
    public function pegawai()
    {
        // return $this->hasMany(Pegawai::class);
    }
}
