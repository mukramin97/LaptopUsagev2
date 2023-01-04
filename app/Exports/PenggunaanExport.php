<?php

namespace App\Exports;

use App\Models\Penggunaan;
use App\Models\Kelas;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class PenggunaanExport implements FromCollection, WithHeadings
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
        $data = Penggunaan::query()
                   ->join('table_siswa', 'table_siswa.id', '=', 'table_penggunaan.siswa_id')
                   ->join('table_kelas', 'table_kelas.id', '=', 'table_siswa.kelas_id')
                   ->select('table_siswa.nama', 'table_siswa.NISN', 'table_kelas.nama_kelas','table_kelas.tingkatan', 'table_penggunaan.tanggal_pinjam', 'table_penggunaan.tanggal_kembali');

        // Filter by kelas_id if it is not null
        if ($this->kelasId) {
        $data = $data->where('table_siswa.kelas_id', $this->kelasId);
        }

        // Filter by tanggal if startDate and endDate are not null
        if ($this->startDate && $this->endDate) {

            $endDate1 = Carbon::parse($this->endDate)->addDays(1);
            $data = $data->whereBetween('tanggal_pinjam', [$this->startDate, $endDate1]);
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
            'Tanggal Pinjam',
            'Tanggal Kembali',
        ];
    }
}
