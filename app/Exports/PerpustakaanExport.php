<?php

namespace App\Exports;

use App\Models\Perpustakaan;
use App\Models\Kelas;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class PerpustakaanExport implements FromCollection, WithHeadings
{

    protected $kelasId;
    protected $startDate;
    protected $endDate;

    public function __construct($kelasId, $startDate, $endDate)
    {
        $this->kelasId = $kelasId ?: null;
        $this->startDate = $startDate ?: null;
        $this->endDate = $endDate ?: null;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = Perpustakaan::query()
                   ->join('table_siswa', 'table_siswa.id', '=', 'table_perpustakaan.siswa_id')
                   ->join('table_kelas', 'table_kelas.id', '=', 'table_siswa.kelas_id')
                   ->select('table_siswa.nama', 'table_siswa.NISN', 'table_kelas.nama_kelas','table_kelas.tingkatan', 'table_perpustakaan.tanggal_masuk', 'table_perpustakaan.tanggal_keluar');

        // Filter by kelas_id if it is not null
        if ($this->kelasId) {
        $data = $data->where('table_siswa.kelas_id', $this->kelasId);
        }

        // Filter by tanggal if startDate and endDate are not null
        if ($this->startDate && $this->endDate) {

            $endDate1 = Carbon::parse($this->endDate)->addDays(1);
            $data = $data->whereBetween('tanggal_masuk', [$this->startDate, $endDate1]);
        }
        $data = $data->get();
        return $data;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Nama',
            'NISN',
            'Nama Kelas',
            'Tingkatan',
            'Tanggal Masuk',
            'Tanggal Keluar',
        ];
    }
}
