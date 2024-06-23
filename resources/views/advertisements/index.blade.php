
@extends('layouts.main')

@section('title') Home @endsection

@section('content')
    <div class="advertisements mt-5">
        @forelse(\Illuminate\Support\Facades\Auth::user()->advertisements  as $ad)
            <div class="card" style="width: 18rem;">
                <img  src="{{ filter_var($ad->image, FILTER_VALIDATE_URL) ? $ad->image : 'storage/img/advertisements/' . $ad->image }}" class="card-img-top card-image" alt="...">
                <div class="card-body">
                    <h5 class="card-title">{{ $ad->title }}</h5>
                    <p class="card-text">{{ \Illuminate\Support\Str::limit($ad->description, 50) }}</p>
                    <p><small>Created: {{ $ad->created_at->diffForHumans() }}</small></p>
                    <a href="{{ route('advertisements.show', $ad->id) }}" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        @empty
            <h4><strong>You haven't created any advertisements yet</strong></h4>
        @endforelse
    </div>
@endsection





