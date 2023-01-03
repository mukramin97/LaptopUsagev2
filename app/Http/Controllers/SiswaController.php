<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Laptop;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Penggunaan;

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
    public function index()
    {
        $siswaDt = Siswa::all();
        return view('Siswa.siswa', compact('siswaDt'));
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

        return redirect('siswa')->with('toast_success', 'Data Siswa Berhasil Ditambah!');
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

        return redirect('siswa')->with('toast_success', 'Data Siswa Berhasil Diubah!');
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
        return redirect('siswa')->with('toast_success', 'Kelas Berhasil Dihapus!');
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
