<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // 🌟 PASTIKAN INI ADA
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    // ... kode redirect ...

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = User::where('google_id', $googleUser->id)->orWhere('email', $googleUser->email)->first();

            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password' => bcrypt(str()->random(24)),
                ]);
            } elseif (!$user->google_id) {
                $user->update(['google_id' => $googleUser->id]);
            }

            Auth::login($user, true); // 🌟 Pastikan Auth bisa dipanggil
            return redirect()->route('home');

        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Gagal login dengan Google.');
        }
    }
}