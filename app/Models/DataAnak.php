<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataAnak extends Model
{
    protected $table = 'data_anak';
    protected $primarykey = 'id';
    protected $fillable = [
        'id_keluarga',
        'nama_lengkap',
        'nik',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'pendidikan',
        'jenis_pekerjaan',
        'status_pernikahan',
        'status_hubungan_dalam_keluarga',
        'kewarganegaraan',
        'no_passport',
        'no_kitap',
        'nama_ayah',
        'nama_ibu'
    ];
    public function keluarga()
    {
        return $this->belongsTo(DataKeluarga::class, 'id_keluarga');
    }
}
