<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Type;
use Illuminate\Support\Str;
use App\Functions\Helper;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = Type::paginate(8);
        return view('admin.type.index', compact('types'));
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
        $exist = Type::where('name', $request->name)->exists();

        if ($exist) {
            return redirect()->route('admin.type.index')->with('error', 'Categoria già esistente');
        }
        $new_type = new Type();
        $new_type->name = $request->name;
        $new_type->slug = Str::slug($request->name, '-');
        $new_type->save();
        return redirect()->route('admin.type.index')->with('success', 'Categoria creata con successo');
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
    public function update(Request $request, Type $type)
    {
        $val_data = $request->validate([
            'name' => 'required|min:2|max:20',
        ],[
            'name.required' => 'Devi inserire il nome della categoria',
            'name.min' => 'Il nome della categoria deve essere minimo 2 caratteri',
            'name.max' => 'Il nome della categoria deve essere massimo 20 caratteri'
        ]);


        $exist = Type::where('name', $request->name)->first();
        if($exist){
            return redirect()->route('admin.type.index')->with('error', 'Categoria già presente');
        }


        $val_data['slug'] = Helper::generateSlug($request->name, Type::class);


        $type->update($val_data);


        return redirect()->route('admin.type.index')->with('success', 'Categoria aggiornata con successo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Type $type)
    {
        $type->delete();
        return redirect()->route('admin.type.index')->with('success', 'Categoria eliminata con successo');
    }
}
