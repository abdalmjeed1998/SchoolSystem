<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

 
    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::updateOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'password' => Hash::make(uniqid()),
            ]
        );

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        $facebookUser = Socialite::driver('facebook')->user();

        $user = User::updateOrCreate(
            ['email' => $facebookUser->getEmail()],
            [
                'name' => $facebookUser->getName(),
                'password' => Hash::make(uniqid()),
            ]
        );

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
