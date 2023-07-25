<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Memo extends Model
{
    use HasFactory;
    protected $table = 'memo';
    protected $primarykey = 'id';
    protected $fillable = [
        'kode_memo',
        'tgl_memo',
        'perihal',
        'deskripsi',
        'pengirim',
        'penerima'
    ];

    public function pengirim()
    {
        return $this->belongsTo(user::class, 'pengirim', 'id');
    }
    public function penerima()
    {
        return $this->belongsTo(PenanggungJawab::class, 'penerima', 'id');
    }
}
