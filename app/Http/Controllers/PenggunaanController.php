<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\Models\Penggunaan;
use App\Models\Kelas;
use App\Models\Siswa;
use Carbon\Carbon;


use Yajra\DataTables\DataTables;

use App\Exports\PenggunaanExport;
use Maatwebsite\Excel\Facades\Excel;

class PenggunaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $penggunaanDt = Penggunaan::get();
        $kelasDt = Kelas::all();

        $penggunaanDt = DB::table('table_penggunaan')
            ->join('table_siswa', 'table_penggunaan.siswa_id', '=', 'table_siswa.id')
            ->join('table_kelas', 'table_siswa.kelas_id', '=', 'table_kelas.id')
            ->when($request->filterKelas, function($query) use($request){ return
                $query->where('table_siswa.kelas_id', $request->filterKelas);
            })
            ->when($request->startDate && $request->endDate, function($query) use($request){
                $endDate = Carbon::parse($request->endDate)->addDays(1);
                return $query->whereBetween('table_penggunaan.tanggal_pinjam', [$request->startDate, $endDate]);
            })
            ->orderBy('table_penggunaan.tanggal_pinjam', 'desc')
            ->select('table_penggunaan.*','table_siswa.nama', 'table_siswa.NISN', 'table_kelas.nama_kelas', )
            ->get();

            if($request->ajax()){
                $allData = Datatables::of($penggunaanDt)
                ->addIndexColumn()
                ->addColumn('tanggal_pinjam', function($row) {
                    return $row->tanggal_pinjam;
                })
                ->addColumn('tanggal_kembali', function($row) {
                    return $row->tanggal_kembali;
                })
                ->addColumn('nama_kelas', function($row) {
                    return $row->nama_kelas;
                })
                ->addColumn('NISN', function($row) {
                    return $row->NISN;
                })
                ->rawColumns(['action', 'nama_kelas', 'NISN'])
                ->make(true);

                return $allData;
            }

        return view('Penggunaan.penggunaan', compact('penggunaanDt', 'kelasDt'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $currentDateTime = Carbon::now();
        $penggunaan = Penggunaan::create([
            'siswa_id' => $request->siswa_id,
            'tanggal_pinjam' => $currentDateTime,
        ]);
        return response()->json([
            'message' => 'Data Penggunaan Siswa Berhasil Ditambah!',
            'data' => $penggunaan,
          ], 200);
    }

    public function storeByNISN(Request $request)
    {
        $currentDateTime = Carbon::now();
        $nisn = $request->filterNISN;
        $siswa = Siswa::where("NISN", $nisn)->first();
        if($siswa){
            $penggunaan_terakhir = $siswa->penggunaan()->latest()->first();
            if ($penggunaan_terakhir && !$penggunaan_terakhir->tanggal_kembali) {
                return response()->json([
                    'status' => 'laptop masih digunakan',
                    'message' => 'Laptop masih digunakan, kembalikan laptop terlebih dahulu',
                ]);
            }
            $penggunaan = Penggunaan::create([
                'siswa_id' => $siswa->id,
                'tanggal_pinjam' => $currentDateTime,
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Data Penggunaan Siswa Berhasil Ditambah!',
                'data' => $penggunaan,
              ], 200);
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'Siswa tidak ditemukan'
            ]);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $currentDateTime = Carbon::now();
        $editPenggunaan = Penggunaan::findorfail($id);
        $editPenggunaan->tanggal_kembali = $currentDateTime;
        $editPenggunaan->save();
        return response()->json([
            'message' => 'Data Penggunaan Berhasil Ditambah!',
            'data' => $editPenggunaan,
          ], 200);
    }

    public function updateByNISN(Request $request)
    {
        $currentDateTime = Carbon::now();
        $nisn = $request->filterNISNKembali;
        $siswa = Siswa::where("NISN", $nisn)->first();

        if($siswa){
            $penggunaan_terakhir = $siswa->penggunaan()->latest()->first();
            if ($penggunaan_terakhir && !$penggunaan_terakhir->tanggal_kembali) {
                $penggunaan_terakhir->tanggal_kembali = $currentDateTime;
                $penggunaan_terakhir->save();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Data Penggunaan Berhasil Ditambah!',
                    'data' => $penggunaan_terakhir,
                  ], 200);
            }
            else{
                return response()->json([
                    'status' => 'laptop belum dipinjam',
                    'message' => 'Laptop belum dipinjam!',
                    'data' => $penggunaan_terakhir,
                  ], 200);
            }
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'Siswa tidak ditemukan'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deletePenggunaan = Penggunaan::find($id);
        $deletePenggunaan->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Data penggunaan berhasil dihapus',
            'data' => $deletePenggunaan,
          ], 200);
        
    }

    public function penggunaanExport(Request $request){
        $kelasId = $request->filterKelas;
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        return Excel::download(new PenggunaanExport($kelasId, $startDate, $endDate), 'penggunaan.xlsx');
    }
}
