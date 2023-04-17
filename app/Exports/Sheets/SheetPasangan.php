<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class SheetPasangan implements FromCollection, WithHeadings, WithTitle
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
            "No KK",
            "Nama Pasangan",
            "NIK",
            "Jenis Kelamin",
            "Tempat Lahir",
            "Tanggal Lahir",
            "Agama",
            "Pendidikan",
            "Jenis Pekerjaan",
            "Status Pernikahan",
            "Status Hubungan dalam Keluarga",
            "Kewarganegaraan",
            "No Passport",
            "No Kitap",
            "Nama Ayah",
            "Nama Ibu",
        ];
        return [$data];
    }
    public function title(): string
    {
        return 'Data Pasangan';
    }
}
