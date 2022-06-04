<?php

namespace App\Http\Controllers;

use App\Models\CentrePoint;
use Illuminate\Http\Request;

class CentrePointController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /**
         * Menampilkan data centrepoint dengan datatable
         */
        return view('centrepoint.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /**
         * Menampilkan form create centrepoint
         */
        return view('centrepoint.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Lakukan validasi data
        $this->validate($request,[
            'location' => 'required'
        ]);

        // jalankan proses simpan data ke table centrepoint
        $centrePoint = new CentrePoint;
        $centrePoint->location = $request->input('location');
        $centrePoint->save();

        // setelah data disimpan redirect ke halaman index centrepoint
        if ($centrePoint) {
            return redirect()->route('centre-point.index')->with('success', 'Data berhasil Disimpan');
        } else {
            return redirect()->route('centre-point.index')->with('error', 'Data gagal Disimpan');
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
    public function edit(CentrePoint $centrePoint)
    {
        // Mencari data yang dipilih lalu menampilkannya ke view edit centrepoint
        // dan mempassing $centrePoint ke view edit centrepoint
        $centrePoint = CentrePoint::findOrFail($centrePoint->id);
        return view('centrepoint.edit',[
            'centrePoint' => $centrePoint
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CentrePoint $centrePoint)
    {
        // setelah data centrepoint yang akan di edit sesuai 
        // maka jalankan proses update jika berhasil akan di redirect ke halaman index
        $centrePoint = CentrePoint::findOrFail($centrePoint->id);
        $centrePoint->location = $request->input('location');
        $centrePoint->update();

        if ($centrePoint) {
            return redirect()->route('centre-point.index')->with('success', 'Data berhasil Diupdate');
        } else {
            return redirect()->route('centre-point.index')->with('error', 'Data gagal Diupdate');
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
        // Proses hapus data  dari tabel centrepoint
        $centrePoint = CentrePoint::findOrFail($id);
        $centrePoint->delete();
        return redirect()->back();
    }
}
