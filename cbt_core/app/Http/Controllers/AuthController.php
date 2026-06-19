<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm($slug = null)
    {
        if ($slug) {
            $tenant = \App\Models\Tenant::where('slug', $slug)->first();
            if (!$tenant) {
                abort(404, 'Sekolah tidak ditemukan.');
            }
            return view('auth.login', ['tenant' => $tenant]);
        }

        return view('auth.login', ['tenant' => null]);
    }

    public function login(Request $request, $slug = null)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $user = Auth::user();

            // Check if login is via school domain and matches
            if ($slug) {
                $tenant = \App\Models\Tenant::where('slug', $slug)->first();
                if (!$tenant || $user->tenant_id !== $tenant->id) {
                    Auth::logout();
                    return back()->withErrors(['email' => 'Akun Anda tidak terdaftar di sekolah ini.']);
                }
            }

            // Route user based on their role
            if ($user->isSuperAdmin()) {
                return redirect()->route('superadmin.dashboard');
            }

            // Ensure tenant is active
            $tenant = $user->tenant;
            if ($tenant) {
                if (!$tenant->is_active) {
                    Auth::logout();
                    return back()->withErrors(['email' => 'Sekolah Anda sedang ditangguhkan. Hubungi Super Admin.']);
                }
                
                // Store tenant data to session
                session([
                    'tenant_id' => $tenant->id,
                    'tenant_slug' => $tenant->slug,
                    'tenant_name' => $tenant->nama_sekolah
                ]);

                if ($tenant->isExpired()) {
                    return redirect()->route('tenant.expired', ['slug' => $tenant->slug]);
                }
            }

            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard', ['slug' => $tenant->slug]);
            } elseif ($user->isTeacher()) {
                return redirect()->route('teacher.dashboard', ['slug' => $tenant->slug]);
            } elseif ($user->isStudent()) {
                return redirect()->route('student.dashboard', ['slug' => $tenant->slug]);
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        $slug = session('tenant_slug');
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($slug) {
            return redirect()->route('school.login', ['slug' => $slug]);
        }

        return redirect()->route('login');
    }

    public function expired($slug)
    {
        $tenant = \App\Models\Tenant::where('slug', $slug)->firstOrFail();
        return view('auth.expired', ['tenant' => $tenant]);
    }
}
