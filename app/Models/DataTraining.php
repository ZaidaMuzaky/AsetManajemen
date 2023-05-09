<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataTraining extends Model
{
    protected $table = 'data_training';
    protected $primarykey = 'id';
    protected $fillable = [
        'id_pegawai',
        'nama_training',
        'jenis_training',
        'bidang_training',
        'penyelenggara',
        'lokasi_training',
        'waktu_mulai_pelaksanaan',
        'waktu_selesai_pelaksanaan',
        'dokumen_data_training'
    ];
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai');
    }
}
