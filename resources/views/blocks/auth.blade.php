<form action="{{ route('login') }}" method="POST" novalidate>
    @csrf
    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text"  value="{{ old('username') }}" class="form-control @error('username') is-invalid  @enderror was-validated" name="username">
        @error('username')
        <p class="invalid-feedback">{{ $message }}</p>
        @enderror
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control @error('password') is-invalid @enderror " name="password">
        @error('password')
        <p class="invalid-feedback">{{ $message }}</p>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary">Submit</button><br>
    <div class="auth_socials mt-3">
        <a href="{{ route('auth.github') }}"><i class="h1 text-dark fa-brands fa-github"></i></a>
        <a href="{{ route('auth.google') }}"><i class="h1 text-primary fa-brands fa-google"></i></a>
    </div>
</form>

