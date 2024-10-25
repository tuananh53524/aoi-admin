<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\Role;

class SimpleACL
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role_id == config('app.roles.root')) {
                return $next($request);
            }
        }

        // Lấy route hiện tại
        $route = Route::current();
        $prefix = isset($route->action['prefix']) ? $route->action['prefix'] : null;
        // Kiểm tra prefix 'admin' và quyền truy cập
        if (strpos($prefix, 'admin') !== false) {
            if (!Auth::check()) return redirect()->route('login');
            
            // abort(401); 
        }

        return $next($request);
    }
}
