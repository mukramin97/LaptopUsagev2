<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Kelas;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = Kelas::all();
        return view('Kelas.kelas', compact('datas'));
        
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
        //dd($request->all());
        Kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'tingkatan' => $request->tingkatan,
        ]);

        return redirect('kelas')->with('toast_success', 'Data Kelas Berhasil Ditambah!');
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

        $editKelas = Kelas::find($id);
        $editKelas->nama_kelas = $request->nama_kelas;
        $editKelas->tingkatan = $request->tingkatan;
        $editKelas->save();
        return redirect('kelas')->with('toast_success', 'Data Kelas Berhasil Diubah!');

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
        return redirect('kelas')->with('toast_success', 'Kelas Berhasil Dihapus!');
    }
}
