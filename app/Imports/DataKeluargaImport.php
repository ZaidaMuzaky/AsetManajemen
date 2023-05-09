<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Imports\Sheets\SheetImportAnak;
use App\Imports\Sheets\SheetImportPasangan;
use App\Imports\Sheets\SheetImportKeluarga;


class DataKeluargaImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        $sheets = [
            'Data Keluarga' => new SheetImportKeluarga(),
            'Data Pasangan' => new SheetImportPasangan(),
            'Data Anak' => new SheetImportAnak(),
        ];

        return $sheets;
    }
}
