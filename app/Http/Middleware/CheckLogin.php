<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        if ($user->status == 0) {
            auth()->logout();
            return redirect()->route('admin.login')->with('error', 'Your account is not active.');
        }

        autoCreatePermissionUsingModules();
        $user->syncRoles($user->getRoleNames()->first());
        return $next($request);
    }
}
