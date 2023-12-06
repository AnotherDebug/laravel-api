<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Technology;
use Illuminate\Support\Str;
use App\Functions\Helper;

class TechnologyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $technologies = Technology::paginate(10);
        return view('admin.technologies.index', compact('technologies'));
    }

    public function projectsTechnologies(Technology $technology)
    {
        $projects = $technology->projects;
        return view('admin.technologies.projects-technologies', compact('projects', 'technology'));
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
        $exist = Technology::where('name', $request->name)->exists();

        if ($exist) {
            return redirect()->route('admin.technologies.index')->with('error', 'Categoria già esistente');
        }
        $new_category = new Technology();
        $new_category->name = $request->name;
        $new_category->slug = Str::slug($request->name, '-');
        $new_category->save();
        return redirect()->route('admin.technologies.index')->with('success', 'Categoria creata con successo');
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
    public function update(Request $request, Technology $technology)
    {

        $val_data = $request->validate([
            'name' => 'required|min:2|max:20',
        ],[
            'name.required' => 'Devi inserire il nome della categoria',
            'name.min' => 'Il nome della categoria deve essere minimo 2 caratteri',
            'name.max' => 'Il nome della categoria deve essere massimo 20 caratteri'
        ]);


        $exist = Technology::where('name', $request->name)->first();
        if($exist){
            return redirect()->route('admin.technologies.index')->with('error', 'Categoria già presente');
        }


        $val_data['slug'] = Helper::generateSlug($request->name, Technology::class);


        $technology->update($val_data);


        return redirect()->route('admin.technologies.index')->with('success', 'Categoria aggiornata con successo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Technology $technology)
    {
        $technology->delete();
        return redirect()->route('admin.technologies.index')->with('success', 'Categoria eliminata con successo');
    }
}
