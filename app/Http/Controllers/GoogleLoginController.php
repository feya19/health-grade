<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Exception;

class GoogleLoginController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();
            $finduser = User::where('google_id', $user->id)->first();

            if ($finduser) {
                Auth::login($finduser);
                return $this->redirectBasedOnBioStatus($finduser);
            } else {
                $newUser = User::updateOrCreate(['email' => $user->email], [
                    'name' => $user->name,
                    'google_id' => $user->id,
                    'email_verified_at' => now(),
                    'password' => bcrypt('password')
                ]);

                Auth::login($newUser);

                // New user always redirected to bio page
                return redirect()->intended('bio');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * Redirect user based on bio completion status
     */
    protected function redirectBasedOnBioStatus(User $user)
    {
        if ($this->isBioComplete($user)) {
            return redirect()->intended('dashboard');
        }
        return redirect()->intended('bio');
    }

    /**
     * Check if user has completed all bio information
     */
    protected function isBioComplete(User $user): bool
    {
        return $user->gender !== null
            && $user->berat_badan !== null
            && $user->tinggi_badan !== null
            && $user->date_of_birth !== null;
    }
}
