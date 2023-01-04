<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\Models\Laptop;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Penggunaan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

use Yajra\DataTables\DataTables;

use App\Exports\SiswaExport;
use App\Imports\SiswaImport;
use Maatwebsite\Excel\Facades\Excel;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $siswaDt = Siswa::get();
        $kelasDt = Kelas::all();

        $siswaDt = DB::table('table_siswa')
            ->join('table_kelas', 'table_siswa.kelas_id', '=', 'table_kelas.id')
            ->join('table_laptop', 'table_siswa.laptop_id', '=', 'table_laptop.id')
            ->when($request->filterKelas, function($query) use($request){ return
                $query->where('table_siswa.kelas_id', $request->filterKelas);
            })
            ->select('table_siswa.*','table_kelas.nama_kelas', 'table_laptop.merk', 'table_laptop.spesifikasi', )
            ->get();

            if($request->ajax()){
                $allData = Datatables::of($siswaDt)
                ->addIndexColumn()
                ->addColumn('nama_kelas', function($row) {
                    return $row->nama_kelas;
                })
                ->addColumn('merk', function($row) {
                    return $row->merk;
                })
                ->addColumn('spesifikasi', function($row) {
                    return $row->spesifikasi;
                })
                ->rawColumns(['action', 'nama', 'NISN'])
                ->make(true);
                return $allData;
            }
        
        return view('Siswa.siswa', compact('siswaDt', 'kelasDt'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kelasDt = Kelas::all();
        return view('Siswa.create_siswa', compact('kelasDt'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validatedData = Validator::make($request->all(), [
            'NISN' => 'required|unique:table_siswa|numeric',
            'nama' => 'required|min:3|max:255',
            'kelas' => 'required|exists:table_kelas,id',
            'merk' => 'required|min:3|max:255',
            'spesifikasi' => 'required|min:3|max:255',
        ]);

        if(!$validatedData->fails()){
            $laptop = Laptop::create([
                'merk' => $request->merk,
                'spesifikasi' => $request->spesifikasi,
            ]);
    
            $laptopId = $laptop->id;
    
            Siswa::create([
                'NISN' => $request->NISN,
                'nama' => $request->nama,
                'kelas_id' => $request->kelas,
                'laptop_id' => $laptopId,
            ]);
            return redirect('siswa');
        }
        else{
            return response()->json(['status' => 0, 'error' => $validatedData->errors()->toArray()]);
        };

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
        $editSiswa = Siswa::findorfail($id);
        $kelasDt = Kelas::all();

        return view('Siswa.edit_siswa', compact('editSiswa', 'kelasDt'));
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
        $validatedData = Validator::make($request->all(), [
            'NISN' => 'required|unique:table_siswa,NISN,' . $id . '|numeric',
            'nama' => 'required|min:3|max:255',
            'kelas' => 'required|exists:table_kelas,id',
            'merk' => 'required|min:3|max:255',
            'spesifikasi' => 'required|min:3|max:255',
        ]);

        if(!$validatedData->fails()){
            $editSiswa = Siswa::findorfail($id);
            $editSiswa->NISN = $request->NISN;
            $editSiswa->nama = $request->nama;
            $editSiswa->kelas_id = $request->kelas;
            $laptopId = $editSiswa->laptop_id;
            $editSiswa->save();

            $editLaptop = Laptop::findorfail($laptopId);
            $editLaptop->merk = $request->merk;
            $editLaptop->spesifikasi = $request->spesifikasi;
            $editLaptop->save();
            return redirect('siswa');
        }
        else{
            return response()->json(['status' => 0, 'error' => $validatedData->errors()->toArray()]);
        };   

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteSiswa = Siswa::find($id);
        $deleteSiswa->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Data siswa berhasil dihapus',
            'data' => $deleteSiswa,
          ], 200);
    }

    public function siswaExport(){
        return Excel::download(new SiswaExport, 'siswa.xlsx');
    }

    public function siswaImport(Request $request){
        $file = $request->file('file');
        $namaFile = $file->getClientOriginalName();
        $file->move('DataSiswa', $namaFile);

        Excel::import(new SiswaImport, public_path('DataSiswa/'.$namaFile));
        return redirect('siswa');
    }

}
