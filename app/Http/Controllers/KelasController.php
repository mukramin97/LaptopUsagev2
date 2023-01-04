<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\Models\Kelas;

use Illuminate\Support\Facades\Validator;

use Yajra\DataTables\DataTables;

use App\Exports\KelasExport;
use App\Imports\KelasImport;
use Maatwebsite\Excel\Facades\Excel;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $kelasDt = Kelas::all();

        $kelasDt = DB::table('table_kelas')
            ->when($request->filterTingkatan, function($query) use($request){ return
                $query->where('table_kelas.tingkatan', $request->filterTingkatan);
            })
            ->select('table_kelas.*',)
            ->get();

            if($request->ajax()){
                $allData = Datatables::of($kelasDt)
                ->addIndexColumn()
                ->addColumn('id', function($row) {
                    return $row->id;
                })
                ->addColumn('nama_kelas', function($row) {
                    return $row->nama_kelas;
                })
                ->addColumn('tingkatan', function($row) {
                    return $row->tingkatan;
                })
                ->rawColumns(['action'])
                ->make(true);
                return $allData;
            }
        
        return view('Kelas.kelas', compact('kelasDt'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Kelas.create_kelas');
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
            'nama_kelas' => 'required|unique:table_kelas|max:25',
            'tingkatan' => 'required',
        ]);

        if(!$validatedData->fails()){
            Kelas::create([
                'nama_kelas' => $request->nama_kelas,
                'tingkatan' => $request->tingkatan,
            ]);
            return redirect('kelas');
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
        

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $editKelas = Kelas::findorfail($id);
        return view('Kelas.edit_kelas', compact('editKelas'));
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
            'nama_kelas' => 'required|unique:table_kelas,nama_kelas,' . $id . '|max:25|min:3',
            'tingkatan' => 'required',
        ]);

        if(!$validatedData->fails()){
            $editKelas = Kelas::findorfail($id);
            $editKelas->nama_kelas = $request->nama_kelas;
            $editKelas->tingkatan = $request->tingkatan;
            $editKelas->save();
            return redirect('kelas');
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

        $deleteKelas = Kelas::find($id);
        $deleteKelas->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Data siswa berhasil dihapus',
            'data' => $deleteKelas,
          ], 200);
    }

    public function kelasExport(){
        return Excel::download(new KelasExport, 'kelas.xlsx');
    }

    public function kelasImport(Request $request){
        $file = $request->file('file');
        $namaFile = $file->getClientOriginalName();
        $file->move(public_path('DataKelas'), $namaFile);

        Excel::import(new KelasImport, public_path('DataKelas/'.$namaFile));
        return redirect('kelas');
    }

}
