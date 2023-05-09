<?php

namespace App\Imports;

use App\Models\DataOrganisasi;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class DataOrganisasiImport implements ToCollection, WithHeadingRow
{

    public function collection(Collection $rows)
    {
        foreach ($rows as  $row) {
            DataOrganisasi::create([
                'kode_organisasi' => $row['Kode Organisasi'],
                'nama_organisasi' => $row['Nama Organisasi'],
                'nama_pejabat' => $row['Nama Pejabat'],
                'status_pejabat' => $row['Status Pejabat'],
                'level_organisasi' => $row['Level Organisasi'],
                'status' => $row['Status'],
                'jobdesk' => $row['Jobdesk']
            ]);
        }
    }

    public function startRow(): int
    {
        return 2;
    }

    public function headingRow(): int
    {
        return 1;
    }
}
