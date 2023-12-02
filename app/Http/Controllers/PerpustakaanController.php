<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\Models\Perpustakaan;
use App\Models\Kelas;
use App\Models\Siswa;

use Carbon\Carbon;

use Yajra\DataTables\DataTables;

use App\Exports\PerpustakaanExport;
use Maatwebsite\Excel\Facades\Excel;

class PerpustakaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $kelasDt = Kelas::get();
        $perpustakaanDt = Siswa::get();
        $currentDate = Carbon::today();
        $count_siswa = Perpustakaan::whereDate('tanggal_masuk', $currentDate)->count();
        
      
        //Thanks ChatGPT, i don't know how it is working!
        $perpustakaanDt = DB::table('table_siswa')
            ->leftJoin(DB::raw('(SELECT p.* FROM table_perpustakaan p INNER JOIN (SELECT siswa_id, MAX(tanggal_masuk) AS max_created_at FROM table_perpustakaan GROUP BY siswa_id) t ON p.siswa_id = t.siswa_id AND p.tanggal_masuk = t.max_created_at) AS table_perpustakaan'), function($join) {
                $join->on('table_siswa.id', '=', 'table_perpustakaan.siswa_id')
                     ->on('table_perpustakaan.id', '=', DB::raw('(SELECT id FROM table_perpustakaan WHERE siswa_id = table_siswa.id ORDER BY created_at DESC LIMIT 1)'));
            })
            ->join('table_kelas', 'table_siswa.kelas_id', '=', 'table_kelas.id')
            ->when($request->filterKelas, function($query)use ($request){ return
                $query->where('table_siswa.kelas_id', $request->filterKelas);
            })
            ->select('table_siswa.*','table_perpustakaan.id AS id_perpustakaan', 'table_perpustakaan.tanggal_masuk', 'table_perpustakaan.tanggal_keluar', 'table_kelas.nama_kelas',)
            ->get();


             //dd($dashboardDt);
        if($request->ajax()){
            $allData = Datatables::of($perpustakaanDt)
            ->addIndexColumn()
            ->addColumn('tanggal_masuk', function($row) {
                if($row->tanggal_masuk !=null){
                    return $row->tanggal_masuk;
                }
                else{
                    return "No Record";
                }
              })
            ->addColumn('tanggal_keluar', function($row) {
                if($row->tanggal_masuk !=null){
                    return $row->tanggal_keluar;
                }
                else{
                    return "No Record";
                }
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

        return view('Perpustakaan.perpustakaan', compact('kelasDt', 'perpustakaanDt', 'count_siswa'));
    }

    public function indexData(Request $request){

        $perpustakaanDt = Perpustakaan::get();
        $kelasDt = Kelas::all();

        $perpustakaanDt = DB::table('table_perpustakaan')
            ->join('table_siswa', 'table_perpustakaan.siswa_id', '=', 'table_siswa.id')
            ->join('table_kelas', 'table_siswa.kelas_id', '=', 'table_kelas.id')
            ->when($request->filterKelas, function($query) use($request){ return
                $query->where('table_siswa.kelas_id', $request->filterKelas);
            })
            ->when($request->startDate && $request->endDate, function($query) use($request){
                $endDate = Carbon::parse($request->endDate)->addDays(1);
                return $query->whereBetween('table_perpustakaan.tanggal_masuk', [$request->startDate, $endDate]);
            })
            ->orderBy('table_perpustakaan.tanggal_masuk', 'desc')
            ->select('table_perpustakaan.*','table_siswa.nama', 'table_siswa.NISN', 'table_kelas.nama_kelas', )
            ->get();

            if($request->ajax()){
                $allData = Datatables::of($perpustakaanDt)
                ->addIndexColumn()
                ->addColumn('tanggal_masuk', function($row) {
                    return $row->tanggal_masuk;
                })
                ->addColumn('tanggal_keluar', function($row) {
                    return $row->tanggal_keluar;
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

        return view('Perpustakaan.perpustakaanData', compact('perpustakaanDt', 'kelasDt'));
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
        $perpustakaan = Perpustakaan::create([
            'siswa_id' => $request->siswa_id,
            'tanggal_masuk' => $currentDateTime,
        ]);
        return response()->json([
            'message' => 'Data siswa masuk berhasil tercatat!',
            'data' => $perpustakaan,
          ], 200);
    }

    public function storePerpusByNISN(Request $request)
    {
        $currentDateTime = Carbon::now();
        $nisn = $request->filterNISN;
        $siswa = Siswa::where("NISN", $nisn)->first();
        if($siswa){
            $perpustakaan_terakhir = $siswa->perpustakaan()->latest()->first();
            if ($perpustakaan_terakhir && !$perpustakaan_terakhir->tanggal_keluar) {
                return response()->json([
                    'status' => 'siswa masih di dalam perpustakaan',
                    'message' => 'Siswa masih di dalam perpustakaan, input keluar terlebih dahulu!',
                ]);
            }
            $perpustakaan = Perpustakaan::create([
                'siswa_id' => $siswa->id,
                'tanggal_masuk' => $currentDateTime,
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Siswa masuk perpustakaan berhasil tercatat!',
                'data' => $perpustakaan,
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
        $editPerpus = Perpustakaan::findorfail($id);
        $editPerpus->tanggal_keluar = $currentDateTime;
        $editPerpus->save();
        return response()->json([
            'message' => 'Data siswa keluar berhasil tercatat!',
            'data' => $editPerpus,
          ], 200);
    }

    public function updatePerpusByNISN(Request $request)
    {
        $currentDateTime = Carbon::now();
        $nisn = $request->filterNISNKembali;
        $siswa = Siswa::where("NISN", $nisn)->first();

        if($siswa){
            $perpustakaan_terakhir = $siswa->perpustakaan()->latest()->first();
            if ($perpustakaan_terakhir && !$perpustakaan_terakhir->tanggal_keluar) {
                $perpustakaan_terakhir->tanggal_keluar = $currentDateTime;
                $perpustakaan_terakhir->save();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Data Siswa keluar berhasil tercatat!',
                    'data' => $perpustakaan_terakhir,
                  ], 200);
            }
            else{
                return response()->json([
                    'status' => 'siswa belum masuk perpustakaan',
                    'message' => 'Siswa belum masuk perpustakaan!',
                    'data' => $perpustakaan_terakhir,
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
        $deletePerpustakaan = Perpustakaan::find($id);
        $deletePerpustakaan->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Data perpustakaan berhasil dihapus',
            'data' => $deletePerpustakaan,
          ], 200);
        
    }

    public function perpustakaanExport(Request $request){
        $kelasId = $request->filterKelas;
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        return Excel::download(new PerpustakaanExport($kelasId, $startDate, $endDate), 'perpustakaan.xlsx');
    }
}
