<?php

namespace App\Imports\Sheets;

use App\Models\DataAnak;
use App\Models\DataKeluarga;
use DateTime;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\DefaultValueBinder;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class SheetImportAnak extends DefaultValueBinder implements ToCollection, WithHeadingRow, WithCustomValueBinder
{
    public function bindValue(Cell $cell, $value)
    {
        if (is_numeric($value)) {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);

            return true;
        }

        // else return default behavior
        return parent::bindValue($cell, $value);
    }
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
    public function collection(Collection $rows)
    {
        foreach ($rows as  $row) {
            $keluarga = DataKeluarga::where('no_kk', $row['No KK'])->first();
            if ($keluarga) {
                DataAnak::create([
                    'id_keluarga' => $keluarga->id,
                    'nama_lengkap' => ucwords($row['Nama Anak']),
                    'nik' => $row['NIK'],
                    'jenis_kelamin' => $row['Jenis Kelamin'],
                    'tempat_lahir' => ucwords($row['Tempat Lahir']),
                    'tanggal_lahir' => $this->convertDate($row['Tanggal Lahir']),
                    'agama' => ucwords($row['Agama']),
                    'pendidikan' => strtoupper($row['Pendidikan']),
                    'jenis_pekerjaan' => ucwords($row['Jenis Pekerjaan']),
                    'status_pernikahan' => ucwords($row['Status Pernikahan']),
                    'status_hubungan_dalam_keluarga' => ucwords($row['Status Hubungan dalam Keluarga']),
                    'kewarganegaraan' => ucwords($row['Kewarganegaraan']),
                    'no_passport' => $row['No Passport'],
                    'no_kitap' => $row['No Kitap'],
                    'nama_ayah' => ucwords($row['Nama Ayah']),
                    'nama_ibu' => ucwords($row['Nama Ibu'])
                ]);
            }
        }
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function startRow(): int
    {
        return 2;
    }
}
