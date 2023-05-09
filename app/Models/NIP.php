<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NIP extends Model
{
    protected $table = 'nip';
    protected $primarykey = 'id_nip';
    protected $fillable = [
        'id_kepegawaian',
        'tahun_sk',
        'no_urut_pegawai',
        'nama_lengkap'
    ];
}
