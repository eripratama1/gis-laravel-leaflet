<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CentrePoint;
use App\Models\Space;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function categories()
    {
        $categories = Category::orderBy('created_at', 'DESC');
        return datatables()->of($categories)
            ->addColumn('action', 'category.action')
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->toJson();
    }

    public function centrepoint()
    {
        $centrepoint = CentrePoint::orderBy('created_at', 'DESC');
        return datatables()->of($centrepoint)
            ->addColumn('action', 'centrepoint.action')
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->toJson();
    }

    public function spaces()
    {
        $spaces = Space::orderBy('created_at','DESC');
        return datatables()->of($spaces)
        ->addColumn('action','space.action')
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->toJson();
    }
}
