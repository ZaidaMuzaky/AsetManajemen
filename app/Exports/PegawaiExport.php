<?php

namespace App\Exports;

use App\Models\Pegawai;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class PegawaiExport implements FromCollection, WithHeadings, WithTitle
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
        return [
            "NIP",
            "Nama",
            "Status Karyawan",
            "Kontrak 1",
            "Selesai Kontrak 1",
            "Kontrak 2",
            "Selesai Kontrak 2",
            "Kontrak 3",
            "Selesai Kontrak 3",
            "Kontrak 4",
            "Selesai Kontrak 4",
            "Kontrak 5",
            "Selesai Kontrak 5",
            "Kontrak 6",
            "Selesai Kontrak 6",
            "Kontrak 7",
            "Selesai Kontrak 7",
            "Kontrak 8",
            "Selesai Kontrak 8",
            "Kontrak 9",
            "Selesai Kontrak 9",
            "Kontrak 10",
            "Selesai Kontrak 10",
            "Tanggal NPP",
            "Tanggal Pensiun",
            "Dokumen Dasar Pensiun",
            "Masa Kerja",
            "Asal Kepegawaian",
            "Jenis Kelamin",
            "Pendidikan Terakhir",
            "Pendidikan T/NT",
            "Jurusan Pendidikan",
            "Sekolah/Universitas",
            "Pendidikan Diakui",
            "Tempat Lahir",
            "Tanggal Lahir",
            "Umur",
            "Agama",
            "Status Hubungan Dalam Keluarga",
            "Nama Ayah",
            "Nama Ibu",
            "Alamat KTP",
            "Alamat Domisili",
            "Kota Asal",
            "No KTP",
            "Kewarganegaraan",
            "No Passport",
            "No Kitap",
            "No BPJS Kesehatan",
            "No BPJS Ketenagakerjaan",
            "Nama Bank",
            "No Rekening Gaji",
            "No Rekening PPIP",
            "NPWP",
            "No_Handphone",
            "Email",
            "Unit Kerja",
            "Departemen",
            "Division",
            "Foto Pegawai",
            "Jabatan",
            "Tipe Pegawai",
        ];
    }
    public function title(): string
    {
        return 'Data Karyawan';
    }
}
