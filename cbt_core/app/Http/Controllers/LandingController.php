<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tenant;

class LandingController extends Controller
{
    public function index()
    {
        return view('landing');
    }

    public function showRegisterForm()
    {
        return view('auth.register_tenant');
    }

    public function registerTenant(Request $request)
    {
        $request->validate([
            'nama_sekolah' => 'required|string|max:150',
            'slug' => 'required|alpha_dash|max:80|unique:tenants,slug',
            'email' => 'required|email|max:150|unique:tenants,email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'phone' => 'nullable|string|max:20',
        ], [
            'slug.unique' => 'Slug domain sekolah sudah terdaftar.',
            'email.unique' => 'Email ini sudah terdaftar sebagai akun/sekolah.',
        ]);

        // 1. Create Tenant
        $tenant = Tenant::create([
            'nama_sekolah' => $request->nama_sekolah,
            'slug' => $request->slug,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => 'trial',
            'trial_ends_at' => now()->addDays(14),
            'max_students' => 50,
            'max_teachers' => 10,
            'is_active' => true,
        ]);

        // 2. Create User Admin for this School
        $user = \App\Models\User::create([
            'name' => 'Admin ' . $request->nama_sekolah,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'admin',
            'tenant_id' => $tenant->id,
        ]);

        auth()->login($user);

        return redirect()->route('admin.dashboard', ['slug' => $tenant->slug])
                         ->with('success', 'Sekolah berhasil didaftarkan! Selamat datang di dashboard trial Anda.');
    }
}
