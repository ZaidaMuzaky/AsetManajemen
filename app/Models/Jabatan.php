<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $table = 'jabatan';
    protected $primarykey = 'id';
    protected $fillable = [
        'kode_jabatan',
        'nama_jabatan',
        'status'
    ];
    public $timestamps = false;
    public function pegawai()
    {
        return $this->hasOne(Pegawai::class);
    }
}
