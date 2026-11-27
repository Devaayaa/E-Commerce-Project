<?php

namespace App\Http\Controllers;

use App\Models\Courier;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route(Auth::user()->dashboardRoute());
        }

        return view('auth.login');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route(Auth::user()->dashboardRoute());
        }

        return view('auth.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'Email atau password salah.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route(Auth::user()->dashboardRoute()));
    }

    public function register(Request $request)
    {
        // Hanya 3 jenis akun yang boleh didaftarkan publik. Role admin tidak pernah bisa dipilih.
        $data = $request->validate([
            'account_type' => ['required', Rule::in([User::ROLE_CUSTOMER, User::ROLE_SELLER, User::ROLE_COURIER])],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],

            // Seller
            'store_name' => ['required_if:account_type,seller', 'nullable', 'string', 'max:255'],
            'store_address' => ['required_if:account_type,seller', 'nullable', 'string', 'max:1000'],

            // Seller & Courier
            'phone' => ['required_if:account_type,seller,courier', 'nullable', 'regex:/^(\+62|62|0)8[0-9]{8,12}$/'],

            // Courier
            'vehicle_type' => ['required_if:account_type,courier', 'nullable', Rule::in(['motor', 'mobil'])],
            'vehicle_plate' => ['required_if:account_type,courier', 'nullable', 'string', 'max:15'],
        ], [
            'phone.regex' => 'Invalid phone number format (e.g., 081234567890).',
        ]);

        $role = $data['account_type'];

        $user = DB::transaction(function () use ($data, $role) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'], // di-hash otomatis oleh cast 'hashed'
                'role' => $role,
            ]);

            match ($role) {
                User::ROLE_SELLER => Seller::create([
                    'user_id' => $user->id,
                    'store_name' => $data['store_name'],
                    'store_slug' => $this->uniqueStoreSlug($data['store_name']),
                    'phone' => $data['phone'],
                    'address' => $data['store_address'],
                    'status' => 'active',
                ]),
                User::ROLE_COURIER => Courier::create([
                    'user_id' => $user->id,
                    'phone' => $data['phone'],
                    'vehicle_type' => $data['vehicle_type'],
                    'vehicle_plate' => strtoupper($data['vehicle_plate']),
                    'status' => 'offline',
                ]),
                default => $user->ensureCustomerProfile(),
            };

            return $user;
        });

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route($user->dashboardRoute())->with('success', 'Account successfully created. Welcome to Loka!');
    }

    private function uniqueStoreSlug(string $name): string
    {
        $base = Str::slug($name) ?: 'toko';
        $slug = $base;
        $i = 1;

        while (Seller::where('store_slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
