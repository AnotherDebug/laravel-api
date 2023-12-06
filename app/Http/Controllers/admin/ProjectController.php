<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Functions\Helper;
use App\Models\Technology;
use Illuminate\Support\Facades\Storage;
use App\Models\Type;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::paginate(7);
        return view('admin.projects.index', compact('projects'));
    }

    public function typeProjects(Type $type)
    {


        return view('admin.projects.type-projects', compact('type'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $project = null;
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.projects.create', compact('types', 'project', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        // salvo nella variabile exist il risultato della ricerca
        $exist = Project::where('name', $request->name)->first();
        // se la ricerca ha trovato un risultato parte il messaggio di errore
        if ($exist) {
            return redirect()->route('admin.projects.index')->with('error', 'Progetto già esistente');
        }

        $form_data = $request->all();

        $form_data['slug'] = Helper::generateSlug($request->name, Project::class);

        // se esiste la chiave image salvo l'immagine nel file system e nel database
        if (array_key_exists('image', $form_data)) {
            // prima di salvare il file prendo il nome del file per salvarlo nel db
            $form_data['image_original_name'] = $request->file('image')->getClientOriginalName();
             // salvo il file nello storage rinominandolo
             //dd($form_data);
            $form_data['image'] = Storage::put('uploads', $request->file('image'));

        }

        $new_project = Project::create($form_data);


        if (array_key_exists('technologies', $form_data)) {
            $new_project->technologies()->attach($form_data['technologies']);
        }


        return redirect()->route('admin.projects.create', $new_project)->with('success', 'Progetto inserito con successo');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {

        $types = Type::all();
        $technologies = Technology::all();

        return view('admin.projects.edit', compact('project', 'technologies', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProjectRequest $request, project $project)
    {
        // $project->name = $request->name;
        // $project->slug = Helper::generateSlug($request->name, Project::class);
        // $project->date_start = $request->date_start;
        // $project->description = $request->description;
        // $project->save();

        // return redirect()->route('admin.projects.index');
        $form_data = $request->all();
        if($form_data['name']!= $project->name){
            $form_data['slug'] = Helper::generateSlug($form_data['name'], project::class);
        }else{
            $form_data['slug'] = $project->slug;
        }

        if(array_key_exists('image', $form_data)){
            // se esiste la chiave image vuol dire che devo sostituire l'immagine presente (se c'è) eliminando quella vecchia
            if($project->image){
                // se era presente la elimino dallo storage
                Storage::disk('public')->delete($project->image);
            }

            // prima di salvare il file prendo il nome del file per salvarlo nel db
            $form_data['image_original_name'] = $request->file('image')->getClientOriginalName();
            // salvo il file nello storage rinominandolo
            $form_data['image'] = Storage::put('uploads', $form_data['image']);
        }


        $project->update($form_data);


        if (array_key_exists('technologies', $form_data)) {
            $project->technologies()->sync($form_data['technologies']);
        }


        return redirect()->route('admin.projects.show', $project);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('admin.projects.index');
    }
}
