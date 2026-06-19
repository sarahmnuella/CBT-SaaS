<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tenant;

class SuperAdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_tenants' => Tenant::count(),
            'active_tenants' => Tenant::where('is_active', true)->count(),
            'trial_tenants' => Tenant::where('status', 'trial')->count(),
            'premium_tenants' => Tenant::where('status', 'premium')->count(),
        ];

        $tenants = Tenant::latest()->paginate(10);

        return view('superadmin.dashboard', compact('stats', 'tenants'));
    }

    public function updateStatus(Request $request, $id)
    {
        $tenant = Tenant::findOrFail($id);
        $tenant->update([
            'status' => $request->status,
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('success', 'Status sekolah berhasil diperbarui.');
    }

    public function extendPackage(Request $request, $id)
    {
        $request->validate([
            'months' => 'required|integer|min:1',
        ]);

        $tenant = Tenant::findOrFail($id);
        
        $currentExpiry = $tenant->expired_at && $tenant->expired_at->isFuture()
            ? $tenant->expired_at
            : now();
            
        $tenant->update([
            'expired_at' => $currentExpiry->addMonths($request->months),
            'status' => 'premium',
        ]);

        return back()->with('success', "Masa aktif {$tenant->nama_sekolah} berhasil diperpanjang.");
    }

    public function deleteTenant($id)
    {
        $tenant = Tenant::findOrFail($id);
        $tenant->delete();

        return back()->with('success', 'Data sekolah berhasil dihapus.');
    }
}
