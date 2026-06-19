<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Tenant;

class TenantMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // 1. Resolve school from URL slug: /s/{slug}/...
        $slug = $request->route('slug');
        
        if ($slug) {
            $tenant = Tenant::where('slug', $slug)->first();
            
            if (!$tenant) {
                abort(404, 'Sekolah tidak ditemukan.');
            }
            
            if (!$tenant->is_active) {
                return response()->view('errors.tenant_suspended', ['tenant' => $tenant], 403);
            }

            if ($tenant->isExpired()) {
                return response()->view('errors.tenant_expired', ['tenant' => $tenant], 403);
            }

            // Store tenant info in session and request attributes
            session(['tenant_id' => $tenant->id, 'tenant_slug' => $tenant->slug, 'tenant_name' => $tenant->nama_sekolah]);
            $request->attributes->set('tenant', $tenant);
        } else {
            // If logged in and has tenant_id, sync session
            if (auth()->check() && auth()->user()->tenant_id) {
                $tenant = auth()->user()->tenant;
                if ($tenant) {
                    if (!$tenant->is_active) {
                        auth()->logout();
                        return redirect()->route('login')->withErrors(['email' => 'Sekolah Anda sedang ditangguhkan.']);
                    }
                    if ($tenant->isExpired()) {
                        session(['tenant_id' => $tenant->id, 'tenant_slug' => $tenant->slug, 'tenant_name' => $tenant->nama_sekolah]);
                        // Only allow access to expired dashboard or logout
                        if (!$request->is('*/expired') && !$request->is('logout')) {
                            return redirect()->route('tenant.expired', ['slug' => $tenant->slug]);
                        }
                    }
                    session(['tenant_id' => $tenant->id, 'tenant_slug' => $tenant->slug, 'tenant_name' => $tenant->nama_sekolah]);
                }
            }
        }

        return $next($request);
    }
}
