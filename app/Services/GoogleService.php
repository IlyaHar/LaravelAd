<?php

namespace App\Services;

class GoogleService
{
    public function login()
    {
        $googleUser = \Laravel\Socialite\Facades\Socialite::driver('google')->user();

        $user = \App\Models\User::updateOrCreate([
            'email' => $googleUser->email
        ], [
            'name' => $googleUser->name,
            'email' => $googleUser->email,
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
        ]);

        \Illuminate\Support\Facades\Auth::login($user);

        return redirect('/');
    }
}
