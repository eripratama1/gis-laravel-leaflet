<?php

namespace App\Http\Controllers;

use App\Models\CentrePoint;
use App\Models\Space;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index()
    {
        $centrePoint = CentrePoint::get()->first();
        //$spaces = Space::get()->pluck('location','name')->toArray();
        $spaces = Space::get();
        return view('map',[
            'spaces' => $spaces,
            'centrePoint' => $centrePoint
        ]);
        //return dd($spaces);
    }

    public function show($slug)
    {
        $centrePoint = CentrePoint::get()->first();
        $spaces = Space::where('slug',$slug)->first();
        return view('detail',[
            'centrePoint' => $centrePoint,
            'spaces' => $spaces
        ]);
    }
}
