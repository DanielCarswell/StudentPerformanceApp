<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAdvisorAuthenticate
{
    public function handle(Request $request, Closure $next)
    {
        $roles = \DB::table('roles')
        ->join('user_role', 'user_role.role_id', '=', 'roles.id')
        ->where('user_id', '=', auth()->user()->id)
        ->get();

        foreach($roles as $role) {
            if($role->name === 'Admin' || $role->name === 'Moderator' || $role->name === 'Advisor')  {
                return $next($request);
            }
        }

        return new Response('Page Access/Permission Denied', 403);
    }
}