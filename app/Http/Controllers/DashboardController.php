<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\Laptop;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Penggunaan;


use DataTables;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $kelasDt = Kelas::get();
        $dashboardDt = Siswa::get();
        
      
        //Thanks ChatGPT, i don't know how it is working!
        $dashboardDt = DB::table('table_siswa')
            ->leftJoin(DB::raw('(SELECT p.* FROM table_penggunaan p INNER JOIN (SELECT siswa_id, MAX(tanggal_pinjam) AS max_created_at FROM table_penggunaan GROUP BY siswa_id) t ON p.siswa_id = t.siswa_id AND p.tanggal_pinjam = t.max_created_at) AS table_penggunaan'), function($join) {
                $join->on('table_siswa.id', '=', 'table_penggunaan.siswa_id')
                     ->on('table_penggunaan.id', '=', DB::raw('(SELECT id FROM table_penggunaan WHERE siswa_id = table_siswa.id ORDER BY created_at DESC LIMIT 1)'));
            })
            ->join('table_kelas', 'table_siswa.kelas_id', '=', 'table_kelas.id')
            ->when($request->filterKelas, function($query)use ($request){ return
                $query->where('table_siswa.kelas_id', $request->filterKelas);
            })
            ->select('table_siswa.*','table_penggunaan.id AS id_penggunaan', 'table_penggunaan.tanggal_pinjam', 'table_penggunaan.tanggal_kembali', 'table_kelas.nama_kelas')
            ->get();


             //dd($dashboardDt);
        if($request->ajax()){
            $allData = Datatables::of($dashboardDt)
            ->addIndexColumn()
            ->addColumn('tanggal_pinjam', function($row) {
                if($row->tanggal_pinjam !=null){
                    return $row->tanggal_pinjam;
                }
                else{
                    return "No Record";
                }
              })
            ->addColumn('tanggal_kembali', function($row) {
                if($row->tanggal_pinjam !=null){
                    return $row->tanggal_kembali;
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
        return view('Dashboard.home', compact('kelasDt', 'dashboardDt'));
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
