<?php

namespace App\Imports\Sheets;

use App\Models\DataKeluarga;
use App\Models\Pegawai;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\DefaultValueBinder;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class SheetImportKeluarga extends DefaultValueBinder implements ToCollection, WithHeadingRow, WithCustomValueBinder
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

    public function convertToString($number)
    {
        return (string) $number;
    }
    public function collection(Collection $rows)
    {
        foreach ($rows as  $row) {
            $pegawai = Pegawai::where('nip', $row['NIP Pegawai'])->first();
            if ($pegawai) {
                $keluarga = DataKeluarga::where('id_pegawai', $pegawai->id)->exists();
                if (!$keluarga) {
                    DataKeluarga::create([
                        'id_pegawai' => $pegawai->id,
                        'no_kk' => $this->convertToString($row['No KK']),
                        'status_perkawinan' => $row['Status Perkawinan'],
                        'dokumen_kk' => $row['Dokumen KK'],
                        'status_anak' => $row['Status Anak']
                    ]);
                }
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
