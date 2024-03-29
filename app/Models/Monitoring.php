<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Monitoring extends Model
{
    use HasFactory;
    protected $table = 'monitoring';
    protected $fillable = [
        'tgl_monitoring',
        'deskripsi',
        'kondisi',
        'idPenanggungJawab',
        'idDataAset',
    ];

    public function PenanggungJawab()
    {
        return $this->belongsTo(PenanggungJawab::class, 'idPenanggungJawab', 'id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'kondisi', 'value');
    }

    public function detailAset()
    {
        return $this->belongsTo(DetailAset::class, 'idDataAset', 'id');
    }
}
