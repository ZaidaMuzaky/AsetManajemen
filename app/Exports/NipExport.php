<?php

namespace App\Exports;

use App\Models\NIP;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class NipExport implements FromCollection, WithHeadings, WithTitle
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
            "ID Kepegawaian",
            "Tahun SK",
            "Nomor Urut",
            "Nama Lengkap",
        ];
    }
    public function title(): string
    {
        return 'Data NIP';
    }
}
