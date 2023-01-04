<?php

namespace App\Exports;

use App\Models\Kelas;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KelasExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Kelas::all()->map(function ($kelas) {
            return [
                'nama_kelas' => $kelas->nama_kelas,
                'tingkatan' => $kelas->tingkatan,
            ];
        });
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Nama Kelas',
            'Tingkatan',
        ];
    }
}
