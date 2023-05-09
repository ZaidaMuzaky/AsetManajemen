<?php

namespace App\Imports;

use App\Models\DataTraining;
use App\Models\Pegawai;
use DateTime;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class DataTrainingImport implements ToCollection, WithHeadingRow
{
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
        // return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date));
    }
    public function SetJenisTraining($jt)
    {
        if ($jt == 'Softskill') {
            return 'Softskill';
        } else if ($jt == 'Hardskill') {
            return 'Hardskill';
        } else if ($jt == 'Basic Training') {
            return 'Basic Training';
        } else {
            return null;
        }
    }
    public function collection(Collection $rows)
    {
        foreach ($rows as  $row) {
            $pegawai = Pegawai::where('nip', $row['NIP Pegawai'])->first();
            if ($pegawai) {
                $exists = DataTraining::where([
                    ['nama_training', $row['Nama Training']],
                    ['id_pegawai', $pegawai->id],
                    ['penyelenggara', $row['Penyelenggara']]
                ])->exists();
                if (!$exists) {
                    DataTraining::create([
                        'id_pegawai' => $pegawai->id,
                        'nama_training' => $row['Nama Training'],
                        'jenis_training' => $this->SetJenisTraining($row['Jenis Training']),
                        'bidang_training' => $row['Bidang Training'],
                        'penyelenggara' => $row['Penyelenggara'],
                        'lokasi_training' => $row['Lokasi Training'],
                        'waktu_mulai_pelaksanaan' => $this->convertDate($row['Waktu Mulai Pelaksanaan']),
                        'waktu_selesai_pelaksanaan' => $this->convertDate($row['Waktu Selesai Pelaksanaan']),
                        'dokumen_data_training' => $row['Dokumen Data Training']
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
