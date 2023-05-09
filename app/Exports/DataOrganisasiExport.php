<?php

namespace App\Exports;

use App\Models\DataOrganisasi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class DataOrganisasiExport implements FromCollection, WithHeadings, WithTitle
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $o = DataOrganisasi::select([
            'kode_organisasi',
            'nama_organisasi',
            'nama_pejabat',
            'status_pejabat',
            'level_organisasi',
            'status',
            'jobdesk',
        ])
            ->get();
        return $o;
    }
    public function headings(): array
    {
        return [
            "Kode Organisasi",
            "Nama Organisasi",
            "Nama Pejabat",
            "Status Pejabat",
            "Level Organisasi",
            "Status",
            "Jobdesk",
        ];
    }
    public function title(): string
    {
        return 'Data Organisasi';
    }
}
