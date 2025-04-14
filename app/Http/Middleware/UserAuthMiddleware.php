<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
//    public function handle(Request $request, Closure $next): Response
//    {
//        if(!Auth::guard('web')->check()){
//            return redirect()->route('user.login.page')->with('error', 'Mhusika Hajathibitishwa Kuingia');
//        }
//
//        return $next($request);
//    }

//    public function handle($request, Closure $next, $role)
//    {
//        // Check if the user is authenticated
//        if (!Auth::guard('web')->check()) {
//            return redirect()->route('user.login.page')->with('error', 'Mhusika Hajathibitishwa Kuingia');
//        }
//
//        // Now check the role of the authenticated user
//        $user = Auth::guard('web')->user();
//
//        if ($user->user_type !== $role) {
//            return redirect()->route('home')->with('error', 'Mhusika Hajathibitishwa Kuingia Kwenye Anwani');
//        }
//
//        return $next($request);
//    }

    public function handle(Request $request, Closure $next, $role)
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Mhusika Hajathibitishwa Kuingia');
        }

        // Check if the user's role matches the role defined in the middleware
        // dd(Auth::user()->user_type !== $role, Auth::user()->user_type);

        if (Auth::user()->user_type !== $role) {
            return redirect()->route('login')->with('error', 'Mhusika Hajathibitishwa Kuingia Kweny Ukurusa Huo');
        }

        return $next($request);
    }

}
