<?php

namespace App\Imports;

use App\Models\Kelas;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class KelasImport implements ToModel, WithStartRow
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
        return new Kelas([
            'nama_kelas' => $row[0],
            'tingkatan' => $row[1],
        ]);
    }
}
