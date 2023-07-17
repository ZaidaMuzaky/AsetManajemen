<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailAset extends Model
{
    use HasFactory;
    protected $table = 'detail_aset';
    protected $fillable = [
        'kode_aset',
        'nama',
        'kategori_aset',
        'tahun_perolehan',
        'asal_perusahaan',
        'kondisi',
        'deskripsi_aset',
        'lokasi',
        'idPenanggungJawab',
        'idDetailBarang'
    ];

    public function dataBarang()
    {
        return $this->belongsTo(DataBarang::class, 'idDetailBarang', 'id');
    }

    public function PenanggungJawab()
    {
        return $this->belongsTo(PenanggungJawab::class, 'idPenanggungJawab', 'id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'kondisi', 'value');
    }

    public function monitoring()
    {
        return $this->hasMany(Monitoring::class, 'idDataAset', 'id');
    }
}
