<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CentrePoint;
use App\Models\Space;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class SpaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('space.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $centrepoint = CentrePoint::get()->first();
        $category    = Category::get();
        return view('space.create', [
            'centrepoint' => $centrepoint,
            'category'    => $category
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'content' => 'required',
            'image' => 'image|mimes:png,jpg,jpeg',
            'category' => 'required',
            'location' => 'required'
        ]);

        $spaces = new Space;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '_' . $file->getClientOriginalName();
            $file->move('uploads/imgCover/', $imageName);
        }
        $spaces->image = $imageName;
        $spaces->name = $request->input('name');
        $spaces->slug = Str::slug($request->name, '-');
        $spaces->location = $request->input('location');
        $spaces->content = $request->input('content');

        //return dd($spaces);
         $spaces->save();
         $spaces->getCategory()->sync($request->category);

         if ($spaces) {
            return redirect()->route('space.index')->with('success', 'Data berhasil disimpan');
        } else {
            return redirect()->route('spaceI.index')->with('error', 'Data gagal disimpan');
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
    public function edit(Space $space)
    {
        $category = Category::all();
        $space = Space::findOrFail($space->id);
        return view('space.edit',[
            'category' => $category,
            'space' => $space
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Space $space)
    {
        $this->validate($request, [
            'name' => 'required',
            'content' => 'required',
            'image' => 'image|mimes:png,jpg,jpeg',
            'category' => 'required',
            'location' => 'required'
        ]);

        $space = Space::findOrFail($space->id);
        if ($request->hasFile('image')) {
            if (File::exists("uploads/imgCover/".$space->image)) {
                File::delete("uploads/imgCover/".$space->image);
            }
            $file = $request->file("image");
            $space->image = time().'_'. $file->getClientOriginalName();
            $file->move('uploads/imgCover/',$space->image);
            $request['image'] = $space->image;
        }

        $space->update([
            'name' => $request->name,
            'location' => $request->location,
            'content' => $request->content,
            'slug' => Str::slug($request->name,'-'),
        ]);
        $space->getCategory()->sync($request->category);

        if ($space) {
            return redirect()->route('space.index')->with('success', 'Data berhasil diupdate');
        } else {
            return redirect()->route('space.index')->with('error', 'Data gagal diupdate');
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
        $space = Space::findOrFail($id);
        if (File::exists("uploads/imgCover/".$space->image)) {
            File::delete("uploads/imgCover/".$space->image);
        }
        $space->delete();
        $space->getCategory()->detach();
        return redirect()->route('space.index');

    }
}
