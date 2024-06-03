<?php

namespace App\Services;

class GitHubService
{
    public function login()
    {
        $githubUser = \Laravel\Socialite\Facades\Socialite::driver('github')->user();

        $user = \App\Models\User::updateOrCreate([
            'email' => $githubUser->email
        ], [
            'name' => $githubUser->nickname,
            'email' => $githubUser->email,
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
        ]);

        \Illuminate\Support\Facades\Auth::login($user);

        return redirect('/');
    }
}
