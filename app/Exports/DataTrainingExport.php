<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class DataTrainingExport implements FromCollection, WithHeadings, WithTitle
{
    private $data;
    public function __construct($data)
    {
        $this->data = $data;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->data;
    }
    public function headings(): array
    {
        $header = [
            "NIP Pegawai",
            "Nama Pegawai",
            "Nama Training",
            "Jenis Training",
            "Bidang Training",
            "Penyelenggara",
            "Lokasi Training",
            "Waktu Mulai Pelaksanaan",
            "Waktu Selesai Pelaksanaan",
            "Dokumen Data Training"
        ];
        return $header;
    }
    public function title(): string
    {
        return 'Data Training';
    }
}
