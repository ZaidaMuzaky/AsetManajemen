<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class DataSertifikasiExport implements FromCollection, WithHeadings, WithTitle
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
            "Nama Sertifikasi",
            "Jenis Sertifikasi",
            "Bidang Sertifikasi",
            "Penyelenggara",
            "Lokasi Sertifikasi",
            "Waktu Mulai Pelaksanaan",
            "Waktu Selesai Pelaksanaan",
            "Tanggal Sertifikat Diterbitkan",
            "Masa Berlaku Sampai dengan",
            "Dokumen Data Sertifikasi"
        ];
        return $header;
    }
    public function title(): string
    {
        return 'Data Sertifikasi';
    }
}
