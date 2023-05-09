<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;


class SheetKeluarga implements FromCollection, WithHeadings, WithTitle
{
    private $data;
    public function __construct($data)
    {
        $this->data = $data;
    }
    public function collection()
    {
        return $this->data;
    }
    public function headings(): array
    {
        $data = [
            "NIP Pegawai",
            "Nama Pegawai",
            "No KK",
            "Status Perkawinan",
            "Dokumen KK",
            "Status Anak",
        ];
        return [$data];
    }
    public function title(): string
    {
        return 'Data Keluarga';
    }
}
