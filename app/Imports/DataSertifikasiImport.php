<?php

namespace App\Imports;

use App\Models\DataSertifikasi;
use App\Models\Pegawai;
use DateTime;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class DataSertifikasiImport implements ToCollection, WithHeadingRow, SkipsOnError
{
    use SkipsErrors;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }
    public function convertDate($excel_date)
    {
        if ($this->validateDate($excel_date, 'Y-m-d')) {
            return $excel_date;
        } else if ($this->validateDate($excel_date, 'd-m-Y')) {
            $unix_date = ($excel_date - 25569) * 86400;
            $date = gmdate("Y-m-d", $unix_date);
            return $date;
        } else if ($excel_date == '') {
            return null;
        } else {
            $unix_date = ($excel_date - 25569) * 86400;
            $date = gmdate("Y-m-d", $unix_date);
            return $date;
        }
    }
    public function collection(Collection $rows)
    {
        foreach ($rows as  $row) {
            $pegawai = Pegawai::where('nip', $row['NIP Pegawai'])->first();
            if ($pegawai) {
                $exists = DataSertifikasi::where([
                    ['nama_sertifikasi', $row['Nama Sertifikasi']],
                    ['id_pegawai', $pegawai->id],
                    ['penyelenggara', $row['Penyelenggara']]
                ])->exists();
                if (!$exists) {
                    DataSertifikasi::create([
                        'id_pegawai' => $pegawai->id,
                        'nama_sertifikasi' => $row['Nama Sertifikasi'],
                        'jenis_sertifikasi' => $row['Jenis Sertifikasi'],
                        'bidang_sertifikasi' => $row['Bidang Sertifikasi'],
                        'penyelenggara' => $row['Penyelenggara'],
                        'lokasi_sertifikasi' => $row['Lokasi Sertifikasi'],
                        'waktu_mulai_pelaksanaan' => $this->convertDate($row['Waktu Mulai Pelaksanaan']),
                        'waktu_selesai_pelaksanaan' => $this->convertDate($row['Waktu Selesai Pelaksanaan']),
                        'tanggal_sertifikat_diterbitkan' => $this->convertDate($row['Tanggal Sertifikat Diterbitkan']),
                        'masa_berlaku_sampai_dengan' => $this->convertDate($row['Masa Berlaku Sampai dengan']),
                        'dokumen_data_sertifikasi' => $row['Dokumen Data Sertifikasi']
                    ]);
                }
            }
        }
    }

    public function headingRow(): int
    {
        return 1;
    }
}
