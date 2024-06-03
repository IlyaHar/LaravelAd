<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Services\BitbucketService;
use App\Services\CreateUserService;
use App\Services\GitHubService;
use App\Services\GoogleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $conditionals = $request->validate([
            'username' => ['required', 'min:3', 'max:255'],
            'password' => ['required', 'min:8'],
        ]);

        $user =  User::query()->where('name', '=', $conditionals['username'])->first();

        if (null === $user) {
            $user = User::create(
                [
                    'name' => $conditionals['username'],
                    'email' => fake()->safeEmail,
                    'email_verified_at' => now(),
                    'password' => $conditionals['password'],
                    'remember_token' => Str::random(10),
                ]
            );
        } else {
            if (!Hash::check($conditionals['password'], $user->password)) {
                return back()->withErrors(['password' => 'The provided credentials do not match our records.'])->withInput();
            };
        }

        Auth::login($user);

        $request->session()->regenerate();

        return back();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return back();
    }

    public function loginByGitHub(GitHubService $service)
    {
       return $service->login();
    }

    public function loginByGoogle(GoogleService $service)
    {
        return $service->login();
    }

    public function loginByBitbucket(BitbucketService $service)
    {
        return $service->login();
    }
}
