@extends('layouts.admin')

@section('content')
    <div class="create">
        <h1 class="text-center">Add new Project</h1>

        @if (session('success'))
            <div id="error-message" class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="container-fluid my-5">
            <div class="row">
                <div class="col">


                    <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bolder">Name:</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                id="name" value="{{ old('name') }}">
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="type_id" class="form-label fw-bolder">Type:</label>
                            <select name="type_id" class="form-select" id="type_id">
                                <option value="">Choose the type:</option>
                                @foreach ($types as $type)
                                    <option value="{{ $type->id }}" @if ($type->id == old('type_id', $project?->type?->id)) selected @endif>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">

                                @foreach ($technologies as $technology)
                                <input
                                    type="checkbox"
                                    class="btn-check"
                                    id="technology_{{ $technology->id }}"
                                    autocomplete="off"
                                    name="technologies[]"
                                    value="{{ $technology->id }}">
                                <label class="btn btn-outline-primary" for="technology_{{ $technology->id }}">{{ $technology->name }}</label>
                                @endforeach

                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="date_start" class="form-label fw-bolder">Date
                                start:</label>
                            <input type="date" name="date_start"
                                class="form-control @error('date_start') is-invalid @enderror" id="date_start"
                                value="{{ old('date_start') }}">
                            @error('date_start')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label fw-bolder">Image:</label>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                                id="image" value="{{ old('image') }}">
                            @error('image')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="thumb w-25 mb-4">
                            <label for="imagePreview" class="form-label d-block fw-bolder">Image preview</label>
                            <img id="imagePreview"
                                src="{{ old('image') ? asset('storage/' . old('image')) : 'https://via.placeholder.com/200x200' }}"
                                class="img-fluid" alt="">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label "><strong>Description:</strong></label>

                                <textarea id="editor" class="form-control ck-editor__editable @error('editor') is-invalid @enderror " rows="3"
                                    name="description">{{ old('description') }}</textarea>
                                @error('editor')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            {{-- <small class="text-muted">Characters remaining: <span id="char-count">500</span></small> --}}
                        </div>

                        <button type="submit" class="btn btn-primary">Add</button>
                        <a href="{{ route('admin.projects.index') }}" type="reset" class="btn btn-secondary">Abort</a>
                    </form>


                </div>
            </div>
        </div>
    </div>


    <script>
        // function conto(maxLength) {
        //     let c = document.getElementById('description').value;
        //     document.getElementById('char-count').innerHTML = maxLength - c.length;
        // }

        document.getElementById('image').addEventListener('change', function() {
            const preview = document.getElementById('imagePreview');
            const fileInput = this;

            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                };

                reader.readAsDataURL(fileInput.files[0]);
            }
        });

        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });
    </script>



@endsection


@section('title')
    | Add new Project
@endsection
