<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kontrak extends Model
{
    protected $table = 'kontrak';
    protected $primarykey = 'id_kontrak';
    protected $fillable = [
        'id_pegawai',
        'kontrak_1',
        'selesai_kontrak_1',
        'kontrak_2',
        'selesai_kontrak_2',
        'kontrak_3',
        'selesai_kontrak_3',
        'kontrak_4',
        'selesai_kontrak_4',
        'kontrak_5',
        'selesai_kontrak_5',
        'kontrak_6',
        'selesai_kontrak_6',
        'kontrak_7',
        'selesai_kontrak_7',
        'kontrak_8',
        'selesai_kontrak_8',
        'kontrak_9',
        'selesai_kontrak_9',
        'kontrak_10',
        'selesai_kontrak_10',
        'tanggal_npp',
        'tanggal_pensiun',
        'dokumen_dasar_pensiun'
    ];
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai');
    }
}
