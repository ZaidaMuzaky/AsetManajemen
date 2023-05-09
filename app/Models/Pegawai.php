<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $table = 'pegawai';
    protected $primarykey = 'id';
    protected $fillable = [
        'nip',
        'nama',
        'status_karyawan',
        'masa_kerja',
        'asal_kepegawaian',
        'jenis_kelamin',
        'pendidikan_terakhir',
        'pendidikan_tnt',
        'jurusan_pendidikan',
        'sekolah_universitas',
        'pendidikan_diakui',
        'tempat_lahir',
        'tanggal_lahir',
        'umur',
        'agama',
        'status_hubungan_dalam_keluarga',
        'nama_ayah',
        'nama_ibu',
        'alamat_ktp',
        'alamat_domisili',
        'kota_asal',
        'no_ktp',
        'kewarganegaraan',
        'no_kitap',
        'no_bpjs_kesehatan',
        'no_bpjs_ketenagakerjaan',
        'nama_bank',
        'no_rekening_gaji',
        'no_rekening_ppip',
        'npwp',
        'no_passport',
        'no_handphone',
        'email',
        'unit_kerja',
        'departemen',
        'division',
        'foto_pegawai',
        'kode_jabatan',
        'kode_tipe_pegawai',
    ];

    public function tipepegawai()
    {
        return $this->belongsTo(TipePegawai::class, 'kode_tipe_pegawai');
    }
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'kode_jabatan');
    }

    public function kontrak()
    {
        return $this->hasOne(Kontrak::class, 'id_pegawai', 'id');
    }

    public function datakeluarga()
    {
        return $this->hasOne(DataKeluarga::class, 'id_keluarga');
    }
    public function datatraining()
    {
        return $this->hasMany(DataTraining::class);
    }
    public function datasertifikasi()
    {
        return $this->hasMany(DataSertifikasi::class);
    }
}
