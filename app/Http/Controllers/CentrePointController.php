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
        return view('centrepoint.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        $this->validate($request,[
            'location' => 'required'
        ]);

        $centrePoint = new CentrePoint;
        $centrePoint->location = $request->input('location');
        $centrePoint->save();

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
        $centrePoint = CentrePoint::findOrFail($id);
        $centrePoint->delete();
        return redirect()->back();
    }
}
