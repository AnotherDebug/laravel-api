@extends('layouts.admin')



@section('content')
    <div class="projectDetail ms-5 pt-5 pe-5">
        <h1 class="text-center border-bottom mb-4 p-3">{{ $project->name }} <td><a class="btn btn-warning"
                    href="{{ route('admin.projects.edit', $project) }}"><i class="fa-solid fa-pencil"></i></a></td>
            @include('admin.partials.form-delete', [
                'route' => route('admin.projects.destroy', $project),
                'message' => 'Sei sicuro di voler eliminare questa categoria?',
            ])</h1>

        @if ($project->type)
            <p><strong>Type:</strong> {{ $project->type->name }}</p>
        @endif


        @forelse ($project->technologies as $technology)
            <span class="badge text-bg-primary ">{{ $technology->name }}</span>
        @empty
            <span class="badge text-bg-warning">No Technology</span>
        @endforelse

        <p class="mt-3"><strong>Date Start:</strong> {{ $project->date_start }}</p>
        <p><strong>Description:</strong> {!! $project->description !!}</p>
        <div class="img">
            <img class="w-50" src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->image_original_name }}">
        </div>
        <p>{{ $project->image_original_name }}</p>
    </div>
@endsection


@section('title')
    | Projects Detail
@endsection
