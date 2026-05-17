<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\VolunteerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return Auth::user()->role === 'admin' ? redirect('/admin/dashboard') : redirect('/volunteer/dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            }

            return redirect()->intended('/volunteer/dashboard');
        }

        return back()->withErrors([
            'email' => 'Kombinasi email dan password tidak ditemukan.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return Auth::user()->role === 'admin' ? redirect('/admin/dashboard') : redirect('/volunteer/dashboard');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'whatsapp' => ['required', 'string', 'max:20'],
            'campus_major' => ['required', 'string', 'max:255'],
            'domicile' => ['required', 'string', 'max:255'],
            'interested_subjects' => ['required', 'string'],
            'availability' => ['required', 'string', 'max:255'],
            'motivation' => ['required', 'string'],
            'ktm_photo' => ['nullable', 'image', 'max:5120'], // max 5MB
        ]);

        $ktmPath = null;
        if ($request->hasFile('ktm_photo')) {
            $ktmPath = $request->file('ktm_photo')->store('ktm', 'public');
        } else {
            // Fallback default image if no file uploaded
            $ktmPath = 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=400&auto=format&fit=crop&q=80';
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'volunteer',
            'status' => 'pending', // pending admin verification
        ]);

        VolunteerProfile::create([
            'user_id' => $user->id,
            'whatsapp' => $request->whatsapp,
            'campus_major' => $request->campus_major,
            'domicile' => $request->domicile,
            'interested_subjects' => $request->interested_subjects,
            'availability' => $request->availability,
            'motivation' => $request->motivation,
            'ktm_photo' => $ktmPath,
        ]);

        Auth::login($user);

        return redirect('/volunteer/dashboard')->with('success', 'Pendaftaran berhasil! Akun Anda sedang menunggu verifikasi dari Admin.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda telah berhasil logout.');
    }
}
