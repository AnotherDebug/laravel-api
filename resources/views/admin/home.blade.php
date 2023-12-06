@extends('layouts.admin')

@section('content')
    <div class="adminHome container">
        <h1 class="m-3 text-center">Home Dashboard</h1>

        <div class="card">
            <h5 class="card-header">Featured</h5>
            <div class="card-body">
                <h5 class="card-title">Projects</h5>
                <p class="card-text">Currently there are n.<strong>{{ $projects }}</strong>.</p>

            </div>
            <div class="card-body bg-body-secondary ">
                <h5 class="card-title">Technologies</h5>
                <p class="card-text">Currently there are n.<strong>{{ $technologies }}</strong>.</p>

            </div>
            <div class="card-body bg-body-tertiary ">
                <h5 class="card-title">Types</h5>
                <p class="card-text">Currently there are n.<strong>{{ $types }}</strong>.</p>

            </div>
        </div>

    </div>
@endsection

@section('title')
    | Dashboard
@endsection
