@extends('layouts.main')

@section('title') {{ $advertisement->title }} @endsection

@section('content')
<div>
    <img src="../storage/img/advertisements/{{ $advertisement->image }}" class="card-img-top ">
    <h2 class="mt-3">{{ $advertisement->title }}</h2>
    <h5>DESCRIPTION</h5>
    <p>
        {{ $advertisement->description }}
    </p>
</div>
@endsection
@section('sidebar')
    <div>
        <h3 class="mt-3">{{ $advertisement->title }}</h3>
        <p><strong>{{ $advertisement->created_at }}</strong></p>
        <span>Author: </span><strong><span>{{ $advertisement->user->name }}</span></strong><br>
        <div class="mt-5">
            <form action="{{ route('advertisements.destroy', $advertisement->id) }}" method="POST">
                @method('DELETE')
                @csrf
                @can('update', $advertisement)
                    <a href="{{ route('advertisements.edit', $advertisement->id) }}" class="btn btn-warning">Edit</a>
                @endcan
                @can('delete', $advertisement)
                    <button type="submit" class="btn btn-danger">Delete</button>
                @endcan
            </form>
        </div>

    </div>
@endsection
