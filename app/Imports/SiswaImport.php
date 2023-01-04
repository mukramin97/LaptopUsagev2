<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Laptop;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class SiswaImport implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        return 2;  // The import will start at the third row
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        $kelas = Kelas::where('nama_kelas', $row[2])->first();

        if ($kelas) {
            // If a matching kelas is found, use its id as the kelas_id
            $kelasId = $kelas->id;
        } else {
            // If no matching kelas is found, next row
            return;
        }

        $laptop = Laptop::create([
            'merk' => $row[3],
            'spesifikasi' => $row[4],
        ]);

        $laptopId = $laptop->id;

        return new Siswa([
            'nama' => $row[0],
            'NISN' => $row[1],
            'laptop_id' => $laptopId,
            'kelas_id' => $kelasId,
        ]);
    }
}
