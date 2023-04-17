<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Sheets\SheetKeluarga;
use App\Exports\Sheets\SheetAnak;
use App\Exports\Sheets\SheetPasangan;

class DataKeluargaExport implements WithMultipleSheets
{
    private $keluarga, $pasangan, $anak;
    public function __construct($keluarga, $pasangan, $anak)
    {
        $this->keluarga = $keluarga;
        $this->pasangan = $pasangan;
        $this->anak = $anak;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function sheets(): array
    {
        $sheets = [];
        $sheets[] = new SheetKeluarga($this->keluarga);
        $sheets[] = new SheetPasangan($this->pasangan);
        $sheets[] = new SheetAnak($this->anak);

        return $sheets;
    }
}
