<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('google_id', $googleUser->id)
                ->orWhere('email', $googleUser->email)
                ->first();

            if (! $user) {
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password' => str()->random(24),
                    'role' => User::ROLE_CUSTOMER,
                ]);
                $user->ensureCustomerProfile();
            } elseif (! $user->google_id) {
                $user->update(['google_id' => $googleUser->id]);
            }

            Auth::login($user, true);
            request()->session()->regenerate();

            return redirect()->intended(route($user->dashboardRoute()));
        } catch (\Throwable $e) {
            report($e);

            return redirect()->route('login')->with('error', 'Gagal login dengan Google.');
        }
    }
}
