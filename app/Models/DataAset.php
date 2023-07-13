<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataAset extends Model
{
    use HasFactory;
    protected $table = 'data_aset';
    protected $fillable = [
        'nomor', 'nama', 'perusahaan', 'id_divisi', 'tahun', 'kondisi'
    ];

    public function divisi()
    {
        return $this->belongsTo(Divisi::class, 'id_divisi', 'id');
    }
}
