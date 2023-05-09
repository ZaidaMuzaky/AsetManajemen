<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataSertifikasi extends Model
{
    protected $table = 'data_sertifikasi';
    protected $primarykey = 'id';
    protected $fillable = [
        'id_pegawai',
        'nama_sertifikasi',
        'jenis_sertifikasi',
        'bidang_sertifikasi',
        'penyelenggara',
        'lokasi_sertifikasi',
        'waktu_mulai_pelaksanaan',
        'waktu_selesai_pelaksanaan',
        'tanggal_sertifikat_diterbitkan',
        'masa_berlaku_sampai_dengan',
        'dokumen_data_sertifikasi'
    ];
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai');
    }
}
