<?php

namespace App\Imports;

use App\Models\Kontrak;
use App\Models\NIP;
use App\Models\Pegawai;
use App\Models\TipePegawai;
use Carbon\Carbon;
use DateTime;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\DefaultValueBinder;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class PegawaiImport extends DefaultValueBinder implements ToCollection, WithHeadingRow, WithChunkReading, WithCustomValueBinder
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
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function cekJabatan($nama)
    {
        if ($nama == 'Belum Ada' || $nama == null || $nama == '') {
            return '1';
        } else if ($nama == 'Direktur') {
            return '2';
        } else if ($nama == 'Supervisor') {
            return '3';
        } else if ($nama == 'Manajer') {
            return '4';
        } else if ($nama == 'Staff') {
            return '5';
        } else {
            return '1';
        }
    }
    public function cekTipePegawai($nip)
    {
        $tp = substr($nip, 0, 2);
        $tipepegawai = TipePegawai::where('kode_tipe_pegawai', $tp)->get('id');
        return $tipepegawai[0]['id'];
    }
    public function cekDivisi($input)
    {
        if (strpos($input, 'Tecnology') !== false || strpos($input, 'tecnology') !== false) {
            return 'Tecnology & Quality Control';
        } else if (strpos($input, 'Operation') !== false || strpos($input, 'operation') !== false) {
            return 'Operation';
        } else if (strpos($input, 'Finance') !== false || strpos($input, 'finance') !== false) {
            return 'Finance';
        } else if (strpos($input, 'Human') !== false || strpos($input, 'human') !== false) {
            return 'Human Resource & General Affairs';
        } else if (strpos($input, 'Deputy') !== false || strpos($input, 'deputy') !== false) {
            return 'Deputy GM Sub Quality Control';
        }
    }
    public function getTahunSK($tahun)
    {
        $todayYear = Carbon::now()->format('Y');
        $todayYear -= 50;
        $year = substr($tahun, 2, 2);
        $todayYear = substr($todayYear, 2, 2);
        if ($year >= $todayYear) {
            $year = '19' . $year;
        } else {
            $year = '20' . $year;
        }
        return $year;
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
    public function createPegawai($row)
    {
        $pegawai =  Pegawai::create([
            'nip' => $row['NIP'],
            'nama' => ucwords($row['Nama']),
            'status_karyawan' => ucwords($row['Status Karyawan']),
            'masa_kerja' => $row['Masa Kerja'],
            'asal_kepegawaian' => strtoupper($row['Asal Kepegawaian']),
            'jenis_kelamin' => $row['Jenis Kelamin'],
            'pendidikan_terakhir' => ucwords($row['Pendidikan Terakhir']),
            'pendidikan_tnt' => ucwords($row['Pendidikan T/NT']),
            'jurusan_pendidikan' => ucwords($row['Jurusan Pendidikan']),
            'sekolah_universitas' => ucwords($row['Sekolah/Universitas']),
            'pendidikan_diakui' => strtoupper($row['Pendidikan Diakui']),
            'tempat_lahir' => $row['Tempat Lahir'],
            'tanggal_lahir' => $this->convertDate($row['Tanggal Lahir']),
            'umur' => $row['Umur'],
            'agama' => ucwords($row['Agama']),
            'status_hubungan_dalam_keluarga' => ucwords($row['Status Hubungan Dalam Keluarga']),
            'nama_ayah' => ucwords($row['Nama Ayah']),
            'nama_ibu' => ucwords($row['Nama Ibu']),
            'alamat_ktp' => ucwords($row['Alamat KTP']),
            'alamat_domisili' => ucwords($row['Alamat Domisili']),
            'kota_asal' => ucwords($row['Kota Asal']),
            'no_ktp' => $row['No KTP'],
            'kewarganegaraan' => ucwords($row['Kewarganegaraan']),
            'no_passport' => $row['No Passport'],
            'no_kitap' => $row['No Kitap'],
            'no_bpjs_kesehatan' => $row['No BPJS Kesehatan'],
            'no_bpjs_ketenagakerjaan' => $row['No BPJS Ketenagakerjaan'],
            'nama_bank' => $row['Nama Bank'],
            'no_rekening_gaji' => $row['No Rekening Gaji'],
            'no_rekening_ppip' => $row['No Rekening PPIP'],
            'npwp' => $row['NPWP'],
            'no_handphone' => $row['No_Handphone'],
            'email' => $row['Email'],
            'unit_kerja' => $row['Unit Kerja'],
            'departemen' => $row['Departemen'],
            'division' => $this->cekDivisi($row['Division']),
            'foto_pegawai' => $row['Foto Pegawai'],
            'kode_jabatan' => $this->cekJabatan(ucwords($row['Jabatan'])),
            'kode_tipe_pegawai' => $this->cekTipePegawai($row['NIP'])
        ]);
        if ($pegawai) {
            Kontrak::create([
                'id_pegawai' => $pegawai->id,
                'kontrak_1' => $this->convertDate($row['Kontrak 1']),
                'selesai_kontrak_1' => $this->convertDate($row['Selesai Kontrak 1']),
                'kontrak_2' => $this->convertDate($row['Kontrak 2']),
                'selesai_kontrak_2' => $this->convertDate($row['Selesai Kontrak 2']),
                'kontrak_3' => $this->convertDate($row['Kontrak 3']),
                'selesai_kontrak_3' => $this->convertDate($row['Selesai Kontrak 3']),
                'kontrak_4' => $this->convertDate($row['Kontrak 4']),
                'selesai_kontrak_4' => $this->convertDate($row['Selesai Kontrak 4']),
                'kontrak_5' => $this->convertDate($row['Kontrak 5']),
                'selesai_kontrak_5' => $this->convertDate($row['Selesai Kontrak 5']),
                'kontrak_6' => $this->convertDate($row['Kontrak 6']),
                'selesai_kontrak_6' => $this->convertDate($row['Selesai Kontrak 6']),
                'kontrak_7' => $this->convertDate($row['Kontrak 7']),
                'selesai_kontrak_7' => $this->convertDate($row['Selesai Kontrak 7']),
                'kontrak_8' => $this->convertDate($row['Kontrak 8']),
                'selesai_kontrak_8' => $this->convertDate($row['Selesai Kontrak 8']),
                'kontrak_9' => $this->convertDate($row['Kontrak 9']),
                'selesai_kontrak_9' => $this->convertDate($row['Selesai Kontrak 9']),
                'kontrak_10' => $this->convertDate($row['Kontrak 10']),
                'selesai_kontrak_10' => $this->convertDate($row['Selesai Kontrak 10']),
                'tanggal_npp' => $this->convertDate($row['Tanggal NPP']),
                'tanggal_pensiun' => $this->convertDate($row['Tanggal Pensiun']),
                'dokumen_dasar_pensiun' => $row['Dokumen Dasar Pensiun']
            ]);
        }
    }
    public function createNip($row)
    {
        $nip = NIP::create([
            'nama_lengkap' => $row['Nama'],
            'id_kepegawaian' => substr($row['NIP'], 0, 2),
            'tahun_sk' => $this->getTahunSK($row['NIP']),
            'no_urut_pegawai' => substr($row['NIP'], 4, 5)
        ]);
        if ($nip) {
            return true;
        }
    }
    public function collection(Collection $rows)
    {
        foreach ($rows as  $row) {
            $existnip = NIP::where([
                ['id_kepegawaian', substr($row['NIP'], 0, 2)],
                ['tahun_sk', $this->getTahunSK($row['NIP'])],
                ['no_urut_pegawai', substr($row['NIP'], 4, 5)]
            ])->exists();
            $existspegawai = Pegawai::where('nip', $row['NIP'])->exists();
            if ($existnip && !$existspegawai) {
                $this->createPegawai($row);
            } else if (!$existnip && !$existspegawai) {
                $createNip = $this->createNip($row);
                if ($createNip) {
                    $this->createPegawai($row);
                }
            } else if ($existspegawai && !$existnip) {
                $this->createNip($row);
            }
        }
    }
    public function chunkSize(): int
    {
        return 10;
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
