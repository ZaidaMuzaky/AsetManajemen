<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarPengguna extends Model
{
    protected $table = 'penanggung_jawab';
    protected $primarykey = 'id';
    protected $fillable = [
        'id_divisi',
        'nip',
        'nama',
    ];
    public function Divisi()
    {
        return $this->belongsTo(Divisi::class, 'id_divisi', 'id');
    }
}
