<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeUserMail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Exception;

class GoogleAuthController extends Controller
{
    /**
     * Redirect user to Google
     */
    public function redirect()
    {
        return Socialite::driver('google')
            ->stateless()
            ->redirect();
    }

    /**
     * Handle Google callback
     */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')
                ->stateless()
                ->user();
        } catch (Exception $e) {
            return redirect('/login')->withErrors([
                'google' => 'Google authentication failed. Please try again.',
            ]);
        }

        $email = $googleUser->getEmail();
        $name = $googleUser->getName() ?: ($googleUser->getNickname() ?: 'User');

        $user = User::where('google_id', $googleUser->id)->first();

        if (!$user) {
            $user = User::where('email', $googleUser->email)->first();
        }

        if (!$user) {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'google_id' => $googleUser->id,
                'email_verified_at' => now(),
                'password' => null,
                'role' => User::ROLE_USER,
            ]);
        } else {
            if (!$user->google_id) {
                $user->update([
                    'google_id' => $googleUser->id,
                ]);
            }
        }

        Auth::login($user, true);

        return redirect()->intended($user->routeFor('dashboard'));
    }

}
