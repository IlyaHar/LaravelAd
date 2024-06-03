@extends('layouts.main')

@section('title') Create advertisement @endsection

@section('content')
    <h1 class="text-primary-emphasis">Create advertisement</h1><br>
    <form action="{{ route('advertisements.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}">
            @error('title')
            <p class="invalid-feedback">{{ $message }}</p>
            @enderror()
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" value="{{ old('image') }}">
            @error('image')
            <p class="invalid-feedback">{{ $message }}</p>
            @enderror()
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea rows="7" name="description" id="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
            @error('description')
            <p class="invalid-feedback">{{ $message }}</p>
            @enderror()
        </div>
        <input type="submit" class="btn btn-primary" value="Create">
    </form>
@endsection
