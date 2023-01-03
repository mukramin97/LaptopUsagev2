<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\Laptop;
use Maatwebsite\Excel\Concerns\ToModel;

class SiswaImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $laptop = Laptop::create([
            'merk' => $row[3],
            'spesifikasi' => $row[4],
        ]);

        $laptopId = $laptop->id;

        return new Siswa([
            'nama' => $row[0],
            'NISN' => $row[1],
            'laptop_id' => $laptopId,
            'kelas_id' => $row[2],
        ]);
    }
}
