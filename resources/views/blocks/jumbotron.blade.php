@guest()
<div class="container">
    <div class="p-5 mb-5 bg-body-tertiary rounded-3">
        <div class="container-fluid py-5">
            <h1 class="display-5 fw-bold">Hello!</h1>
            <p class="col-md-8 fs-4">It is website where you can create a lot of advertisements!</p>
            <p><strong class="col-md-8 fs-4">You need to login to create new advertisement</strong></p>
        </div>
    </div>
</div>
@endguest

@auth()
    <div class="container">
        <div class="p-5 mb-5 bg-body-tertiary rounded-3">
            <div class="container-fluid py-5">
                <h1 class="display-5 fw-bold">Hello, {{ \Illuminate\Support\Facades\Auth::user()->name }}!</h1>
                <p class="col-md-8 fs-4">Are you going to create new advertisement ?</p>

                @php
                    $latestAdvertisement = \Illuminate\Support\Facades\Auth::user()->advertisements()->latest()->first();
                @endphp

                @if($latestAdvertisement)
                <p>Last time you created advertisement {{ $latestAdvertisement->created_at->diffForHumans() }} </p>
                @else
                    <p>You haven't created any advertisement yet</p>
                @endif
                <a href="{{ route('advertisements.create') }}" class="btn btn-primary">Create Ad</a>
                <a class="btn btn-secondary mx-2" href="{{ route('logout') }}" >Logout</a>
            </div>
        </div>
    </div>
@endauth
