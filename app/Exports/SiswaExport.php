<?php

namespace App\Exports;

use App\Models\Siswa;
use App\Models\Laptop;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SiswaExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection()
    {
        return Siswa::with('laptop')->get()->map(function ($siswa) {
            return [
                'nama' => $siswa->nama,
                'NISN' => $siswa->NISN,
                'nama_kelas' =>$siswa->kelas->nama_kelas,
                'merk' => $siswa->laptop->merk,
                'spesifikasi' => $siswa->laptop->spesifikasi,
                
            ];
        });
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Nama',
            'NISN',
            'Kelas',
            'Merk Laptop',
            'Spesifikasi',
        ];
    }
}
