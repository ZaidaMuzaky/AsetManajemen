<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataOrganisasi extends Model
{
    protected $table = 'data_organisasi';
    protected $primarykey = 'id';
    protected $fillable = [
        'kode_organisasi',
        'nama_organisasi',
        'nama_pejabat',
        'status_pejabat',
        'level_organisasi',
        'jobdesk',
        'status'
    ];
}
