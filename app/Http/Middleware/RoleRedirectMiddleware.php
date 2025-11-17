<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleRedirectMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();
            $currentRoute = $request->route();

            // Kalau user sudah login dan coba akses /login
            if ($currentRoute && $currentRoute->getName() === 'login') {
                return $this->redirectToRoleDashboard($user);
            }

            // Kalau user akses dashboard umum, arahkan ke dashboard role
            if ($currentRoute && $currentRoute->getName() === 'dashboard') {
                return $this->redirectToRoleDashboard($user);
            }

            // Biarkan user tetap di dashboard role masing-masing
            $allowedDashboards = [
                'admin.dashboard',
                'dosen.dashboard',
                'mahasiswa.dashboard',
                'lapangan.dashboard',
            ];

            if ($currentRoute && in_array($currentRoute->getName(), $allowedDashboards)) {
                return $next($request);
            }
        }

        return $next($request);
    }

    /**
     * Redirect user to their role-specific dashboard
     */
    private function redirectToRoleDashboard($user)
    {
        $redirectRoutes = [
            'admin' => 'admin.dashboard',
            'dosen-biasa' => 'dosen.dashboard',
            'mahasiswa' => 'mahasiswa.dashboard',
            'pembimbing-lapangan' => 'lapangan.dashboard',
        ];

        foreach ($redirectRoutes as $role => $route) {
            if ($user->hasRole($role)) {
                // Redirect langsung ke route role-specific, bukan ke dashboard umum
                return redirect()->route($route);
            }
        }

        // Default fallback jika tidak ada role yang cocok - redirect ke home
        return redirect('/');
    }
}
